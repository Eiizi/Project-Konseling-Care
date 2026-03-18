<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Str; // Tambahkan ini

class PaymentController extends Controller
{
    public function __construct()
    {
        // Pastikan config ini sesuai dengan file .env dan config/midtrans.php Anda
        // Biasanya: config('services.midtrans.server_key') jika pakai default Laravel
        Config::$serverKey = config('services.midtrans.server_key'); 
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function show(Transaction $transaction)
    {
        // 1. Cek Validasi Kepemilikan
        if ($transaction->appointment?->patient_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // 2. Jika sudah lunas, jangan bayar lagi
        if ($transaction->status !== 'pending') {
            return redirect()->route('patient.appointments.index')
                ->with('info', 'Transaksi ini sudah diproses.');
        }

        $user = Auth::user();

        // 3. Generate Order ID yang Unik
        // Jika kolom 'transaction_code' kosong, kita buat manual pakai ID
        $orderId = $transaction->transaction_code 
                   ?? 'TRX-' . $transaction->id . '-' . Str::random(5);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId, 
                'gross_amount' => (int) $transaction->total_amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '08123456789',
            ],
            'item_details' => [[
                'id' => 'APT-' . $transaction->appointment->id,
                'price' => (int) $transaction->total_amount,
                'quantity' => 1,
                'name' => 'Konseling ' . ucfirst($transaction->appointment->meeting_type),
            ]],
        ];

        try {
            // Ambil Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);
            
            // (Opsional) Simpan token ke DB jika ingin dipakai ulang nanti
            $transaction->update(['snap_token' => $snapToken]);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Midtrans Error: ' . $e->getMessage());
        }

        // Tampilkan View Pembayaran
        return view('patient.payment.show', compact('transaction', 'snapToken'));
    }
}