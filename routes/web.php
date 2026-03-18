<?php


use App\Http\Controllers\Admin\CounselorController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController; 
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Counselor\ScheduleController as CounselorScheduleController;
use App\Http\Controllers\Counselor\SessionNoteController;
use App\Http\Controllers\Auth\CounselorRegistrationController;
use App\Http\Controllers\Admin\ScheduleController;

use App\Http\Controllers\Counselor\ProfileController;
use App\Http\Controllers\Patient\BookingController;
use App\Http\Controllers\Patient\PaymentController;
use App\Http\Controllers\Patient\ProfileController as PatientProfileController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Counselor\ProfileController as CounselorProfileController;

use App\Http\Controllers\Patient\ReviewController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\Auth\OtpController;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // Ambil 4 konselor yang terverifikasi secara acak untuk ditampilkan
    $counselors = User::where('role', 'counselor')
                        ->whereHas('profile', fn($q) => $q->where('is_verified', true)) // Hanya yg terverifikasi
                        ->with('profile') // Ambil data profile
                        ->inRandomOrder() // Tampilkan acak
                        ->take(4) // Ambil 4 saja
                        ->get();

    return view('welcome', compact('counselors')); // Kirim data $counselors ke view

});


// RUTE REGISTRASI KONSELOR
Route::get('/counselor/register', [CounselorRegistrationController::class, 'create'])->name('counselor.register');
Route::post('/counselor/register', [CounselorRegistrationController::class, 'store'])->name('counselor.register.store');

