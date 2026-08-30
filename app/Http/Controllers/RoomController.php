<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

/**
 * Controller untuk mengelola data kamar hotel.
 *
 * Hak Akses:
 * - Admin: Melihat, Menambah, Mengedit, dan Menghapus Kamar (CRUD Penuh)
 * - User/Tamu: Hanya melihat daftar kamar untuk dibooking
 */
class RoomController extends Controller
{
    /**
     * Menampilkan daftar semua kamar.
     */
    public function index()
    {
        $rooms = Room::orderBy('room_number', 'asc')->get();

        $roomTypes = ['Standard', 'Deluxe', 'Suite'];

        return view('rooms.index', compact('rooms', 'roomTypes'));
    }

    /**
     * Menampilkan form tambah kamar baru (Khusus Admin).
     */
    public function create()
    {
        $roomTypes = ['Standard', 'Deluxe', 'Suite'];
        return view('rooms.create', compact('roomTypes'));
    }

    /**
     * Menyimpan kamar baru ke database (Khusus Admin).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|unique:rooms,room_number|max:50',
            'room_type'   => 'required|string|in:Standard,Deluxe,Suite',
            'price'       => 'required|numeric|min:0',
            'status'      => 'required|in:available,occupied',
        ], [
            'room_number.required' => 'Nomor kamar wajib diisi.',
            'room_number.unique'   => 'Nomor kamar sudah ada.',
            'room_type.required'   => 'Tipe kamar wajib dipilih.',
            'price.required'       => 'Harga kamar wajib diisi.',
            'price.numeric'        => 'Harga harus berupa angka.',
            'status.required'      => 'Status kamar wajib dipilih.',
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Kamar baru ' . $validated['room_number'] . ' berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit kamar (Khusus Admin).
     */
    public function edit(Room $room)
    {
        $roomTypes = ['Standard', 'Deluxe', 'Suite'];
        return view('rooms.edit', compact('room', 'roomTypes'));
    }

    /**
     * Meng-update data kamar di database (Khusus Admin).
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:50|unique:rooms,room_number,' . $room->id,
            'room_type'   => 'required|string|in:Standard,Deluxe,Suite',
            'price'       => 'required|numeric|min:0',
            'status'      => 'required|in:available,occupied',
        ], [
            'room_number.required' => 'Nomor kamar wajib diisi.',
            'room_number.unique'   => 'Nomor kamar sudah digunakan kamar lain.',
            'room_type.required'   => 'Tipe kamar wajib dipilih.',
            'price.required'       => 'Harga kamar wajib diisi.',
            'status.required'      => 'Status kamar wajib dipilih.',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Data kamar ' . $room->room_number . ' berhasil diperbarui!');
    }

    /**
     * Menghapus data kamar (Khusus Admin).
     */
    public function destroy(Room $room)
    {
        $roomNumber = $room->room_number;
        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'Kamar ' . $roomNumber . ' berhasil dihapus.');
    }
}
