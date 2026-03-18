<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Website Konseling</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
        <!-- Logo Anda -->
        <div class="flex justify-center mb-6">
            <!-- Ganti dengan logo Anda -->
            <h2 class="text-2xl font-bold text-center text-gray-800">MindWell</h2>
        </div>

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Login ke Akun Anda</h2>

        <!-- Session Status (Pesan setelah daftar konselor) -->
        @if (session('status'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('status') }}
            </div>
        @endif
        
        <!-- Menampilkan Error Validasi Login -->
         @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc pl-5">
                    <li>Email atau password salah.</li>
                </ul>
            </div>
        @endif


        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Alamat Email -->
            <div>
                <label for="email" class...="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus
                       class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                       class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Remember Me & Lupa Password -->
            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                    <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 hover:text-blue-800" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <!-- Tombol Login -->
            <div class="mt-6">
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Login
                </button>
            </div>
        </form>
        
        <!-- ============================================== -->
        <!--           REVISI LINK REGISTER DI SINI         -->
        <!-- ============================================== -->
        <p class="text-sm text-center text-gray-600 mt-6">
            Belum punya akun? <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">Daftar sebagai Pasien</a>
        </p>
        <p class="text-sm text-center text-gray-600 mt-2">
            Ingin mendaftar sebagai Konselor? <a href="{{ route('counselor.register') }}" class="font-medium text-green-600 hover:text-green-500">Daftar di sini</a>
        </p>
        <!-- ============================================== -->
        <!--             AKHIR REVISI LINK                -->
        <!-- ============================================== -->
    </div>

</body>
</html>
