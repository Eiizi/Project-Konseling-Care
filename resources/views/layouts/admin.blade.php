<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - MindWell</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-slate-900 text-white flex flex-col shadow-xl z-20 hidden md:flex">
            <div class="h-20 flex items-center px-8 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center font-bold text-white text-xl">M</div>
                    <span class="text-lg font-bold tracking-wide">MindWell Admin</span>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Menu Utama</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Dashboard
                </a>

                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-6">Manajemen Data</p>

                <a href="{{ route('admin.counselors.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.counselors.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Manajemen Konselor
                </a>

                <a href="{{ route('admin.patients.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.patients.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Manajemen Pasien
                </a>

                <a href="{{ route('admin.schedules.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.schedules.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Manajemen Jadwal
                </a>

                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-6">Keuangan</p>

                <a href="{{ route('admin.transactions.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.transactions.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Transaksi
                </a>

                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-6">Sistem</p>

                
                @if(Auth::user()->role === 'super_admin')
                    <a href="{{ route('admin.admins.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.admins.*') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Manajemen Admin
                    </a>
                @endif
               

                <a href="{{ route('admin.profile.edit') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.profile.*') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profil Saya
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-3 text-red-400 hover:bg-slate-800 hover:text-red-300 rounded-xl transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50 relative">
            <header class="h-20 bg-white shadow-sm flex items-center justify-between px-8 z-10">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">@yield('header_title', 'Admin Dashboard')</h1>
                    <p class="text-sm text-gray-500">@yield('header_subtitle', 'Selamat datang di panel administrator.')</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                       
                        <p class="text-xs text-indigo-600 font-medium">
                            {{ Auth::user()->role === 'super_admin' ? 'Super Admin' : 'Administrator' }}
                        </p>
                    </div>

                    
                    <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-200 overflow-hidden">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover" alt="Foto Profil">
                        @else
                            {{ substr(Auth::user()->name, 0, 1) }}
                        @endif
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-x-hidden overflow-y-auto p-8">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg flex items-center shadow-sm">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>