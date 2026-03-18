@extends('layouts.counselor_layout')

@section('header_title', 'Edit Profil')
@section('header_subtitle', 'Perbarui informasi profesional dan akun Anda.')

@section('content')

<div class="max-w-5xl mx-auto">
    <form action="{{ route('counselor.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="md:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center sticky top-6">
                    <div class="relative inline-block mb-4 group">
                        <div class="w-36 h-36 bg-gray-200 rounded-full overflow-hidden mx-auto border-4 border-white shadow-lg">
                            @if(Auth::user()->profile_photo_path)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Profile" class="w-full h-full object-cover group-hover:opacity-75 transition">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-5xl font-bold text-gray-400 bg-gray-100 group-hover:bg-gray-200 transition">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <label for="photo" class="absolute bottom-1 right-1 bg-indigo-600 text-white p-2.5 rounded-full cursor-pointer hover:bg-indigo-700 shadow-md transition-transform transform hover:scale-110">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </label>
                        <input type="file" name="profile_photo" id="photo" class="hidden">
                    </div>
                    <h3 class="font-bold text-xl text-gray-900">{{ Auth::user()->name }}</h3>
                    <p class="text-sm text-gray-500 mb-4">{{ $user->profile->specializations ?? 'Konselor Profesional' }}</p>
                    
                    <div class="flex justify-center gap-2">
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-full">STR: {{ $user->profile->str_number ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-1 h-6 bg-indigo-500 rounded mr-3"></div>
                        <h4 class="text-lg font-bold text-gray-800">Informasi Dasar</h4>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap & Gelar</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-xl border-gray-300 bg-gray-50 text-gray-500 shadow-sm cursor-not-allowed" readonly>
                        </div>
                    </div>

                    <div class="flex items-center mb-6">
                        <div class="w-1 h-6 bg-purple-500 rounded mr-3"></div>
                        <h4 class="text-lg font-bold text-gray-800">Detail Profesional</h4>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Spesialisasi</label>
                            <input type="text" name="specializations" value="{{ old('specializations', $user->profile->specializations ?? '') }}" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="Contoh: Psikolog Klinis">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor STR</label>
                            <input type="text" name="str_number" value="{{ old('str_number', $user->profile->str_number ?? '') }}" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Biaya per Sesi (Rp)</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="rate" value="{{ old('rate', $user->profile->rate ?? '') }}" class="w-full pl-10 rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Praktik (Offline)</label>
                            <textarea name="address" rows="3" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">{{ old('address', $user->profile->address ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-8 border-t border-gray-100 pt-6 text-right">
                        <button type="submit" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-lg text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-1">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection