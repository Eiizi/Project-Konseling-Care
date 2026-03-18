<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CounselorProfile extends Model
{
    protected $fillable = [
        'user_id',
        'photo',
        'specializations',
        'experience_years',
        'bio',
        'certificate_url',
        'is_verified',
        'rate',
        'cv_url',
        'identity_url',
        'rate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
