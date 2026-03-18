<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Konselor Baru</title>
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
                <h2 class="text-2xl font-semibold">Admin Panel</h2>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.counselors.index') }}" class="flex items-center px-4 py-2 text-gray-100 bg-gray-700 rounded-md">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21v-1a6 6 0 00-5.173-5.917M9 21a6 6 0 01-6-6v-1a6 6 0 016-6v12z" /></svg>
                    Manajemen Konselor
                </a>
                 <!-- Link lain bisa ditambahkan di sini -->
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-md p-6">
                <h1 class="text-2xl font-semibold text-gray-700">Tambah Konselor Baru</h1>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                 <div class="bg-white rounded-lg shadow-md p-8 max-w-2xl mx-auto">
                    
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.counselors.store') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                             <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" name="password" id="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="mt-4">
                            <label for="rate" class="block text-sm font-medium text-gray-700">Harga per Sesi (Rp)</label>
                            <input type="number" name="rate" id="rate" value="{{ old('rate', 100000) }}" required 
                             class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                             placeholder="Contoh: 100000">
                            <p class="mt-1 text-xs text-gray-500">Masukkan harga tanpa titik atau koma.</p>
                            </div>
                            <div class="mt-8 flex justify-end space-x-4">
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('admin.counselors.index') }}" class="px-5 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300">
                                Batal
                            </a>
                             <button type="submit" class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700">
                                Simpan Konselor
                            </button>
                        </div>

                        
                    </form>
                </div>
            </main>
        </div>
    </div>

</body>
</html>
