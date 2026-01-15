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
        'nama_pelanggan',
        'email_pelanggan',
        'no_telepon',
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
        'jam_mulai' => 'datetime:H:i',
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
     * Get status pembayaran badge class
     */
    public function getStatusPembayaranBadgeAttribute()
    {
        return match($this->status_pembayaran) {
            'pending' => 'bg-warning',
            'paid' => 'bg-success',
            'failed' => 'bg-danger',
            'cancelled' => 'bg-secondary',
            default => 'bg-warning'
        };
    }

    /**
     * Get status pembayaran text
     */
    public function getStatusPembayaranTextAttribute()
    {
        return match($this->status_pembayaran) {
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Dibayar',
            'failed' => 'Pembayaran Gagal',
            'cancelled' => 'Dibatalkan',
            'expired' => 'Kadaluarsa',
            default => 'Menunggu Pembayaran'
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
        return Carbon::parse($this->jam_mulai)->format('H:i');
    }

    /**
     * Get formatted jam selesai (calculated from jam_mulai + durasi)
     */
    public function getFormattedJamSelesaiAttribute()
    {
        $jamMulai = Carbon::parse($this->jam_mulai);
        return $jamMulai->addHours($this->durasi)->format('H:i');
    }

    /**
     * Calculate jam selesai based on jam mulai and durasi
     */
    public function calculateJamSelesai()
    {
        $jamMulai = Carbon::parse($this->jam_mulai);
        return $jamMulai->addHours($this->durasi)->format('H:i:s');
    }

    /**
     * Scope for today's transactions
     */
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal_booking', today());
    }

    /**
     * Scope for this month's transactions
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal_booking', now()->month)
                    ->whereYear('tanggal_booking', now()->year);
    }

    /**
     * Scope for paid transactions
     */
    public function scopePaid($query)
    {
        return $query->where('status_pembayaran', 'paid');
    }
}
