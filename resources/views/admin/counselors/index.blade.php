@extends('layouts.admin')

@section('header_title', 'Manajemen Konselor')
@section('header_subtitle', 'Kelola data psikolog dan jadwal praktik.')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-bold text-gray-800">Daftar Konselor Aktif</h2>
        <a href="{{ route('admin.counselors.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Konselor
        </a>
    </div>

    {{-- Grid Card Layout --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($counselors as $counselor)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                
                {{-- Header Kartu: Foto & Info Utama --}}
                <div class="p-6 text-center border-b border-gray-50">
                    <div class="relative inline-block">
                        <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-indigo-50 shadow-sm mx-auto mb-4">
                            @if($counselor->avatar)
                                <img src="{{ asset('storage/' . $counselor->avatar) }}" alt="{{ $counselor->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-indigo-600 flex items-center justify-center text-white text-3xl font-bold">
                                    {{ substr($counselor->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        {{-- Badge Status --}}
                        <span class="absolute bottom-1 right-1 w-5 h-5 border-2 border-white rounded-full {{ $counselor->schedules->count() > 0 ? 'bg-green-500' : 'bg-gray-400' }}" title="{{ $counselor->schedules->count() > 0 ? 'Jadwal Aktif' : 'Tidak Ada Jadwal' }}"></span>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors">{{ $counselor->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $counselor->profile->specialization ?? 'Psikolog Umum' }}</p>
                    
                    {{-- Kode Unik Konselor --}}
                    <div class="mt-3 inline-block px-3 py-1 bg-gray-100 text-gray-600 text-xs font-mono font-bold rounded-lg">
                        ID: CNSL-{{ str_pad($counselor->id, 3, '0', STR_PAD_LEFT) }}
                    </div>
                </div>

                {{-- Body Kartu: Statistik Ringkas --}}
                <div class="px-6 py-4 bg-gray-50/50 grid grid-cols-2 gap-4 text-center border-b border-gray-50">
                    <div>
                        <span class="block text-xs text-gray-400 uppercase font-bold">Tarif/Sesi</span>
                        <span class="block text-sm font-bold text-gray-800">Rp {{ number_format($counselor->profile->rate ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-400 uppercase font-bold">Total Sesi</span>
                        {{-- Hitung total sesi (appointments) yang statusnya selesai --}}
                        <span class="block text-sm font-bold text-indigo-600">
                            {{ $counselor->appointments_as_counselor_count ?? 0 }} Sesi
                        </span>
                    </div>
                </div>

                {{-- Footer Kartu: Jadwal & Aksi --}}
                <div class="p-4">
                    <div class="mb-4">
                        <p class="text-xs text-gray-400 uppercase font-bold mb-2">Jadwal Praktik:</p>
                        <div class="flex flex-wrap gap-1">
                            @forelse($counselor->schedules as $schedule)
                                <span class="px-2 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-bold rounded border border-indigo-100">
                                    {{ substr($schedule->day_of_week, 0, 3) }} {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                </span>
                            @empty
                                <span class="text-xs text-gray-400 italic">Belum atur jadwal</span>
                            @endforelse
                        </div>
                        
                        {{-- NOTIFIKASI BENTROK (Jika Ada) --}}
                        @if(isset($conflicts) && in_array($counselor->id, $conflicts))
                            <div class="mt-3 p-2 bg-red-50 border border-red-100 rounded-lg flex items-start gap-2">
                                <svg class="w-4 h-4 text-red-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <p class="text-[10px] text-red-600 font-bold leading-tight">
                                    Peringatan: Jadwal konselor ini bentrok dengan konselor lain!
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('admin.counselors.show', $counselor->id) }}" class="flex-1 py-2 text-center text-sm font-bold text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                            Detail
                        </a>
                        <a href="{{ route('admin.counselors.edit', $counselor->id) }}" class="flex-1 py-2 text-center text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">
                            Edit Data
                        </a>
                        <form action="{{ route('admin.counselors.destroy', $counselor->id) }}" method="POST" onsubmit="return confirm('Hapus konselor ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg border border-transparent hover:border-red-100 transition">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-gray-100">
                <p class="text-gray-500">Belum ada data konselor.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $counselors->links() }}
    </div>

@endsection