@extends('layouts.patient')

@section('title', 'Jadwal Saya')
@section('header_title', $viewType == 'upcoming' ? 'Jadwal Sesi' : 'Riwayat Sesi')
@section('header_subtitle', 'Kelola sesi konseling Anda di sini.')

@section('content')

    {{-- TABS NAVIGASI --}}
    <div class="flex space-x-4 mb-6 border-b border-gray-200">
        <a href="{{ route('patient.appointments.index', ['view' => 'upcoming']) }}" 
           class="pb-2 px-4 text-sm font-medium transition-colors {{ $viewType == 'upcoming' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
            Akan Datang / Menunggu Bayar
        </a>
        <a href="{{ route('patient.appointments.index', ['view' => 'history']) }}" 
           class="pb-2 px-4 text-sm font-medium transition-colors {{ $viewType == 'history' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
            Riwayat Selesai
        </a>
    </div>

    {{-- KONTEN JADWAL --}}
    @if($appointments->isEmpty())
        {{-- TAMPILAN KOSONG --}}
        <div class="bg-white rounded-xl shadow-sm p-12 text-center border border-gray-100">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Belum ada sesi</h3>
            <p class="text-gray-500 mb-6">Anda belum memiliki jadwal pada kategori ini.</p>
            @if($viewType == 'upcoming')
                <a href="{{ route('patient.counselors.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-sm">
                    Cari Konselor Baru
                </a>
            @endif
        </div>
    @else
        {{-- LIST JADWAL --}}
        <div class="grid gap-4">
            @foreach($appointments as $app)
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6 hover:shadow-md transition">
                    
                    {{-- BAGIAN KIRI: Info Waktu & Konselor --}}
                    <div class="flex items-start gap-4 w-full md:w-auto">
                        <div class="flex-shrink-0 text-center bg-indigo-50 rounded-lg p-3 min-w-[80px]">
                            <span class="block text-xl font-bold text-indigo-700">{{ $app->schedule_time->format('d') }}</span>
                            <span class="block text-xs uppercase text-indigo-500 font-semibold">{{ $app->schedule_time->format('M') }}</span>
                        </div>

                        <div>
                            <h4 class="text-lg font-bold text-gray-900">{{ $app->counselor->name }}</h4>
                            
                            <div class="flex flex-wrap gap-2 mt-1 mb-2">
                                {{-- 1. Badge Tipe Meeting --}}
                                @if($app->meeting_type == 'offline')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-purple-100 text-purple-700 border border-purple-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        Offline (Tatap Muka)
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        Online (Video)
                                    </span>
                                @endif

                                {{-- 2. Badge Status --}}
                                @if($app->status == 'pending')
                                    <span class="px-2 py-0.5 text-xs font-bold rounded bg-yellow-100 text-yellow-700 border border-yellow-200">Menunggu Pembayaran</span>
                                @elseif($app->status == 'confirmed')
                                    <span class="px-2 py-0.5 text-xs font-bold rounded bg-green-100 text-green-700 border border-green-200">Terkonfirmasi</span>
                                @elseif($app->status == 'completed')
                                    <span class="px-2 py-0.5 text-xs font-bold rounded bg-blue-100 text-blue-700 border border-blue-200">Selesai</span>
                                @elseif($app->status == 'cancelled')
                                    <span class="px-2 py-0.5 text-xs font-bold rounded bg-red-100 text-red-700 border border-red-200">Dibatalkan</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- BAGIAN TENGAH: Jam --}}
                    <div class="text-center md:text-right w-full md:w-auto">
                        <p class="text-2xl font-mono font-bold text-gray-800">{{ $app->schedule_time->format('H:i') }}</p>
                        <p class="text-xs text-gray-400">WIB</p>
                    </div>

                    {{-- BAGIAN KANAN: Tombol Aksi --}}
                    <div class="flex flex-col gap-2 w-full md:w-auto min-w-[150px]">
                        
                        {{-- KONDISI 1: PENDING (Belum Bayar) --}}
                        @if($app->status == 'pending')
                            @if($app->transaction)
                                <a href="{{ route('patient.payment.show', $app->transaction->id) }}" class="block w-full px-4 py-2 bg-yellow-500 text-white text-sm font-bold rounded-lg hover:bg-yellow-600 text-center shadow-sm transition">
                                    Lanjut Bayar
                                </a>
                            @else
                                <span class="text-xs text-red-500 text-center italic">Error: Invoice Hilang</span>
                            @endif
                            
                            <form action="{{ route('patient.appointments.cancel', $app->id) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini?');">
                                @csrf @method('PATCH')
                                <button type="submit" class="block w-full px-4 py-2 border border-red-200 text-red-600 text-sm font-medium rounded-lg hover:bg-red-50 text-center transition">
                                    Batalkan
                                </button>
                            </form>
                        
                        {{-- KONDISI 2: TERKONFIRMASI (Sudah Bayar) --}}
                        @elseif($app->status == 'confirmed')
                            
                            {{-- Jika Offline: Lihat Tiket --}}
                            @if($app->meeting_type == 'offline')
                                <a href="{{ route('patient.session.show', $app->id) }}" class="flex items-center justify-center w-full px-4 py-2 bg-purple-600 text-white text-sm font-bold rounded-lg hover:bg-purple-700 transition shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                    Lihat Tiket
                                </a>
                            
                            {{-- Jika Online: Masuk Sesi --}}
                            @else
                                <a href="{{ route('patient.session.show', $app->id) }}" class="flex items-center justify-center w-full px-4 py-2 bg-indigo-600 text-white text-sm font-bold rounded-lg hover:bg-indigo-700 transition shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10z"/></svg>
                                    Masuk Sesi
                                </a>
                            @endif

                        {{-- KONDISI 3: SELESAI --}}
                        @elseif($app->status == 'completed')
                            <a href="{{ route('patient.session.show', $app->id) }}" class="block w-full px-4 py-2 border border-indigo-600 text-indigo-600 text-sm font-bold rounded-lg hover:bg-indigo-50 text-center transition">
                                Lihat Catatan
                            </a>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        <div class="mt-6">
            {{ $appointments->appends(['view' => $viewType])->links() }}
        </div>
    @endif

@endsection