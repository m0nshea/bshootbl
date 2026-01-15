<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Meja;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    /**
     * Display a listing of transactions
     */
    public function index(Request $request)
    {
        $query = Transaksi::with(['user', 'meja.category']);

        // Filter by status if provided
        if ($request->has('status_pembayaran') && $request->status_pembayaran != '') {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        if ($request->has('status_booking') && $request->status_booking != '') {
            $query->where('status_booking', $request->status_booking);
        }

        // Filter by date range
        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('tanggal_booking', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('tanggal_booking', '<=', $request->tanggal_sampai);
        }

        // Search by kode transaksi or nama pelanggan
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_transaksi', 'like', "%{$search}%")
                  ->orWhere('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('email_pelanggan', 'like', "%{$search}%");
            });
        }

        $transaksis = $query->latest()->paginate(15);

        // Statistics for dashboard
        $stats = [
            'total_transaksi' => Transaksi::count(),
            'transaksi_hari_ini' => Transaksi::today()->count(),
            'total_pendapatan' => Transaksi::paid()->sum('total_harga'),
            'pendapatan_bulan_ini' => Transaksi::paid()->thisMonth()->sum('total_harga'),
            'transaksi_pending' => Transaksi::where('status_pembayaran', 'pending')->count(),
            'transaksi_berlangsung' => Transaksi::where('status_booking', 'ongoing')->count()
        ];

        return view('adminTransaksi.transaksi', compact('transaksis', 'stats'));
    }

    /**
     * Show transaction details
     */
    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['user', 'meja.category']);
        return view('adminTransaksi.detail', compact('transaksi'));
    }

    /**
     * Update transaction status
     */
    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status_pembayaran' => 'nullable|in:pending,paid,failed,cancelled',
            'status_booking' => 'nullable|in:confirmed,ongoing,completed,cancelled',
            'metode_pembayaran' => 'nullable|string',
            'catatan' => 'nullable|string'
        ]);

        $data = [];
        
        if ($request->has('status_pembayaran')) {
            $data['status_pembayaran'] = $request->status_pembayaran;
        }
        
        if ($request->has('status_booking')) {
            $data['status_booking'] = $request->status_booking;
            
            // Auto set checkin/checkout times
            if ($request->status_booking === 'ongoing' && !$transaksi->waktu_checkin) {
                $data['waktu_checkin'] = now();
            }
            
            if ($request->status_booking === 'completed' && !$transaksi->waktu_checkout) {
                $data['waktu_checkout'] = now();
            }
        }
        
        if ($request->has('metode_pembayaran')) {
            $data['metode_pembayaran'] = $request->metode_pembayaran;
        }
        
        if ($request->has('catatan')) {
            $data['catatan'] = $request->catatan;
        }

        $transaksi->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Status transaksi berhasil diperbarui!'
        ]);
    }

    /**
     * Check in customer
     */
    public function checkin(Transaksi $transaksi)
    {
        if ($transaksi->status_booking !== 'confirmed') {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi harus dalam status dikonfirmasi untuk check-in'
            ], 400);
        }

        $transaksi->update([
            'status_booking' => 'ongoing',
            'waktu_checkin' => now()
        ]);

        // Update meja status to occupied
        $transaksi->meja->update(['status' => 'occupied']);

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil check-in!'
        ]);
    }

    /**
     * Check out customer
     */
    public function checkout(Transaksi $transaksi)
    {
        if ($transaksi->status_booking !== 'ongoing') {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi harus dalam status berlangsung untuk check-out'
            ], 400);
        }

        $transaksi->update([
            'status_booking' => 'completed',
            'waktu_checkout' => now()
        ]);

        // Update meja status back to available
        $transaksi->meja->update(['status' => 'available']);

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil check-out!'
        ]);
    }

    /**
     * Cancel transaction
     */
    public function cancel(Transaksi $transaksi)
    {
        $transaksi->update([
            'status_pembayaran' => 'cancelled',
            'status_booking' => 'cancelled'
        ]);

        // Make sure meja is available
        $transaksi->meja->update(['status' => 'available']);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dibatalkan!'
        ]);
    }

    /**
     * Get transaction statistics for dashboard
     */
    public function getStats()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        $stats = [
            'total_transaksi' => Transaksi::count(),
            'transaksi_hari_ini' => Transaksi::whereDate('created_at', $today)->count(),
            'total_pendapatan' => Transaksi::paid()->sum('total_harga'),
            'pendapatan_hari_ini' => Transaksi::paid()->whereDate('created_at', $today)->sum('total_harga'),
            'pendapatan_bulan_ini' => Transaksi::paid()->where('created_at', '>=', $thisMonth)->sum('total_harga'),
            'transaksi_pending' => Transaksi::where('status_pembayaran', 'pending')->count(),
            'transaksi_berlangsung' => Transaksi::where('status_booking', 'ongoing')->count(),
            'meja_terpakai' => Meja::where('status', 'occupied')->count(),
            'meja_tersedia' => Meja::where('status', 'available')->count()
        ];

        return response()->json($stats);
    }
}
