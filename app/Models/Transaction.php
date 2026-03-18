<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

        protected $fillable = [
            'appointment_id',
            'base_price',
            'admin_fee',
            'total_amount',
            'payment_method',
            'status',
            'transaction_code',
            'snap_token', // <--- WAJIB ADA DI SINI (TRANSACTION MODEL)
            'unique_code',
        ];

        /**
         * Mendapatkan data janji temu (appointment) terkait transaksi ini.
         */
        public function appointment()
        {
            return $this->belongsTo(Appointment::class);
        }
}
