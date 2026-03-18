<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Pasien - Website Konseling</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center py-12 px-4">

    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
        <div class="flex justify-center mb-6">
             <h2 class="text-2xl font-bold text-center text-gray-800">MindWell</h2>
        </div>
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Buat Akun Pasien</h2>

        <!-- ============================================== -->
        <!--     BLOK UNTUK MENAMPILKAN ERROR VALIDASI      -->
        <!-- ============================================== -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- ============================================== -->

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nama -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Email -->
            <div class="mt-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <!-- REVISI BARU: Nomor HP -->
            <div class="mt-4">
                <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                <input id="phone_number" type="tel" name="phone_number" value="{{ old('phone_number') }}" required
                       class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: 08123456789">
            </div>

            <!-- REVISI BARU: Umur & Jenis Kelamin -->
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                     <label for="age" class="block text-sm font-medium text-gray-700">Umur</label>
                    <input id="age" type="number" name="age" value="{{ old('age') }}" required
                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="25">
                </div>
                 <div>
                     <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select id="gender" name="gender" required
                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih...</option>
                        <option value="pria" @if(old('gender') == 'pria') selected @endif>Pria</option>
                        <option value="wanita" @if(old('gender') == 'wanita') selected @endif>Wanita</option>
                    </select>
                </div>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                       class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <!-- Konfirmasi Password -->
            <div class="mt-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Tombol Register -->
            <div class="mt-6">
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Register
                </button>
            </div>
        </form>
        
        <p class="text-sm text-center text-gray-600 mt-6">
            Sudah punya akun? <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">Login di sini</a>
        </p>
        <p class="text-sm text-center text-gray-600 mt-2">
            Mendaftar sebagai Konselor? <a href="{{ route('counselor.register') }}" class="font-medium text-green-600 hover:text-green-500">Klik di sini</a>
        </p>
    </div>

</body>
</html>