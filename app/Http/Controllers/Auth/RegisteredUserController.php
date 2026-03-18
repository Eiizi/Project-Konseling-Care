<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['required', 'string', 'max:20'],
            'age' => ['required', 'integer'],
            'gender' => ['required', 'string'],
        ]);

        
        $user = User::where('email', $request->email)->first();

        if ($user) {
            
            if ($user->email_verified_at) {
                return back()->withErrors(['email' => 'Email ini sudah terdaftar. Silakan login.']);
            }
            
           
            $user->update([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
                'age' => $request->age,
                'gender' => $request->gender,
                'role' => 'patient',   
                'status' => 'active',  
            ]);
        } else {
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'patient',   
                'status' => 'active',  
                'phone_number' => $request->phone_number,
                'age' => $request->age,
                'gender' => $request->gender,
            ]);
        }

        // 3. Generate & Simpan OTP Baru
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save(); // Simpan OTP ke database

        // 4. Kirim Email
        try {
            Mail::to($user->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            Log::error("Gagal kirim email OTP: " . $e->getMessage());
        }

       
        session(['verification_email' => $user->email]);

      
        return redirect()->route('otp.verify');
    }
}