@extends('layouts.patient')

@section('title', 'Profil ' . $counselor->name)

@section('header_title', 'Detail Konselor')
@section('header_subtitle', 'Lihat profil lengkap dan pilih jadwal konsultasi.')

@section('content')

<div class="space-y-6">
    
    {{-- TOMBOL KEMBALI --}}
    <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 transition-colors mb-2">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Konselor
    </a>

    {{-- KARTU PROFIL KONSELOR --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 flex flex-col md:flex-row gap-8 items-start">
            
            <div class="flex-shrink-0 mx-auto md:mx-0">
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-indigo-50 shadow-md">
                    <img src="{{ $counselor->profile?->photo ? asset('storage/'.$counselor->profile->photo) : 'https://placehold.co/200x200/E2E8F0/94A3B8?text='.substr($counselor->name, 0, 1) }}" 
                         alt="{{ $counselor->name }}" 
                         class="w-full h-full object-cover">
                </div>
            </div>

            <div class="flex-1 text-center md:text-left space-y-3">
                <div>
                    <div class="mb-2 flex justify-center md:justify-start">
                        <span class="inline-block px-2 py-1 bg-indigo-50 text-indigo-700 text-xs font-mono font-bold rounded-md border border-indigo-100" title="Kode Identitas Konselor">
                            {{ $counselor->counselor_code }}
                        </span>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900">{{ $counselor->name }}</h2>
                    <p class="text-indigo-600 font-medium">{{ $counselor->profile?->specializations ?? 'Psikolog Umum' }}</p>
                </div>

                <div class="flex flex-wrap justify-center md:justify-start gap-4 text-sm text-gray-600">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Pengalaman: {{ $counselor->profile?->experience_years ?? 0 }} Tahun
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        {{ number_format($counselor->average_rating, 1) }} ({{ $counselor->review_count }} Ulasan)
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Tentang Konselor</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        {{ $counselor->profile?->bio ?? 'Belum ada deskripsi singkat untuk konselor ini.' }}
                    </p>
                </div>
            </div>

            <div class="w-full md:w-auto bg-gray-50 p-6 rounded-xl border border-gray-200 text-center md:text-right min-w-[200px]">
                <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-1">Biaya Sesi</p>
                <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($counselor->profile?->rate ?? 100000, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-1">per 60 menit</p>
            </div>
        </div>
    </div>

    {{-- BAGIAN PILIH JADWAL --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Pilih Jadwal Konseling
        </h3>

        @if(empty($availableSlots))
            
            <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h4 class="text-lg font-medium text-gray-900">Jadwal Belum Tersedia</h4>
                <p class="text-gray-500 max-w-sm mx-auto mt-2">Konselor ini belum mengatur jadwal ketersediaan. Silakan cek konselor lain atau kembali nanti.</p>
            </div>

        @else
            
            <form action="{{ route('patient.booking.store') }}" method="POST">
                @csrf
                <input type="hidden" name="counselor_id" value="{{ $counselor->id }}">
                
                {{-- PILIHAN METODE --}}
                <div class="mb-8 bg-indigo-50 p-5 rounded-xl border border-indigo-100">
                    <label class="block text-sm font-bold text-gray-800 mb-4">Metode Konseling:</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="relative flex items-center p-4 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-500 hover:shadow-md transition-all group">
                            <input type="radio" name="meeting_type" value="online" checked class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                            <div class="ml-4">
                                <span class="block text-sm font-bold text-gray-900 group-hover:text-indigo-700">Online (Video Call)</span>
                                <span class="block text-xs text-gray-500 mt-0.5">Via Google Meet / Zoom</span>
                            </div>
                        </label>

                        <label class="relative flex items-center p-4 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-500 hover:shadow-md transition-all group">
                            <input type="radio" name="meeting_type" value="offline" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                            <div class="ml-4">
                                <span class="block text-sm font-bold text-gray-900 group-hover:text-indigo-700">Offline (Tatap Muka)</span>
                                <span class="block text-xs text-gray-500 mt-0.5">Datang ke Lokasi Klinik</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="space-y-8">
                    @foreach($availableSlots as $date => $data)
                        <div>
                            <h4 class="flex items-center text-base font-semibold text-gray-800 mb-4 border-b border-gray-100 pb-2">
                                <span class="bg-indigo-100 text-indigo-700 py-1 px-3 rounded-md text-sm mr-2">{{ $data['dayName'] }}</span>
                                {{ $data['dateFormatted'] }}
                            </h4>
                            
                            {{-- GRID JAM DENGAN LOGIKA WARNA --}}
                            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-3">
                                @foreach($data['slots'] as $slot)
                                    @php
                                        // Format Y-m-d H:i:00 agar cocok dengan data Controller
                                        $slotVal = $slot->format('Y-m-d H:i:00');
                                        
                                        // CEK STATUS
                                        $isMine = in_array($slotVal, $myAppointments ?? []);
                                        $isTaken = in_array($slotVal, $bookedSlots ?? []);
                                    @endphp

                                    @if($isMine)
                                        {{-- KONDISI 1: JADWAL SAYA (HIJAU - TETAP MUNCUL) --}}
                                        <div class="px-2 py-3 text-sm font-bold rounded-lg border border-green-200 text-green-700 bg-green-100 shadow-sm flex flex-col items-center justify-center cursor-default ring-2 ring-green-500 ring-offset-1">
                                            <span class="mb-1">{{ $slot->format('H:i') }}</span>
                                            <span class="text-[10px] uppercase bg-green-200 px-1.5 rounded">Terjadwal</span>
                                        </div>

                                    @elseif($isTaken)
                                        {{-- KONDISI 2: JADWAL ORANG LAIN (ABU GELAP - TETAP MUNCUL) --}}
                                        <button type="button" disabled class="px-2 py-3 text-sm font-medium rounded-lg border border-gray-600 bg-gray-700 text-white opacity-90 cursor-not-allowed flex flex-col items-center justify-center shadow-inner">
                                            <span class="line-through opacity-50">{{ $slot->format('H:i') }}</span>
                                            <span class="text-[10px] text-gray-300 mt-1 font-bold">BOOKED</span>
                                        </button>

                                    @else
                                        {{-- KONDISI 3: TERSEDIA (PUTIH - BISA DIKLIK) --}}
                                        <button type="submit" 
                                                name="schedule_time" 
                                                value="{{ $slot->format('Y-m-d H:i:s') }}"
                                                onclick="return confirm('Apakah Anda yakin ingin memesan sesi pada {{ $slot->format('d M Y, H:i') }}?')"
                                                class="px-2 py-3 text-sm font-medium rounded-lg border border-gray-200 text-gray-700 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 bg-white shadow-sm hover:shadow-md">
                                            {{ $slot->format('H:i') }}
                                        </button>
                                    @endif

                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
        @endif
    </div>
</div>

@endsection