@extends('layouts.counselor_layout')

@section('header_title', 'Dashboard Overview')
@section('header_subtitle', 'Pantau aktivitas dan jadwal konsultasi Anda hari ini.')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition-shadow">
            <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-4">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Pendapatan Bulan Ini</p>
                {{-- MENGGUNAKAN VARIABEL YANG SUDAH ADA DI CONTROLLER --}}
                <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($counselorRevenue ?? 0, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition-shadow">
            <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mr-4">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Pasien Aktif (Bulan Ini)</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $activePatientsCount ?? 0 }} Pasien</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition-shadow">
            <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-4">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Jadwal Hari Ini</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $sessionsTodayCount ?? 0 }} Sesi</h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Jadwal Segera (Upcoming)</h3>
                <p class="text-xs text-gray-500">Daftar pasien yang terkonfirmasi akan melakukan konsultasi.</p>
            </div>
            <a href="{{ route('counselor.appointments.upcoming') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">Lihat Semua &rarr;</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Pasien</th>
                        <th class="px-6 py-4 font-semibold">Waktu & Tanggal</th>
                        <th class="px-6 py-4 font-semibold">Metode</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($upcomingAppointments as $app)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold mr-3 shadow-sm">
                                        {{ substr($app->patient->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $app->patient->name }}</p>
                                        <p class="text-xs text-gray-500">Pasien #{{ $app->patient->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-gray-800">{{ $app->schedule_time->format('H:i') }} WIB</p>
                                <p class="text-xs text-gray-500">{{ $app->schedule_time->isoFormat('dddd, D MMM YYYY') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if($app->meeting_type == 'offline')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                        Offline (Tatap Muka)
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        Online (Video)
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                    Confirmed
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($app->status == 'confirmed')
                                    <form action="{{ route('counselor.appointments.start', $app->id) }}" method="POST" onsubmit="return confirm('Mulai sesi ini sekarang?')" class="inline-block">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">
                                            Mulai Sesi
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p>Belum ada jadwal sesi yang akan datang.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection