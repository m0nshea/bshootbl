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

    public function __construct()
    {
        // Middleware is handled by routes, not in constructor
    }

    /**
     * Get payment service instance
     */
    private function getPaymentService()
    {
        if (!$this->paymentService) {
            $this->paymentService = app(PaymentService::class);
        }
        return $this->paymentService;
    }

    /**
     * Get available time slots for a specific meja and date
     */
    public function getAvailableTimes(Request $request, $mejaId)
    {
        try {
            $request->validate([
                'date' => 'required|date|after_or_equal:today',
                'duration' => 'integer|min:1|max:8'
            ]);

            $date = $request->get('date');
            $duration = $request->get('duration', 1);

            $meja = Meja::findOrFail($mejaId);

            // Get available time slots using the new method
            $availableSlots = $meja->getAvailableTimeSlotsForDate($date, $duration);
            $bookedSlots = $meja->getBookedTimeSlotsForDate($date);

            return response()->json([
                'success' => true,
                'available_slots' => $availableSlots,
                'booked_slots' => $bookedSlots,
                'date' => $date,
                'meja_id' => $mejaId,
                'duration' => $duration,
                'meja_status' => $meja->status,
                'debug' => [
                    'total_bookings' => $meja->transaksis()
                        ->where('tanggal_booking', $date)
                        ->whereIn('status_pembayaran', ['paid', 'pending'])
                        ->where('status_booking', '!=', 'completed')
                        ->where('status_booking', '!=', 'cancelled')
                        ->count()
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting available times', [
                'meja_id' => $mejaId,
                'date' => $request->get('date'),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat jam tersedia: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available dates for a specific meja (dates that have at least one available time slot)
     */
    public function getAvailableDates(Request $request, $mejaId)
    {
        try {
            $request->validate([
                'duration' => 'integer|min:1|max:8'
            ]);

            $duration = $request->get('duration', 1);
            $meja = Meja::findOrFail($mejaId);

            // Check next 30 days for available slots
            $availableDates = [];
            $startDate = now();
            $endDate = now()->addDays(30);

            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                try {
                    $dateString = $date->toDateString();

                    // Skip if meja is in maintenance
                    if ($meja->status === 'maintenance') {
                        continue;
                    }

                    // Get available slots for this date
                    $availableSlots = $meja->getAvailableTimeSlotsForDate($dateString, $duration);

                    // Check if there are any available slots for this date
                    $availableSlotsCount = 0;
                    foreach ($availableSlots as $slot) {
                        if (isset($slot['available']) && $slot['available'] === true) {
                            $availableSlotsCount++;
                        }
                    }

                    if ($availableSlotsCount > 0) {
                        $availableDates[] = [
                            'date' => $dateString,
                            'formatted_date' => $date->format('d/m/Y'),
                            'day_name' => $date->format('l'),
                            'available_slots_count' => $availableSlotsCount
                        ];
                    }
                } catch (\Exception $dateError) {
                    // Log individual date error but continue with other dates
                    Log::warning('Error processing date in getAvailableDates', [
                        'meja_id' => $mejaId,
                        'date' => $date->toDateString(),
                        'error' => $dateError->getMessage()
                    ]);
                    continue;
                }
            }

            return response()->json([
                'success' => true,
                'available_dates' => $availableDates,
                'duration' => $duration,
                'meja_id' => $mejaId,
                'debug' => [
                    'total_dates_checked' => 30,
                    'available_dates_found' => count($availableDates),
                    'meja_status' => $meja->status
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting available dates', [
                'meja_id' => $mejaId,
                'duration' => $request->get('duration'),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat tanggal tersedia: ' . $e->getMessage(),
                'debug' => [
                    'error_type' => get_class($e),
                    'error_line' => $e->getLine(),
                    'error_file' => basename($e->getFile())
                ]
            ], 500);
        }
    }


    /**
     * Debug specific time slot availability
     */
    public function debugTimeSlot(Request $request, $mejaId)
    {
        try {
            $meja = Meja::findOrFail($mejaId);
            $date = $request->get('date', now()->toDateString());
            $time = $request->get('time', '21:00');
            $duration = $request->get('duration', 1);

            // Get ALL bookings for this date (regardless of status)
            $allBookings = $meja->transaksis()
                ->where('tanggal_booking', $date)
                ->get(['id', 'jam_mulai', 'durasi', 'status_pembayaran', 'status_booking', 'created_at']);

            // Get filtered bookings (what the system uses)
            $filteredBookings = $meja->transaksis()
                ->where('status_pembayaran', 'paid')
                ->where('tanggal_booking', $date)
                ->where('status_booking', '!=', 'completed')
                ->where('status_booking', '!=', 'cancelled')
                ->get(['id', 'jam_mulai', 'durasi', 'status_pembayaran', 'status_booking', 'created_at']);

            // Test the specific time slot
            $requestedStart = \Carbon\Carbon::parse($date . ' ' . $time);
            $requestedEnd = $requestedStart->copy()->addHours((int)$duration);

            $conflictDetails = [];
            foreach ($filteredBookings as $booking) {
                $jamMulai = $booking->jam_mulai;
                $durasi = (int)$booking->durasi;

                if (preg_match('/^\d{2}:\d{2}$/', $jamMulai)) {
                    $bookingStart = \Carbon\Carbon::parse($date . ' ' . $jamMulai);
                } else {
                    $bookingStart = \Carbon\Carbon::parse($jamMulai);
                    if ($bookingStart->format('Y-m-d') === '1970-01-01') {
                        $bookingStart = \Carbon\Carbon::parse($date . ' ' . $bookingStart->format('H:i:s'));
                    }
                }

                $bookingEnd = $bookingStart->copy()->addHours($durasi);

                $overlaps = $requestedStart->lt($bookingEnd) && $requestedEnd->gt($bookingStart);

                $conflictDetails[] = [
                    'booking_id' => $booking->id,
                    'booking_time' => $bookingStart->format('H:i') . '-' . $bookingEnd->format('H:i'),
                    'requested_time' => $requestedStart->format('H:i') . '-' . $requestedEnd->format('H:i'),
                    'overlaps' => $overlaps,
                    'status_pembayaran' => $booking->status_pembayaran,
                    'status_booking' => $booking->status_booking
                ];
            }

            $isAvailable = $meja->isTimeSlotAvailable($date, $time, $duration);

            return response()->json([
                'success' => true,
                'meja_id' => $mejaId,
                'test_params' => [
                    'date' => $date,
                    'time' => $time,
                    'duration' => $duration
                ],
                'result' => [
                    'is_available' => $isAvailable,
                    'requested_slot' => $requestedStart->format('H:i') . '-' . $requestedEnd->format('H:i')
                ],
                'all_bookings' => $allBookings,
                'filtered_bookings' => $filteredBookings,
                'conflict_analysis' => $conflictDetails,
                'debug_info' => [
                    'total_bookings' => $allBookings->count(),
                    'filtered_bookings_count' => $filteredBookings->count(),
                    'conflicts_found' => collect($conflictDetails)->where('overlaps', true)->count()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }


        try {
            $request->validate([
                'date' => 'required|date|after_or_equal:today',
                'time' => 'required|date_format:H:i',
                'duration' => 'required|integer|min:1|max:8'
            ]);

            $meja = Meja::findOrFail($mejaId);
            $date = $request->get('date');
            $time = $request->get('time');
            $duration = $request->get('duration');

            $isAvailable = $meja->isTimeSlotAvailable($date, $time, $duration);

            return response()->json([
                'success' => true,
                'available' => $isAvailable,
                'date' => $date,
                'time' => $time,
                'duration' => $duration,
                'meja_id' => $mejaId
            ]);
        } catch (\Exception $e) {
            Log::error('Error checking time slot availability', [
                'meja_id' => $mejaId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memeriksa ketersediaan waktu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show checkout form
     */
    public function checkout(Request $request)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu untuk melakukan booking.');
        }

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
            // Ensure user is authenticated
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login terlebih dahulu untuk melakukan booking.',
                    'redirect' => route('login')
                ], 401);
            }

            // Validate request
            $validated = $request->validate([
                'meja_id' => 'required|exists:mejas,id',
                'jenis_ball' => 'required|in:8_ball,9_ball',
                'tanggal_booking' => 'required|date|after_or_equal:today',
                'jam_mulai' => 'required|date_format:H:i',
                'durasi' => 'required|integer|min:1|max:8',
                'metode_pembayaran' => 'required|in:qris,transfer,ewallet',
                'catatan' => 'nullable|string'
            ]);

            // Get meja
            $meja = Meja::findOrFail($validated['meja_id']);

            // Check if the requested time slot is available
            $isAvailable = $meja->isTimeSlotAvailable(
                $validated['tanggal_booking'],
                $validated['jam_mulai'],
                $validated['durasi']
            );

            if (!$isAvailable) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Maaf, waktu yang Anda pilih sudah tidak tersedia. Silakan pilih waktu lain.',
                        'error_type' => 'time_slot_unavailable'
                    ], 422);
                }

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Maaf, waktu yang Anda pilih sudah tidak tersedia. Silakan pilih waktu lain.');
            }

            // Calculate total
            $totalHarga = $meja->harga * $validated['durasi'];

            // Generate unique transaction code
            $kodeTransaksi = Transaksi::generateKodeTransaksi();

            // Create transaction
            $transaksi = Transaksi::create([
                'kode_transaksi' => $kodeTransaksi,
                'user_id' => Auth::id(),
                'meja_id' => $validated['meja_id'],
                'jenis_ball' => $validated['jenis_ball'],
                'tanggal_booking' => \Carbon\Carbon::parse($validated['tanggal_booking'])->startOfDay(),
                'jam_mulai' => $validated['jam_mulai'],
                'durasi' => $validated['durasi'],
                'harga_per_jam' => $meja->harga,
                'total_harga' => $totalHarga,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'status_pembayaran' => 'pending',
                'status_booking' => 'confirmed',
                'catatan' => $validated['catatan'] ?? null
            ]);

            // Create payment token using Midtrans
            try {
                $paymentResult = $this->getPaymentService()->createPaymentToken(
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
                $paymentResult = $this->getPaymentService()->createPaymentToken(
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
                $statusResult = $this->getPaymentService()->checkPaymentStatus($transaksi->midtrans_order_id);

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
            $result = $this->getPaymentService()->cancelPayment($transaksiId, Auth::id());

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
        try {
            // Simple version without complex relationships first
            $transaksis = Transaksi::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('pelangganRiwayat.riwayat', compact('transaksis'));
        } catch (\Exception $e) {
            \Log::error('Riwayat Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->view('errors.500', [
                'message' => 'Terjadi kesalahan saat memuat riwayat: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show transaction detail for customer
     */
    public function detailRiwayat($transaksiId)
    {
        try {
            $transaksi = Transaksi::with(['meja.category'])
                ->where('user_id', Auth::id())
                ->findOrFail($transaksiId);

            return view('pelangganRiwayat.detail', compact('transaksi'));
        } catch (\Exception $e) {
            Log::error('Error loading detail riwayat: ' . $e->getMessage());
            return redirect()->route('customer.riwayat')
                ->with('error', 'Transaksi tidak ditemukan atau terjadi kesalahan.');
        }
    }

    /**
     * Test overlap logic for debugging
     */
    public function testOverlap(Request $request, $mejaId)
    {
        try {
            $meja = Meja::findOrFail($mejaId);
            $testDate = $request->get('date', now()->toDateString());

            // Get actual bookings for this date
            $bookings = $meja->transaksis()
                ->whereIn('status_pembayaran', ['paid', 'pending'])
                ->where('tanggal_booking', $testDate)
                ->whereNotIn('status_booking', ['completed', 'cancelled', 'failed'])
                ->get(['id', 'jam_mulai', 'durasi', 'status_pembayaran', 'status_booking']);

            // Test if 21:00 slot is available
            $isAvailable = $meja->isTimeSlotAvailable($testDate, '21:00', 1);

            return response()->json([
                'success' => true,
                'meja_id' => $mejaId,
                'test_date' => $testDate,
                'existing_bookings' => $bookings,
                'testing_slot' => '21:00-22:00',
                'is_available' => $isAvailable,
                'should_be_unavailable_if_booking_exists' => $bookings->count() > 0
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
