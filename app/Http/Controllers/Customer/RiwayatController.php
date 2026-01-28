<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    /**
     * Show customer transaction history
     */
    public function index()
    {
        try {
            // Very simple test first
            return response()->json([
                'message' => 'RiwayatController works!',
                'user_authenticated' => auth()->check(),
                'user_id' => auth()->id()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Show transaction detail
     */
    public function show($id)
    {
        return response()->json(['message' => 'Detail works', 'id' => $id]);
    }
}