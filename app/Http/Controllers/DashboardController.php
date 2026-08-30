<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Controller untuk mengelola Halaman Home dan Dashboard Pengguna.
 */
class DashboardController extends Controller
{
    /**
     * Menampilkan Halaman Home Publik (Landings page).
     */
    public function home()
    {
        $totalRooms     = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $sampleRooms    = Room::where('status', 'available')->take(3)->get();

        return view('home', compact('totalRooms', 'availableRooms', 'sampleRooms'));
    }

    /**
     * Menampilkan Dashboard khusus setelah login.
     * Mengarahkan ke Dashboard Admin atau Dashboard Tamu.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. DASHBOARD ADMIN
        if ($user->isAdmin()) {
            $totalRooms        = Room::count();
            $availableRooms   = Room::where('status', 'available')->count();
            $occupiedRooms    = Room::where('status', 'occupied')->count();
            $totalBookings     = Booking::count();
            $activeBookings   = Booking::where('status', 'active')->count();
            $cancelledBookings = Booking::where('status', 'cancelled')->count();
            $totalRevenue      = Booking::where('status', 'active')->sum('total_price');

            // Overall occupancy percentage
            $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;

            // Room Occupancy Statistics per Type
            $roomTypes = ['Standard', 'Deluxe', 'Suite'];
            $roomOccupancyStats = [];
            foreach ($roomTypes as $type) {
                $typeTotal = Room::where('room_type', $type)->count();
                $typeOccupied = Room::where('room_type', $type)->where('status', 'occupied')->count();
                $rate = $typeTotal > 0 ? round(($typeOccupied / $typeTotal) * 100) : 0;
                $roomOccupancyStats[$type] = [
                    'total' => $typeTotal,
                    'occupied' => $typeOccupied,
                    'rate' => $rate,
                ];
            }

            // 7 Days Daily Revenue Chart Data
            $chartLabels = [];
            $chartData = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $chartLabels[] = $date->isoFormat('dddd'); // e.g. Senin, Selasa
                $dailyRevenue = Booking::whereDate('created_at', $date->toDateString())
                    ->where('status', 'active')
                    ->sum('total_price');
                // Convert to Millions or keep full value
                $chartData[] = round($dailyRevenue / 1000000, 2);
            }

            // 5 Transaksi booking terbaru untuk panel admin
            $recentBookings = Booking::with(['guest', 'room'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return view('dashboard.admin', compact(
                'totalRooms', 'availableRooms', 'occupiedRooms', 'totalBookings',
                'activeBookings', 'cancelledBookings', 'totalRevenue', 'occupancyRate',
                'roomOccupancyStats', 'chartLabels', 'chartData', 'recentBookings'
            ));
        }

        // 2. DASHBOARD USER / TAMU
        $availableRooms = Room::where('status', 'available')->count();

        $myBookingsCount = Booking::where('guest_id', $user->id)->count();
        $myActiveBookingsCount = Booking::where('guest_id', $user->id)
            ->where('status', 'active')
            ->count();

        // Booking aktif milik tamu tersebut
        $myActiveBookings = Booking::with(['room'])
            ->where('guest_id', $user->id)
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.user', compact(
            'availableRooms', 'myBookingsCount', 'myActiveBookingsCount', 'myActiveBookings'
        ));
    }
}
