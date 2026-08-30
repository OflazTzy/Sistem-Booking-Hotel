<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

/**
 * Seeder untuk mengisi data awal kamar hotel.
 * Menggunakan array PHP untuk mendefinisikan data kamar.
 */
class RoomSeeder extends Seeder
{
    /**
     * Menjalankan seeder untuk memasukkan data kamar.
     *
     * Menggunakan array asosiatif untuk setiap kamar dan
     * foreach untuk iterasi dan menyimpan data ke database.
     */
    public function run(): void
    {
        // Array berisi data kamar awal hotel
        // Setiap elemen adalah array asosiatif dengan key sesuai kolom tabel
        $rooms = [
            [
                'room_number' => '101',
                'room_type' => 'Standard',
                'price' => 300000,
                'status' => 'available',
            ],
            [
                'room_number' => '102',
                'room_type' => 'Deluxe',
                'price' => 500000,
                'status' => 'available',
            ],
            [
                'room_number' => '103',
                'room_type' => 'Deluxe',
                'price' => 500000,
                'status' => 'available',
            ],
            [
                'room_number' => '201',
                'room_type' => 'Suite',
                'price' => 800000,
                'status' => 'available',
            ],
            [
                'room_number' => '202',
                'room_type' => 'Suite',
                'price' => 800000,
                'status' => 'available',
            ],
        ];

        // Menggunakan foreach untuk iterasi setiap data kamar
        // dan menyimpannya ke database menggunakan Eloquent
        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
