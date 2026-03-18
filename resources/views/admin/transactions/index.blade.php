@extends('layouts.admin')

@section('header_title', 'Manajemen Transaksi')
@section('header_subtitle', 'Riwayat pembayaran sesi konseling.')

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    
    <div class="px-6 py-5 bg-gray-50/50 flex flex-col md:flex-row justify-between items-center gap-4 border-b border-gray-100">
        <h3 class="text-lg font-bold text-gray-800">Daftar Transaksi</h3>
        
        <form action="{{ route('admin.transactions.index') }}" method="GET" class="w-full md:w-96 relative">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            
            <input type="text" name="search" value="{{ request('search') }}" 
                placeholder="Cari Kode Bayar, Nama..." 
                class="w-full pl-10 pr-4 py-2 rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </form>
    </div>

    <div class="border-b border-gray-100 px-6">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <a href="{{ route('admin.transactions.index') }}" 
               class="{{ !request('status') ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                Semua Transaksi
            </a>

            <a href="{{ route('admin.transactions.index', ['status' => 'success']) }}" 
               class="{{ request('status') == 'success' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-green-600 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
               <span class="flex items-center">
                    <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                    Lunas
               </span>
            </a>

            <a href="{{ route('admin.transactions.index', ['status' => 'pending']) }}" 
               class="{{ request('status') == 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-yellow-600 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
               <span class="flex items-center">
                    <span class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></span>
                    Pending
               </span>
            </a>

            <a href="{{ route('admin.transactions.index', ['status' => 'failed']) }}" 
               class="{{ request('status') == 'failed' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-red-600 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
               <span class="flex items-center">
                    <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>
                    Gagal / Batal
               </span>
            </a>
        </nav>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Kode Bayar</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Pasien</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Konselor</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Jumlah</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase text-center">Status</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase text-right">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($transactions as $trx)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-mono font-bold text-indigo-700 text-xs bg-indigo-50 px-2 py-1 rounded border border-indigo-100">
                                {{ $trx->order_id ?? 'INV/' . $trx->created_at->format('Y') . '/' . str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-900 text-sm">{{ $trx->appointment->patient->name ?? '-' }}</span>
                                <span class="text-xs text-gray-500">ID: P-{{ $trx->appointment->patient->id ?? '?' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $trx->appointment->counselor->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-800 text-sm">
                            Rp {{ number_format($trx->base_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if(in_array($trx->status, ['success', 'paid', 'verified', 'settlement']))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                    Lunas
                                </span>
                            @elseif($trx->status == 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                    Pending
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                    Gagal
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-sm text-gray-500">
                            {{ $trx->created_at->format('d M Y') }}<br>
                            <span class="text-xs text-gray-400">{{ $trx->created_at->format('H:i') }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-gray-500 font-medium">Tidak ada transaksi di kategori ini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-100">
        {{ $transactions->links() ?? '' }}
    </div>
</div>
@endsection