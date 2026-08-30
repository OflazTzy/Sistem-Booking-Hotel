<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Menjalankan semua seeder untuk mengisi data awal database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RoomSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
