<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OtpController extends Controller
{
    public function create()
    {
        // Pastikan ada email di session, kalau tidak tendang ke login
        if (!session('verification_email')) {
            return redirect()->route('login');
        }
        return view('auth.verify-otp');
    }

    public function store(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $email = session('verification_email');
        $user = User::where('email', $email)->first();

        // Validasi User & OTP
        if (!$user || $user->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah. Silakan cek email Anda.']);
        }

        // Validasi Waktu
        if (Carbon::now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa.']);
        }

        // --- SUKSES ---

        // 1. Bersihkan OTP di DB & Tandai Email Verified
        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
            'email_verified_at' => now(),
        ]);

        // 2. Login User secara resmi
        Auth::login($user);

        // 3. Hapus session sementara
        session()->forget('verification_email');

        // 4. Redirect ke Dashboard sesuai Role
        if ($user->role === 'admin') return redirect()->route('admin.dashboard');
        if ($user->role === 'counselor') return redirect()->route('counselor.dashboard');

        return redirect()->route('patient.dashboard');
    }
}