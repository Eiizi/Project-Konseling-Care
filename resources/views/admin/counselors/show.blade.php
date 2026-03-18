@extends('layouts.admin')

@section('header_title', 'Detail Konselor')
@section('header_subtitle', 'Profil lengkap dan riwayat praktik psikolog.')

@section('content')

    <div class="mb-6">
        <a href="{{ route('admin.counselors.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Konselor
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- KOLOM KIRI: PROFIL KONSELOR --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center sticky top-8">
                <div class="relative inline-block mb-4">
                    <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-indigo-50 shadow-sm mx-auto">
                        @if($counselor->avatar)
                            <img src="{{ asset('storage/' . $counselor->avatar) }}" alt="{{ $counselor->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-indigo-600 flex items-center justify-center text-white text-4xl font-bold">
                                {{ substr($counselor->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <h2 class="text-xl font-bold text-gray-900">{{ $counselor->name }}</h2>
                <p class="text-indigo-600 font-medium text-sm mb-1">{{ $counselor->profile->specialization ?? 'Psikolog Umum' }}</p>
                <p class="text-gray-400 text-xs">{{ $counselor->email }}</p>

                <div class="grid grid-cols-2 gap-4 mt-6 border-t border-gray-100 pt-6">
                    <div class="text-center">
                        <span class="block text-2xl font-bold text-gray-800">{{ $counselor->appointmentsAsCounselor->where('status', 'completed')->count() }}</span>
                        <span class="text-xs text-gray-400 uppercase font-bold tracking-wider">Sesi Selesai</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-2xl font-bold text-gray-800">Rp {{ number_format($counselor->profile->rate ?? 0, 0, ',', '.') }}</span>
                        <span class="text-xs text-gray-400 uppercase font-bold tracking-wider">Tarif</span>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-100 text-left space-y-3">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold mb-1">Jadwal Praktik</p>
                        <div class="flex flex-wrap gap-2">
                            @forelse($counselor->schedules as $sched)
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded font-medium">
                                    {{ $sched->day_of_week }}, {{ \Carbon\Carbon::parse($sched->start_time)->format('H:i') }}
                                </span>
                            @empty
                                <span class="text-xs text-gray-400 italic">Tidak ada jadwal aktif.</span>
                            @endforelse
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <p class="text-xs text-gray-400 uppercase font-bold mb-1">Bio / Deskripsi</p>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            {{ $counselor->profile->bio ?? 'Belum ada deskripsi profil.' }}
                        </p>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.counselors.edit', $counselor->id) }}" class="block w-full py-2 px-4 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition text-sm mb-3">
                        Edit Profil
                    </a>
                    <form action="{{ route('admin.counselors.destroy', $counselor->id) }}" method="POST" onsubmit="return confirm('Hapus konselor ini secara permanen?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="block w-full py-2 px-4 border border-red-200 text-red-600 font-bold rounded-xl hover:bg-red-50 transition text-sm">
                            Hapus Akun
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: RIWAYAT SESI --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-800">Riwayat Sesi Pasien</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pasien</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Metode</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($appointments as $app)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-bold text-gray-800">{{ $app->schedule_time->format('d M Y') }}</p>
                                        <p class="text-xs text-gray-500">{{ $app->schedule_time->format('H:i') }} WIB</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-xs font-bold text-green-600 mr-2">
                                                {{ substr($app->patient->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $app->patient->name }}</p>
                                                <p class="text-xs text-gray-500">ID: P-{{ $app->patient->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($app->meeting_type == 'offline')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">Offline</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">Online</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($app->status == 'completed')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-700">Selesai</span>
                                        @elseif($app->status == 'cancelled')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-700">Batal</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-gray-100 text-gray-600">{{ ucfirst($app->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        Konselor ini belum memiliki riwayat sesi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $appointments->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection