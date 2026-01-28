<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'meja_id',
        'jenis_ball',
        'tanggal_booking',
        'jam_mulai',
        'durasi',
        'harga_per_jam',
        'total_harga',
        'status_pembayaran',
        'status_booking',
        'metode_pembayaran',
        'catatan',
        'waktu_checkin',
        'waktu_checkout',
        // Midtrans fields
        'snap_token',
        'midtrans_order_id',
        'payment_type',
        'payment_expires_at',
        'paid_at'
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
        'jam_mulai' => 'string',
        'harga_per_jam' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'waktu_checkin' => 'datetime',
        'waktu_checkout' => 'datetime',
        'payment_expires_at' => 'datetime',
        'paid_at' => 'datetime'
    ];

    /**
     * Generate unique transaction code
     */
    public static function generateKodeTransaksi()
    {
        $prefix = 'TRX';
        $date = date('Ymd');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        
        do {
            $kode = $prefix . $date . $random;
            $exists = self::where('kode_transaksi', $kode)->exists();
            if ($exists) {
                $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            }
        } while ($exists);
        
        return $kode;
    }

    /**
     * Get the user that owns the transaction
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the meja for this transaction
     */
    public function meja()
    {
        return $this->belongsTo(Meja::class);
    }

    /**
     * Get formatted total harga
     */
    public function getFormattedTotalHargaAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    /**
     * Get formatted harga per jam
     */
    public function getFormattedHargaPerJamAttribute()
    {
        return 'Rp ' . number_format($this->harga_per_jam, 0, ',', '.');
    }

    /**
     * Scope untuk transaksi yang sudah dibayar
     */
    public function scopePaid($query)
    {
        return $query->where('status_pembayaran', 'paid');
    }

    /**
     * Scope untuk transaksi pending
     */
    public function scopePending($query)
    {
        return $query->where('status_pembayaran', 'pending');
    }

    /**
     * Scope untuk transaksi hari ini
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope untuk transaksi bulan ini
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    /**
     * Scope untuk transaksi yang gagal/dibatalkan
     */
    public function scopeFailed($query)
    {
        return $query->whereIn('status_pembayaran', ['failed', 'cancelled']);
    }

    /**
     * Get status pembayaran badge class
     */
    public function getStatusPembayaranBadgeAttribute()
    {
        return match($this->status_pembayaran) {
            'paid' => 'badge-success',
            'pending' => 'badge-warning',
            'failed' => 'badge-danger',
            'cancelled' => 'badge-secondary',
            'expired' => 'badge-dark',
            default => 'badge-secondary'
        };
    }

    /**
     * Get status pembayaran text
     */
    public function getStatusPembayaranTextAttribute()
    {
        return match($this->status_pembayaran) {
            'paid' => 'Dibayar',
            'pending' => 'Menunggu Pembayaran',
            'failed' => 'Gagal',
            'cancelled' => 'Dibatalkan',
            'expired' => 'Kedaluwarsa',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get status booking badge class
     */
    public function getStatusBookingBadgeAttribute()
    {
        return match($this->status_booking) {
            'confirmed' => 'bg-info',
            'ongoing' => 'bg-primary',
            'completed' => 'bg-success',
            'cancelled' => 'bg-secondary',
            default => 'bg-info'
        };
    }

    /**
     * Get status booking text
     */
    public function getStatusBookingTextAttribute()
    {
        return match($this->status_booking) {
            'confirmed' => 'Dikonfirmasi',
            'ongoing' => 'Sedang Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => 'Dikonfirmasi'
        };
    }

    /**
     * Get formatted tanggal booking
     */
    public function getFormattedTanggalBookingAttribute()
    {
        return $this->tanggal_booking->format('d/m/Y');
    }

    /**
     * Get formatted jam mulai
     */
    public function getFormattedJamMulaiAttribute()
    {
        // Handle different time formats
        if (strlen($this->jam_mulai) === 5 && strpos($this->jam_mulai, ':') !== false) {
            // Already in HH:MM format
            return $this->jam_mulai;
        }
        
        try {
            return Carbon::parse($this->jam_mulai)->format('H:i');
        } catch (\Exception $e) {
            // Fallback: assume it's already formatted
            return $this->jam_mulai;
        }
    }

    /**
     * Get formatted jam selesai (calculated from jam_mulai + durasi)
     */
    public function getFormattedJamSelesaiAttribute()
    {
        try {
            $jamMulai = Carbon::parse($this->jam_mulai);
            return $jamMulai->addHours((int)$this->durasi)->format('H:i');
        } catch (\Exception $e) {
            // Fallback calculation
            if (strlen($this->jam_mulai) === 5) {
                $hour = (int) substr($this->jam_mulai, 0, 2);
                $endHour = $hour + (int)$this->durasi;
                return sprintf('%02d:00', $endHour);
            }
            return $this->jam_mulai;
        }
    }

    /**
     * Get jenis ball text
     */
    public function getJenisBallTextAttribute()
    {
        return match($this->jenis_ball) {
            '8_ball' => '8 Ball',
            '9_ball' => '9 Ball',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Calculate jam selesai based on jam mulai and durasi
     */
    public function calculateJamSelesai()
    {
        $jamMulai = Carbon::parse($this->jam_mulai);
        return $jamMulai->addHours((int)$this->durasi)->format('H:i:s');
    }
}
