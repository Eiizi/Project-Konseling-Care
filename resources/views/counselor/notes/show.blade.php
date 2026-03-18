<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan Sesi Pasien</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link.active { background-color: #4A5568; color: #F7FAFC; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen bg-gray-200">
        <div class="w-64 bg-gray-800 text-white flex flex-col">
             <div class="px-8 py-6 border-b border-gray-700">
                <h2 class="text-2xl font-semibold">Counselor Portal</h2>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-2">
                <a href="{{ route('counselor.dashboard') }}" class="sidebar-link flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('counselor.dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                    Dashboard
                </a>
                <a href="{{ route('counselor.schedules.index') }}" class="sidebar-link flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('counselor.schedules.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    Atur Jadwal
                </a>
                <a href="{{ route('counselor.appointments.upcoming') }}" class="sidebar-link flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('counselor.appointments.upcoming') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    Sesi Akan Datang
                </a>
                <a href="{{ route('counselor.history.index') }}" class="sidebar-link flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('counselor.history.index') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Riwayat Sesi
                </a>
                <a href="{{ route('counselor.profile.edit') }}" class="sidebar-link flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('counselor.profile.edit') ? 'active' : '' }}">
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

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-md p-6">
                <h1 class="text-2xl font-semibold text-gray-700">Catatan Sesi & Feedback Pasien</h1>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                
                 @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow-md">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Detail Sesi</h2>
                         <a href="{{ url()->previous() }}" class="text-gray-600 hover:text-gray-900">&larr; Kembali</a>
                    </div>
                    
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg border">
                        <p><strong>Pasien:</strong> {{ $appointment->patient->name }}</p>
                        <p><strong>Waktu Sesi:</strong> {{ $appointment->schedule_time->format('d M Y, H:i') }} WIB</p>
                        <p><strong>Status:</strong> <span class="font-semibold">{{ ucfirst($appointment->status) }}</span></p>
                    </div>

                    <form action="{{ route('counselor.notes.store', $appointment->id) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="notes" class="block text-gray-700 text-lg font-bold mb-2">Catatan Sesi (Pribadi)</label>
                            <p class="text-sm text-gray-500 mb-3">Catatan ini <strong class="text-red-600">RAHASIA</strong> dan hanya dapat dilihat oleh Anda.</p>
                            <textarea name="notes" id="notes" rows="10" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Tulis catatan perkembangan pasien, topik diskusi, atau rencana sesi berikutnya di sini...">{{ $appointment->sessionNote?->notes }}</textarea>
                             @error('notes') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-6 border-t pt-6">
                            <label for="counselor_feedback" class="block text-gray-700 text-lg font-bold mb-2">Feedback untuk Pasien</label>
                            <p class="text-sm text-gray-500 mb-3">Catatan ini akan dapat <strong class="text-blue-600">DIBACA OLEH PASIEN dan ADMIN</strong>. Berikan rangkuman, penyemangat, atau "PR" untuk sesi berikutnya.</p>
                            <textarea name="counselor_feedback" id="counselor_feedback" rows="5" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Sesi hari ini berjalan baik. Pertahankan journaling harian Anda dan coba teknik pernapasan 4-7-8...">{{ $appointment->counselor_feedback }}</textarea>
                             @error('counselor_feedback') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-green-700">
                                Simpan Catatan & Feedback
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>