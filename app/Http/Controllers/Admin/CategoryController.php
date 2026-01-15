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
            $categories = Category::latest()->paginate(10);
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
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ], [
            'nama.required' => 'Nama kategori harus diisi',
            'nama.unique' => 'Nama kategori sudah ada',
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
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
            ], [
                'nama.required' => 'Nama kategori harus diisi',
                'nama.unique' => 'Nama kategori sudah ada',
                'thumbnail.image' => 'File harus berupa gambar',
                'thumbnail.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp',
                'thumbnail.max' => 'Ukuran gambar maksimal 2MB'
            ]);

            $data = [
                'nama' => $request->nama
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
            // Delete thumbnail file
            if ($kategori->thumbnail && Storage::disk('public')->exists('categories/' . $kategori->thumbnail)) {
                Storage::disk('public')->delete('categories/' . $kategori->thumbnail);
            }

            $kategori->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
