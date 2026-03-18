<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['appointment_id', 'patient_id', 'counselor_id', 'rating', 'comment'];

    public function patient() { return $this->belongsTo(User::class, 'patient_id'); }
    public function counselor() { return $this->belongsTo(User::class, 'counselor_id'); }
}