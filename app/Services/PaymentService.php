<?php

namespace App\Services;

use App\Models\Transaksi;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
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
     * Create payment token for booking transaction
     */
    public function createPaymentToken($transaksiId, $userId)
    {
        try {
            DB::beginTransaction();

            // Validate transaction
            $transaksi = $this->validateTransaksi($transaksiId, $userId);

            // Check existing payment token
            $existingToken = $this->checkExistingPaymentToken($transaksi);
            if ($existingToken) {
                DB::commit();
                return $this->handleExistingPaymentToken($transaksi, $existingToken);
            }

            // Generate Midtrans order ID
            $midtransOrderId = $transaksi->kode_transaksi . '_' . now()->format('YmdHis');

            // Generate snap token
            $snapToken = $this->generateMidtransToken($midtransOrderId, $transaksi);

            // Update transaction with payment info
            $transaksi->update([
                'snap_token' => $snapToken,
                'midtrans_order_id' => $midtransOrderId,
                'payment_expires_at' => now()->addHours(24)
            ]);

            DB::commit();

            return [
                'success' => true,
                'transaction_id' => $transaksi->id,
                'kode_transaksi' => $transaksi->kode_transaksi,
                'midtrans_order_id' => $midtransOrderId,
                'snap_token' => $snapToken,
                'expires_at' => $transaksi->payment_expires_at,
                'total_amount' => $transaksi->total_harga
            ];

        } catch (Exception $e) {
            DB::rollback();

            Log::error('Payment token creation failed', [
                'transaksi_id' => $transaksiId,
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Validate transaction
     */
    private function validateTransaksi($transaksiId, $userId)
    {
        $transaksi = Transaksi::with(['meja.category', 'user'])
            ->where('id', $transaksiId)
            ->where('user_id', $userId)
            ->whereIn('status_pembayaran', ['pending', 'failed'])
            ->first();

        if (!$transaksi) {
            throw new Exception('Transaksi tidak ditemukan atau tidak valid');
        }

        return $transaksi;
    }

    /**
     * Check if transaction already has valid payment token
     */
    private function checkExistingPaymentToken($transaksi)
    {
        if (!$transaksi->snap_token) {
            return null;
        }

        // Check if token is still valid (not expired)
        if ($transaksi->payment_expires_at && $transaksi->payment_expires_at > now()) {
            return $transaksi->snap_token;
        }

        return null;
    }

    /**
     * Handle existing payment token
     */
    private function handleExistingPaymentToken($transaksi, $snapToken)
    {
        return [
            'success' => true,
            'transaction_id' => $transaksi->id,
            'kode_transaksi' => $transaksi->kode_transaksi,
            'midtrans_order_id' => $transaksi->midtrans_order_id,
            'snap_token' => $snapToken,
            'expires_at' => $transaksi->payment_expires_at,
            'total_amount' => $transaksi->total_harga,
            'message' => 'Menggunakan token pembayaran yang sudah ada'
        ];
    }

    /**
     * Generate Midtrans snap token
     */
    private function generateMidtransToken($midtransOrderId, $transaksi)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $midtransOrderId,
                'gross_amount' => (int) round($transaksi->total_harga),
            ],
            'item_details' => $this->buildItemDetails($transaksi),
            'customer_details' => [
                'first_name' => $transaksi->user->name ?? 'Customer',
                'email' => filter_var($transaksi->user->email, FILTER_VALIDATE_EMAIL)
                    ? $transaksi->user->email
                    : 'customer@bshootbilliard.com',
                'phone' => $transaksi->user->no_telepon ?? '08123456789',
            ],
            'enabled_payments' => $this->getEnabledPayments($transaksi->metode_pembayaran),
            'callbacks' => [
                'finish' => route('customer.payment.finish', $transaksi->id)
            ],
            'expiry' => [
                'start_time' => now()->format('Y-m-d H:i:s O'),
                'unit' => 'hours',
                'duration' => 24
            ]
        ];

        return \Midtrans\Snap::getSnapToken($params);
    }

    /**
     * Build item details for Midtrans
     */
    private function buildItemDetails($transaksi)
    {
        return [
            [
                'id' => 'BOOKING-' . $transaksi->meja_id,
                'price' => (int) round($transaksi->total_harga),
                'quantity' => 1,
                'name' => substr('Booking ' . $transaksi->meja->nama_meja . ' - ' . $transaksi->durasi . ' Jam', 0, 50),
            ]
        ];
    }

    /**
     * Get enabled payment methods based on selected method
     */
    private function getEnabledPayments($metode_pembayaran)
    {
        // Map metode pembayaran to Midtrans payment methods
        $paymentMap = [
            'qris' => ['qris', 'gopay', 'shopeepay'],
            'transfer' => ['bank_transfer', 'bca_va', 'bni_va', 'bri_va', 'permata_va'],
            'ewallet' => ['gopay', 'shopeepay', 'qris'],
            'credit_card' => ['credit_card']
        ];

        return $paymentMap[$metode_pembayaran] ?? ['qris', 'gopay', 'bank_transfer'];
    }

    /**
     * Check payment status from Midtrans
     */
    public function checkPaymentStatus($midtransOrderId)
    {
        try {
            $status = \Midtrans\Transaction::status($midtransOrderId);
            
            return [
                'success' => true,
                'order_id' => $status->order_id,
                'transaction_status' => $status->transaction_status,
                'payment_type' => $status->payment_type,
                'transaction_time' => $status->transaction_time,
                'gross_amount' => $status->gross_amount
            ];

        } catch (Exception $e) {
            Log::error('Check payment status failed', [
                'midtrans_order_id' => $midtransOrderId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengecek status pembayaran'
            ];
        }
    }

    /**
     * Cancel payment
     */
    public function cancelPayment($transaksiId, $userId)
    {
        try {
            $transaksi = Transaksi::where('id', $transaksiId)
                ->where('user_id', $userId)
                ->first();

            if (!$transaksi) {
                throw new Exception('Transaksi tidak ditemukan');
            }

            if ($transaksi->status_pembayaran === 'paid') {
                throw new Exception('Pembayaran sudah berhasil, tidak dapat dibatalkan');
            }

            // Cancel in Midtrans if order ID exists
            if ($transaksi->midtrans_order_id) {
                try {
                    \Midtrans\Transaction::cancel($transaksi->midtrans_order_id);
                } catch (Exception $e) {
                    Log::warning('Midtrans cancel failed', [
                        'midtrans_order_id' => $transaksi->midtrans_order_id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // Update transaction status
            $transaksi->update([
                'status_pembayaran' => 'cancelled',
                'status_booking' => 'cancelled'
            ]);

            return [
                'success' => true,
                'message' => 'Pembayaran berhasil dibatalkan'
            ];

        } catch (Exception $e) {
            Log::error('Cancel payment failed', [
                'transaksi_id' => $transaksiId,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }
}