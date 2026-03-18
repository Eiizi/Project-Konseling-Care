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
        .sidebar-link.active {
            background-color: #4A5568; /* bg-gray-700 */
            color: #F7FAFC; /* text-gray-100 */
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen bg-gray-200">
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

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-md p-6">
                <h1 class="text-2xl font-semibold text-gray-700">Temukan Konselor Anda</h1>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($counselors as $counselor)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col"> 
                            <div class="p-6 flex-grow"> 
                                <div class="flex items-center space-x-4">
                                    <img class="h-16 w-16 rounded-full object-cover flex-shrink-0" src="{{ $counselor->profile?->photo ? asset('storage/'.$counselor->profile->photo) : 'https://placehold.co/100x100/E2E8F0/94A3B8?text=Foto' }}" alt="Foto {{ $counselor->name }}">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $counselor->name }}</h3>
                                        <p class="text-sm text-blue-600 font-medium">{{ $counselor->profile?->specializations ?? 'Spesialisasi belum diatur' }}</p>
                                    </div>
                                </div>
                                <p class="mt-4 text-sm text-gray-600 line-clamp-3">{{ $counselor->profile?->bio ?? 'Bio belum tersedia.' }}</p>
                            </div>
                             <div class="p-6 border-t border-gray-200 mt-auto"> 
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Pengalaman: {{ $counselor->profile?->experience_years ?? 0 }} tahun</span>
                                    <a href="{{ route('patient.counselors.show', ['counselor' => $counselor->id]) }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md hover:bg-blue-700 whitespace-nowrap">
                                        Lihat Profil & Jadwal
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 col-span-full text-center">Belum ada konselor yang tersedia.</p>
                    @endforelse
                </div>
            </main>
        </div>
    </div>
</body>
</html>