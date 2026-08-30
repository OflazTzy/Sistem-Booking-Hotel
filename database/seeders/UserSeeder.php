<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder untuk akun Admin dan Tamu.
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Hotel
        User::firstOrCreate(
            ['email' => 'admin@hotel.com'],
            [
                'name'            => 'Administrator Hotel',
                'password'        => Hash::make('password'),
                'role'            => 'admin',
                'identity_number' => '3201000000000001',
                'phone'           => '081234567890',
            ]
        );

        // 2. Akun User / Tamu Sample
        $sampleGuests = [
            [
                'name'            => 'Budi Santoso',
                'email'           => 'tamu@hotel.com',
                'identity_number' => '3201234567890001',
                'phone'           => '081987654321',
            ],
            [
                'name'            => 'Siti Rahmawati',
                'email'           => 'siti@gmail.com',
                'identity_number' => '3201234567890002',
                'phone'           => '081298765432',
            ],
            [
                'name'            => 'Aria Kusuma',
                'email'           => 'aria.kusuma@gmail.com',
                'identity_number' => '3201234567890003',
                'phone'           => '081345678901',
            ],
            [
                'name'            => 'Jane Smith',
                'email'           => 'jane.smith@gmail.com',
                'identity_number' => '3201234567890004',
                'phone'           => '081456789012',
            ],
        ];

        foreach ($sampleGuests as $guest) {
            User::firstOrCreate(
                ['email' => $guest['email']],
                [
                    'name'            => $guest['name'],
                    'password'        => Hash::make('password'),
                    'role'            => 'user',
                    'identity_number' => $guest['identity_number'],
                    'phone'           => $guest['phone'],
                ]
            );
        }
    }
}
