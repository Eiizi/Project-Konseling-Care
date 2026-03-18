@extends('layouts.patient')

@section('title', 'Dashboard Pasien')

@section('content')
    
    @if($nextSession)
    <div class="mb-8 bg-gradient-to-r from-indigo-600 to-blue-500 rounded-2xl shadow-lg text-white p-6 flex flex-col md:flex-row items-center justify-between relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-white opacity-10 rounded-full blur-xl"></div>
        
        <div class="z-10">
            <h3 class="text-lg font-semibold opacity-90">Sesi Konseling Berikutnya</h3>
            <p class="text-3xl font-bold mt-1">{{ \Carbon\Carbon::parse($nextSession->schedule_time)->isoFormat('dddd, D MMMM YYYY') }}</p>
            <p class="text-lg mt-1 opacity-90">Pukul {{ \Carbon\Carbon::parse($nextSession->schedule_time)->format('H:i') }} WIB</p>
            <div class="mt-4 flex items-center">
                <div class="flex -space-x-2 mr-3">
                    <img class="w-8 h-8 rounded-full border-2 border-indigo-500 object-cover" src="{{ $nextSession->counselor->profile?->photo ? asset('storage/'.$nextSession->counselor->profile->photo) : 'https://placehold.co/100' }}" alt="Counselor">
                </div>
                <span>Bersama <strong>{{ $nextSession->counselor->name }}</strong></span>
            </div>
        </div>
        <div class="mt-6 md:mt-0 z-10">
             <a href="{{ route('patient.session.show', $nextSession->id) }}" class="px-6 py-3 bg-white text-indigo-600 font-bold rounded-xl shadow-md hover:bg-gray-50 transition transform hover:-translate-y-1">
                Masuk Ruang Sesi
            </a>
        </div>
    </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Pilih Konselor Anda</h2>
            <p class="text-gray-500 mt-1">Temukan profesional yang tepat untuk mendengarkan Anda.</p>
        </div>
        <div class="w-full md:w-auto">
            <form action="{{ route('patient.dashboard') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau kode..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full md:w-64 text-sm shadow-sm">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($counselors as $counselor)
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">
                <div class="p-6 flex-grow flex flex-col items-center text-center">
                    
                    <div class="relative mb-3">
                        <img class="h-24 w-24 rounded-full object-cover border-4 border-indigo-50 shadow-sm" 
                             src="{{ $counselor->profile?->photo ? asset('storage/'.$counselor->profile->photo) : 'https://placehold.co/150x150/E2E8F0/94A3B8?text=Foto' }}" 
                             alt="{{ $counselor->name }}">
                    </div>

                    <div class="mb-2">
                        <span class="inline-block px-2 py-0.5 bg-gray-50 text-indigo-600 text-[10px] font-mono font-bold rounded border border-indigo-100 tracking-wider">
                            {{ $counselor->counselor_code }}
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 leading-tight mb-1">{{ $counselor->name }}</h3>
                    <p class="text-sm text-gray-500 font-medium mb-3">{{ $counselor->profile?->specializations ?? 'Psikolog Umum' }}</p>
                    
                    <div class="mt-auto w-full pt-4 border-t border-gray-100">
                        <p class="text-lg font-bold text-gray-800 mb-4">
                            Rp {{ number_format($counselor->profile?->rate ?? 100000, 0, ',', '.') }}
                        </p>
                        <a href="{{ route('patient.counselors.show', $counselor->id) }}" class="block w-full py-2.5 bg-white border border-indigo-600 text-indigo-600 font-semibold rounded-xl hover:bg-indigo-600 hover:text-white transition-colors duration-300 text-center">
                            Lihat Profil
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Tidak ada konselor ditemukan</h3>
                <p class="text-gray-500">Coba cari dengan kata kunci lain.</p>
            </div>
        @endforelse
    </div>
@endsection