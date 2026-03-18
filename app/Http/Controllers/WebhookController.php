<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Notifications\AppointmentConfirmed; // Notifikasi kita
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Untuk logging error
use Midtrans\Config;
use Midtrans\Notification;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Set Kunci Server Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            // 2. Ambil notifikasi
            $notification = new Notification();
            
            // 3. Validasi Notifikasi (PENTING!)
            // Ini akan melempar exception jika signature key tidak valid
            $status = $notification->transaction_status;
            $type = $notification->payment_type;
            $order_id = $notification->order_id;
            $fraud = $notification->fraud_status;

            // 4. Cari Transaksi di Database
            $transaction = Transaction::where('transaction_code', $order_id)->first();

            if (!$transaction) {
                 Log::warning("Webhook Midtrans: Transaksi tidak ditemukan (Order ID: {$order_id})");
                 return response()->json(['message' => 'Transaction not found.'], 404);
            }

            // 5. Update Status Berdasarkan Notifikasi
            
            // Jangan proses jika status sudah final (success/verified/completed)
            if ($transaction->status === 'success' || $transaction->status === 'verified' || $transaction->status === 'completed') {
                return response()->json(['message' => 'Transaction already processed.']);
            }

            if ($status == 'capture' || $status == 'settlement') {
                // Pembayaran berhasil
                if ($fraud == 'accept') {
                    // Pembayaran aman, update DB
                    $this->updateOrderAsPaid($transaction, $type);
                }
            } else if ($status == 'pending') {
                // Transaksi masih menunggu pembayaran
                $transaction->update(['status' => 'pending', 'payment_method' => $type]);
            } else if ($status == 'deny' || $status == 'cancel' || $status == 'expire') {
                // Transaksi gagal atau dibatalkan
                $transaction->update(['status' => 'failed']);
            }

            return response()->json(['message' => 'Webhook processed successfully.']);

        } catch (\Exception $e) {
            // Tangani error (misal: signature key tidak valid)
            Log::error("Webhook Midtrans Error: " . $e->getMessage());
            return response()->json(['message' => 'Error processing webhook.'], 400);
        }
    }

    /**
     * Helper function untuk update DB dan kirim notifikasi
     */
    protected function updateOrderAsPaid(Transaction $transaction, $paymentType)
    {
        // 1. Update Transaksi
        $transaction->update([
            'status' => 'success', // atau 'paid'
            'payment_method' => $paymentType
        ]);

        // 2. Update Appointment
        $appointment = $transaction->appointment;
        if ($appointment) {
            $appointment->update(['status' => 'confirmed']);

            // 3. Kirim Notifikasi (jika sudah disiapkan)
            $konselor = $appointment->counselor;
            $adminUsers = User::where('role', 'admin')->get();

            if ($konselor) {
                 try {
                     $konselor->notify(new AppointmentConfirmed($appointment)); 
                 } catch (\Exception $e) {
                     Log::error('Gagal kirim notif ke konselor ' . $konselor->id . ': ' . $e->getMessage());
                 }
            }
            if ($adminUsers->isNotEmpty()) {
                foreach ($adminUsers as $admin) {
                     try {
                        $admin->notify(new AppointmentConfirmed($appointment)); 
                     } catch (\Exception $e) {
                         Log::error('Gagal kirim notif ke admin ' . $admin->id . ': ' . $e->getMessage());
                     }
                }
            }
        }
    }
}