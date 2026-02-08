<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Meja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Display laporan page
     */
    public function index()
    {
        return view('adminLaporan.laporan');
    }

    /**
     * Reset all transaction data (set to 0)
     */
    public function resetData(Request $request)
    {
        try {
            DB::beginTransaction();

            // Truncate transaksis table (delete all records)
            DB::table('transaksis')->truncate();

            // Reset meja status to available
            Meja::query()->update(['status' => 'available']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Semua data transaksi berhasil direset menjadi 0'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mereset data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get report data based on filters
     */
    public function getData(Request $request)
    {
        try {
            $type = $request->get('type', 'revenue');
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');
            $period = $request->get('period', 'daily');

            $query = Transaksi::with(['user', 'meja'])
                ->where('status_pembayaran', 'paid');

            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }

            $data = $query->get();

            // Process data based on report type
            $result = $this->processReportData($data, $type, $period);

            return response()->json([
                'success' => true,
                'data' => $result
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process report data based on type
     */
    private function processReportData($data, $type, $period)
    {
        switch ($type) {
            case 'revenue':
                return $this->processRevenueData($data, $period);
            case 'transaction':
                return $this->processTransactionData($data, $period);
            case 'table':
                return $this->processTableData($data, $period);
            case 'customer':
                return $this->processCustomerData($data, $period);
            default:
                return [];
        }
    }

    private function processRevenueData($data, $period)
    {
        // Group by period and calculate revenue
        return $data->groupBy(function($item) use ($period) {
            return $this->groupByPeriod($item->created_at, $period);
        })->map(function($items) {
            return [
                'total' => $items->sum('total_harga'),
                'count' => $items->count()
            ];
        });
    }

    private function processTransactionData($data, $period)
    {
        return $data->groupBy(function($item) use ($period) {
            return $this->groupByPeriod($item->created_at, $period);
        })->map(function($items) {
            return [
                'count' => $items->count(),
                'total' => $items->sum('total_harga')
            ];
        });
    }

    private function processTableData($data, $period)
    {
        return $data->groupBy('meja_id')->map(function($items) {
            return [
                'meja' => $items->first()->meja->nama_meja ?? 'Unknown',
                'count' => $items->count(),
                'total' => $items->sum('total_harga')
            ];
        });
    }

    private function processCustomerData($data, $period)
    {
        return $data->groupBy('user_id')->map(function($items) {
            return [
                'customer' => $items->first()->user->name ?? 'Unknown',
                'count' => $items->count(),
                'total' => $items->sum('total_harga')
            ];
        });
    }

    private function groupByPeriod($date, $period)
    {
        switch ($period) {
            case 'daily':
                return $date->format('Y-m-d');
            case 'weekly':
                return $date->format('Y-W');
            case 'monthly':
                return $date->format('Y-m');
            default:
                return $date->format('Y-m-d');
        }
    }
}
