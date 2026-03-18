@extends('layouts.admin')

@section('header_title', 'Tambah Admin')
@section('header_subtitle', 'Daftarkan administrator baru.')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.admins.index') }}" class="inline-flex items-center text-gray-500 hover:text-indigo-600 mb-6 transition">
        &larr; Kembali
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Informasi Akun</h3>
        
        <form action="{{ route('admin.admins.store') }}" method="POST">
            @csrf
            
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                    </div>
                </div>

                <div class="bg-blue-50 p-4 rounded-xl text-sm text-blue-700 flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p>Admin baru akan didaftarkan dengan status <strong>Pending</strong>. Anda atau admin lain perlu melakukan verifikasi di halaman daftar admin agar akun tersebut bisa digunakan.</p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition transform hover:-translate-y-1">
                    Daftarkan Admin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection