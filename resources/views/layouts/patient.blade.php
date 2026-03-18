<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MindWell')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* CSS Aktif dari kode Anda */
        .sidebar-link.active { background-color: #4A5568; color: #F7FAFC; } 
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        
        <div class="w-64 bg-gray-900 text-white flex flex-col hidden md:flex shadow-xl">
            <div class="px-8 py-6 border-b border-gray-700 flex items-center space-x-2">
                <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center">
                    <span class="text-xl font-bold">M</span>
                </div>
                <h2 class="text-xl font-bold tracking-wide">MindWell</h2>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-2">
                
                <a href="{{ route('patient.dashboard') }}" 
                   class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-xl transition-all duration-200 {{ request()->routeIs('patient.dashboard') ? 'active shadow-lg' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                    <span class="font-medium">Beranda</span>
                </a>
                
                <a href="{{ route('patient.appointments.index', ['view' => 'upcoming']) }}" 
                   class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-xl transition-all duration-200 {{ (request()->routeIs('patient.appointments.index') && request('view') != 'history') ? 'active shadow-lg' : '' }}">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <span class="font-medium">Jadwal Saya</span>
                </a>

                <a href="{{ route('patient.appointments.index', ['view' => 'history']) }}" 
                   class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-xl transition-all duration-200 {{ (request()->routeIs('patient.appointments.index') && request('view') == 'history') ? 'active shadow-lg' : '' }}">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="font-medium">Riwayat Sesi</span>
                </a>

                <a href="{{ route('patient.profile.edit') }}" 
                   class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-xl transition-all duration-200 {{ request()->routeIs('patient.profile.edit') ? 'active shadow-lg' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span class="font-medium">Profil Saya</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2 text-red-400 hover:bg-red-500/10 hover:text-red-300 rounded-lg transition-colors">
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden relative">
            
            <header class="bg-white shadow-sm z-10">
                <div class="px-6 py-4 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            @yield('header_title', 'Halo, ' . Auth::user()->name . ' 👋')
                        </h1>
                        <p class="text-sm text-gray-500">
                            @yield('header_subtitle', 'Bagaimana perasaan Anda hari ini?')
                        </p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-gray-200 overflow-hidden border-2 border-indigo-100">
                         <img src="{{ Auth::user()->photo_path ? asset('storage/'.Auth::user()->photo_path) : 'https://placehold.co/100x100/E2E8F0/94A3B8?text='.substr(Auth::user()->name, 0, 1) }}" alt="Profile" class="object-cover w-full h-full">
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r shadow-sm flex items-center">
                        <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>