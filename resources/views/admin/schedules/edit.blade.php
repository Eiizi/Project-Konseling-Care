@extends('layouts.admin')

@section('header_title', 'Edit Jadwal')
@section('header_subtitle', 'Sesuaikan waktu kerja konselor.')

@section('content')

<div class="max-w-3xl mx-auto">
    
    <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center text-gray-500 hover:text-indigo-600 mb-6 transition">
        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar Jadwal
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        
        <div class="flex items-center mb-8 pb-6 border-b border-gray-100">
            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold mr-4">
                {{ substr($schedule->counselor->name ?? 'C', 0, 1) }}
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Mengedit Jadwal Untuk:</p>
                <h3 class="text-lg font-bold text-gray-900">{{ $schedule->counselor->name ?? 'Konselor' }}</h3>
            </div>
        </div>

        <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hari</label>
                    <select name="day_of_week" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        @foreach(['Monday'=>'Senin', 'Tuesday'=>'Selasa', 'Wednesday'=>'Rabu', 'Thursday'=>'Kamis', 'Friday'=>'Jumat', 'Saturday'=>'Sabtu', 'Sunday'=>'Minggu'] as $val => $label)
                            <option value="{{ $val }}" {{ $schedule->day_of_week == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jam Mulai</label>
                        <input type="time" name="start_time" value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jam Selesai</label>
                        <input type="time" name="end_time" value="{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection