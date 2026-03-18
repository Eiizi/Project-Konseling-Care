<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Konselor - Website Konseling</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-12">

    <div class="w-full max-w-lg bg-white rounded-lg shadow-md p-8">
        <div class="flex justify-center mb-6">
            <h2 class="text-2xl font-bold text-center text-gray-800">MindWell Counselor</h2>
        </div>

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Daftar sebagai Konselor</h2>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('counselor.register.store') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap (beserta gelar)</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mt-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                       class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mt-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mt-6 border-t pt-6 space-y-4">
                <p class="text-sm text-gray-600">Unggah dokumen Anda untuk verifikasi. (Format: PDF, JPG, PNG. Maks: 2MB)</p>

                <div>
                    <label for="certificate_file" class="block text-sm font-medium text-gray-700">File Sertifikat / Lisensi (SIP/STR)</label>
                    <input id="certificate_file" type="file" name="certificate_file" required
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div>
                    <label for="cv_file" class="block text-sm font-medium text-gray-700">File CV (Curriculum Vitae) (PDF)</label>
                    <input id="cv_file" type="file" name="cv_file" required accept=".pdf"
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                 <div>
                    <label for="identity_file" class="block text-sm font-medium text-gray-700">File Identitas (KTP/Paspor)</label>
                    <input id="identity_file" type="file" name="identity_file" required
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>


            <div class="mt-6">
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Daftar & Ajukan Verifikasi
                </button>
            </div>
        </form>

        <p class="text-sm text-center text-gray-600 mt-6">
            Sudah punya akun? <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">Login di sini</a>
        </p>
         <p class="text-sm text-center text-gray-600 mt-2">
            Daftar sebagai Pasien? <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">Daftar di sini</a>
        </p>
    </div>

</body>
</html>