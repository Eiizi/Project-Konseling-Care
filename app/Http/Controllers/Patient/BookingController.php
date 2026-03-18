<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * MENAMPILKAN HALAMAN DETAIL KONSELOR & JADWAL
     */
    public function show($id)
    {
        $counselor = User::where('role', 'counselor')->with(['profile', 'schedules'])->findOrFail($id);

        // --- 1. GENERATE SEMUA JAM (JANGAN FILTER BOOKING DISINI) ---
        $availableSlots = [];
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addWeeks(2);

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dayName = $date->format('l');
            $schedules = $counselor->schedules->where('day_of_week', $dayName);

            if ($schedules->count() > 0) {
                $slots = [];
                foreach ($schedules as $schedule) {
                    $start = Carbon::parse($date->format('Y-m-d') . ' ' . $schedule->start_time);
                    $end = Carbon::parse($date->format('Y-m-d') . ' ' . $schedule->end_time);

                    while ($start->lt($end)) {
                        // MASUKKAN SEMUA JAM KERJA KE LIST
                        $slots[] = $start->copy();
                        $start->addHour();
                    }
                }
                if (!empty($slots)) {
                    $availableSlots[$date->format('Y-m-d')] = [
                        'dayName' => $dayName,
                        'dateFormatted' => $date->format('d F Y'),
                        'slots' => $slots
                    ];
                }
            }
        }

        // --- 2. AMBIL DATA BOOKING UNTUK MEWARNAI TOMBOL ---
        $allBookings = Appointment::where('counselor_id', $counselor->id)
            ->whereIn('status', ['pending', 'confirmed', 'paid'])
            ->get();

        $myAppointments = [];
        $bookedSlots = [];

        foreach ($allBookings as $booking) {
            $timeString = Carbon::parse($booking->schedule_time)->format('Y-m-d H:i:00');
            if (Auth::check() && $booking->patient_id == Auth::id()) {
                $myAppointments[] = $timeString; // Jadwal Saya
            } else {
                $bookedSlots[] = $timeString; // Jadwal Orang Lain
            }
        }

        return view('patient.counselors.show', compact('counselor', 'availableSlots', 'myAppointments', 'bookedSlots'));
    }

    /**
     * MENYIMPAN BOOKING BARU
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'counselor_id' => 'required|exists:users,id',
            'schedule_time' => 'required|date_format:Y-m-d H:i:s',
            'meeting_type' => 'required|in:online,offline', 
        ]);

        try {
            DB::beginTransaction();

            $patient = Auth::user();
            $counselor = User::with('profile')->findOrFail($validated['counselor_id']);
            $scheduleTime = Carbon::parse($validated['schedule_time']);
            $meetingType = $validated['meeting_type'];

            // 2. Cek Double Booking (Validasi Backend)
            $existing = Appointment::where('counselor_id', $counselor->id)
                ->where('schedule_time', $scheduleTime)
                ->whereIn('status', ['pending', 'confirmed', 'paid'])
                ->exists();

            if ($existing) {
                return back()->with('error', 'Maaf, slot waktu ini baru saja diambil orang lain.');
            }

            // 3. Hitung Biaya
            $base_price = $counselor->profile->rate ?? 100000;
            $admin_fee = 5000; 
            $total_amount = $base_price + $admin_fee; 

            // 4. Simpan Appointment
            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'counselor_id' => $counselor->id,
                'schedule_time' => $scheduleTime,
                'status' => 'pending',
                'meeting_type' => $meetingType, 
                'session_type' => $meetingType, 
                'meeting_link' => ($meetingType == 'online') ? 'https://meet.google.com/new' : null,
            ]);

            // 5. Simpan Transaksi
            $transactionCode = 'INV-' . time() . '-' . rand(100,999);
            
            $transaction = Transaction::create([
                'appointment_id' => $appointment->id,
                'base_price' => $base_price,
                'admin_fee' => $admin_fee,
                'total_amount' => $total_amount,
                'status' => 'pending',
                'transaction_code' => $transactionCode,
                'snap_token' => null, 
            ]);

            // 6. Konfigurasi Midtrans (Gunakan Config File)
            Config::$serverKey = config('services.midtrans.server_key'); 
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $transactionCode,
                    'gross_amount' => (int) $total_amount,
                ],
                'customer_details' => [
                    'first_name' => $patient->name,
                    'email' => $patient->email,
                    'phone' => $patient->phone_number ?? '08123456789',
                ],
                'item_details' => [
                    [
                        'id' => 'CNSL-' . $counselor->id,
                        'price' => (int) $base_price,
                        'quantity' => 1,
                        'name' => 'Konseling: ' . substr($counselor->name, 0, 40) // Midtrans max name length check
                    ],
                    [
                        'id' => 'ADM-FEE',
                        'price' => (int) $admin_fee,
                        'quantity' => 1,
                        'name' => 'Biaya Admin'
                    ]
                ]
            ];

            // 7. Minta Snap Token
            $snapToken = Snap::getSnapToken($params);
            $transaction->update(['snap_token' => $snapToken]);

            DB::commit();

            return redirect()->route('patient.payment.show', $transaction->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function cancel(Appointment $appointment) {
        if ($appointment->patient_id !== Auth::id()) abort(403);
        
        $appointment->update(['status' => 'cancelled']);
        if($appointment->transaction) {
            $appointment->transaction->update(['status' => 'cancelled']);
        }
        
        return back()->with('success', 'Janji temu berhasil dibatalkan.');
    }

    public function showSession(Appointment $appointment) {
        if ($appointment->patient_id !== Auth::id()) abort(403);
        $meetingLink = $appointment->meeting_link ?? "#";
        return view('patient.session.show', ['appointment' => $appointment, 'meetingLink' => $meetingLink]);
    }

    public function completeSession(Appointment $appointment) {
        if ($appointment->patient_id !== Auth::id()) abort(403);
        $appointment->update(['status' => 'completed']);
        return redirect()->route('patient.appointments.index', ['view' => 'history']);
    }
}