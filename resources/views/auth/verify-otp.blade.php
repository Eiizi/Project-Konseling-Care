<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Verifikasi Email</h2>
            <p class="text-gray-500 text-sm mt-2">
                Kami telah mengirimkan kode 6 digit ke: <br>
                <span class="font-semibold text-indigo-600">{{ session('verification_email') }}</span>
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('otp.verify.store') }}">
            @csrf
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kode OTP</label>
                <input type="text" name="otp" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-center text-2xl tracking-[0.5em]" 
                       placeholder="XXXXXX" maxlength="6" required autofocus autocomplete="off">
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 font-bold transition duration-300">
                Verifikasi & Masuk
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('register') }}" class="text-sm text-gray-500 hover:text-indigo-600">Salah email? Daftar ulang</a>
        </div>
    </div>
</body>
</html>