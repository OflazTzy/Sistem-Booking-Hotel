<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    /**
     * Menampilkan halaman profil pengguna (Tamu & Admin).
     */
    public function profile()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Memperbarui profil pengguna.
     */
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $user->id,
            'phone'           => 'nullable|string|max:20',
            'identity_number' => 'nullable|string|max:50',
            'password'        => 'nullable|string|min:6|confirmed',
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email tersebut sudah digunakan akun lain.',
            'password.min'   => 'Password baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $dataToUpdate = [
            'name'            => $validated['name'],
            'email'           => $validated['email'],
            'phone'           => $validated['phone'],
            'identity_number' => $validated['identity_number'],
        ];

        if (!empty($validated['password'])) {
            $dataToUpdate['password'] = Hash::make($validated['password']);
        }

        $user->update($dataToUpdate);

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }

    /**
     * Menampilkan form tambah Tamu Baru (Khusus Admin).
     */
    public function createGuest()
    {
        return view('admin.guests.create');
    }

    /**
     * Menyimpan data Tamu Baru ke database.
     */
    public function storeGuest(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'identity_number' => 'required|string|max:50',
            'phone'           => 'required|string|max:20',
            'password'        => 'required|string|min:6|confirmed',
        ], [
            'name.required'            => 'Nama tamu wajib diisi.',
            'email.required'           => 'Email wajib diisi.',
            'email.unique'             => 'Email sudah terdaftar.',
            'identity_number.required' => 'Nomor KTP/SIM wajib diisi.',
            'phone.required'           => 'Nomor telepon/WA wajib diisi.',
            'password.required'        => 'Password wajib diisi.',
            'password.min'             => 'Password minimal 6 karakter.',
            'password.confirmed'       => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name'            => $validated['name'],
            'email'           => $validated['email'],
            'identity_number' => $validated['identity_number'],
            'phone'           => $validated['phone'],
            'password'        => Hash::make($validated['password']),
            'role'            => 'user', // Role Tamu
        ]);

        return redirect()->route('admin.guests.index')
            ->with('success', 'Tamu baru bernama ' . $validated['name'] . ' berhasil ditambahkan!');
    }
}
