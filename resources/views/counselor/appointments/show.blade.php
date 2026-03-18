@extends('layouts.counselor_layout')

@section('header_title', 'Detail Sesi')
@section('header_subtitle', 'Informasi lengkap sesi konsultasi.')

@section('content')
<div class="max-w-4xl mx-auto">
    
    {{-- Tombol Kembali --}}
    <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-indigo-600 mb-6 inline-flex items-center transition-colors">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>

    {{-- Kartu Info Pasien --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-6 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center text-xl font-bold text-indigo-600">
                {{ substr($appointment->patient->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $appointment->patient->name }}</h2>
                <p class="text-gray-500">{{ $appointment->patient->email }}</p>
                <div class="mt-1 flex gap-3 text-xs text-gray-400">
                    <span>{{ $appointment->patient->phone_number ?? '-' }}</span>
                    <span>&bull;</span>
                    <span>{{ $appointment->patient->age ?? '-' }} Thn</span>
                    <span>&bull;</span>
                    <span>{{ ucfirst($appointment->patient->gender ?? '-') }}</span>
                </div>
            </div>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-400 uppercase tracking-wide font-semibold">Jadwal Sesi</p>
            <p class="text-xl font-bold text-indigo-600">{{ $appointment->schedule_time->format('H:i') }} WIB</p>
            <p class="text-sm text-gray-600">{{ $appointment->schedule_time->isoFormat('dddd, D MMMM YYYY') }}</p>
            
            <div class="mt-2">
                @if($appointment->status == 'completed')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Selesai</span>
                @elseif($appointment->status == 'cancelled')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Dibatalkan</span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($appointment->status) }}</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Link Meeting / Lokasi --}}
    @if($appointment->meeting_type == 'online')
        <div class="bg-blue-50 border border-blue-100 p-6 rounded-2xl flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h3 class="font-bold text-blue-900 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    Sesi Online (Video Call)
                </h3>
                <p class="text-sm text-blue-700 mt-1">Gunakan link berikut untuk memulai sesi.</p>
            </div>
            <a href="{{ $appointment->meeting_link ?? '#' }}" target="_blank" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-sm w-full md:w-auto text-center">
                Buka Google Meet
            </a>
        </div>
    @else
        <div class="bg-purple-50 border border-purple-100 p-6 rounded-2xl flex items-center">
            <svg class="w-8 h-8 text-purple-600 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <div>
                <h3 class="font-bold text-purple-900">Sesi Offline (Tatap Muka)</h3>
                <p class="text-sm text-purple-700">Pasien akan datang ke lokasi praktik Anda.</p>
            </div>
        </div>
    @endif

    {{-- [BARU] Bagian Tombol Aksi (Catatan & Mulai Sesi) --}}
    <div class="mt-8 flex flex-wrap justify-end gap-4">
        
        {{-- TOMBOL MULAI (Jika belum selesai) --}}
        @if($appointment->status == 'confirmed')
            <form action="{{ route('counselor.appointments.start', $appointment->id) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="flex items-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow hover:bg-indigo-700 transition" onclick="return confirm('Mulai sesi ini dan tandai sebagai Selesai?')">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Mulai & Selesaikan Sesi
                </button>
            </form>
        @endif

        {{-- TOMBOL CATATAN (Hanya muncul jika status SELESAI) --}}
        @if($appointment->status == 'completed')
            <a href="{{ route('counselor.notes.show', $appointment->id) }}" class="flex items-center px-6 py-3 bg-green-600 text-white font-bold rounded-xl shadow hover:bg-green-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Berikan Catatan Pasien
            </a>
        @endif
    </div>

</div>
@endsection