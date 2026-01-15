<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories for customers
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('pelangganKategori.kategori', compact('categories'));
    }

    /**
     * Show category details
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('pelangganKategori.detail', compact('category'));
    }
}
