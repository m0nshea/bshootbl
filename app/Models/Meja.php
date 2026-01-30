<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class Meja extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_meja',
        'lantai',
        'category_id',
        'status',
        'foto',
        'deskripsi'
    ];

    /**
     * Get the category that owns the meja
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all transaksis for this meja
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    /**
     * Check if meja is currently booked (paid booking for today or future)
     */
    public function isBooked()
    {
        // Check if meja status is reserved
        if ($this->status === 'reserved') {
            return true;
        }

        // Check if there's a paid booking for today or future
        return $this->transaksis()
            ->where('status_pembayaran', 'paid')
            ->where('tanggal_booking', '>=', now()->toDateString())
            ->where('status_booking', '!=', 'completed')
            ->exists();
    }

    /**
     * Check if specific date and time slot is available for booking
     * 
     * @param string $date Date in Y-m-d format
     * @param string $startTime Time in H:i format
     * @param int $duration Duration in hours
     * @return bool
     */
    public function isTimeSlotAvailable($date, $startTime, $duration)
    {
        try {
            if ($this->status === 'maintenance') {
                return false;
            }

            $requestedStart = \Carbon\Carbon::parse($date . ' ' . $startTime);
            $requestedEnd = $requestedStart->copy()->addHours((int)$duration);

            // FIX: Convert date to Carbon untuk handling timezone
            $dateCarbon = \Carbon\Carbon::parse($date)->startOfDay();

            $conflictingBookings = $this->transaksis()
                ->select('id', 'jam_mulai', 'durasi', 'tanggal_booking')
                ->whereIn('status_pembayaran', ['paid', 'pending'])
                ->whereDate('tanggal_booking', $dateCarbon) // Gunakan whereDate
                ->where('status_booking', 'confirmed')
                ->get();


            foreach ($conflictingBookings as $booking) {
                try {
                    // FIX: Ambil hanya tanggal dari tanggal_booking
                    $bookingDate = \Carbon\Carbon::parse($booking->tanggal_booking)->format('Y-m-d');

                    // Parse jam_mulai (format TIME saja: 08:00:00)
                    $bookingStart = \Carbon\Carbon::parse($bookingDate . ' ' . $booking->jam_mulai);
                    $bookingEnd = $bookingStart->copy()->addHours((int)$booking->durasi);



                    if ($this->timeSlotsOverlap($requestedStart, $requestedEnd, $bookingStart, $bookingEnd)) {
                        return false;
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            return true;
        } catch (\Exception $e) {
            Log::error("Error checking time slot availability", ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Check if two time slots overlap
     * 
     * @param \Carbon\Carbon $start1
     * @param \Carbon\Carbon $end1
     * @param \Carbon\Carbon $start2
     * @param \Carbon\Carbon $end2
     * @return bool
     */
    public function timeSlotsOverlap($start1, $end1, $start2, $end2)
    {
        // Test case untuk debugging: 21:00-22:00 vs 21:00-22:00 harus overlap
        $overlaps = ($start1->lt($end2) && $end1->gt($start2));
        // Untuk slot yang sama persis, pasti overlap
        if ($start1->eq($start2) && $end1->eq($end2)) {
            $overlaps = true;
        }

        return $overlaps;
    }

    /**
     * Get all booked time slots for a specific date
     * 
     * @param string $date Date in Y-m-d format
     * @return array Array of booked time slots
     */
    public function getBookedTimeSlotsForDate($date)
    {
        $bookedSlots = [];

        try {
            $bookings = $this->transaksis()
                ->select('id', 'jam_mulai', 'durasi', 'tanggal_booking')
                ->whereIn('status_pembayaran', ['paid', 'pending']) // Include pending payments
                ->where('tanggal_booking', $date)
                ->where('status_booking', 'confirmed') // Exclude only completed/cancelled/failed
                ->get();

            foreach ($bookings as $booking) {
                try {
                    // Handle different time formats in jam_mulai
                    $jamMulai = $booking->jam_mulai;

                    // If jam_mulai is already in H:i format
                    if (preg_match('/^\d{2}:\d{2}$/', $jamMulai)) {
                        $startTime = \Carbon\Carbon::parse($date . ' ' . $jamMulai);
                    } else {
                        // Try to parse as datetime or other format
                        $startTime = \Carbon\Carbon::parse($jamMulai);
                        // If it's just time, combine with date
                        if ($startTime->format('Y-m-d') === '1970-01-01') {
                            $startTime = \Carbon\Carbon::parse($date . ' ' . $startTime->format('H:i:s'));
                        }
                    }

                    $endTime = $startTime->copy()->addHours((int)$booking->durasi);

                    $bookedSlots[] = [
                        'start' => $startTime->format('H:i'),
                        'end' => $endTime->format('H:i'),
                        'duration' => $booking->durasi,
                        'booking_id' => $booking->id
                    ];
                } catch (\Exception $e) {
                    // Skip this booking if we can't parse it
                    continue;
                }
            }
        } catch (\Exception $e) {
            // Return empty array on error
        }

        return $bookedSlots;
    }

    /**
     * Get available time slots for a specific date
     * 
     * @param string $date Date in Y-m-d format
     * @param int $duration Requested duration in hours
     * @return array Array of available time slots
     */
    public function getAvailableTimeSlotsForDate($date, $duration = 1)
    {
        // Operating hours (can be made configurable)
        $openingHour = 8;  // 08:00
        $closingHour = 22; // 22:00

        $availableSlots = [];

        // Generate all possible time slots
        for ($hour = $openingHour; $hour <= ($closingHour - $duration); $hour++) {
            $timeSlot = sprintf('%02d:00', $hour);

            if ($this->isTimeSlotAvailable($date, $timeSlot, $duration)) {
                $availableSlots[] = [
                    'time' => $timeSlot,
                    'display' => $timeSlot . ' - ' . sprintf('%02d:00', $hour + $duration),
                    'available' => true
                ];
            } else {
                $availableSlots[] = [
                    'time' => $timeSlot,
                    'display' => $timeSlot . ' - ' . sprintf('%02d:00', $hour + $duration),
                    'available' => false
                ];
            }
        }

        return $availableSlots;
    }

    /**
     * Get current booking status for display
     * This now shows general availability, not specific time-based booking
     */
    public function getBookingStatusAttribute()
    {
        if ($this->status === 'reserved' || $this->status === 'maintenance') {
            return $this->status;
        }

        // Check if table has any bookings today
        $hasBookingsToday = $this->transaksis()
            ->where('status_pembayaran', 'paid')
            ->where('tanggal_booking', now()->toDateString())
            ->where('status_booking', '!=', 'completed')
            ->exists();

        return $hasBookingsToday ? 'partially_booked' : 'available';
    }

    /**
     * Get booking status text
     */
    public function getBookingStatusTextAttribute()
    {
        $status = $this->getBookingStatusAttribute();

        return match ($status) {
            'available' => 'Tersedia',
            'partially_booked' => 'Sebagian Terisi',
            'reserved' => 'Direservasi',
            'maintenance' => 'Maintenance',
            default => 'Tersedia'
        };
    }

    /**
     * Get booking status CSS class
     */
    public function getBookingStatusClassAttribute()
    {
        $status = $this->getBookingStatusAttribute();

        return match ($status) {
            'available' => 'meja-available',
            'partially_booked' => 'meja-partial',
            'reserved' => 'meja-reserved',
            'maintenance' => 'meja-maintenance',
            default => 'meja-available'
        };
    }

    /**
     * Get the formatted price from category
     */
    public function getFormattedHargaAttribute()
    {
        $harga = $this->category ? $this->category->harga_per_jam : 0;
        return 'Rp ' . number_format($harga, 0, ',', '.');
    }

    /**
     * Get the price per hour from category
     */
    public function getHargaAttribute()
    {
        return $this->category ? $this->category->harga_per_jam : 0;
    }

    /**
     * Get the status badge class
     */
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'available' => 'status-available',
            'occupied' => 'status-occupied',
            'reserved' => 'status-reserved',
            'maintenance' => 'status-maintenance',
            default => 'status-available'
        };
    }

    /**
     * Get the status text
     */
    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            'available' => 'Tersedia',
            'occupied' => 'Terisi',
            'reserved' => 'Direservasi',
            'maintenance' => 'Maintenance',
            default => 'Tersedia'
        };
    }

    /**
     * Get the foto URL
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/meja/' . $this->foto);
        }
        return asset('img/table.jpeg');
    }
}
