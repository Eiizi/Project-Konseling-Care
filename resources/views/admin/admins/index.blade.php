@extends('layouts.admin')

@section('header_title', 'Manajemen Admin')
@section('header_subtitle', 'Kelola akses administrator sistem.')

@section('content')

<div class="mb-6 text-right">
    <a href="{{ route('admin.admins.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow transition">
        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        Tambah Admin Baru
    </a>
</div>

@if($pendingAdmins->count() > 0)
<div class="bg-yellow-50 rounded-2xl shadow-sm border border-yellow-200 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-yellow-200 bg-yellow-100/50 flex items-center">
        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <h3 class="text-lg font-bold text-yellow-800">Menunggu Verifikasi</h3>
    </div>
    <div class="p-6">
        <table class="w-full text-left">
            <thead>
                <tr class="text-xs font-semibold text-yellow-700 uppercase">
                    <th class="pb-3">Nama</th>
                    <th class="pb-3">Email</th>
                    <th class="pb-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingAdmins as $admin)
                <tr class="border-b border-yellow-200 last:border-0">
                    <td class="py-3 font-bold text-gray-800">{{ $admin->name }}</td>
                    <td class="py-3 text-gray-600">{{ $admin->email }}</td>
                    <td class="py-3 text-right space-x-2">
                        <form action="{{ route('admin.admins.verify', $admin->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Verifikasi dan aktifkan admin ini?')">
                            @csrf @method('PATCH')
                            <button class="px-3 py-1 bg-green-600 text-white text-xs font-bold rounded-lg hover:bg-green-700 transition">Verifikasi</button>
                        </form>
                        <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tolak dan hapus data ini?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 bg-red-100 text-red-600 text-xs font-bold rounded-lg hover:bg-red-200 transition">Tolak</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
        <h3 class="text-lg font-bold text-gray-800">Daftar Admin Aktif</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Admin</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr class="bg-indigo-50/50">
                    <td class="px-6 py-4 font-bold text-indigo-700 flex items-center">
                        <span class="w-8 h-8 rounded-full bg-indigo-200 flex items-center justify-center mr-3 text-xs">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        {{ Auth::user()->name }} (Anda)
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ Auth::user()->email }}</td>
                    <td class="px-6 py-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Active</span></td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.profile.edit') }}" class="text-xs font-bold text-indigo-600 hover:underline">Edit Profil</a>
                    </td>
                </tr>

                @foreach($activeAdmins as $admin)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900 flex items-center">
                        <span class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-3 text-xs text-gray-500">{{ substr($admin->name, 0, 1) }}</span>
                        {{ $admin->name }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $admin->email }}</td>
                    <td class="px-6 py-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Active</span></td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Hapus akses admin ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700 text-xs font-bold">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection