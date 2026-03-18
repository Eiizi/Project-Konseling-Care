<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Menampilkan daftar semua admin (Aktif & Pending).
     */
    public function index()
    {
        // Ambil admin yang pending (butuh verifikasi)
        $pendingAdmins = User::where('role', 'admin')
            ->where('id', '!=', Auth::id()) // Jangan tampilkan diri sendiri
            ->where('status', 'pending') // Pastikan kolom status ada di DB
            ->latest()
            ->get();

        // Ambil admin yang sudah aktif
        $activeAdmins = User::where('role', 'admin')
            ->where('id', '!=', Auth::id())
            ->where(function($q) {
                $q->where('status', 'active')
                  ->orWhere('status', 'verified'); // Sesuaikan dengan enum database Anda
            })
            ->latest()
            ->get();

        return view('admin.admins.index', compact('pendingAdmins', 'activeAdmins'));
    }

    /**
     * Form tambah admin baru.
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Simpan admin baru (Status otomatis Pending).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'status' => 'pending', // Default pending, butuh verifikasi
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin baru berhasil didaftarkan. Status saat ini: Pending.');
    }

    /**
     * Verifikasi Admin.
     */
    public function verify($id)
    {
        $admin = User::findOrFail($id);
        
        // Ubah status jadi active/verified
        $admin->update(['status' => 'active']); 

        return back()->with('success', 'Akun admin berhasil diverifikasi dan diaktifkan.');
    }

    /**
     * Hapus Admin.
     */
    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        if ($admin->id == Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }
        $admin->delete();
        return back()->with('success', 'Data admin berhasil dihapus.');
    }
}