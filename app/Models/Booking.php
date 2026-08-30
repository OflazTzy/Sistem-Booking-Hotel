<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Booking merepresentasikan data pemesanan kamar hotel.
 */
class Booking extends Model
{
    /**
     * Kolom yang boleh diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'guest_id',
        'room_id',
        'check_in',
        'check_in_time',
        'check_out',
        'check_out_time',
        'total_nights',
        'late_hours',
        'late_fee',
        'total_price',
        'payment_method',
        'status',
    ];

    /**
     * Cast atribut ke tipe data tertentu.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
        ];
    }

    /**
     * Relasi: Booking dimiliki oleh satu Guest (belongsTo).
     * guest_id merujuk ke users.id.
     */
    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    }

    /**
     * Relasi: Booking dimiliki oleh satu Room (belongsTo).
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Accessor untuk mendapatkan kode booking (BK001, BK002, dst).
     *
     * @return string
     */
    public function getBookingCodeAttribute(): string
    {
        return 'BK' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }
}
