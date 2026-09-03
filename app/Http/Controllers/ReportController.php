<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * Controller untuk mengelola Rekapan & Laporan Keuangan Bulanan / Rentang Tanggal Hotel.
 * (Khusus Administrator).
 */
class ReportController extends Controller
{
    /**
     * Daftar nama bulan Indonesia.
     */
    const MONTHS = [
        1  => 'Januari',
        2  => 'Februari',
        3  => 'Maret',
        4  => 'April',
        5  => 'Mei',
        6  => 'Juni',
        7  => 'Juli',
        8  => 'Agustus',
        9  => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    /**
     * Menampilkan halaman Laporan & Rekapan Admin (Support Filter Bulan/Tahun & Filter Rentang Tanggal).
     */
    public function index(Request $request)
    {
        $filterType     = $request->query('filter_type', 'month'); // 'month' atau 'date_range'
        $selectedMonth  = (int) $request->query('month', date('n'));
        $selectedYear   = (int) $request->query('year', date('Y'));
        $startDate      = $request->query('start_date');
        $endDate        = $request->query('end_date');
        $selectedStatus = $request->query('status', 'all');

        $query = Booking::with(['guest', 'room']);

        // Logika Filter: Berdasarkan Rentang Tanggal Spesifik ATAU Berdasarkan Bulan & Tahun
        if ($filterType === 'date_range' && $startDate && $endDate) {
            $query->whereBetween('check_in', [$startDate, $endDate]);
        } else {
            $query->whereYear('check_in', $selectedYear)
                  ->whereMonth('check_in', $selectedMonth);
        }

        if ($selectedStatus && $selectedStatus !== 'all') {
            $query->where('status', $selectedStatus);
        }

        $bookings = $query->orderBy('check_in', 'asc')->get();

        // Statistik Laporan
        $totalBookings  = $bookings->count();
        $paidBookings   = $bookings->whereIn('status', ['active', 'confirmed', 'completed']);
        $totalRevenue   = $paidBookings->sum('total_price');
        $totalNights    = $paidBookings->sum('total_nights');
        $uniqueRooms    = $bookings->pluck('room_id')->unique()->count();
        $avgPerBooking  = $paidBookings->count() > 0 ? (int) ($totalRevenue / $paidBookings->count()) : 0;

        $months = self::MONTHS;
        $years  = range(date('Y') - 2, date('Y') + 2);

        return view('admin.reports.index', compact(
            'bookings',
            'filterType',
            'selectedMonth',
            'selectedYear',
            'startDate',
            'endDate',
            'selectedStatus',
            'totalBookings',
            'totalRevenue',
            'totalNights',
            'uniqueRooms',
            'avgPerBooking',
            'months',
            'years'
        ));
    }

    /**
     * Menampilkan cetak PDF Laporan & Rekapan.
     */
    public function pdf(Request $request)
    {
        $filterType     = $request->query('filter_type', 'month');
        $selectedMonth  = (int) $request->query('month', date('n'));
        $selectedYear   = (int) $request->query('year', date('Y'));
        $startDate      = $request->query('start_date');
        $endDate        = $request->query('end_date');
        $selectedStatus = $request->query('status', 'all');

        $query = Booking::with(['guest', 'room']);

        if ($filterType === 'date_range' && $startDate && $endDate) {
            $query->whereBetween('check_in', [$startDate, $endDate]);
            $periodLabel = Carbon::parse($startDate)->format('d/m/Y') . ' s/d ' . Carbon::parse($endDate)->format('d/m/Y');
        } else {
            $query->whereYear('check_in', $selectedYear)
                  ->whereMonth('check_in', $selectedMonth);
            $monthName   = self::MONTHS[$selectedMonth] ?? 'Semua';
            $periodLabel = $monthName . ' ' . $selectedYear;
        }

        if ($selectedStatus && $selectedStatus !== 'all') {
            $query->where('status', $selectedStatus);
        }

        $bookings = $query->orderBy('check_in', 'asc')->get();

        $totalBookings  = $bookings->count();
        $paidBookings   = $bookings->whereIn('status', ['active', 'confirmed', 'completed']);
        $totalRevenue   = $paidBookings->sum('total_price');
        $totalNights    = $paidBookings->sum('total_nights');

        return view('admin.reports.pdf', compact(
            'bookings',
            'filterType',
            'periodLabel',
            'selectedStatus',
            'totalBookings',
            'totalRevenue',
            'totalNights'
        ));
    }
}
