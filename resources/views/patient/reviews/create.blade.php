<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beri Penilaian Sesi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link.active { background-color: #4A5568; color: #F7FAFC; }
        /* CSS untuk Bintang Rating */
        .rating-stars { display: flex; flex-direction: row-reverse; justify-content: center; }
        .rating-stars input[type="radio"] { display: none; }
        .rating-stars label {
            font-size: 2.5rem; /* Ukuran bintang */
            color: #E5E7EB; /* Warna bintang mati (gray-300) */
            cursor: pointer;
            transition: color 0.2s;
        }
        .rating-stars input[type="radio"]:checked ~ label {
            color: #F59E0B; /* Warna bintang hidup (yellow-500) */
        }
        .rating-stars label:hover,
        .rating-stars label:hover ~ label {
            color: #F59E0B; /* Warna saat hover */
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen bg-gray-200">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white flex flex-col">
            <!-- ... (Salin kode sidebar lengkap dari file patient/dashboard.blade.php Anda di sini) ... -->
             <div class="px-8 py-6 border-b border-gray-700">
                <h2 class="text-2xl font-semibold">Panel Pasien</h2>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-2">
                <!-- ... (Salin semua link <nav> dari file patient/dashboard.blade.php Anda di sini) ... -->
                <a href="{{ route('patient.dashboard') }}" class="sidebar-link ...">Dashboard</a>
                <a href="{{ route('patient.counselors.index') }}" class="sidebar-link ...">Cari Konselor</a>
                <a href="{{ route('patient.appointments.index', ['view' => 'upcoming']) }}" class="sidebar-link ...">Jadwal Saya</a>
                <a href="{{ route('patient.appointments.index', ['view' => 'history']) }}" class="sidebar-link ... active">Riwayat Sesi</a> <!-- Buat ini aktif -->
                <a href="{{ route('patient.profile.edit') }}" class="sidebar-link ...">Profil Saya</a>
            </nav>
            <div class="px-8 py-6 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="w-full ...">Logout</button></form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-md p-6">
                <h1 class="text-2xl font-semibold text-gray-700">Beri Penilaian Sesi</h1>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold mb-2">Sesi Selesai</h2>
                        <p class="text-gray-600 mb-2">dengan <strong>{{ $appointment->counselor->name }}</strong></p>
                        <p class="text-sm text-gray-500 mb-6">{{ $appointment->schedule_time->isoFormat('dddd, D MMMM YYYY, HH:mm') }} WIB</p>
                    </div>

                    <form action="{{ route('patient.reviews.store', $appointment->id) }}" method="POST">
                        @csrf
                        
                        <!-- Peringkat Bintang -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-center">Beri Rating Anda</label>
                            <div class="rating-stars">
                                <!-- Bintang 5 ke 1 (dibalik agar CSS :hover ~ bekerja) -->
                                <input type="radio" id="star5" name="rating" value="5" required><label for="star5" title="5 bintang">★</label>
                                <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="4 bintang">★</label>
                                <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="3 bintang">★</label>
                                <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="2 bintang">★</label>
                                <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="1 bintang">★</label>
                            </div>
                             @error('rating') <p class="text-red-500 text-xs text-center mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Komentar/Testimoni -->
                        <div class="mb-6">
                            <label for="comment" class="block text-gray-700 text-sm font-bold mb-2">Tulis Testimoni (Opsional)</label>
                            <textarea name="comment" id="comment" rows="5" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ceritakan pengalaman konseling Anda...">{{ old('comment') }}</textarea>
                             @error('comment') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('patient.appointments.index', ['view' => 'history']) }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Nanti Saja</a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700">Kirim Penilaian</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>