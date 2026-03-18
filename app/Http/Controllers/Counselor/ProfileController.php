<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman edit profil konselor.
     */
    public function edit(Request $request) // Anda bisa juga pakai $request
    {
        $user = $request->user(); // Ambil user dari request
        $user->load('profile'); // Pastikan data profile (termasuk foto, bio, dll) diambil
        return view('counselor.profile.edit', compact('user'));
    }

    /**
     * Mengupdate data profil konselor.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // 1. Validasi Data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            
            // Sesuaikan dengan nama kolom di database/form Anda
            // Ganti 'specialty' menjadi 'specializations' jika itu nama kolom Anda
            'specializations' => ['nullable', 'string', 'max:255'], 
            'experience_years' => ['nullable', 'integer', 'min:0'],
            'bio' => ['nullable', 'string'],
            'rate' => ['required', 'numeric', 'min:0'],
            'phone_number' => ['nullable', 'string', 'max:20'], // Tambahkan ini

            // Validasi Password (jika diisi)
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // 2. Siapkan data untuk tabel 'users'
        $userData = $request->only('name', 'email');
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        $user->update($userData);

        // 3. Siapkan data untuk tabel 'counselor_profiles'
        $profileData = $request->only('specializations', 'experience_years', 'bio', 'rate', 'phone_number');
        // Ganti 'specializations' ke 'specialty' jika nama kolomnya itu
        // $profileData = $request->only('specialty', 'experience_years', 'bio', 'rate', 'phone_number');


        // 4. Handle Upload Foto Profil
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->profile?->photo_path) { // Ganti 'photo_path' jika nama kolom Anda 'photo' atau 'photo_url'
                Storage::disk('public')->delete($user->profile->photo_path);
            }
            // Simpan foto baru
            $path = $request->file('photo')->store('profile_photos/counselor', 'public');
            $profileData['photo_path'] = $path; // Ganti 'photo_path' jika nama kolom Anda 'photo' atau 'photo_url'
        }

        // 5. Update atau Buat data profil
        // Gunakan firstOrNew untuk keamanan jika profil belum ada
        $profile = $user->profile()->firstOrNew([]);
        $profile->fill($profileData);
        $profile->save();

        // 6. Redirect kembali dengan pesan sukses
        return redirect()->route('counselor.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}