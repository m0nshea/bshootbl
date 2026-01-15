<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PenggunaController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::withCount(['transaksis', 'transaksis as total_spent' => function($q) {
            $q->where('status_pembayaran', 'paid')->select(\DB::raw('sum(total_harga)'));
        }]);

        // Filter by role if provided
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Filter by registration date
        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }

        // Search by name or email
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter users with transactions
        if ($request->has('has_transactions') && $request->has_transactions == '1') {
            $query->has('transaksis');
        }

        $users = $query->latest()->paginate(15);

        // Statistics
        $stats = [
            'total_users' => User::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'users_with_transactions' => User::has('transaksis')->count(),
            'new_users_this_month' => User::whereMonth('created_at', now()->month)
                                         ->whereYear('created_at', now()->year)
                                         ->count(),
            'active_users_today' => User::whereHas('transaksis', function($q) {
                $q->whereDate('created_at', today());
            })->count()
        ];

        return view('adminPengguna.pengguna', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('adminPengguna.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,customer',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string'
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'role.required' => 'Role harus dipilih',
            'role.in' => 'Role tidak valid'
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat
            ]);

            return redirect()->route('admin.pengguna.index')
                           ->with('success', 'Pengguna berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified user
     */
    public function show(User $pengguna)
    {
        $pengguna->load(['transaksis.meja.category']);
        
        // User statistics
        $userStats = [
            'total_transaksi' => $pengguna->transaksis->count(),
            'total_spent' => $pengguna->transaksis->where('status_pembayaran', 'paid')->sum('total_harga'),
            'transaksi_completed' => $pengguna->transaksis->where('status_booking', 'completed')->count(),
            'transaksi_pending' => $pengguna->transaksis->where('status_pembayaran', 'pending')->count(),
            'last_transaction' => $pengguna->transaksis->sortByDesc('created_at')->first(),
            'favorite_meja' => $pengguna->transaksis->groupBy('meja_id')
                                                   ->map->count()
                                                   ->sortDesc()
                                                   ->keys()
                                                   ->first()
        ];

        if ($userStats['favorite_meja']) {
            $userStats['favorite_meja'] = \App\Models\Meja::find($userStats['favorite_meja']);
        }

        return view('adminPengguna.detail', compact('pengguna', 'userStats'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $pengguna)
    {
        return view('adminPengguna.edit', compact('pengguna'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $pengguna)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($pengguna->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,customer',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'role.required' => 'Role harus dipilih',
            'role.in' => 'Role tidak valid',
            'status.required' => 'Status harus dipilih'
        ]);

        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'status' => $request->status
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $pengguna->update($data);

            return redirect()->route('admin.pengguna.index')
                           ->with('success', 'Data pengguna berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $pengguna)
    {
        try {
            // Check if user has transactions
            if ($pengguna->transaksis()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus pengguna yang memiliki riwayat transaksi. Nonaktifkan saja.'
                ], 400);
            }

            $pengguna->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pengguna berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle user status (active/inactive)
     */
    public function toggleStatus(User $pengguna)
    {
        try {
            $newStatus = $pengguna->status === 'active' ? 'inactive' : 'active';
            $pengguna->update(['status' => $newStatus]);

            return response()->json([
                'success' => true,
                'message' => 'Status pengguna berhasil diubah!',
                'new_status' => $newStatus
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user statistics for dashboard
     */
    public function getStats()
    {
        $stats = [
            'total_users' => User::count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'active_users' => User::where('status', 'active')->count(),
            'users_with_transactions' => User::has('transaksis')->count(),
            'top_customers' => User::withCount(['transaksis as total_spent' => function($q) {
                $q->where('status_pembayaran', 'paid')->select(\DB::raw('sum(total_harga)'));
            }])
            ->where('role', 'customer')
            ->orderBy('total_spent', 'desc')
            ->limit(5)
            ->get()
        ];

        return response()->json($stats);
    }

    /**
     * Export users data
     */
    public function export(Request $request)
    {
        $users = User::with(['transaksis'])->get();
        
        $csvData = [];
        $csvData[] = ['ID', 'Nama', 'Email', 'Role', 'No Telepon', 'Status', 'Total Transaksi', 'Total Spent', 'Tanggal Daftar'];
        
        foreach ($users as $user) {
            $csvData[] = [
                $user->id,
                $user->name,
                $user->email,
                $user->role,
                $user->no_telepon ?? '-',
                $user->status ?? 'active',
                $user->transaksis->count(),
                'Rp ' . number_format($user->transaksis->where('status_pembayaran', 'paid')->sum('total_harga'), 0, ',', '.'),
                $user->created_at->format('d/m/Y H:i')
            ];
        }

        $filename = 'users_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($csvData) {
            $file = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
