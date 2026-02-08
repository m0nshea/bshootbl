<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MejaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $mejas = Meja::with('category')->oldest()->paginate(10);
            return view('adminMeja.meja', compact('mejas'));
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
        $categories = Category::all();
        return view('adminMeja.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_meja' => 'required|string|max:255|unique:mejas,nama_meja',
            'lantai' => 'required|string|max:10',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:available,occupied,reserved,maintenance',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi' => 'nullable|string'
        ], [
            'nama_meja.required' => 'Nama meja harus diisi',
            'nama_meja.unique' => 'Nama meja sudah ada',
            'lantai.required' => 'Lantai harus dipilih',
            'category_id.required' => 'Kategori harus dipilih',
            'category_id.exists' => 'Kategori tidak valid',
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp',
            'foto.max' => 'Ukuran gambar maksimal 2MB'
        ]);

        try {
            $fotoName = null;
            
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $fotoName = time() . '_' . Str::slug($request->nama_meja) . '.' . $file->getClientOriginalExtension();
                
                // Create directory if not exists
                if (!Storage::disk('public')->exists('meja')) {
                    Storage::disk('public')->makeDirectory('meja');
                }
                
                // Store file
                $file->storeAs('meja', $fotoName, 'public');
            }

            Meja::create([
                'nama_meja' => $request->nama_meja,
                'lantai' => $request->lantai,
                'category_id' => $request->category_id,
                'status' => $request->status,
                'foto' => $fotoName,
                'deskripsi' => $request->deskripsi
            ]);

            return redirect()->route('admin.meja.index')
                           ->with('success', 'Meja berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Meja $meja)
    {
        $meja->load('category');
        return view('adminMeja.show', compact('meja'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meja $meja)
    {
        $categories = Category::all();
        return view('adminMeja.edit', compact('meja', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meja $meja)
    {
        try {
            $request->validate([
                'nama_meja' => 'required|string|max:255|unique:mejas,nama_meja,' . $meja->id,
                'lantai' => 'required|string|max:10',
                'category_id' => 'required|exists:categories,id',
                'status' => 'required|in:available,occupied,reserved,maintenance',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'deskripsi' => 'nullable|string'
            ], [
                'nama_meja.required' => 'Nama meja harus diisi',
                'nama_meja.unique' => 'Nama meja sudah ada',
                'lantai.required' => 'Lantai harus dipilih',
                'category_id.required' => 'Kategori harus dipilih',
                'category_id.exists' => 'Kategori tidak valid',
                'status.required' => 'Status harus dipilih',
                'status.in' => 'Status tidak valid',
                'foto.image' => 'File harus berupa gambar',
                'foto.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp',
                'foto.max' => 'Ukuran gambar maksimal 2MB'
            ]);

            $data = [
                'nama_meja' => $request->nama_meja,
                'lantai' => $request->lantai,
                'category_id' => $request->category_id,
                'status' => $request->status,
                'deskripsi' => $request->deskripsi
            ];

            if ($request->hasFile('foto')) {
                // Delete old foto
                if ($meja->foto && Storage::disk('public')->exists('meja/' . $meja->foto)) {
                    Storage::disk('public')->delete('meja/' . $meja->foto);
                }

                // Upload new foto
                $file = $request->file('foto');
                $fotoName = time() . '_' . Str::slug($request->nama_meja) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('meja', $fotoName, 'public');
                
                $data['foto'] = $fotoName;
            }

            $meja->update($data);

            return redirect()->route('admin.meja.index')
                           ->with('success', 'Meja berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meja $meja)
    {
        try {
            // Delete foto file
            if ($meja->foto && Storage::disk('public')->exists('meja/' . $meja->foto)) {
                Storage::disk('public')->delete('meja/' . $meja->foto);
            }

            $meja->delete();

            return response()->json([
                'success' => true,
                'message' => 'Meja berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
