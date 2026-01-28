<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class ResetTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:reset {--force : Force reset without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all transactions in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $totalTransaksi = Transaksi::count();
        
        if ($totalTransaksi === 0) {
            $this->info('ℹ️  Tidak ada transaksi untuk dihapus');
            return 0;
        }

        $this->info("📊 Total transaksi yang akan dihapus: {$totalTransaksi}");

        // Ask for confirmation unless --force is used
        if (!$this->option('force')) {
            if (!$this->confirm('Apakah Anda yakin ingin menghapus semua transaksi? Tindakan ini tidak dapat dibatalkan.')) {
                $this->info('❌ Reset dibatalkan');
                return 0;
            }
        }

        try {
            $this->info('🔄 Memulai reset transaksi...');
            
            // Delete all transactions
            Transaksi::truncate();
            $this->info("✅ Berhasil menghapus {$totalTransaksi} transaksi");
            
            // Reset auto increment
            DB::statement('ALTER TABLE transaksis AUTO_INCREMENT = 1');
            $this->info('🔄 Auto increment direset ke 1');
            
            $this->info('✅ Reset transaksi selesai!');
            $this->info('📈 Grafik dashboard akan menampilkan data 0 (tidak ada data simulasi)');
            $this->info('🔄 Grafik akan kembali menampilkan data real saat ada transaksi baru');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
    }
}