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
        // Summary statistics
        $stats = [
            'total_transaksi' => Transaksi::count(),
            'total_penghasilan' => Transaksi::where('status_pembayaran', 'paid')->sum('total_harga'),
            'transaksi_hari_ini' => Transaksi::whereDate('created_at', today())->count(),
            'penghasilan_hari_ini' => Transaksi::where('status_pembayaran', 'paid')
                                              ->whereDate('created_at', today())
                                              ->sum('total_harga'),
            'transaksi_pending' => Transaksi::where('status_pembayaran', 'pending')->count(),
            'transaksi_berlangsung' => Transaksi::where('status_booking', 'ongoing')->count(),
            'total_meja' => Meja::count(),
            'meja_tersedia' => Meja::where('status', 'available')->count(),
            'meja_terpakai' => Meja::where('status', 'occupied')->count(),
            'total_pelanggan' => User::where('role', 'customer')->count(),
        ];

        // Calculate average per day (last 10 days)
        $tenDaysAgo = Carbon::now()->subDays(10);
        $revenueLastTenDays = Transaksi::where('status_pembayaran', 'paid')
                                      ->where('created_at', '>=', $tenDaysAgo)
                                      ->sum('total_harga');
        $stats['rata_rata_per_hari'] = $revenueLastTenDays / 10;

        // Most popular table (meja terfavorit)
        $mostPopularTable = Transaksi::select('meja_id', DB::raw('count(*) as total_booking'))
                                    ->groupBy('meja_id')
                                    ->orderBy('total_booking', 'desc')
                                    ->with('meja')
                                    ->first();
        
        $stats['meja_terfavorit'] = $mostPopularTable ? $mostPopularTable->meja->nama_meja : '-';
        $stats['meja_terfavorit_count'] = $mostPopularTable ? $mostPopularTable->total_booking : 0;

        // Daily revenue for chart (last 7 days)
        $dailyRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $revenue = Transaksi::where('status_pembayaran', 'paid')
                               ->whereDate('created_at', $date)
                               ->sum('total_harga');
            $dailyRevenue[] = [
                'date' => $date->format('d M'),
                'revenue' => $revenue
            ];
        }

        // Weekly revenue for chart (last 4 weeks)
        $weeklyRevenue = [];
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
            $revenue = Transaksi::where('status_pembayaran', 'paid')
                               ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                               ->sum('total_harga');
            $weeklyRevenue[] = [
                'week' => 'Week ' . ($i + 1),
                'revenue' => $revenue
            ];
        }

        // Monthly revenue for chart (last 6 months)
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $revenue = Transaksi::where('status_pembayaran', 'paid')
                               ->whereYear('created_at', $month->year)
                               ->whereMonth('created_at', $month->month)
                               ->sum('total_harga');
            $monthlyRevenue[] = [
                'month' => $month->format('M Y'),
                'revenue' => $revenue
            ];
        }

        // Yearly revenue for chart (last 3 years)
        $yearlyRevenue = [];
        for ($i = 2; $i >= 0; $i--) {
            $year = Carbon::now()->subYears($i)->year;
            $revenue = Transaksi::where('status_pembayaran', 'paid')
                               ->whereYear('created_at', $year)
                               ->sum('total_harga');
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
