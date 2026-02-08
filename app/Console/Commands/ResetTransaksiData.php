<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetTransaksiData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaksi:reset {--force : Force reset without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset semua data transaksi dan laporan menjadi 0';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('╔════════════════════════════════════════════════════════╗');
        $this->info('║        RESET DATA TRANSAKSI & LAPORAN                  ║');
        $this->info('╚════════════════════════════════════════════════════════╝');
        $this->newLine();

        // Show warning
        $this->warn('⚠️  PERINGATAN: Tindakan ini akan:');
        $this->warn('   • Menghapus SEMUA data transaksi');
        $this->warn('   • Mereset semua laporan menjadi 0');
        $this->warn('   • Mereset status meja menjadi tersedia');
        $this->warn('   • Data TIDAK DAPAT dikembalikan!');
        $this->newLine();

        // Check current data
        $totalTransaksi = DB::table('transaksis')->count();
        $this->info("📊 Total transaksi saat ini: {$totalTransaksi}");
        $this->newLine();

        // Confirmation
        if (!$this->option('force')) {
            if (!$this->confirm('Apakah Anda yakin ingin melanjutkan?', false)) {
                $this->info('❌ Reset dibatalkan.');
                return 0;
            }
        }

        // Start reset process
        $this->info('🔄 Memulai proses reset...');
        $this->newLine();

        try {
            // Delete all transactions (using delete instead of truncate)
            $this->info('   ⏳ Menghapus data transaksi...');
            $deleted = DB::table('transaksis')->delete();
            $this->info("   ✅ {$deleted} data transaksi berhasil dihapus");

            // Reset meja status
            $this->info('   ⏳ Mereset status meja...');
            $updated = DB::table('mejas')->update(['status' => 'available']);
            $this->info("   ✅ {$updated} meja direset menjadi tersedia");

            $this->newLine();
            $this->info('╔════════════════════════════════════════════════════════╗');
            $this->info('║              RESET BERHASIL! ✨                        ║');
            $this->info('╚════════════════════════════════════════════════════════╝');
            $this->newLine();
            $this->info('✓ Semua data transaksi telah dihapus');
            $this->info('✓ Laporan direset menjadi 0');
            $this->info('✓ Status meja direset');
            $this->newLine();

            return 0;

        } catch (\Exception $e) {
            
            $this->newLine();
            $this->error('╔════════════════════════════════════════════════════════╗');
            $this->error('║              RESET GAGAL! ❌                           ║');
            $this->error('╚════════════════════════════════════════════════════════╝');
            $this->newLine();
            $this->error('Error: ' . $e->getMessage());
            $this->newLine();

            return 1;
        }
    }
}
