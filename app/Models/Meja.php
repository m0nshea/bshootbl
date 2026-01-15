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
