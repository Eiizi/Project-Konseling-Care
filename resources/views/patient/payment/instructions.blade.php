<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruksi Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
         .sidebar-link.active { background-color: #4A5568; color: #F7FAFC; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen bg-gray-200">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white flex flex-col">
             <div class="px-8 py-6 border-b border-gray-700">
                <h2 class="text-2xl font-semibold">Panel Pasien</h2>
            </div>
            <!-- Bagian Navigasi Sidebar -->
            <nav class="flex-1 px-4 py-4 space-y-2">
    <a href="{{ route('patient.dashboard') }}" class="sidebar-link flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
        Dashboard
    </a>
    <a href="{{ route('patient.counselors.index') }}" class="sidebar-link flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('patient.counselors.*') ? 'active' : '' }}">
       <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
        Cari Konselor
    </a>
    <a href="{{ route('patient.appointments.index', ['view' => 'upcoming']) }}" class="sidebar-link flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('patient.appointments.index') && request()->query('view', 'upcoming', 'upcoming') != 'history' ? 'active' : '' }}">
       <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
        Jadwal Saya
    </a>
    <a href="{{ route('patient.appointments.index', ['view' => 'history']) }}" class="sidebar-link flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('patient.appointments.index') && request()->query('view') === 'history' ? 'active' : '' }}">
       <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        Riwayat Sesi
    </a>
     <a href="{{ route('patient.profile.edit') }}" class="sidebar-link flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('patient.profile.edit') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
        Profil Saya
    </a>
</nav>
            <div class="px-8 py-6 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-md p-6">
                <h1 class="text-2xl font-semibold text-gray-700">Instruksi Pembayaran</h1>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                 <div class="bg-white rounded-lg shadow-md p-8 max-w-2xl mx-auto">
                 <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-3">Detail Tagihan</h2>
                     <div class="space-y-2 text-gray-700 mb-6">
                        <p><strong>Kode Transaksi:</strong> <span class="font-mono bg-gray-200 px-2 py-1 rounded">{{ $transaction->transaction_code }}</span></p>
                        <p><strong>Konselor:</strong> {{ $transaction->appointment->counselor->name ?? 'N/A' }}</p>
                        <p><strong>Jadwal:</strong>
                            @if ($transaction->appointment && $transaction->appointment->schedule_time)
                                {{ $transaction->appointment->schedule_time->isoFormat('dddd, D MMMM YYYY, HH:mm') }} WIB
                            @else
                                N/A
                            @endif
                        </p>
                        <p class="text-lg font-bold"><strong>Total Bayar:</strong> <span class="text-red-600">Rp {{ number_format($transaction->amount ?? 0, 0, ',', '.') }}</span></p>
                     </div>

                     <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-3 mt-8">Cara Pembayaran</h2>

                     <div class="space-y-6">
                         <!-- ... Instruksi Transfer Bank ... -->
                         <div>
                             <h3 class="text-lg font-medium text-gray-700 mb-2">Transfer Bank (Virtual Account)</h3>
                             <p class="text-gray-600">Silakan transfer sejumlah <strong>Rp {{ number_format($transaction->amount ?? 0, 0, ',', '.') }}</strong> ke nomor Virtual Account berikut:</p>
                             <p class="mt-2 text-lg font-semibold bg-blue-100 inline-block px-4 py-2 rounded">BCA Virtual Account: <span class="font-mono">8808 1234 5678 9012</span></p>
                             <p class="text-sm text-gray-500 mt-1">Atau Bank Lain (Mandiri, BNI, dll.) dengan kode bank + nomor VA.</p>
                             <p class="text-sm text-gray-500 mt-1">Pastikan jumlah transfer sesuai hingga digit terakhir.</p>
                         </div>

                         <!-- ... Instruksi E-Wallet ... -->
                          <div>
                              <h3 class="text-lg font-medium text-gray-700 mb-2">E-Wallet (GoPay/OVO/DANA)</h3>
                             <p class="text-gray-600">Scan QR Code berikut menggunakan aplikasi E-Wallet Anda:</p>
                             <div class="mt-2 w-40 h-40">
                                 @php
                                     $qrData = "Payment Code: " . $transaction->transaction_code . "\nAmount: IDR " . number_format($transaction->amount ?? 0, 0, ',', '.');
                                     $encodedQrData = urlencode($qrData);
                                     $qrCodeUrl = "https://quickchart.io/qr?text={$encodedQrData}&size=160";
                                 @endphp
                                 <img src="{{ $qrCodeUrl }}" alt="QR Code Pembayaran" class="border rounded">
                             </div>
                             <p class="text-sm text-gray-500 mt-1">Atau transfer manual ke nomor: <span class="font-mono">0812 3456 7890</span> (a/n Website Konseling)</p>
                         </div>
                     </div>

                     <div class="mt-8 border-t pt-6 text-center space-y-4">
                         <p class="text-gray-600">Pembayaran Anda akan diverifikasi oleh Admin dalam waktu 1x24 jam. Status sesi akan otomatis terkonfirmasi setelah verifikasi berhasil.</p>

                         <!-- ============================================== -->
                         <!--       FORM SIMULASI PEMBAYARAN DI SINI       -->
                         <!-- ============================================== -->
                         
                         <form action="{{ route('patient.payment.simulate', $transaction->id) }}" method="POST">
                             @csrf <!-- Token Keamanan Laravel, wajib ada -->
                             <button type="submit" class="px-6 py-3 bg-yellow-500 text-white font-bold rounded-lg shadow-md hover:bg-yellow-600">
                                 Saya Sudah Bayar (Simulasi)
                             </button>
                         </form>
                         <!-- ============================================== -->
                         <!--         AKHIR FORM SIMULASI PEMBAYARAN       -->
                         <!-- ============================================== -->

                         <a href="{{ route('patient.appointments.index') }}" class="inline-block mt-4 px-6 py-2 bg-gray-500 text-white font-semibold rounded-lg shadow-md hover:bg-gray-600">
                             Kembali ke Riwayat Sesi
                         </a>
                     </div>
                 </div>
            </main>
        </div>
    </div>
</body>
</html>

