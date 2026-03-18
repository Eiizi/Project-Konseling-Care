@extends('layouts.counselor_layout')

@section('header_title', 'Sesi Akan Datang')
@section('header_subtitle', 'Daftar konsultasi yang menunggu giliran atau segera dimulai.')

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu Jadwal</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pasien</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Metode</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Status</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                {{-- PERBAIKAN: Gunakan $upcomingAppointments --}}
                @forelse($upcomingAppointments as $app)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-lg font-bold text-gray-800">{{ $app->schedule_time->format('H:i') }}</span>
                                <span class="text-xs text-gray-500">{{ $app->schedule_time->isoFormat('dddd, D MMMM YYYY') }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold mr-3">
                                    {{ substr($app->patient->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $app->patient->name }}</p>
                                    <p class="text-xs text-gray-500">ID: #{{ $app->patient->id }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            @if($app->meeting_type == 'offline')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Tatap Muka
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10z"/></svg>
                                    Video Call
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($app->status == 'confirmed')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">SIAP DIMULAI</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">{{ strtoupper($app->status) }}</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right">
                            @if($app->status == 'confirmed')
                                <form action="{{ route('counselor.appointments.start', $app->id) }}" method="POST" onsubmit="return confirm('Mulai sesi ini sekarang?')" class="inline-block">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg transition-colors shadow-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Mulai Sesi
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('counselor.appointments.show', $app->id) }}" class="text-gray-500 hover:text-indigo-600 font-medium text-sm">Detail</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">Tidak ada jadwal mendatang</h3>
                                <p class="text-sm text-gray-500 mt-1">Saat ini Anda tidak memiliki sesi yang harus ditangani.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection