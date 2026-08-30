<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Booking Hotel
|--------------------------------------------------------------------------
*/

// =============================================
// RUTE PUBLIK (Dapat diakses siapa saja)
// =============================================
Route::get('/', [DashboardController::class, 'home'])->name('home');
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->where('room', '[0-9]+')->name('rooms.show');

// Rute Autentikasi (Belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/login/otp/verify', [AuthController::class, 'verifyOtp'])->name('otp.verify');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/register/verify-otp', [AuthController::class, 'verifyRegisterOtp'])->name('register.otp.verify');
});

// =============================================
// RUTE TERPROTEKSI (Harus Login)
// =============================================
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Pengguna (Disesuaikan otomatis untuk Admin / Tamu)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pengaturan Profil User / Admin
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.show');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // Transaksi Pemesanan Kamar (Guest & Common)
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{room}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/verify-payment', [BookingController::class, 'verifyPayment'])->name('bookings.verify.payment');
    Route::get('/bookings/{booking}/pdf', [BookingController::class, 'pdf'])->name('bookings.pdf');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // =============================================
    // RUTE KHUSUS ADMIN (CRUD Kamar, Booking Offline, & Tamu)
    // =============================================
    Route::middleware('admin')->group(function () {
        // Room Management
        Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
        Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
        Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
        Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
        Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

        // Reservasi Offline Resepsionis (Belikan Tiket Tamu Offline)
        Route::get('/admin/bookings/create', [BookingController::class, 'createOfflineBooking'])->name('admin.bookings.create');
        Route::post('/admin/bookings', [BookingController::class, 'storeOfflineBooking'])->name('admin.bookings.store');

        // Admin Management & Guests List (Tambah & Kelola Tamu)
        Route::get('/admin/guests', [UserController::class, 'guests'])->name('admin.guests.index');
        Route::get('/admin/guests/create', [UserController::class, 'createGuest'])->name('admin.guests.create');
        Route::post('/admin/guests', [UserController::class, 'storeGuest'])->name('admin.guests.store');
        
        Route::get('/admin/admins', [UserController::class, 'admins'])->name('admin.admins.index');
        Route::get('/admin/admins/create', [UserController::class, 'createAdmin'])->name('admin.admins.create');
        Route::post('/admin/admins', [UserController::class, 'storeAdmin'])->name('admin.admins.store');
    });

});
