<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Controller untuk mengelola booking hotel dan alur verifikasi pembayaran QRIS & Tunai.
 *
 * Fitur keamanan:
 * - Database Transaction + Pessimistic Locking (lockForUpdate) untuk mencegah race condition / double booking.
 * - Validasi minimum 1 malam menginap.
 * - Guard terhadap nilai negatif pada perhitungan denda.
 * - Proteksi duplikasi verifikasi pembayaran.
 */
class BookingController extends Controller
{
    /**
     * Tarif denda keterlambatan check-out per jam (Rp).
     */
    private const LATE_FEE_PER_HOUR = 50000;

    /**
     * Batas standar jam check-out hotel (24-hour format).
     */
    private const STANDARD_CHECKOUT_TIME = '12:00';

    /**
     * Menampilkan daftar booking.
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $bookings = Booking::with(['guest', 'room'])
                ->orderBy('created_at', 'desc')
                ->get();
            return view('bookings.index', compact('bookings'));
        } else {
            $bookings = Booking::with(['guest', 'room'])
                ->where('guest_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();

            $myBookingsCount = $bookings->count();
            $myActiveBookings = $bookings->where('status', 'active');
            $myActiveBookingsCount = $myActiveBookings->count();

            return view('bookings.index', compact('bookings', 'myBookingsCount', 'myActiveBookingsCount', 'myActiveBookings'));
        }
    }

    /**
     * Menampilkan form booking kamar.
     */
    public function create(Room $room)
    {
        if (!$room->isAvailable()) {
            return redirect()->route('rooms.index')
                ->with('error', 'Kamar ' . $room->room_number . ' tidak tersedia untuk dibooking.');
        }

        return view('bookings.create', compact('room'));
    }

