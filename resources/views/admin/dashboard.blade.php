@extends('layouts.admin')

@section('header_title', 'Dashboard Overview')
@section('header_subtitle', 'Analisis data dan performa platform MindWell.')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 mr-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Konselor</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $counselorCount ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition">
            <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center text-green-600 mr-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Pasien</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $patientCount ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition">
            <div class="w-12 h-12 rounded-xl bg-yellow-50 flex items-center justify-center text-yellow-600 mr-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Sesi Selesai</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $completedSessionsCount ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition">
            <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 mr-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Pendapatan</p>
                <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800">Analisis Pendapatan & Sesi</h3>
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">6 Bulan Terakhir</span>
            </div>
            <div id="revenueChart" style="min-height: 300px;"></div>
        </div>

        <div class="lg:col-span-1 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Demografi Pengguna</h3>
            <div id="userChart" class="flex justify-center" style="min-height: 300px;"></div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Aktivitas Transaksi Terbaru</h3>
                <p class="text-xs text-gray-500">Monitoring pembayaran masuk secara real-time.</p>
            </div>
            <a href="{{ route('admin.transactions.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 flex items-center">
                Lihat Semua &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Kode Bayar</th>
                        <th class="px-6 py-4 font-semibold">Pasien</th>
                        <th class="px-6 py-4 font-semibold">Jumlah</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentTransactions ?? [] as $transaction)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-mono font-bold text-indigo-700 text-xs bg-indigo-50 px-2 py-1 rounded border border-indigo-100">
                                    {{ $transaction->order_id ?? 'INV/' . $transaction->created_at->format('Y') . '/' . str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-xs font-bold text-gray-500 mr-3">
                                        {{ substr($transaction->appointment->patient->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-800 text-sm">{{ $transaction->appointment->patient->name ?? 'User Dihapus' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-700 text-sm">
                                Rp {{ number_format($transaction->base_price ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if(in_array($transaction->status, ['success', 'paid', 'verified', 'settlement']))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">Lunas</span>
                                @elseif($transaction->status == 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">Pending</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">Gagal</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-gray-500 font-mono">
                                {{ $transaction->created_at->format('d M, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400 italic">Belum ada aktivitas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // --- DATA DARI CONTROLLER ---
            const months = @json($months);
            const revenueData = @json($revenueData);
            const sessionData = @json($sessionData);
            const counselorCount = {{ $counselorCount }};
            const patientCount = {{ $patientCount }};

            // --- 1. CONFIG GRAFIK PENDAPATAN & SESI (Mixed Chart) ---
            var optionsRevenue = {
                series: [{
                    name: 'Pendapatan (Rp)',
                    type: 'area', // Grafik Area
                    data: revenueData
                }, {
                    name: 'Sesi Selesai',
                    type: 'line', // Grafik Garis
                    data: sessionData
                }],
                chart: {
                    height: 350,
                    type: 'line', // Tipe dasar line
                    fontFamily: 'Plus Jakarta Sans, sans-serif',
                    toolbar: { show: false } // Hilangkan menu toolbar
                },
                stroke: {
                    width: [2, 4], // Ketebalan garis
                    curve: 'smooth'
                },
                colors: ['#818cf8', '#fbbf24'], // Warna Ungu (Pendapatan), Kuning (Sesi)
                fill: {
                    type: ['gradient', 'solid'],
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.2,
                        stops: [0, 90, 100]
                    }
                },
                labels: months, // Label Bulan (Jan, Feb, Mar...)
                yaxis: [
                    {
                        title: { text: 'Pendapatan' },
                        labels: {
                            formatter: function (value) {
                                return "Rp " + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    },
                    {
                        opposite: true,
                        title: { text: 'Jumlah Sesi' }
                    }
                ],
                dataLabels: { enabled: false },
                legend: { position: 'top' }
            };

            var chartRevenue = new ApexCharts(document.querySelector("#revenueChart"), optionsRevenue);
            chartRevenue.render();


            // --- 2. CONFIG GRAFIK USER (Donut Chart) ---
            var optionsUser = {
                series: [counselorCount, patientCount],
                labels: ['Konselor', 'Pasien'],
                chart: {
                    type: 'donut',
                    height: 350,
                    fontFamily: 'Plus Jakarta Sans, sans-serif',
                },
                colors: ['#3b82f6', '#10b981'], // Biru (Konselor), Hijau (Pasien)
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total User',
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                legend: { position: 'bottom' }
            };

            var chartUser = new ApexCharts(document.querySelector("#userChart"), optionsUser);
            chartUser.render();

        });
    </script>

@endsection