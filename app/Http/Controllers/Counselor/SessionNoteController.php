<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\SessionNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionNoteController extends Controller
{
    /**
     * Menampilkan form untuk menambah/mengedit catatan sesi.
     */
    public function show(Appointment $appointment)
    {
        // Validasi: Pastikan appointment ini milik konselor yang login
        if ($appointment->counselor_id !== Auth::id()) {
            abort(403);
        }
        
        // Muat catatan yang sudah ada jika ada
        $appointment->load('sessionNote'); 
        
        return view('counselor.notes.show', compact('appointment'));
    }

    /**
     * Menyimpan (atau memperbarui) catatan sesi.
     */
    public function store(Request $request, Appointment $appointment)
    {
        // Validasi: Pastikan appointment ini milik konselor yang login
        if ($appointment->counselor_id !== Auth::id()) {
            abort(403);
        }

        // Validasi kedua input
        $request->validate([
            'notes' => 'nullable|string', // Catatan pribadi (boleh kosong)
            'counselor_feedback' => 'nullable|string|max:2000', // Catatan untuk pasien (boleh kosong)
        ]);

        // 1. Simpan/Update Catatan Pribadi (ke tabel session_notes)
        // Hanya simpan jika diisi, jika tidak, biarkan
        if ($request->filled('notes')) {
            SessionNote::updateOrCreate(
                ['appointment_id' => $appointment->id], // Cari berdasarkan appointment_id
                [
                    'counselor_id' => Auth::id(),
                    'notes' => $request->notes // Data yang akan di-update atau di-create
                ]
            );
        }

        // 2. Simpan/Update Catatan Publik (ke tabel appointments)
        $appointment->update([
            'counselor_feedback' => $request->counselor_feedback
        ]);

        return back()->with('success', 'Catatan sesi dan feedback berhasil disimpan.');
    }
}