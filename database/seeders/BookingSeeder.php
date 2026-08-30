<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $guests = User::where('role', 'user')->get();
        $rooms = Room::all();

        if ($guests->isEmpty() || $rooms->isEmpty()) {
            return;
        }

        $sampleBookings = [
            [
                'guest' => $guests->first(),
                'room' => $rooms->where('room_number', '101')->first() ?? $rooms->first(),
                'check_in' => Carbon::now()->subDays(2),
                'check_out' => Carbon::now()->addDays(2),
                'status' => 'active',
                'payment' => 'qris',
            ],
            [
                'guest' => $guests->skip(1)->first() ?? $guests->first(),
                'room' => $rooms->where('room_number', '102')->first() ?? $rooms->first(),
                'check_in' => Carbon::now()->subDays(1),
                'check_out' => Carbon::now()->addDays(3),
                'status' => 'active',
                'payment' => 'cash',
            ],
            [
                'guest' => $guests->skip(2)->first() ?? $guests->first(),
                'room' => $rooms->where('room_number', '103')->first() ?? $rooms->first(),
                'check_in' => Carbon::now()->addDays(1),
                'check_out' => Carbon::now()->addDays(4),
                'status' => 'pending',
                'payment' => 'qris',
            ],
            [
                'guest' => $guests->skip(3)->first() ?? $guests->first(),
                'room' => $rooms->where('room_number', '201')->first() ?? $rooms->first(),
                'check_in' => Carbon::now()->addDays(2),
                'check_out' => Carbon::now()->addDays(5),
                'status' => 'cancelled',
                'payment' => 'cash',
            ],
            [
                'guest' => $guests->first(),
                'room' => $rooms->where('room_number', '202')->first() ?? $rooms->first(),
                'check_in' => Carbon::now()->subDays(5),
                'check_out' => Carbon::now()->subDays(3),
                'status' => 'active',
                'payment' => 'qris',
            ],
        ];

        foreach ($sampleBookings as $data) {
            if (!$data['room']) continue;

            $totalNights = max(1, (int) $data['check_in']->diffInDays($data['check_out']));
            $totalPrice = $totalNights * (int) $data['room']->price;

            Booking::create([
                'guest_id' => $data['guest']->id,
                'room_id' => $data['room']->id,
                'check_in' => $data['check_in']->toDateString(),
                'check_in_time' => '14:00:00',
                'check_out' => $data['check_out']->toDateString(),
                'check_out_time' => '12:00:00',
                'total_nights' => $totalNights,
                'late_hours' => 0,
                'late_fee' => 0,
                'total_price' => $totalPrice,
                'payment_method' => $data['payment'],
                'status' => $data['status'],
            ]);
        }
    }
}
