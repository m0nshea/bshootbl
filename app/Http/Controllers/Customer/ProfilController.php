<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfilController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {
        $user = Auth::user();
        return view('pelangganProfil.profil', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'no_telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'tanggal_lahir' => ['nullable', 'date'],
            'password_baru' => ['nullable', 'confirmed'], // Removed minimum length requirement
        ]);

        // Update basic info
        $user->name = $validated['nama'];
        $user->email = $validated['email'];
        $user->no_telepon = $validated['no_telepon'];
        $user->alamat = $validated['alamat'];
        
        if (isset($validated['tanggal_lahir'])) {
            $user->tanggal_lahir = $validated['tanggal_lahir'];
        }

        // Update password if provided
        if ($request->filled('password_baru')) {
            $user->password = Hash::make($validated['password_baru']);
        }

        $user->save();

        return redirect()->route('customer.profil')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
