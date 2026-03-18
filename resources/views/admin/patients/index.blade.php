@extends('layouts.admin')

@section('header_title', 'Manajemen Pasien')
@section('header_subtitle', 'Data pengguna pasien yang terdaftar di platform.')

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
        <h3 class="text-lg font-bold text-gray-800">Daftar Pasien</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($patients as $patient)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold mr-3">
                                    {{ substr($patient->name, 0, 1) }}
                                </div>
                                <span class="font-bold text-gray-900">{{ $patient->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $patient->email }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $patient->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            {{-- Jika ada fitur detail --}}
                           <a href="{{ route('admin.patients.show', $patient->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">Detail</a>
                            
                            <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus pasien ini? Data riwayat mungkin akan hilang.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            Tidak ada data pasien.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-100">
        {{ $patients->links() ?? '' }}
    </div>
</div>
@endsection