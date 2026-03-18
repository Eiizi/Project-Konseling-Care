<?php
namespace App\Http\Controllers\Patient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // <--- WAJIB

class ProfileController extends Controller
{
    public function edit() {
        return view('patient.profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request) {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone_number' => 'required',
            'age' => 'required',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'age' => $request->age,
            'gender' => $request->gender,
        ];

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('password')) {
            $request->validate(['password' => 'confirmed|min:8']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return back()->with('success', 'Profil Pasien berhasil diperbarui!');
    }
}