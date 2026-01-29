<?php

namespace App\Services;

use App\Models\Transaksi;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebhookPaymentService
{
    public function __construct()
    {
        // Set Midtrans configuration
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    /**
     * Handle Midtrans notification webhook
     */
    public function handleNotification($notification)
    {
        try {
            DB::beginTransaction();

            // Create notification object
            $notif = new \Midtrans\Notification();

            // Extract data from notification
            $transactionStatus = $notif->transaction_status;
            $fraudStatus = $notif->fraud_status ?? null;
            $orderId = $notif->order_id;
            $paymentType = $notif->payment_type;

            Log::info('Midtrans Notification Received', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
                'payment_type' => $paymentType
            ]);

            // Find transaction by midtrans_order_id
            $transaksi = Transaksi::where('midtrans_order_id', $orderId)->first();

            if (!$transaksi) {
                Log::error('Transaction not found for Midtrans order', [
                    'midtrans_order_id' => $orderId
                ]);
                throw new Exception('Transaksi tidak ditemukan');
            }

            // Handle different transaction statuses
            $this->updateTransactionStatus($transaksi, $transactionStatus, $fraudStatus, $paymentType);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Notification processed successfully',
                'transaction_id' => $transaksi->id,
                'status' => $transactionStatus
            ];

        } catch (Exception $e) {
            DB::rollback();

            Log::error('Webhook notification processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Update transaction status based on Midtrans notification
     */
    private function updateTransactionStatus($transaksi, $transactionStatus, $fraudStatus, $paymentType)
    {
        $updateData = [
            'payment_type' => $paymentType,
            'updated_at' => now()
        ];

        switch ($transactionStatus) {
            case 'capture':
                if ($fraudStatus == 'accept') {
                    $updateData['status_pembayaran'] = 'paid';
                    $updateData['status_booking'] = 'confirmed';
                    $updateData['paid_at'] = now();
                    
                    // Update meja status to reserved (not occupied yet, just reserved)
                    // $transaksi->meja->update(['status' => 'reserved']);
                } else {
                    $updateData['status_pembayaran'] = 'pending';
                }
                break;

            case 'settlement':
                $updateData['status_pembayaran'] = 'paid';
                $updateData['status_booking'] = 'confirmed';
                $updateData['paid_at'] = now();
                
                // Update meja status to reserved (not occupied yet, just reserved)
                // $transaksi->meja->update(['status' => 'reserved']);
                break;

            case 'pending':
                $updateData['status_pembayaran'] = 'pending';
                $updateData['status_booking'] = 'pending';
                break;

            case 'deny':
            case 'cancel':
                $updateData['status_pembayaran'] = 'failed';
                $updateData['status_booking'] = 'cancelled';
                
                // Make meja available again
                $transaksi->meja->update(['status' => 'available']);
                break;

            case 'expire':
                $updateData['status_pembayaran'] = 'expired';
                $updateData['status_booking'] = 'cancelled';
                
                // Make meja available again
                $transaksi->meja->update(['status' => 'available']);
                break;

            default:
                Log::warning('Unknown transaction status', [
                    'transaction_id' => $transaksi->id,
                    'status' => $transactionStatus
                ]);
                break;
        }

        $transaksi->update($updateData);

        Log::info('Transaction status updated', [
            'transaction_id' => $transaksi->id,
            'kode_transaksi' => $transaksi->kode_transaksi,
            'old_status' => $transaksi->getOriginal('status_pembayaran'),
            'new_status' => $updateData['status_pembayaran'] ?? 'unchanged',
            'meja_status' => $transaksi->meja->status
        ]);
    }

    /**
     * Verify notification signature
     */
    public function verifySignature($orderId, $statusCode, $grossAmount, $serverKey)
    {
        $mySignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        return $mySignature;
    }
}
