<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Meja;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BookingController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Show checkout form
     */
    public function checkout(Request $request)
    {
        $mejaId = $request->get('meja');
        $meja = Meja::with('category')->findOrFail($mejaId);
        
        // Get booking details from request
        $bookingData = [
            'meja' => $meja,
            'nama' => $request->get('nama', $meja->nama_meja),
            'harga' => $request->get('harga', $meja->harga),
            'tanggal' => $request->get('tanggal'),
            'jam' => $request->get('jam'),
            'durasi' => $request->get('durasi')
        ];
        
        // Calculate total if all data is present
        if ($bookingData['durasi']) {
            $bookingData['total'] = $bookingData['harga'] * $bookingData['durasi'];
        }

        return view('pelangganMeja.checkout', compact('bookingData'));
    }

    /**
     * Process booking and create transaction
     */
    public function processBooking(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'meja_id' => 'required|exists:mejas,id',
                'nama_pelanggan' => 'required|string|max:255',
                'email_pelanggan' => 'required|email',
                'no_telepon' => 'nullable|string|max:20',
                'tanggal_booking' => 'required|date',
                'jam_mulai' => 'required',
                'durasi' => 'required|integer|min:1|max:8',
                'metode_pembayaran' => 'required|in:qris,transfer,ewallet',
                'catatan' => 'nullable|string'
            ]);

            // Get meja
            $meja = Meja::findOrFail($validated['meja_id']);

            // Calculate total
            $totalHarga = $meja->harga * $validated['durasi'];

            // Generate unique transaction code
            $kodeTransaksi = Transaksi::generateKodeTransaksi();

            // Create transaction
            $transaksi = Transaksi::create([
                'kode_transaksi' => $kodeTransaksi,
                'user_id' => Auth::id(),
                'meja_id' => $validated['meja_id'],
                'nama_pelanggan' => $validated['nama_pelanggan'],
                'email_pelanggan' => $validated['email_pelanggan'],
                'no_telepon' => $validated['no_telepon'] ?? null,
                'tanggal_booking' => $validated['tanggal_booking'],
                'jam_mulai' => $validated['jam_mulai'],
                'durasi' => $validated['durasi'],
                'harga_per_jam' => $meja->harga,
                'total_harga' => $totalHarga,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'status_pembayaran' => 'pending',
                'status_booking' => 'pending',
                'catatan' => $validated['catatan'] ?? null
            ]);

            // Create payment token using Midtrans
            try {
                $paymentResult = $this->paymentService->createPaymentToken(
                    $transaksi->id,
                    Auth::id()
                );

                // Check if request expects JSON (AJAX request)
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Booking berhasil dibuat',
                        'transaction_id' => $transaksi->id,
                        'kode_transaksi' => $transaksi->kode_transaksi,
                        'snap_token' => $paymentResult['snap_token'],
                        'total_amount' => $transaksi->total_harga
                    ]);
                }

                // Redirect to payment page with snap token (for non-AJAX)
                return redirect()->route('customer.payment.page', $transaksi->id)
                               ->with('success', 'Booking berhasil! Silakan lakukan pembayaran.');

            } catch (\Exception $e) {
                Log::error('Payment token creation failed', [
                    'transaksi_id' => $transaksi->id,
                    'error' => $e->getMessage()
                ]);

                // If AJAX request
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Booking berhasil, namun gagal membuat token pembayaran. Silakan coba lagi dari halaman riwayat.',
                        'transaction_id' => $transaksi->id
                    ], 500);
                }

                // If payment token creation fails, still allow user to see transaction
                return redirect()->route('customer.pembayaran', $transaksi->id)
                               ->with('warning', 'Booking berhasil, namun terjadi kesalahan saat membuat pembayaran. Silakan coba lagi.');
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation error
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()
                           ->withInput()
                           ->withErrors($e->errors());

        } catch (\Exception $e) {
            Log::error('Booking Error: ' . $e->getMessage());
            
            // If AJAX request
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show payment page with Midtrans Snap
     */
    public function paymentPage($transaksiId)
    {
        $transaksi = Transaksi::with(['meja.category'])->findOrFail($transaksiId);
        
        // Check if user owns this transaction
        if (Auth::id() !== $transaksi->user_id) {
            abort(403, 'Unauthorized access');
        }

        // Check if already paid
        if ($transaksi->status_pembayaran === 'paid') {
            return redirect()->route('customer.riwayat')
                           ->with('info', 'Transaksi ini sudah dibayar.');
        }

        // Get or create payment token
        try {
            if (!$transaksi->snap_token || $transaksi->payment_expires_at < now()) {
                $paymentResult = $this->paymentService->createPaymentToken(
                    $transaksi->id,
                    Auth::id()
                );
                $transaksi->refresh();
            }
        } catch (\Exception $e) {
            Log::error('Failed to get payment token', [
                'transaksi_id' => $transaksiId,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('customer.riwayat')
                           ->with('error', 'Gagal memuat halaman pembayaran. Silakan coba lagi.');
        }

        return view('pelangganPembayaran.pembayaran', compact('transaksi'));
    }

    /**
     * Handle payment finish callback from Midtrans
     */
    public function paymentFinish($transaksiId)
    {
        $transaksi = Transaksi::findOrFail($transaksiId);
        
        // Check if user owns this transaction
        if (Auth::id() !== $transaksi->user_id) {
            abort(403, 'Unauthorized access');
        }

        // Check payment status from Midtrans
        if ($transaksi->midtrans_order_id) {
            try {
                $statusResult = $this->paymentService->checkPaymentStatus($transaksi->midtrans_order_id);
                
                if ($statusResult['success']) {
                    $transactionStatus = $statusResult['transaction_status'];
                    
                    if (in_array($transactionStatus, ['settlement', 'capture'])) {
                        return redirect()->route('customer.riwayat')
                                       ->with('success', 'Pembayaran berhasil! Booking Anda telah dikonfirmasi.');
                    } elseif ($transactionStatus === 'pending') {
                        return redirect()->route('customer.riwayat')
                                       ->with('info', 'Pembayaran Anda sedang diproses. Silakan tunggu konfirmasi.');
                    } else {
                        return redirect()->route('customer.riwayat')
                                       ->with('warning', 'Status pembayaran: ' . $transactionStatus);
                    }
                }
            } catch (\Exception $e) {
                Log::error('Check payment status failed', [
                    'transaksi_id' => $transaksiId,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return redirect()->route('customer.riwayat')
                       ->with('info', 'Silakan cek status pembayaran Anda di riwayat transaksi.');
    }

    /**
     * Show payment page (legacy - for backward compatibility)
     */
    public function pembayaran($transaksiId)
    {
        return $this->paymentPage($transaksiId);
    }

    /**
     * Show QRIS payment page (legacy - redirect to new payment page)
     */
    public function qris($transaksiId = null)
    {
        if (!$transaksiId) {
            return redirect()->route('customer.meja')
                           ->with('error', 'Transaksi tidak ditemukan.');
        }
        
        return $this->paymentPage($transaksiId);
    }

    /**
     * Confirm payment (simulate payment gateway callback - for testing only)
     */
    public function confirmPayment(Request $request, $transaksiId)
    {
        $transaksi = Transaksi::findOrFail($transaksiId);
        
        // Check if user owns this transaction
        if (Auth::id() !== $transaksi->user_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $transaksi->update([
            'status_pembayaran' => 'paid',
            'status_booking' => 'confirmed',
            'paid_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dikonfirmasi!'
        ]);
    }

    /**
     * Cancel payment
     */
    public function cancelPayment($transaksiId)
    {
        try {
            $result = $this->paymentService->cancelPayment($transaksiId, Auth::id());
            
            return redirect()->route('customer.riwayat')
                           ->with('success', $result['message']);

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', $e->getMessage());
        }
    }

    /**
     * Show customer transaction history
     */
    public function riwayat()
    {
        $transaksis = Transaksi::with(['meja.category'])
                              ->where('user_id', Auth::id())
                              ->latest()
                              ->paginate(10);

        return view('pelangganRiwayat.riwayat', compact('transaksis'));
    }

    /**
     * Show transaction detail for customer
     */
    public function detailRiwayat($transaksiId)
    {
        $transaksi = Transaksi::with(['meja.category'])
                             ->where('user_id', Auth::id())
                             ->findOrFail($transaksiId);

        return view('pelangganRiwayat.detail', compact('transaksi'));
    }
}
