<?php

namespace App\Jobs;

use App\Models\Transaksi;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class AutoCancellationBook implements ShouldQueue
{
    use Queueable;

    protected $transaksiId;

    /**
     * Create a new job instance.
     */
    public function __construct($transaksiId)
    {
        $this->transaksiId = $transaksiId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Find the transaction
            $transaksi = Transaksi::find($this->transaksiId);
            
            if (!$transaksi) {
                Log::warning('AutoCancellationBook: Transaction not found', [
                    'transaksi_id' => $this->transaksiId
                ]);
                return;
            }

            // Check if payment is still pending
            if ($transaksi->status_pembayaran !== 'pending') {
                Log::info('AutoCancellationBook: Transaction already processed', [
                    'transaksi_id' => $this->transaksiId,
                    'current_status' => $transaksi->status_pembayaran
                ]);
                return;
            }

            // Check if payment has expired
            if ($transaksi->payment_expires_at && $transaksi->payment_expires_at <= now()) {
                // Cancel the transaction
                $transaksi->update([
                    'status_pembayaran' => 'cancelled'
                ]);
               
            } else {
                Log::info('AutoCancellationBook: Transaction not expired yet', [
                    'transaksi_id' => $this->transaksiId,
                    'expires_at' => $transaksi->payment_expires_at,
                    'current_time' => now()
                ]);
            }

        } catch (\Exception $e) {
            Log::error('AutoCancellationBook: Job execution failed', [
                'transaksi_id' => $this->transaksiId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Re-throw to mark job as failed
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('AutoCancellationBook: Job failed permanently', [
            'transaksi_id' => $this->transaksiId,
            'error' => $exception->getMessage()
        ]);
    }
}
