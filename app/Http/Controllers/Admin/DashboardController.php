<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Meja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        // Summary statistics - Updated logic with scopes
        $stats = [
            // Total transaksi hanya yang sudah dibayar (paid)
            'total_transaksi' => Transaksi::paid()->count(),
            'total_penghasilan' => Transaksi::paid()->sum('total_harga'),
            
            // Transaksi hari ini hanya yang sudah dibayar
            'transaksi_hari_ini' => Transaksi::paid()->today()->count(),
            'penghasilan_hari_ini' => Transaksi::paid()->today()->sum('total_harga'),
            
            // Card baru untuk transaksi pending
            'transaksi_pending' => Transaksi::pending()->count(),
            'transaksi_pending_hari_ini' => Transaksi::pending()->today()->count(),
            
            // Statistik lainnya
            'transaksi_berlangsung' => Transaksi::where('status_booking', 'ongoing')->count(),
            'total_meja' => Meja::count(),
            'meja_tersedia' => Meja::where('status', 'available')->count(),
            'meja_terpakai' => Meja::where('status', 'occupied')->count(),
            'total_pelanggan' => User::where('role', 'customer')->count(),
            
            // Transaksi gagal/dibatalkan
            'transaksi_failed' => Transaksi::failed()->count(),
        ];

        // Calculate average per day (last 10 days) - only paid transactions
        $tenDaysAgo = Carbon::now()->subDays(10);
        $revenueLastTenDays = Transaksi::paid()
                                      ->where('created_at', '>=', $tenDaysAgo)
                                      ->sum('total_harga');
        $stats['rata_rata_per_hari'] = $revenueLastTenDays / 10;

        // Generate realistic revenue data with specified range (50k - 2M)
        
        // Daily revenue for chart (last 7 days) - Range: 50k - 500k per day
        $dailyRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            
            // Get actual revenue or generate realistic data - only paid transactions
            $actualRevenue = Transaksi::paid()
                                   ->whereDate('created_at', $date)
                                   ->sum('total_harga');
            
            // After reset, show actual data only (will be 0)
            $revenue = $actualRevenue; // Will be 0 after reset
            
            $dailyRevenue[] = [
                'date' => $date->format('d M'),
                'revenue' => $revenue
            ];
        }

        // Weekly revenue for chart (last 4 weeks) - Range: 350k - 1.5M per week
        $weeklyRevenue = [];
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
            
            $actualRevenue = Transaksi::paid()
                                   ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                                   ->sum('total_harga');
            
            // After reset, show actual data only (will be 0)
            $revenue = $actualRevenue; // Will be 0 after reset
            
            $weeklyRevenue[] = [
                'week' => 'Minggu ' . (4 - $i),
                'revenue' => $revenue
            ];
        }

        // Monthly revenue for chart (last 6 months) - Range: 1.5M - 8M per month
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            
            $actualRevenue = Transaksi::paid()
                                   ->whereYear('created_at', $month->year)
                                   ->whereMonth('created_at', $month->month)
                                   ->sum('total_harga');
            
            // After reset, show actual data only (will be 0)
            $revenue = $actualRevenue; // Will be 0 after reset
            
            $monthlyRevenue[] = [
                'month' => $month->format('M Y'),
                'revenue' => $revenue
            ];
        }

        // Yearly revenue for chart (2026, 2027, 2028) - Range: 18M - 96M per year
        $yearlyRevenue = [];
        $startYear = 2026; // Mulai dari tahun 2026
        for ($i = 0; $i < 3; $i++) {
            $year = $startYear + $i;
            
            $actualRevenue = Transaksi::paid()
                                   ->whereYear('created_at', $year)
                                   ->sum('total_harga');
            
            // After reset, show actual data only (will be 0 for future years)
            $revenue = $actualRevenue; // Will be 0 for future years
            
            $yearlyRevenue[] = [
                'year' => $year,
                'revenue' => $revenue
            ];
        }

        // Recent transactions (last 5)
        $recentTransactions = Transaksi::with(['user', 'meja'])
                                      ->latest()
                                      ->take(5)
                                      ->get();

        return view('adminDashboard.DashboardAdm', compact(
            'stats',
            'dailyRevenue',
            'weeklyRevenue',
            'monthlyRevenue',
            'yearlyRevenue',
            'recentTransactions'
        ));
    }
}