    /**
     * Memproses dan menyimpan transaksi booking.
     *
     * Menggunakan DB::transaction + lockForUpdate() untuk mencegah
     * race condition ketika dua user mencoba booking kamar yang sama
     * di waktu bersamaan (double booking prevention).
     */
    public function store(Request $request)
    {
        // 1. Validasi input form
        $validated = $request->validate([
            'room_id'         => 'required|exists:rooms,id',
            'name'            => 'required|string|max:255',
            'identity_number' => 'required|string|max:50',
            'phone'           => 'required|string|max:20',
            'check_in'        => 'required|date|after_or_equal:today',
            'check_in_time'   => 'required',
            'check_out'       => 'required|date|after:check_in',
            'check_out_time'  => 'required',
            'payment_method'  => 'required|in:qris,cash',
        ], [
            'name.required'            => 'Nama tamu wajib diisi.',
            'identity_number.required' => 'Nomor identitas wajib diisi.',
            'phone.required'           => 'Nomor HP wajib diisi.',
            'check_in.required'        => 'Tanggal check-in wajib diisi.',
            'check_in_time.required'   => 'Jam check-in wajib diisi.',
            'check_in.after_or_equal'  => 'Tanggal check-in tidak boleh sebelum hari ini.',
            'check_out.required'       => 'Tanggal check-out wajib diisi.',
            'check_out_time.required'  => 'Jam check-out wajib diisi.',
            'check_out.after'          => 'Tanggal check-out harus setelah tanggal check-in.',
            'payment_method.required'  => 'Pilih metode pembayaran.',
        ]);

        // 2. Eksekusi dalam Database Transaction dengan Pessimistic Locking
        //    untuk mencegah race condition (double booking pada kamar yang sama)
        try {
            $booking = DB::transaction(function () use ($validated) {

                // 2a. Lock baris kamar agar user lain tidak bisa membaca/menulis
                //     sampai transaksi ini selesai (Pessimistic Locking)
                $room = Room::where('id', $validated['room_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                // 2b. Cek ulang ketersediaan kamar SETELAH lock diperoleh
                //     (mencegah race condition: dua request lolos cek awal bersamaan)
                if (!$room->isAvailable()) {
                    throw new \Exception('ROOM_NOT_AVAILABLE');
                }

                // 2c. Update profil tamu
                $user = Auth::user();
                $user->update([
                    'name'            => $validated['name'],
                    'identity_number' => $validated['identity_number'],
                    'phone'           => $validated['phone'],
                ]);

                // 2d. Hitung durasi malam menginap (Carbon) dengan guard minimum 1 malam
                $totalNights = $this->calculateNights($validated['check_in'], $validated['check_out']);
                if ($totalNights < 1) {
                    $totalNights = 1; // Guard: minimal 1 malam
                }

                $roomSubtotal = $totalNights * $room->price;

                // 2e. Hitung Jam Keterlambatan Check-out & Denda
                $lateHours = 0;
                $lateFee = 0;
                $standardCheckoutTime = Carbon::parse(self::STANDARD_CHECKOUT_TIME);
                $userCheckoutTime = Carbon::parse($validated['check_out_time']);

                if ($userCheckoutTime->greaterThan($standardCheckoutTime)) {
                    $diffMinutes = $standardCheckoutTime->diffInMinutes($userCheckoutTime);
                    $lateHours = (int) ceil($diffMinutes / 60);

                    // Guard: pastikan lateHours tidak negatif
                    $lateHours = max(0, $lateHours);
                    $lateFee = $lateHours * self::LATE_FEE_PER_HOUR;
                }

                // 2f. Hitung total harga (guard: tidak boleh negatif)
                $totalPrice = max(0, $roomSubtotal + $lateFee);

                // 2g. Simpan transaksi booking
                $booking = Booking::create([
                    'guest_id'       => $user->id,
                    'room_id'        => $room->id,
                    'check_in'       => $validated['check_in'],
                    'check_in_time'  => $validated['check_in_time'],
                    'check_out'      => $validated['check_out'],
                    'check_out_time' => $validated['check_out_time'],
                    'total_nights'   => $totalNights,
                    'late_hours'     => $lateHours,
                    'late_fee'       => $lateFee,
                    'total_price'    => $totalPrice,
                    'payment_method' => $validated['payment_method'],
                    'status'         => 'pending',
                ]);

                // 2h. Update status kamar menjadi occupied (di dalam transaksi)
                $room->update(['status' => 'occupied']);

                return $booking;
            });

        } catch (\Exception $e) {
            // Jika kamar sudah tidak tersedia (race condition terdeteksi)
            if ($e->getMessage() === 'ROOM_NOT_AVAILABLE') {
                return redirect()->route('rooms.index')
                    ->with('error', 'Maaf, kamar ini baru saja dipesan oleh tamu lain. Silakan pilih kamar lain yang tersedia.');
            }
            // Error lainnya
            return redirect()->route('rooms.index')
                ->with('error', 'Terjadi kesalahan saat memproses booking. Silakan coba lagi.');
        }

        // 3. Tulis log transaksi ke file (di luar transaksi DB)
        $logMessage = 'Booking dibuat (' . strtoupper($validated['payment_method']) . ') - '
            . $booking->booking_code
            . ' - Check-out Jam: ' . $validated['check_out_time']
            . ' (Keterlambatan: ' . $booking->late_hours . ' jam, Denda: Rp ' . number_format($booking->late_fee) . ')';
        $this->writeLog($logMessage);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking berhasil dibuat! Kode: ' . $booking->booking_code . '. Silakan lakukan verifikasi pembayaran.');
    }

    /**
     * Menampilkan detail booking.
     */
    public function show(Booking $booking)
    {
        $booking->load(['guest', 'room']);

        if (Auth::user()->isUser() && $booking->guest_id !== Auth::id()) {
            return redirect()->route('bookings.index')
                ->with('error', 'Anda tidak memiliki akses ke booking ini.');
        }

        return view('bookings.show', compact('booking'));
    }

    /**
     * Memproses Verifikasi Pembayaran Lunas.
     *
     * Proteksi:
     * - Tidak bisa verifikasi jika status sudah 'active' (sudah lunas).
     * - Tidak bisa verifikasi jika status sudah 'cancelled'.
     */
    public function verifyPayment(Booking $booking)
    {
        $booking->load(['guest', 'room']);

        // Proteksi akses: tamu hanya bisa verifikasi booking miliknya
        if (Auth::user()->isUser() && $booking->guest_id !== Auth::id()) {
            return redirect()->route('bookings.index')
                ->with('error', 'Akses ditolak.');
        }

        // Guard: cegah verifikasi ganda (sudah lunas)
        if ($booking->status === 'active') {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Booking ' . $booking->booking_code . ' sudah berstatus LUNAS. Tidak perlu verifikasi ulang.');
        }

        // Guard: cegah verifikasi booking yang sudah dibatalkan
        if ($booking->status === 'cancelled') {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Booking ' . $booking->booking_code . ' sudah dibatalkan. Tidak dapat diverifikasi.');
        }

        $booking->update(['status' => 'active']);

        $logMessage = 'Pembayaran LUNAS Diverifikasi (' . strtoupper($booking->payment_method) . ') - '
            . $booking->booking_code . ' - ' . $booking->guest->name;
        $this->writeLog($logMessage);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Verifikasi Pembayaran Berhasil! Status Booking ' . $booking->booking_code . ' kini LUNAS (PAID)!');
    }

    /**
     * Menampilkan / Mengunduh Kuitansi Invoice PDF (DomPDF Stream).
     */
    public function pdf(Booking $booking)
    {
        $booking->load(['guest', 'room']);

        if (Auth::user()->isUser() && $booking->guest_id !== Auth::id()) {
            return redirect()->route('bookings.index')
                ->with('error', 'Akses ditolak.');
        }

        return view('bookings.pdf', compact('booking'));
    }

    /**
     * Membatalkan booking.
     *
     * Proteksi:
     * - Tidak bisa membatalkan booking yang sudah berstatus 'cancelled'.
     * - Booking aktif (LUNAS) hanya bisa dibatalkan oleh Admin.
     * - Kamar otomatis dikembalikan ke status 'available'.
     */
    public function cancel(Booking $booking)
    {
        $booking->load(['guest', 'room']);

        // Proteksi akses
        if (Auth::user()->isUser() && $booking->guest_id !== Auth::id()) {
            return redirect()->route('bookings.index')
                ->with('error', 'Anda tidak memiliki akses untuk membatalkan booking ini.');
        }

        // Guard: sudah dibatalkan sebelumnya
        if ($booking->status === 'cancelled') {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Booking ini sudah dibatalkan sebelumnya.');
        }

        // Guard: booking LUNAS hanya bisa dibatalkan oleh Admin
        if ($booking->status === 'active' && Auth::user()->isUser()) {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Booking yang sudah LUNAS tidak dapat dibatalkan oleh tamu. Silakan hubungi Administrator Hotel.');
        }

        // Eksekusi pembatalan dalam Database Transaction
        DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'cancelled']);
            $booking->room->update(['status' => 'available']);
        });

        $logMessage = 'Booking dibatalkan - ' . $booking->booking_code . ' - ' . $booking->guest->name
            . ' - Oleh: ' . Auth::user()->name . ' (' . Auth::user()->role . ')';
        $this->writeLog($logMessage);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking ' . $booking->booking_code . ' berhasil dibatalkan. Kamar kembali tersedia.');
    }

    // =========================================================================
    // HELPER METHODS (Private)
    // =========================================================================

    /**
     * Menghitung jumlah malam menginap menggunakan Carbon diffInDays.
     * Dijamin mengembalikan nilai minimal 1.
     *
     * @param string $checkIn  Tanggal check-in (Y-m-d)
     * @param string $checkOut Tanggal check-out (Y-m-d)
     * @return int Jumlah malam (minimal 1)
     */
    private function calculateNights(string $checkIn, string $checkOut): int
    {
        $nights = Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut));
        return max(1, (int) $nights); // Guard: minimal 1 malam
    }

    /**
     * Menulis log transaksi ke file storage/app/booking_logs.txt.
     *
     * @param string $message Pesan log
     */
    private function writeLog(string $message): void
    {
        $timestamp = Carbon::now()->format('Y-m-d H:i:s');
        $logEntry = '[' . $timestamp . '] ' . $message;
        Storage::append('booking_logs.txt', $logEntry);
    }
}
