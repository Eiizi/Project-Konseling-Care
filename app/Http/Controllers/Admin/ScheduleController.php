<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Tampilkan daftar KONSELOR (Grouping).
     * View 'admin.schedules.index' mengharapkan variabel $counselors.
     */
    public function index()
    {
        // Ambil semua user dengan role 'counselor'
        // Hitung jumlah jadwal mereka (schedules_count) untuk badge di view
        $counselors = User::where('role', 'counselor')
            ->with('schedules')
            ->withCount('schedules')
            ->latest()
            ->paginate(10);

        // Kirim variabel $counselors (BUKAN $schedules)
        return view('admin.schedules.index', compact('counselors'));
    }

    /**
     * Tampilkan detail jadwal milik SATU konselor tertentu.
     * Di sini admin bisa tambah/hapus jadwal spesifik.
     */
    public function show($id)
    {
        $counselor = User::where('role', 'counselor')
            ->with(['schedules' => function($q) {
                // Urutkan jadwal berdasarkan Hari (Senin-Minggu) lalu Jam Mulai
                $q->orderByRaw("FIELD(day_of_week, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
                  ->orderBy('start_time');
            }])
            ->findOrFail($id);

        return view('admin.schedules.show', compact('counselor'));
    }

    /**
     * Simpan jadwal baru (Satu slot waktu).
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'counselor_id' => 'required|exists:users,id',
            'day_of_week'  => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu', // Sesuaikan dengan Value di Form View
            'start_time'   => 'required',
            'end_time'     => 'required|after:start_time',
        ]);

        // 2. Cek Bentrok Jadwal
        // Pastikan tidak ada jadwal lain milik konselor INI di HARI yang sama yang waktunya tumpang tindih
        $isConflict = Schedule::where('counselor_id', $request->counselor_id)
            ->where('day_of_week', $request->day_of_week)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                      ->orWhere(function($q) use ($request) {
                          $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                      });
            })
            ->exists();

        if ($isConflict) {
            return back()->with('error', 'Gagal: Slot waktu bentrok dengan jadwal yang sudah ada.');
        }

        // 3. Simpan Jadwal Baru
        Schedule::create([
            'counselor_id' => $request->counselor_id, // Gunakan ID dari Form, BUKAN Auth::id()
            'day_of_week'  => $request->day_of_week,
            'start_time'   => $request->start_time,
            'end_time'     => $request->end_time,
        ]);

        return back()->with('success', 'Slot waktu berhasil ditambahkan.');
    }

    /**
     * Hapus slot waktu.
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        // Redirect BACK agar tetap di halaman detail konselor tersebut
        return back()->with('success', 'Slot waktu berhasil dihapus.');
    }

    /**
     * (Opsional) Halaman Edit jika diperlukan
     */
    public function edit($id)
    {
        $schedule = Schedule::with('counselor')->findOrFail($id);
        return view('admin.schedules.edit', compact('schedule'));
    }

    /**
     * (Opsional) Update Jadwal
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $request->validate([
            'day_of_week' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'start_time'  => 'required',
            'end_time'    => 'required|after:start_time',
        ]);

        // Cek Konflik (exclude diri sendiri)
        $isConflict = Schedule::where('counselor_id', $schedule->counselor_id)
            ->where('day_of_week', $request->day_of_week)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                      ->orWhere(function($q) use ($request) {
                          $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                      });
            })
            ->exists();

        if ($isConflict) {
            return back()->with('error', 'Gagal update: Jadwal bentrok.');
        }

        $schedule->update($request->only(['day_of_week', 'start_time', 'end_time']));

        // Kembali ke halaman detail milik konselor
        return redirect()->route('admin.schedules.show', $schedule->counselor_id)
            ->with('success', 'Jadwal berhasil diperbarui.');
    }
}