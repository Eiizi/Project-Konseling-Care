<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = User::where('role', 'patient')->latest()->paginate(10);
        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient', // Otomatis set role sebagai patient
        ]);

        return redirect()->route('admin.patients.index')->with('success', 'Pasien baru berhasil ditambahkan.');
    }
    

    /**
     * Display the specified resource.
     */
   // Di dalam Admin/PatientController.php
    public function show(string $id)
    {
        $patient = User::findOrFail($id);
        
        $appointments = Appointment::where('patient_id', $id)
            ->with(['counselor', 'transaction', 'review', 'sessionNote']) 
            ->latest()
            ->paginate(10); 

        return view('admin.patients.show', compact('patient', 'appointments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
        
        $patient = User::findOrFail($id);

        
        if ($patient->role !== 'patient') {
            return back()->with('error', 'Hanya akun pasien yang dapat dihapus.');
        }

        // 3. Hapus data
        $patient->delete();

        
        return redirect()->route('admin.patients.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }
}
