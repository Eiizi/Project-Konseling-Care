<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'schedule_time' => 'datetime', 
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'counselor_id',
        'schedule_time',
        'status',
        'session_type',
        'notes_for_counselor', 
        'meeting_link',
        'counselor_feedback',
        'meeting_type',
    ];

    /**
     * Mendapatkan data pasien (user) yang membuat janji temu ini.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Mendapatkan data konselor (user) untuk janji temu ini.
     */
    public function counselor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    /**
     * Mendapatkan data transaksi terkait janji temu ini.
     */
    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    /**
     * Mendapatkan review (jika ada) untuk appointment ini.
     */
    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Mendapatkan catatan sesi (jika ada) untuk appointment ini.
     */
    public function sessionNote(): HasOne
    {
        return $this->hasOne(SessionNote::class);
    }
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}