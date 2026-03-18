<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'counselor_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }
}
