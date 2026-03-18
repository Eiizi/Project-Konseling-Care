@extends('layouts.counselor_layout')

@section('header_title', 'Pengaturan Jadwal')
@section('header_subtitle', 'Tentukan ketersediaan waktu Anda untuk konsultasi.')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah Slot (2 Jam)
            </h3>
            
            <form action="{{ route('counselor.schedules.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hari</label>
                    <select name="day" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm bg-gray-50">
                        <option value="Monday">Senin</option>
                        <option value="Tuesday">Selasa</option>
                        <option value="Wednesday">Rabu</option>
                        <option value="Thursday">Kamis</option>
                        <option value="Friday">Jumat</option>
                        <option value="Saturday">Sabtu</option>
                        <option value="Sunday">Minggu</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jam Mulai Sesi</label>
                    <input type="time" name="start_time" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm bg-gray-50" required>
                    
                    <div class="mt-3 bg-blue-50 border border-blue-100 rounded-lg p-3 flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-xs text-blue-700">
                            Sesi otomatis diatur berdurasi <strong>2 Jam</strong>. <br>
                            Contoh: Jika mulai <strong>09:00</strong>, akan selesai <strong>11:00</strong>.
                        </p>
                    </div>
                </div>

                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition-transform transform active:scale-95">
                    Simpan Jadwal
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-700">Jadwal Aktif Saya</h3>
                <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded border">Weekly Repeat</span>
            </div>

            <div class="p-6 grid gap-4">
                @php 
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; 
                    $indoDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                @endphp

                @foreach($days as $index => $day)
                    @php $daySchedules = $schedules->where('day_of_week', $day); @endphp
                    
                    @if($daySchedules->count() > 0)
                        <div class="border rounded-xl p-4 hover:border-indigo-200 transition-colors bg-white shadow-sm">
                            <h4 class="font-bold text-indigo-900 mb-3 flex items-center">
                                <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>
                                {{ $indoDays[$index] }}
                            </h4>
                            <div class="flex flex-wrap gap-3">
                                @foreach($daySchedules as $schedule)
                                    <div class="group flex items-center bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 hover:bg-indigo-50 hover:border-indigo-200 transition-colors">
                                        <span class="text-sm font-mono font-medium text-gray-700 group-hover:text-indigo-700">
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                        </span>
                                        <form action="{{ route('counselor.schedules.destroy', $schedule->id) }}" method="POST" class="ml-3">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors" onclick="return confirm('Hapus slot waktu ini?')">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach

                @if($schedules->isEmpty())
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-gray-500">Anda belum mengatur jadwal ketersediaan.</p>
                        <p class="text-sm text-gray-400">Gunakan form di sebelah kiri untuk menambah slot.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection