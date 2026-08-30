<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Guest menginduk pada Model User.
 * Karena Tamu (Guest) adalah User yang mendaftar di sistem.
 */
class Guest extends User
{
    protected $table = 'users';

    /**
     * Relasi: Guest memiliki banyak Booking (hasMany).
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'guest_id');
    }
}
