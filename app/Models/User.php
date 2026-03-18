<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne; 
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\CounselorProfile;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'age', 
        'gender', 
        'phone_number', 
        'photo_path',
        'otp', 
        'otp_expires_at',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile()
    {
        return $this->hasOne(CounselorProfile::class);
    }
     public function counselor()
    {
        // Ini berasumsi 1 User memiliki 1 Counselor
        return $this->hasOne(Counselor::class);
    }

    // ==================================================================
    // Relasi lain yang sudah kita buat
    // ==================================================================

   
    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    
    public function counselorAppointments()
    {
        return $this->hasMany(Appointment::class, 'counselor_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'counselor_id');
    }

    public function appointmentsAsPatient(): HasMany // Tipe return ditambahkan
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function appointmentsAsCounselor(): HasMany // Tipe return ditambahkan
    {
        return $this->hasMany(Appointment::class, 'counselor_id');
    }

  
    public function reviewsReceived(): HasMany
    {
        return $this->hasMany(Review::class, 'counselor_id');
    }

    // Helper untuk ambil rata-rata rating (misal: 4.5)
    public function getAverageRatingAttribute()
    {
        return $this->reviewsReceived()->avg('rating') ?? 0;
    }
    
    // Helper untuk ambil jumlah review
    public function getReviewCountAttribute()
    {
        return $this->reviewsReceived()->count();
    }

    public function getCounselorCodeAttribute()
    {
        
        return 'CNSL-' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }
}
