<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'thumbnail',
        'harga_per_jam'
    ];

    protected $casts = [
        'harga_per_jam' => 'decimal:2'
    ];

    /**
     * Get the thumbnail URL
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/categories/' . $this->thumbnail);
        }
        return asset('img/default-category.jpg');
    }

    /**
     * Get formatted harga per jam
     */
    public function getFormattedHargaPerJamAttribute()
    {
        return 'Rp ' . number_format($this->harga_per_jam, 0, ',', '.');
    }

    /**
     * Get all mejas that belong to this category
     */
    public function mejas()
    {
        return $this->hasMany(Meja::class);
    }

    /**
     * Check if category can be deleted (not used by any meja)
     */
    public function canBeDeleted()
    {
        return $this->mejas()->count() === 0;
    }

    /**
     * Get category price via AJAX
     */
    public static function getCategoryPrice($categoryId)
    {
        $category = self::find($categoryId);
        return $category ? $category->harga_per_jam : 0;
    }
}
