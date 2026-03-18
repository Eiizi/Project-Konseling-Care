<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pasien Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen bg-gray-200">
        <div class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="px-8 py-6 border-b border-gray-700">
                <h2 class="text-2xl font-semibold">Admin Panel</h2>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.counselors.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    Manajemen Konselor
                </a>
                <a href="{{ route('admin.patients.index') }}" class="flex items-center px-4 py-2 text-gray-100 bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Manajemen Pasien
                </a>
                <a href="{{ route('admin.schedules.index') }}" class="sidebar-link flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    Manajemen Jadwal
                </a>
                <a href="#" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                    Manajemen Transaksi
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
                <h1 class="text-2xl font-semibold text-gray-700">Tambah Pasien Baru</h1>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                
                <div class="bg-white rounded-lg shadow-md p-6 max-w-lg mx-auto">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.patients.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                   class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</B></label>
                            <input type="password" name="password" id="password" required
                                   class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</B></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                   class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('admin.patients.index') }}" class="mr-4 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
                                Simpan Pasien
                            </button>
                        </div>
                    </form>
                </div>

            </main>
        </div>
    </div>
</body>
</html>