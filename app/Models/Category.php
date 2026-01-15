<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'thumbnail'
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
}
