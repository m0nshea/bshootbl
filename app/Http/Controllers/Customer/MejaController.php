<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use App\Models\Category;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    /**
     * Display a listing of available meja for customers
     */
    public function index()
    {
        $mejas = Meja::with('category')
                    ->where('status', 'available')
                    ->latest()
                    ->get();
        
        return view('pelangganMeja.meja', compact('mejas'));
    }

    /**
     * Show meja details
     */
    public function show($id)
    {
        $meja = Meja::with('category')->findOrFail($id);
        return view('pelangganMeja.detail', compact('meja'));
    }

    /**
     * Show meja by type (for backward compatibility)
     */
    public function showByType($type)
    {
        // Map old type system to new category-based system
        $categoryMap = [
            'a' => 'Pool 8 Ball',
            'b' => 'Pool 9 Ball', 
            'vip' => 'VIP'
        ];

        if (isset($categoryMap[$type])) {
            $category = Category::where('nama', $categoryMap[$type])->first();
            if ($category) {
                $meja = Meja::with('category')
                           ->where('category_id', $category->id)
                           ->where('status', 'available')
                           ->first();
                
                if ($meja) {
                    return view('pelangganMeja.detail', compact('meja'));
                }
            }
        }

        // Fallback to first available meja
        $meja = Meja::with('category')
                   ->where('status', 'available')
                   ->first();
        
        if (!$meja) {
            abort(404, 'Meja tidak ditemukan');
        }

        return view('pelangganMeja.detail', compact('meja'));
    }
}
