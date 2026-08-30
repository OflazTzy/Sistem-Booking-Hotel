<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Room merepresentasikan data kamar hotel.
 *
 * Properti:
 * - room_number: nomor kamar (string)
 * - room_type: tipe kamar - Standard, Deluxe, Suite (string)
 * - price: harga per malam dalam Rupiah (integer)
 * - status: status kamar - available atau occupied (string)
 */
class Room extends Model
{
    /**
     * Kolom yang boleh diisi secara massal (mass assignment).
     * Menggunakan array untuk mendefinisikan daftar kolom.
     *
     * @var array<string>
     */
    protected $fillable = [
        'room_number',
        'room_type',
        'price',
        'status',
    ];

    /**
     * Relasi: Room memiliki banyak Booking (hasMany).
     * Satu kamar bisa memiliki banyak riwayat booking.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Mengecek apakah kamar tersedia untuk dibooking.
     * Menggunakan kontrol alur if/else secara implisit melalui perbandingan.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
}
