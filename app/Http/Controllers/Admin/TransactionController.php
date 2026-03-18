<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction; 
use App\Models\Appointment; 
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi.
     */
    public function index(Request $request)
    {
        
        $query = \App\Models\Transaction::with(['appointment.patient', 'appointment.counselor']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                
                $q->where('transaction_code', 'like', "%$search%")
                  
                  
                  ->orWhereHas('appointment.patient', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%$search%");
                  })
                  
                 
                  ->orWhereHas('appointment.counselor', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%$search%");
                  });
            });
        }

        $transactions = $query->latest()->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function confirm(Transaction $transaction) // Route Model Binding
    {
        // Hanya konfirmasi jika statusnya 'success' atau 'paid' tapi belum 'verified'
        if (($transaction->status === 'success' || $transaction->status === 'paid') && $transaction->status !== 'verified') {
            
            
             $transaction->update(['status' => 'verified']); 

            
            if ($transaction->appointment) {
                $transaction->appointment->update(['status' => 'confirmed']);
                 
            }

            return redirect()->route('admin.transactions.index')->with('success', 'Pembayaran berhasil dikonfirmasi.');

        } elseif ($transaction->status === 'verified') {
             return redirect()->route('admin.transactions.index')->with('info', 'Pembayaran ini sudah dikonfirmasi sebelumnya.');
        } else {
            return redirect()->route('admin.transactions.index')->with('error', 'Hanya pembayaran yang sukses/lunas yang bisa dikonfirmasi.');
        }
    }

    
}
