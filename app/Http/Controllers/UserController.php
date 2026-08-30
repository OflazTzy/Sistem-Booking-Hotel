<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Controller untuk mengelola data Tamu dan Administrator oleh Admin.
 */
class UserController extends Controller
{
    /**
     * Menampilkan daftar seluruh Tamu terdaftar (role = user).
     */
    public function guests()
    {
        $guests = User::where('role', 'user')
            ->withCount('bookings')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.guests.index', compact('guests'));
    }

    /**
     * Menampilkan daftar seluruh Admin (role = admin).
     */
    public function admins()
    {
        $admins = User::where('role', 'admin')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Menampilkan form tambah Admin baru.
     */
    public function createAdmin()
    {
        return view('admin.admins.create');
    }

    /**
     * Menyimpan data Admin baru ke database.
     */
    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'identity_number' => 'nullable|string|max:50',
            'phone'           => 'nullable|string|max:20',
            'password'        => 'required|string|min:6|confirmed',
        ], [
            'name.required'     => 'Nama Admin wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name'            => $validated['name'],
            'email'           => $validated['email'],
            'identity_number' => $validated['identity_number'] ?? '3200000000000000',
            'phone'           => $validated['phone'] ?? '081234567890',
            'password'        => Hash::make($validated['password']),
            'role'            => 'admin', // Role khusus Administrator
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin baru bernama ' . $validated['name'] . ' berhasil ditambahkan!');
    }
}
