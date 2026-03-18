@extends('layouts.admin')

@section('header_title', 'Detail Pasien')
@section('header_subtitle', 'Informasi lengkap dan riwayat medis pasien.')

@section('content')

    <div class="mb-6">
        <a href="{{ route('admin.patients.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Pasien
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- KOLOM KIRI: PROFIL PASIEN --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center sticky top-8">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center text-3xl font-bold text-green-600 mx-auto mb-4 border-4 border-white shadow-sm">
                    {{ substr($patient->name, 0, 1) }}
                </div>
                
                <h2 class="text-xl font-bold text-gray-900">{{ $patient->name }}</h2>
                <p class="text-gray-500 text-sm mb-6">{{ $patient->email }}</p>

                <div class="border-t border-gray-100 pt-6 text-left space-y-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">ID Pasien</p>
                        <p class="font-mono text-gray-700 font-medium">#{{ $patient->id }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Terdaftar Sejak</p>
                        <p class="text-gray-700 font-medium">{{ $patient->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">No HP</p>
                        <p class="text-gray-700 font-medium">{{ $patient->phone_number ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Umur & Gender</p>
                        <p class="text-gray-700 font-medium">
                            {{ $patient->age ?? '-' }} Tahun &bull; {{ ucfirst($patient->gender ?? '-') }}
                        </p>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data pasien ini secara permanen?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 border border-red-200 text-red-600 rounded-xl hover:bg-red-50 font-bold transition text-sm">
                            Hapus Akun Pasien
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: RIWAYAT KONSULTASI (DETAIL LENGKAP) --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="flex justify-between items-end">
                <h3 class="text-lg font-bold text-gray-800">Riwayat & Detail Konsultasi</h3>
                <span class="text-xs text-gray-500">Total: {{ $appointments->total() }} Sesi</span>
            </div>

            @forelse($appointments as $app)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    
                    {{-- Header Kartu: Tanggal & Status --}}
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="font-bold text-gray-700">
                                {{ $app->schedule_time->isoFormat('dddd, D MMMM YYYY') }}
                            </span>
                        </div>
                        <div>
                            @if($app->status == 'completed')
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Selesai</span>
                            @elseif($app->status == 'cancelled')
                                <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">Batal</span>
                            @elseif($app->status == 'confirmed')
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Terjadwal</span>
                            @else
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">{{ ucfirst($app->status) }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {{-- Info Konseling --}}
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-3">Detail Sesi</p>
                                <div class="space-y-4">
                                    {{-- Nama Konselor --}}
                                    <div class="flex items-start">
                                        <div class="w-8 flex-shrink-0 text-gray-400 mt-0.5"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">{{ $app->counselor->name ?? 'Konselor Dihapus' }}</p>
                                            <p class="text-xs text-gray-500">Konselor</p>
                                        </div>
                                    </div>
                                    
                                    {{-- Waktu & Durasi --}}
                                    <div class="flex items-start">
                                        <div class="w-8 flex-shrink-0 text-gray-400 mt-0.5"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                                        <div>
                                            {{-- Default Durasi 2 Jam --}}
                                            <p class="text-sm font-bold text-gray-800">
                                                {{ $app->schedule_time->format('H:i') }} - {{ $app->schedule_time->copy()->addHours(2)->format('H:i') }} WIB
                                            </p>
                                            <p class="text-xs text-gray-500">Durasi: 2 Jam (Default)</p>
                                        </div>
                                    </div>

                                    {{-- Metode --}}
                                    <div class="flex items-start">
                                        <div class="w-8 flex-shrink-0 text-gray-400 mt-0.5"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg></div>
                                        <div>
                                            @if($app->meeting_type == 'offline')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-purple-100 text-purple-700 border border-purple-200">Offline (Tatap Muka)</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">Online (Video Call)</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Catatan Konselor (REVISI BAGIAN INI) --}}
                            <div class="h-full flex flex-col">
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-2">Catatan Konselor</p>
                                <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-4 flex-1">
                                    {{-- REVISI: Menggunakan counselor_feedback atau notes --}}
                                    @if(!empty($app->counselor_feedback))
                                        <div class="flex items-start">
                                            <svg class="w-4 h-4 text-yellow-500 mr-2 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                            <p class="text-sm text-gray-700 italic leading-relaxed">
                                                "{{ $app->counselor_feedback }}"
                                            </p>
                                        </div>
                                    @elseif(!empty($app->notes))
                                        <div class="flex items-start">
                                            <svg class="w-4 h-4 text-yellow-500 mr-2 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                            <p class="text-sm text-gray-700 italic leading-relaxed">
                                                "{{ $app->notes }}"
                                            </p>
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-400 italic flex items-center h-full justify-center">
                                            - Belum ada catatan -
                                        </p>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Footer Kartu: Info Pembayaran --}}
                    @if($app->transaction)
                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-100 flex justify-between items-center text-xs">
                        <span class="text-gray-500">Kode Bayar: <span class="font-mono text-gray-700 font-bold">{{ $app->transaction->transaction_code }}</span></span>
                        <div class="text-right">
                             <span class="text-gray-500 block">Total</span>
                             <span class="font-bold text-gray-800 text-sm">Rp {{ number_format($app->transaction->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Belum Ada Riwayat</h3>
                    <p class="text-gray-500">Pasien ini belum melakukan sesi konseling apapun.</p>
                </div>
            @endforelse

            {{-- PAGINATION LINKS --}}
            <div class="mt-4">
                {{ $appointments->links() }}
            </div>

        </div>
    </div>

@endsection