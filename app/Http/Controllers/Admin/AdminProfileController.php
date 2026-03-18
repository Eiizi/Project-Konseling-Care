<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // <--- WAJIB

class AdminProfileController extends Controller
{
    public function edit() {
        return view('admin.profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request) 
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'avatar' => 'nullable|image|max:2048', // Validasi Gambar
        ]);

        $data = ['name' => $request->name, 'email' => $request->email];

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('password')) {
            $request->validate(['password' => 'confirmed|min:8']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return back()->with('success', 'Profil Admin berhasil diperbarui!');
    }
}