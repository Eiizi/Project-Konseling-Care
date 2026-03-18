@extends('layouts.counselor_layout')

@section('header_title', 'Riwayat Sesi')
@section('header_subtitle', 'Arsip seluruh sesi konsultasi yang telah selesai atau dibatalkan.')

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pasien</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis Sesi</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                {{-- KITA GUNAKAN VARIABEL ASLI ANDA: $historyAppointments --}}
                @forelse($historyAppointments as $app)
                    <tr class="hover:bg-gray-50 transition-colors">
                        {{-- WAKTU --}}
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-800">{{ $app->schedule_time->isoFormat('D MMM YYYY') }}</span>
                                <span class="text-xs text-gray-500">{{ $app->schedule_time->format('H:i') }} WIB</span>
                            </div>
                        </td>

                        {{-- PASIEN --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 font-bold mr-3 text-xs">
                                    {{ substr($app->patient->name, 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-900">{{ $app->patient->name }}</span>
                            </div>
                        </td>

                        {{-- JENIS SESI --}}
                        <td class="px-6 py-4">
                            @if($app->meeting_type == 'offline')
                                <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2 py-1 rounded-md border border-purple-100">Offline</span>
                            @else
                                <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded-md border border-blue-100">Online</span>
                            @endif
                        </td>

                        {{-- STATUS --}}
                        <td class="px-6 py-4">
                            @if($app->status == 'completed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                    Selesai
                                </span>
                            @elseif($app->status == 'cancelled')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                    Dibatalkan
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst($app->status) }}
                                </span>
                            @endif
                        </td>

                        {{-- OPSI (TOMBOL NOTES DITAMBAHKAN DI SINI) --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-3">
                                
                                {{-- [BARU] Tombol Catatan --}}
                                @if($app->status == 'completed')
                                    <a href="{{ route('counselor.notes.show', $app->id) }}" class="inline-flex items-center text-green-600 hover:text-green-800 text-sm font-bold hover:underline" title="Berikan Catatan">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Catatan
                                    </a>
                                @endif

                                <a href="{{ route('counselor.appointments.show', $app->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium hover:underline">
                                    Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p>Belum ada riwayat sesi.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $historyAppointments->links() }}
    </div>
</div>
@endsection