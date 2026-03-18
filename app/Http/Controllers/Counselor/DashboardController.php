<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $counselorId = Auth::id();
        $now = Carbon::now();

        // 1. Ambil 5 Sesi yang akan datang
        $upcomingAppointments = Appointment::where('counselor_id', $counselorId)
            ->where('status', 'confirmed')
            ->where('schedule_time', '>', $now)
            ->with('patient')
            ->orderBy('schedule_time', 'asc')
            ->take(5)
            ->get();

        // 2. Hitung jumlah sesi hari ini
        $sessionsTodayCount = Appointment::where('counselor_id', $counselorId)
            ->where('status', 'confirmed')
            ->whereDate('schedule_time', $now->toDateString())
            ->count();

        // 3. Hitung pasien aktif bulan ini
        $activePatientsCount = Appointment::where('counselor_id', $counselorId)
            ->where('status', 'confirmed')
            ->whereMonth('schedule_time', $now->month)
            ->distinct('patient_id')
            ->count('patient_id');

        // 4. Hitung Pendapatan Bulan Ini
        // Pastikan Model Transaction ada dan relasinya benar
        $counselorRevenue = 0;
        try {
            $counselorRevenue = Transaction::whereHas('appointment', function ($query) use ($counselorId) {
                $query->where('counselor_id', $counselorId);
            })
            ->whereIn('status', ['success', 'paid', 'verified']) // Sesuaikan status sukses di midtrans Anda (biasanya 'paid' atau 'settlement')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('base_price'); // Atau 'total_amount' dikurangi admin fee
        } catch (\Exception $e) {
            $counselorRevenue = 0; // Fallback jika tabel transaksi belum siap
        }

        return view('counselor.dashboard', compact(
            'upcomingAppointments', 
            'sessionsTodayCount', 
            'activePatientsCount', 
            'counselorRevenue'
        ));
    }
}