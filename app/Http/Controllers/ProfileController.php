<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage; 
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            return view('admin.profile.edit', [
                'user' => $user,
            ]);
        } 
        
        if ($user->role === 'patient') {
            
            return view('patient.profile.edit', [ 
                'user' => $user,
            ]);
        }

        // Default fallback (misal untuk user lain/breeze standar)
        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        
        $request->validate([
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = $request->user();

        
        $user->fill($request->validated());

        
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        
        if ($request->hasFile('avatar')) {
           
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            
            $path = $request->file('avatar')->store('avatars', 'public');
            
            
            $user->avatar = $path;
        }

        
        $user->save();

    
        return back()->with('status', 'profile-updated')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Opsional: Hapus foto profil saat akun dihapus
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}