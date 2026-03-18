<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Appointment $appointment)
    {
        // Validasi
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Pastikan hanya pasien yang bersangkutan yang bisa review
        if ($appointment->patient_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Simpan Review
        Review::create([
            'appointment_id' => $appointment->id,
            'patient_id' => Auth::id(),
            'counselor_id' => $appointment->counselor_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}