<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionNote extends Model
{
    protected $fillable = ['appointment_id', 'counselor_id', 'notes'];
}
