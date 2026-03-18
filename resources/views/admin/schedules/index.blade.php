@extends('layouts.admin')

@section('header_title', 'Manajemen Jadwal')
@section('header_subtitle', 'Monitoring slot waktu yang dibuka oleh para konselor.')

@section('content')

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800">Daftar Konselor & Slot Waktu</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Konselor</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Slot</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Hari Aktif</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($counselors as $counselor)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold mr-3">
                                        {{ substr($counselor->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 text-sm">{{ $counselor->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $counselor->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($counselor->schedules_count > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                        {{ $counselor->schedules_count }} Slot Waktu
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-500">
                                        Belum Ada Jadwal
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    {{-- Tampilkan hari-hari unik saja --}}
                                    @forelse($counselor->schedules->pluck('day_of_week')->unique() as $day)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold rounded border border-gray-200">
                                            {{ $day }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-400 italic">-</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.schedules.show', $counselor->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-bold rounded-lg hover:bg-indigo-700 transition shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                    Atur Jadwal
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                Tidak ada data konselor.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $counselors->links() }}
        </div>
    </div>

@endsection