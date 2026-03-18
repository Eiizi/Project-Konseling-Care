@extends('layouts.admin')

@section('header_title', 'Atur Jadwal Konselor')
@section('header_subtitle', 'Kelola slot waktu spesifik untuk ' . $counselor->name)

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Konselor
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- KOLOM KIRI: FORM TAMBAH JADWAL --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Tambah Slot Baru</h3>
                
                <form action="{{ route('admin.schedules.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="counselor_id" value="{{ $counselor->id }}">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hari</label>
                        <select name="day_of_week" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" required>
                            <option value="">Pilih Hari...</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mulai</label>
                            <input type="time" name="start_time" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Selesai</label>
                            <input type="time" name="end_time" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" required>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                        + Tambah Jadwal
                    </button>
                </form>
            </div>
        </div>

        {{-- KOLOM KANAN: LIST SLOT WAKTU --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Slot Waktu Aktif</h3>
                    <span class="text-xs font-bold bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full">{{ $counselor->schedules->count() }} Slot</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Hari</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Jam Mulai</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Jam Selesai</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase text-right">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($counselor->schedules as $schedule)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-gray-800">{{ $schedule->day_of_week }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Hapus slot waktu ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium hover:underline">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        Belum ada jadwal yang diatur. Silakan tambah jadwal di panel sebelah kiri.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection