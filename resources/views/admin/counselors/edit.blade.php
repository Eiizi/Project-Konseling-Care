<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit/Verifikasi Konselor</title>
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
                <h2 class="text-2xl font-semibold">Admin Panel</h2>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-2">
                 <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center px-4 py-2 text-gray-300 ...">Dashboard</a>
                 <a href="{{ route('admin.counselors.index') }}" class="sidebar-link flex items-center px-4 py-2 text-gray-100 bg-gray-700 ...">Manajemen Konselor</a>
                 <a href="{{ route('admin.patients.index') }}" class="sidebar-link flex items-center px-4 py-2 text-gray-300 ...">Manajemen Pasien</a>
                 <a href="{{ route('admin.schedules.index') }}" class="sidebar-link flex items-center px-4 py-2 text-gray-300 ...">Manajemen Jadwal</a>
                <a href="{{ route('admin.transactions.index') }}" class="sidebar-link flex items-center px-4 py-2 text-gray-300 ...">Manajemen Transaksi</a>
            </nav>
            <div class="px-8 py-6 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="w-full ...">Logout</button></form>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-md p-6">
                <h1 class="text-2xl font-semibold text-gray-700">Detail & Verifikasi Konselor</h1>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                
                <div class="bg-white rounded-lg shadow-md p-6 max-w-3xl mx-auto">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.counselors.update', $counselor->id) }}" method="POST">
                        @csrf
                        @method('PUT') 
                        
                        <div class="mb-6 border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Diri</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $counselor->name) }}" required
                                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $counselor->email) }}" required
                                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>
                        </div>

                        <div class="mb-6 border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Dokumen Verifikasi</h3>
                            <div class="space-y-3">
                                <p>
                                    <a href="{{ $counselor->profile?->certificate_url ? asset('storage/' . $counselor->profile->certificate_url) : '#' }}" target="_blank" class="text-blue-600 hover:underline">Lihat File Sertifikat/Lisensi</a>
                                    @if(!$counselor->profile?->certificate_url) <span class="text-red-500 text-sm">(Belum di-upload)</span> @endif
                                </p>
                                <p>
                                    <a href="{{ $counselor->profile?->cv_url ? asset('storage/' . $counselor->profile->cv_url) : '#' }}" target="_blank" class="text-blue-600 hover:underline">Lihat File CV</a>
                                     @if(!$counselor->profile?->cv_url) <span class="text-red-500 text-sm">(Belum di-upload)</span> @endif
                                </p>
                                 <p>
                                    <a href="{{ $counselor->profile?->identity_url ? asset('storage/' . $counselor->profile->identity_url) : '#' }}" target="_blank" class="text-blue-600 hover:underline">Lihat File Identitas (KTP)</a>
                                     @if(!$counselor->profile?->identity_url) <span class="text-red-500 text-sm">(Belum di-upload)</span> @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pengaturan Admin</h3>
                            <div class="mb-4">
                                <label for="rate" class="block text-sm font-medium text-gray-700">Harga per Sesi (Rp)</label>
                                <input type="number" name="rate" id="rate" value="{{ old('rate', $counselor->profile?->rate ?? 0) }}" required
                                       class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                                       placeholder="Contoh: 100000">
                                <p class="mt-1 text-xs text-gray-500">Masukkan harga tanpa titik atau koma. Harga ini adalah **harga dasar** sebelum ditambah fee admin 30%.</p>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="hidden" name="is_verified" value="0"> <input id="is_verified" name="is_verified" type="checkbox" value="1" 
                                       @if(old('is_verified', $counselor->profile?->is_verified)) checked @endif
                                       class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="is_verified" class="ml-2 block text-sm font-medium text-gray-900">
                                    Konselor Terverifikasi (Aktif)
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4 border-t pt-6">
                            <a href="{{ route('admin.counselors.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700">
                                Update Konselor
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>