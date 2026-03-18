<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CounselorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // <-- Tambahkan ini
use Illuminate\Validation\Rules;

class CounselorController extends Controller
{
    /**
     * Menampilkan daftar semua konselor.
     */
    public function index()
    {
        // REVISI BAGIAN INI
        $counselors = \App\Models\User::where('role', 'counselor')
            ->with(['profile', 'schedules'])
            // Perhatikan: Kita panggil 'appointmentsAsCounselor'
            ->withCount(['appointmentsAsCounselor as appointments_as_counselor_count' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->latest()
            ->paginate(9);

        // --- LOGIKA DETEKSI JADWAL BENTROK (TETAP SAMA) ---
        $allSchedules = \App\Models\Schedule::all();
        $conflicts = []; 

        foreach ($allSchedules as $schedA) {
            foreach ($allSchedules as $schedB) {
                if ($schedA->counselor_id == $schedB->counselor_id || $schedA->id == $schedB->id) {
                    continue;
                }
                if ($schedA->day_of_week == $schedB->day_of_week) {
                    if ($schedA->start_time < $schedB->end_time && $schedB->start_time < $schedA->end_time) {
                        $conflicts[] = $schedA->counselor_id;
                        $conflicts[] = $schedB->counselor_id;
                    }
                }
            }
        }
        
        $conflicts = array_unique($conflicts);

        return view('admin.counselors.index', compact('counselors', 'conflicts'));
    }

    /**
     * Menampilkan form untuk membuat konselor baru.
     */
    public function create()
    {
        return view('admin.counselors.create');
    }

    /**
     * Menyimpan konselor baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rate' => ['required', 'numeric', 'min:0'], // <-- Validasi rate
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'counselor',
        ]);

        CounselorProfile::create([
            'user_id' => $user->id,
            'is_verified' => true, // Dibuat oleh admin, langsung verifikasi
            'rate' => $request->rate, // <-- Simpan rate
        ]);

        return redirect()->route('admin.counselors.index')->with('success', 'Konselor baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit (dan memverifikasi) data konselor.
     */
    public function edit(User $counselor)
    {
        if ($counselor->role !== 'counselor') {
            abort(404);
        }
        $counselor->load('profile'); // Memuat relasi profil
        return view('admin.counselors.edit', compact('counselor'));
    }

    /**
     * Mengupdate data konselor (dan status verifikasi).
     */
    public function update(Request $request, User $counselor)
    {
        if ($counselor->role !== 'counselor') {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$counselor->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'rate' => ['required', 'numeric', 'min:0'], // <-- Validasi rate
            'is_verified' => ['required', 'boolean'], // Validasi untuk checkbox verifikasi
        ]);

        // Update data user
        $counselor->name = $request->name;
        $counselor->email = $request->email;
        if ($request->filled('password')) {
            $counselor->password = Hash::make($request->password);
        }
        $counselor->save();

        // Update data profil
        if ($counselor->profile) {
            $counselor->profile->update([
                'is_verified' => $request->is_verified, // Ambil nilai 0 or 1
                'rate' => $request->rate, // <-- Update rate
            ]);
        } else {
            // Jika profil belum ada (misal data lama), buat baru
            CounselorProfile::create([
                'user_id' => $counselor->id,
                'is_verified' => $request->is_verified,
                'rate' => $request->rate,
            ]);
        }

        return redirect()->route('admin.counselors.index')->with('success', 'Data konselor berhasil diperbarui.');
    }

    /**
     * Menghapus data konselor.
     */
    public function destroy(User $counselor)
    {
        if ($counselor->role !== 'counselor') { abort(404); }
        
        if ($counselor->profile) {
             Storage::disk('public')->delete($counselor->profile->certificate_url);
             Storage::disk('public')->delete($counselor->profile->cv_url);
             Storage::disk('public')->delete($counselor->profile->identity_url);
             Storage::disk('public')->delete($counselor->profile->photo);
        }
        $counselor->delete(); 
        return redirect()->route('admin.counselors.index')->with('success', 'Konselor berhasil dihapus.');
    }

    /**
     * Memverifikasi (atau membatalkan verifikasi) konselor.
     */
    public function verify(User $counselor)
    {
        if ($counselor->role !== 'counselor' || !$counselor->profile) {
             return back()->with('error', 'Data konselor tidak valid.');
        }

        // Cek apakah harga sudah diatur. Jika belum (masih 0 atau null), jangan verifikasi.
        if ($counselor->profile->rate <= 0) {
             return back()->with('error', 'Harga per sesi belum diatur. Silakan klik "Lihat Detail" untuk mengatur harga sebelum verifikasi.');
        }
        
        $newStatus = !$counselor->profile->is_verified;
        $counselor->profile->update(['is_verified' => $newStatus]);

        $statusMsg = $newStatus ? 'diverifikasi' : 'dibatalkan verifikasinya';
        return back()->with('success', "Konselor berhasil $statusMsg.");
    }

    /**
     * Menampilkan detail konselor tertentu.
     */
    public function show($id)
    {
        // Cari user dengan role counselor beserta relasinya
        $counselor = \App\Models\User::where('role', 'counselor')
            ->with(['profile', 'schedules', 'appointmentsAsCounselor.patient'])
            ->findOrFail($id);

        // Ambil riwayat sesi (appointment) yang ditangani konselor ini
        $appointments = $counselor->appointmentsAsCounselor()
            ->with(['patient', 'transaction'])
            ->latest('schedule_time')
            ->paginate(10);

        return view('admin.counselors.show', compact('counselor', 'appointments'));
    }
}