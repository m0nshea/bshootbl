<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meja extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_meja',
        'lantai',
        'category_id',
        'harga',
        'status',
        'foto',
        'deskripsi'
    ];

    protected $casts = [
        'harga' => 'decimal:2'
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
     * Get current booking status for display
     */
    public function getBookingStatusAttribute()
    {
        if ($this->isBooked() || $this->status === 'reserved') {
            return 'booked';
        }
        
        return $this->status;
    }

    /**
     * Get booking status text
     */
    public function getBookingStatusTextAttribute()
    {
        if ($this->isBooked() || $this->status === 'reserved') {
            return 'Sudah Dibooking';
        }
        
        return $this->status_text;
    }

    /**
     * Get booking status CSS class
     */
    public function getBookingStatusClassAttribute()
    {
        if ($this->isBooked() || $this->status === 'reserved') {
            return 'meja-booked';
        }
        
        return $this->status_badge;
    }

    /**
     * Get the formatted price
     */
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    /**
     * Get the status badge class
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
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
        return match($this->status) {
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
