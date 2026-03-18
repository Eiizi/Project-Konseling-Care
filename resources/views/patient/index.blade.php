<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Konselor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex h-screen bg-gray-200">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="px-8 py-6 border-b border-gray-700">
                <h2 class="text-2xl font-semibold">Panel Pasien</h2>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-2">
                <a href="{{ route('patient.dashboard') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                    Dashboard
                </a>
                <a href="{{ route('patient.counselors.index') }}" class="flex items-center px-4 py-2 text-gray-100 bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    Cari Konselor
                </a>
                <a href="#" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    Jadwal Saya
                </a>
                <a href="#" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Riwayat Sesi
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
                <h1 class="text-2xl font-semibold text-gray-700">Temukan Konselor Anda</h1>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <!-- Filter (Contoh) -->
                <div class="mb-6 bg-white p-4 rounded-lg shadow">
                    <input type="text" placeholder="Cari berdasarkan nama atau spesialisasi..." class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Daftar Konselor -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($counselors as $counselor)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                            <div class="p-6 flex-1">
                                <div class="flex items-center mb-4">
                                    <img class="h-20 w-20 rounded-full object-cover" src="{{ $counselor->profile->photo ?? 'https://placehold.co/100x100/E2E8F0/94A3B8?text=Foto' }}" alt="Foto Konselor">
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $counselor->name }}</h3>
                                        <p class="text-sm text-blue-600 font-medium">{{ $counselor->profile->specializations ?? 'Spesialisasi belum diatur' }}</p>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-4 min-h-[60px]">
                                    {{ Str::limit($counselor->profile->bio ?? 'Bio belum tersedia.', 120) }}
                                </p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-1" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                    5.0 (23 Ulasan)
                                </div>
                            </div>
                            <div class="bg-gray-50 p-4">
                                <a href="#" class="block text-center w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700">
                                    Lihat Profil & Jadwal
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 col-span-3 text-center">Belum ada konselor yang tersedia.</p>
                    @endforelse
                </div>
                
            </main>
        </div>
    </div>
</body>
</html>
