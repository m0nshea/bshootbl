<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TarifController extends Controller
{
    /**
     * Display tarif meja page
     */
    public function index()
    {
        try {
            // Get all meja with categories
            $mejas = Meja::with('category')->orderBy('category_id')->orderBy('nama_meja')->get();
            
            // Get categories for filtering
            $categories = Category::all();
            
            // Group meja by category for better display
            $mejaByCategory = $mejas->groupBy('category.nama');
            
            return view('adminTarif.tarif', compact('mejas', 'categories', 'mejaByCategory'));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memuat data tarif: ' . $e->getMessage());
        }
    }

    /**
     * Update multiple tarif at once
     */
    public function updateBulk(Request $request)
    {
        try {
            $request->validate([
                'tarif' => 'required|array',
                'tarif.*' => 'required|numeric|min:0'
            ]);

            DB::beginTransaction();

            foreach ($request->tarif as $mejaId => $harga) {
                $meja = Meja::findOrFail($mejaId);
                $meja->update(['harga' => $harga]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tarif berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui tarif: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update tarif by category
     */
    public function updateByCategory(Request $request)
    {
        try {
            \Log::info('Update category tarif request', [
                'category_id' => $request->category_id,
                'harga' => $request->harga,
                'request_data' => $request->all()
            ]);

            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'harga' => 'required|numeric|min:0'
            ]);

            DB::beginTransaction();

            // Get category name for response
            $category = Category::findOrFail($request->category_id);
            
            // Update all meja in this category
            $updated = Meja::where('category_id', $request->category_id)
                          ->update(['harga' => $request->harga]);

            \Log::info('Updated meja tarif', [
                'category_id' => $request->category_id,
                'category_name' => $category->nama,
                'new_harga' => $request->harga,
                'updated_count' => $updated
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Tarif untuk {$updated} meja dalam kategori {$category->nama} berhasil diperbarui",
                'updated_count' => $updated,
                'category_name' => $category->nama
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            \Log::error('Validation error in updateByCategory', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . implode(', ', $e->errors())
            ], 422);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error in updateByCategory', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui tarif kategori: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get tarif statistics
     */
    public function getStats()
    {
        try {
            $stats = [
                'total_meja' => Meja::count(),
                'total_kategori' => Category::count(),
                'harga_terendah' => Meja::min('harga'),
                'harga_tertinggi' => Meja::max('harga'),
                'rata_rata_harga' => round(Meja::avg('harga'), 0),
                'tarif_by_category' => Category::with(['mejas' => function($query) {
                    $query->select('category_id', DB::raw('AVG(harga) as avg_harga'), DB::raw('COUNT(*) as total_meja'));
                }])->get()->map(function($category) {
                    return [
                        'nama' => $category->nama,
                        'total_meja' => $category->mejas->count(),
                        'rata_rata_harga' => $category->mejas->avg('harga')
                    ];
                })
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal memuat statistik: ' . $e->getMessage()
            ], 500);
        }
    }
}