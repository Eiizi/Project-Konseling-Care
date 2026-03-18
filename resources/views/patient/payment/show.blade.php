@extends('layouts.patient')

@section('title', 'Konfirmasi Pembayaran')

@section('content')
<div class="max-w-xl mx-auto mt-10">
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
        
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Konfirmasi & Pembayaran</h2>

        <div class="space-y-4 text-gray-700 border-b pb-6 mb-6">
            <div class="flex justify-between">
                <span class="text-gray-500">Kode Transaksi</span>
                <span class="font-mono font-bold text-indigo-600">{{ $transaction->transaction_code }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Konselor</span>
                <span class="font-semibold">{{ $transaction->appointment->counselor->name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Metode</span>
                @if($transaction->appointment->meeting_type == 'offline')
                    <span class="font-bold text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded">OFFLINE</span>
                @else
                    <span class="font-bold text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">ONLINE</span>
                @endif
            </div>
            <div class="flex justify-between items-center pt-4">
                <span class="text-lg font-bold">Total</span>
                <span class="text-2xl font-bold text-red-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="text-center">
            <button id="pay-button" class="w-full px-8 py-4 bg-green-600 text-white font-bold rounded-xl shadow-lg hover:bg-green-700 transition">
                Bayar Sekarang (Sandbox)
            </button>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-GANTI_DENGAN_KEY_ANDA_DISINI"></script>

<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        
        // Ambil token dari database yang dikirim controller
        var snapToken = '{{ $transaction->snap_token }}';

        if(snapToken) {
            window.snap.pay(snapToken, {
                onSuccess: function(result){ window.location.href = "{{ route('patient.appointments.index') }}"; },
                onPending: function(result){ window.location.href = "{{ route('patient.appointments.index') }}"; },
                onError: function(result){ alert("Pembayaran gagal!"); },
                onClose: function(){ console.log('closed'); }
            });
        } else {
            alert("Token pembayaran tidak ditemukan. Silakan booking ulang.");
        }
    });
</script>
@endsection