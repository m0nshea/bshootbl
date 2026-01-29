<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = Category::withCount('mejas')->latest()->paginate(10);
            return view('adminKategori.kategori', compact('categories'));
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('adminKategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama',
            'harga_per_jam' => 'required|numeric|min:0',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ], [
            'nama.required' => 'Nama kategori harus diisi',
            'nama.unique' => 'Nama kategori sudah ada',
            'harga_per_jam.required' => 'Harga per jam harus diisi',
            'harga_per_jam.numeric' => 'Harga per jam harus berupa angka',
            'harga_per_jam.min' => 'Harga per jam tidak boleh kurang dari 0',
            'thumbnail.required' => 'Thumbnail harus dipilih',
            'thumbnail.image' => 'File harus berupa gambar',
            'thumbnail.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp',
            'thumbnail.max' => 'Ukuran gambar maksimal 2MB'
        ]);

        try {
            $thumbnailName = null;
            
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $thumbnailName = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
                
                // Create directory if not exists
                if (!Storage::disk('public')->exists('categories')) {
                    Storage::disk('public')->makeDirectory('categories');
                }
                
                // Store file
                $file->storeAs('categories', $thumbnailName, 'public');
            }

            Category::create([
                'nama' => $request->nama,
                'harga_per_jam' => $request->harga_per_jam,
                'thumbnail' => $thumbnailName
            ]);

            return redirect()->route('admin.kategori.index')
                           ->with('success', 'Kategori berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $kategori)
    {
        return view('adminKategori.show', ['category' => $kategori]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $kategori)
    {
        try {
            return view('adminKategori.edit', ['category' => $kategori]);
        } catch (\Exception $e) {
            return redirect()->route('admin.kategori.index')
                           ->with('error', 'Kategori tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $kategori)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255|unique:categories,nama,' . $kategori->id,
                'harga_per_jam' => 'required|numeric|min:0',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
            ], [
                'nama.required' => 'Nama kategori harus diisi',
                'nama.unique' => 'Nama kategori sudah ada',
                'harga_per_jam.required' => 'Harga per jam harus diisi',
                'harga_per_jam.numeric' => 'Harga per jam harus berupa angka',
                'harga_per_jam.min' => 'Harga per jam tidak boleh kurang dari 0',
                'thumbnail.image' => 'File harus berupa gambar',
                'thumbnail.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp',
                'thumbnail.max' => 'Ukuran gambar maksimal 2MB'
            ]);

            $data = [
                'nama' => $request->nama,
                'harga_per_jam' => $request->harga_per_jam
            ];

            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
                if ($kategori->thumbnail && Storage::disk('public')->exists('categories/' . $kategori->thumbnail)) {
                    Storage::disk('public')->delete('categories/' . $kategori->thumbnail);
                }

                // Upload new thumbnail
                $file = $request->file('thumbnail');
                $thumbnailName = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('categories', $thumbnailName, 'public');
                
                $data['thumbnail'] = $thumbnailName;
            }

            $kategori->update($data);

            return redirect()->route('admin.kategori.index')
                           ->with('success', 'Kategori berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $kategori)
    {
        try {
            // Delete thumbnail file first
            if ($kategori->thumbnail && Storage::disk('public')->exists('categories/' . $kategori->thumbnail)) {
                Storage::disk('public')->delete('categories/' . $kategori->thumbnail);
            }

            // Try to delete the category - database constraint will prevent deletion if referenced
            $kategori->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus!'
            ]);

        } catch (\Illuminate\Database\QueryException $e) {
            // Handle foreign key constraint violation
            if ($e->getCode() === '23000') {
                $mejaCount = $kategori->mejas()->count();
                return response()->json([
                    'success' => false,
                    'message' => "Kategori tidak dapat dihapus karena masih digunakan oleh {$mejaCount} meja. Hapus atau ubah kategori meja tersebut terlebih dahulu."
                ], 422);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan database: ' . $e->getMessage()
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get category price for AJAX requests
     */
    public function getPrice($id)
    {
        try {
            $category = Category::findOrFail($id);
            return response()->json([
                'success' => true,
                'harga_per_jam' => $category->harga_per_jam,
                'formatted_harga' => $category->formatted_harga_per_jam
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }
    }
}
