<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
   
    public function upcoming()
    {
        $upcomingAppointments = Appointment::where('counselor_id', Auth::id())
            ->where('status', 'confirmed')
            ->where('schedule_time', '>=', Carbon::now())
            ->orderBy('schedule_time', 'asc')
            ->get();

        return view('counselor.appointments.upcoming', compact('upcomingAppointments'));
    }

   
    public function history()
    {
        $historyAppointments = Appointment::where('counselor_id', Auth::id())
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('schedule_time', 'desc')
            ->paginate(10); // Pakai pagination agar rapi

        return view('counselor.history.index', compact('historyAppointments'));
    }

  
    public function show($id)
    {
        $appointment = Appointment::with(['patient', 'transaction', 'review'])->findOrFail($id);

        // Security Check: Pastikan ini pasien milik konselor yang login
        if ($appointment->counselor_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke sesi ini.');
        }

        return view('counselor.appointments.show', compact('appointment'));
    }

   
    public function start($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->counselor_id !== Auth::id()) abort(403);

        // Di sini Anda bisa redirect ke Link Google Meet atau sekadar mengubah status
        // Untuk saat ini kita arahkan ke halaman detail saja
        return redirect()->route('counselor.appointments.show', $id)
            ->with('success', 'Sesi siap dimulai. Silakan masuk ke link video.');
    }
}