<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CounselorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // <-- Penting untuk file upload
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered; // Opsional, jika ingin kirim email verif

class CounselorRegistrationController extends Controller
{
    /**
     * Menampilkan form registrasi konselor.
     */
    public function create()
    {
        return view('auth.counselor-register');
    }

    /**
     * Menangani permintaan registrasi konselor.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'certificate_file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'], // Wajib ada file
            'cv_file' => ['required', 'file', 'mimes:pdf', 'max:2048'], // Wajib ada file
            'identity_file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'], // Wajib ada file
        ]);

        // 1. Simpan file-file
        // 'public' disk mengacu ke 'storage/app/public/'
        $certificatePath = $request->file('certificate_file')->store('counselor_documents/certificates', 'public');
        $cvPath = $request->file('cv_file')->store('counselor_documents/cvs', 'public');
        $identityPath = $request->file('identity_file')->store('counselor_documents/identity', 'public');

        // 2. Buat User (sebagai konselor)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'counselor',
        ]);

        // 3. Buat CounselorProfile
        CounselorProfile::create([
            'user_id' => $user->id,
            'certificate_url' => $certificatePath,
            'cv_url' => $cvPath,
            'identity_url' => $identityPath,
            'is_verified' => false, // <-- PENTING: Set verifikasi ke false
        ]);

        // event(new Registered($user)); // Kirim email verifikasi email jika perlu

        // 4. Redirect ke halaman login dengan pesan sukses
        return redirect(route('login'))->with('status', 'Pendaftaran konselor berhasil! Akun Anda akan segera ditinjau oleh administrator.');
    }
}