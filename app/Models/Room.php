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
     * Mengecek apakah kamar tersedia untuk dibooking (secara umum).
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    /**
     * Mengecek ketersediaan kamar berdasarkan RENTANG TANGGAL (Check-in s/d Check-out).
     *
     * ALUR LOGIKA PENGECEKAN BENTROK/OVERLAP HOTEL:
     * Dua periode booking (A: Booking di Database, B: Booking Baru) dianggap BENTROK jika:
     *   A.check_in < B.check_out  AND  A.check_out > B.check_in
     *
     * ALASAN TANGGAL CHECK-OUT TETAP BISA DIPAKAI UNTUK BOOKING BERIKUTNYA:
     * Misal Booking A: Check-in 1 Sep, Check-out 2 Sep (Tamu A keluar jam 12:00).
     * Booking B baru: Check-in 2 Sep, Check-out 3 Sep (Tamu B masuk jam 14:00).
     * Pengecekan overlap: `1 < 3` (True) AND `2 > 2` (FALSE).
     * Hasil perbandingan `2 > 2` adalah FALSE, sehingga sistem TIDAK menganggapnya bentrok.
     * Oleh karena itu, tanggal 2 Sep tetap dapat digunakan untuk booking berikutnya!
     *
     * @param string|\Illuminate\Support\Carbon|null $checkIn  Tanggal check-in yang diminta
     * @param string|\Illuminate\Support\Carbon|null $checkOut Tanggal check-out yang diminta
     * @param int|null $excludeBookingId ID booking yang diabaikan (untuk proses update booking)
     * @return bool True jika kamar KOSONG/TERSEDIA pada tanggal tersebut, False jika BENTROK
     */
    public function isAvailableForDates($checkIn = null, $checkOut = null, ?int $excludeBookingId = null): bool
    {
        // Jika rentang tanggal tidak diisi pada filter, kamar selalu dianggap TERSEDIA/DAPAT DIPESAN untuk tanggal mendatang
        if (!$checkIn || !$checkOut) {
            return true;
        }

        $checkInStr  = is_string($checkIn) ? $checkIn : $checkIn->toDateString();
        $checkOutStr = is_string($checkOut) ? $checkOut : $checkOut->toDateString();

        // Query pengecekan overlap dengan booking lain yang aktif/pending (bukan cancelled)
        $query = $this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($checkInStr, $checkOutStr) {
                // Formula Overlap Reservasi Hotel:
                // Bentrok terjadi jika booking lama dimulai SEBELUM checkout baru AND berakhir SETELAH checkin baru
                $q->where('check_in', '<', $checkOutStr)
                  ->where('check_out', '>', $checkInStr);
            });

        // Abaikan booking yang sedang di-edit (jika ada)
        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        // Kamar TERSEDIA jika TIDAK ADA booking yang bentrok pada rentang tanggal tersebut
        return !$query->exists();
    }
}
