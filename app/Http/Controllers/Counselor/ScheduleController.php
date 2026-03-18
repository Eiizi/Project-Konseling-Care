<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // <--- PASTIKAN ADA INI UNTUK HITUNG JAM

class ScheduleController extends Controller
{
    public function index()
    {
        // ... kode index tetap sama ...
        $schedules = Schedule::where('counselor_id', Auth::id())
            ->orderByRaw("FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->orderBy('start_time')
            ->get();

        return view('counselor.schedules.index', compact('schedules'));
    }

    public function store(Request $request)
    {
        // 1. Validasi (Hapus validasi end_time karena otomatis)
        $request->validate([
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required',
        ]);

        // 2. HITUNG JAM SELESAI OTOMATIS (START + 2 JAM)
        $startTime = Carbon::createFromFormat('H:i', $request->start_time);
        $endTime = $startTime->copy()->addHours(2); // Menambahkan 2 jam

        // 3. Cek Duplikasi (Agar tidak bentrok dengan jadwal lain)
        // Kita cek apakah ada jadwal lain di hari yang sama yang tumpang tindih
        $isConflict = Schedule::where('counselor_id', Auth::id())
            ->where('day_of_week', $request->day)
            ->where(function ($query) use ($request, $endTime) {
                $query->whereBetween('start_time', [$request->start_time, $endTime->format('H:i')])
                      ->orWhereBetween('end_time', [$request->start_time, $endTime->format('H:i')]);
            })
            ->exists();

        if ($isConflict) {
            return back()->with('error', 'Jadwal bentrok dengan sesi lain yang sudah ada.');
        }

        // 4. Simpan ke Database
        Schedule::create([
            'counselor_id' => Auth::id(),
            'day_of_week' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $endTime->format('H:i'), // Simpan hasil hitungan otomatis
        ]);

        return back()->with('success', 'Slot waktu 2 jam berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        // ... kode destroy tetap sama ...
        $schedule = Schedule::findOrFail($id);
        if ($schedule->counselor_id !== Auth::id()) abort(403);
        $schedule->delete();
        return back()->with('success', 'Jadwal berhasil dihapus.');
    }
}