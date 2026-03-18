<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Ringkasan (Cards)
        $counselorCount = User::where('role', 'counselor')->count();
        $patientCount = User::where('role', 'patient')->count();
        $completedSessionsCount = Appointment::where('status', 'completed')->count();
        
        // --- LOGIKA PENDAPATAN RIIL (30% DARI TOTAL TRANSAKSI) ---
        $grossRevenue = Transaction::whereIn('status', ['success', 'paid', 'verified', 'settlement'])->sum('base_price');
        $totalRevenue = $grossRevenue * 0.30; // Ambil 30% saja
        
        // 2. Data Tabel Transaksi Terbaru (5 Terakhir)
        $recentTransactions = Transaction::with(['appointment.patient', 'appointment.counselor'])
            ->latest()
            ->take(5)
            ->get();

        // 3. DATA UNTUK GRAFIK (6 Bulan Terakhir)
        $months = collect([]);
        $revenueData = collect([]);
        $sessionData = collect([]);

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            
            // Nama Bulan (Jan, Feb, dst)
            $months->push($date->format('M'));

            // Pendapatan per Bulan (Gross)
            $monthlyGross = Transaction::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->whereIn('status', ['success', 'paid', 'verified', 'settlement'])
                ->sum('base_price');
            
            // Masukkan ke Grafik (Hanya 30%)
            $revenueData->push($monthlyGross * 0.30);

            // Sesi Selesai per Bulan
            $monthlySessions = Appointment::whereYear('schedule_time', $date->year)
                ->whereMonth('schedule_time', $date->month)
                ->where('status', 'completed')
                ->count();
            $sessionData->push($monthlySessions);
        }

        return view('admin.dashboard', compact(
            'counselorCount', 
            'patientCount', 
            'completedSessionsCount', 
            'totalRevenue', 
            'recentTransactions',
            'months',
            'revenueData',
            'sessionData'
        ));
    }
}