/*
|--------------------------------------------------------------------------
| Rute Panel ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // 1. DASHBOARD
    // Menggunakan Controller baru yang baru saja kita buat
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('dashboard');


    // 2. MANAJEMEN PASIEN
    Route::get('/patients', [App\Http\Controllers\Admin\PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/create', [App\Http\Controllers\Admin\PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [App\Http\Controllers\Admin\PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{id}', [App\Http\Controllers\Admin\PatientController::class, 'show'])->name('patients.show');
    Route::delete('/patients/{id}', [App\Http\Controllers\Admin\PatientController::class, 'destroy'])->name('patients.destroy');


    // 3. MANAJEMEN JADWAL (Fixed: Tidak ada duplikasi)
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
    Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::get('/schedules/{id}', [ScheduleController::class, 'show'])->name('schedules.show');
    Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
    Route::get('/schedules/{id}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('/schedules/{id}', [ScheduleController::class, 'update'])->name('schedules.update');

    // 4. MANAJEMEN KONSELOR
    // Menggunakan full namespace agar tidak error "Class not found"
    Route::resource('counselors', App\Http\Controllers\Admin\CounselorController::class);
    Route::patch('/counselors/{counselor}/verify', [App\Http\Controllers\Admin\CounselorController::class, 'verify'])->name('counselors.verify');


    // 5. MANAJEMEN TRANSAKSI
    Route::get('/transactions', [App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transactions.index');
    Route::patch('/transactions/{transaction}/confirm', [App\Http\Controllers\Admin\TransactionController::class, 'confirm'])->name('transactions.confirm');

    // 6. MANAJEMEN ADMIN (LIST & VERIFIKASI)
    Route::get('/admins', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admins.index');
    Route::get('/admins/create', [App\Http\Controllers\Admin\AdminController::class, 'create'])->name('admins.create');
    Route::post('/admins', [App\Http\Controllers\Admin\AdminController::class, 'store'])->name('admins.store');
    Route::patch('/admins/{id}/verify', [App\Http\Controllers\Admin\AdminController::class, 'verify'])->name('admins.verify');
    Route::delete('/admins/{id}', [App\Http\Controllers\Admin\AdminController::class, 'destroy'])->name('admins.destroy');
       
    
    Route::middleware(['role:super_admin'])->group(function () {
        
        Route::get('/admins', [App\Http\Controllers\Admin\AdminController::class, 'index'])
            ->name('admins.index');
            
        Route::get('/admins/create', [App\Http\Controllers\Admin\AdminController::class, 'create'])
            ->name('admins.create');
            
        Route::post('/admins', [App\Http\Controllers\Admin\AdminController::class, 'store'])
            ->name('admins.store');
            
        Route::patch('/admins/{id}/verify', [App\Http\Controllers\Admin\AdminController::class, 'verify'])
            ->name('admins.verify');
            
        Route::delete('/admins/{id}', [App\Http\Controllers\Admin\AdminController::class, 'destroy'])
            ->name('admins.destroy');
    });

    // 7. PROFIL SAYA (ADMIN)
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

});

/*
|--------------------------------------------------------------------------
| Rute Panel COUNSELOR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:counselor'])
    ->prefix('counselor')
    ->name('counselor.')
    ->group(function () {


Route::get('/dashboard', [App\Http\Controllers\Counselor\DashboardController::class, 'index'])
    ->name('dashboard');

    
    // Sesi Akan Datang
    Route::get('/upcoming-appointments', [App\Http\Controllers\Counselor\AppointmentController::class, 'upcoming'])
        ->name('appointments.upcoming');
    
    // Riwayat Sesi (Selesai/Dibatalkan)
    Route::get('/history', [App\Http\Controllers\Counselor\AppointmentController::class, 'history'])
        ->name('history.index');
    
    // Detail Sesi
    Route::get('/appointments/{id}', [App\Http\Controllers\Counselor\AppointmentController::class, 'show'])
        ->name('appointments.show');
    
    // Mulai Sesi (Ubah Status)
    Route::patch('/appointments/{id}/start', [App\Http\Controllers\Counselor\AppointmentController::class, 'start'])
        ->name('appointments.start');

    
    // Lihat Jadwal
    Route::get('/schedules', [App\Http\Controllers\Counselor\ScheduleController::class, 'index'])
        ->name('schedules.index');
    
    // Tambah Jadwal Baru
    Route::post('/schedules', [App\Http\Controllers\Counselor\ScheduleController::class, 'store'])
        ->name('schedules.store');
    
    // Hapus Jadwal
    Route::delete('/schedules/{id}', [App\Http\Controllers\Counselor\ScheduleController::class, 'destroy'])
        ->name('schedules.destroy');

    
    // Edit Profil
    Route::get('/profile', [App\Http\Controllers\Counselor\ProfileController::class, 'edit'])
        ->name('profile.edit');
    
    // Update Profil (PATCH) - Solusi untuk error MethodNotAllowed tadi
    Route::patch('/profile', [App\Http\Controllers\Counselor\ProfileController::class, 'update'])
        ->name('profile.update');


    Route::get('/appointments/{appointment}/notes', [App\Http\Controllers\Counselor\SessionNoteController::class, 'show'])
        ->name('notes.show');
        
    Route::post('/appointments/{appointment}/notes', [App\Http\Controllers\Counselor\SessionNoteController::class, 'store'])
        ->name('notes.store');


        Route::get('/profile', [CounselorProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [CounselorProfileController::class, 'update'])->name('profile.update');

});
/*
|--------------------------------------------------------------------------
| Rute Panel PATIENT
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:patient'])
    ->prefix('patient')
    ->name('patient.') 
    ->group(function () {

    Route::get('/dashboard', function () {
        $patientId = Auth::id();
        $nextSession = Appointment::where('patient_id', $patientId)->where('status', 'confirmed')->where('schedule_time', '>=', Carbon::now())->with('counselor')->orderBy('schedule_time', 'asc')->first();
        $counselors = User::where('role', 'counselor')->whereHas('profile', fn($q) => $q->where('is_verified', true))->with(['profile', 'reviewsReceived'])->get();
        return view('patient.dashboard', compact('nextSession', 'counselors'));
    })->name('dashboard'); //patient dashboard

   
    Route::get('/counselors', function () {
        $counselors = User::where('role', 'counselor')->whereHas('profile', fn($q) => $q->where('is_verified', true))->with('profile')->get();
        return view('patient.counselors.index', compact('counselors'));
    })->name('counselors.index');

    // Rute untuk menampilkan detail konselor
    Route::get('/counselors/{counselor}', function (User $counselor) {
        if ($counselor->role !== 'counselor' || !$counselor->profile?->is_verified) { 
            abort(404); 
        }
        
        $availability = $counselor->schedules()
        ->orderByRaw("FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
        ->orderBy('start_time')
        ->get();
    
    $availableSlots = [];
    $startDate = Carbon::today();
        
        $availableSlots = [];
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(30); 

        $existingAppointments = Appointment::where('counselor_id', $counselor->id)
                                        ->whereIn('status', ['pending', 'confirmed']) 
                                        ->whereBetween('schedule_time', [$startDate, $endDate->copy()->endOfDay()])
                                        ->pluck('schedule_time') 
                                        ->map(fn($dt) => $dt->format('Y-m-d H:i:s')) 
                                        ->toArray();

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dayOfWeek = $date->format('l'); 
            $slotsForDay = [];

            foreach ($availability as $sched) {
                if ($sched->day_of_week == $dayOfWeek) {
                    $startTime = Carbon::parse($date->format('Y-m-d') . ' ' . $sched->start_time);
                    $endTime = Carbon::parse($date->format('Y-m-d') . ' ' . $sched->end_time);

                    if ($endTime->lt($startTime)) {
                        $endTime->addDay(); 
                    }

                    while ($startTime->lt($endTime)) {
                        $slotTime = $startTime->copy();
                        $isBooked = in_array($slotTime->format('Y-m-d H:i:s'), $existingAppointments);

                        if ($slotTime->isFuture() && !$isBooked) {
                            $slotsForDay[] = $slotTime;
                        }
                        
                        $startTime->addHour(); 
                    }
                }
            }
             if (!empty($slotsForDay)) {
                $availableSlots[$date->format('Y-m-d')] = [
                    'dayName' => $date->isoFormat('dddd'), 
                    'dateFormatted' => $date->isoFormat('D MMMM YYYY'), 
                    'slots' => $slotsForDay,
                ];
            }
        }

        return view('patient.counselors.show', compact('counselor', 'availableSlots'));

    })->name('counselors.show'); // Nama rutenya sekarang 'patient.counselors.show' (INI PENTING!)
Route::get('/appointments', function (Illuminate\Http\Request $request) {
    $viewType = $request->query('view', 'upcoming'); // Default ke upcoming
    
  
    $appointments = collect([]); 

    return view('patient.appointments.index', compact('appointments', 'viewType'));
})->name('appointments.index');

// Di dalam group patient
Route::get('/appointments', function (Illuminate\Http\Request $request) {
    $user = Auth::user();
    $viewType = $request->query('view', 'upcoming'); // Default ke 'upcoming'

    $query = \App\Models\Appointment::where('patient_id', $user->id)
                ->with(['counselor.profile', 'transaction']); // Load relasi

    if ($viewType == 'upcoming') {
        // Tampilkan yang statusnya Pending (Belum bayar) atau Confirmed (Sudah bayar)
        $query->whereIn('status', ['pending', 'confirmed'])
              ->orderBy('schedule_time', 'asc');
    } else {
        // Tampilkan Riwayat (Selesai/Batal)
        $query->whereIn('status', ['completed', 'cancelled'])
              ->orderBy('schedule_time', 'desc');
    }

    $appointments = $query->paginate(10);

    return view('patient.appointments.index', compact('appointments', 'viewType'));
})->name('patient.appointments.index');

    // Rute untuk memproses booking

    Route::post('/appointments/{appointment}/review', [App\Http\Controllers\Patient\ReviewController::class, 'store'])
    ->name('patient.reviews.store');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store'); // Nama rute: patient.booking.store
    Route::get('/payment/{transaction}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{transaction}/simulate', [PaymentController::class, 'simulatePayment'])->name('payment.simulate');
    Route::get('/profile', [PatientProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/appointments/{appointment}/review', [App\Http\Controllers\Patient\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/appointments/{appointment}/review', [App\Http\Controllers\Patient\ReviewController::class, 'store'])->name('reviews.store');
    Route::patch('/profile', [PatientProfileController::class, 'update'])->name('profile.update');
    Route::get('/session/{appointment}', [BookingController::class, 'showSession'])->name('session.show');
    Route::patch('/session/{appointment}/complete', [BookingController::class, 'completeSession'])->name('session.complete');
    Route::patch('/appointments/{appointment}/cancel', [BookingController::class, 'cancel'])->name('appointments.cancel');
     Route::get('/appointments', function (Request $request) { // <-- Tambahkan Request
        $patientId = Auth::id();
        $viewType = $request->query('view', 'upcoming'); // Default 'upcoming'

        $query = Appointment::where('patient_id', $patientId)
                            ->with(['counselor', 'transaction']);

        if ($viewType == 'upcoming') {
            // "Jadwal Saya" = Sesi yang akan datang (pending atau confirmed)
            $query->whereIn('status', ['pending', 'confirmed'])
                  ->where('schedule_time', '>=', Carbon::now()->subMinutes(30)); // Beri toleransi 30 menit
        } else {
            // "Riwayat Sesi" = Sesi yang sudah lewat (completed atau cancelled)
            $query->whereIn('status', ['completed', 'cancelled']);
        }
        
        $appointments = $query->latest('schedule_time')->paginate(10);

        return view('patient.appointments.index', compact('appointments', 'viewType')); // Kirim viewType
    })->name('appointments.index');

    Route::get('/appointments/{appointment}/review', [ReviewController::class, 'create'])->name('reviews.create');
    Route::get('/profile', [App\Http\Controllers\Patient\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/appointments/{appointment}/cancel', [App\Http\Controllers\Patient\BookingController::class, 'cancel'])
    ->name('appointments.cancel');
    Route::post('/appointments/{appointment}/review', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/profile', [PatientProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [PatientProfileController::class, 'update'])->name('profile.update');
});




/*
|--------------------------------------------------------------------------
| Rute Webhook Midtrans (Publik, Tanpa Middleware 'auth')
|--------------------------------------------------------------------------
*/
Route::post('/webhook/midtrans', [WebhookController::class, 'handle'])->name('webhook.midtrans');

// Rute OTP (Harus bisa diakses tanpa login / guest)
Route::middleware('guest')->group(function () {
    Route::get('/verify-otp', [OtpController::class, 'create'])->name('otp.verify');
    Route::post('/verify-otp', [OtpController::class, 'store'])->name('otp.verify.store');
});
/*
|--------------------------------------------------------------------------
| Rute Otentikasi (dari Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php'; 

