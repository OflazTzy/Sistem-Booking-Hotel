# 🏨 Nginap — Hotel Booking Platform (UJIKOM)

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)](https://alpinejs.dev)
[![Chart.js](https://img.shields.io/badge/Chart.js-4.x-FF6384?style=for-the-badge&logo=chart.js&logoColor=white)](https://chartjs.org)

**Nginap** adalah platform pemesanan kamar hotel berbasis web yang dibangun menggunakan framework **Laravel 12** dengan arsitektur **MVC** (Model-View-Controller). Aplikasi ini memiliki desain modern bertema **Warm Earth Tones (Terracotta)** dan terintegrasi dengan fitur autentikasi OTP 2FA via email, verifikasi pembayaran QRIS & Tunai, kalkulasi denda late checkout, serta cetak kuitansi PDF resmi.

---

## ✨ Fitur Utama Sistem

### 🔒 1. Autentikasi & Keamanan Tingkat Tinggi
- **Administrator Login (2FA OTP)**: Login Admin memerlukan verifikasi kode OTP 6-digit yang dikirimkan ke email Gmail resmi.
- **Registrasi Tamu + Email Verification**: Tamu baru wajib memverifikasi kode OTP email sebelum akun dibuat.
- **Pessimistic Locking (`lockForUpdate`)**: Mencegah *double booking* atau *race condition* jika dua tamu memesan kamar yang sama secara bersamaan.
- **Guard Perhitungan Biaya**: Proteksi nilai denda dan total harga agar tidak bisa minus atau bernilai 0.

### 🛋️ 2. Katalog & Pemesanan Kamar
- **Filter & Sorting Kamar**: Cari berdasarkan tipe kamar (*Standard, Deluxe, Suite*) dan pengurutan harga termurah/tertinggi.
- **Pickers Waktu (Carbon)**: Input tanggal & jam check-in (14:00) serta check-out (12:00).
- **Perhitungan Denda Late Checkout**: Otomatis menambahkan denda **Rp 50.000 / jam** apabila checkout melebihi batas jam 12:00 WIB.

### 💳 3. Pembayaran & Verifikasi Instan
- **QRIS Code Online**: Kode QRIS visual + Nomor Virtual Account BCA & Mandiri.
- **Bayar di Tempat (Tunai)**: Pembayaran tunai saat check-in di meja Resepsionis.
- **Verifikasi Lunas Instan**: Mengubah status dari `PENDING` menjadi `PAID / LUNAS`.

### 📊 4. Dashboard Analitis Admin (Chart.js)
- **Ringkasan Kartu Statistik**: Total Kamar, Available, Occupied, dan Pesanan Aktif.
- **Line Chart**: Grafik Tren Pendapatan per Bulan.
- **Doughnut Chart**: Grafik Rasio Okupansi Kamar.
- **Tabel Transaksi Terbaru**: Monitoring 5 pesanan teranyar + aksi cepat.

### 📄 5. Kuitansi Invoice PDF Resmi (DomPDF)
- Halaman cetak kuitansi resmi lengkap dengan **Watermark Stamp Dinamis** (`PAID / LUNAS`, `PENDING / BELUM DIBAYAR`, `CANCELLED`).

---

## 📐 Arsitektur Sistem (MVC)

Aplikasi dibangun murni menggunakan arsitektur **Model-View-Controller**:

- **Model**: `User.php`, `Room.php`, `Booking.php`, `Guest.php`
- **View**: Blade templates (`resources/views/`) dengan Tailwind CSS v3, Alpine.js, dan Chart.js
- **Controller**: `AuthController`, `DashboardController`, `RoomController`, `BookingController`, `UserController`

---

## 🗄️ Skema Database (ERD)

```
[USERS] 1 ----- N [BOOKINGS] N ----- 1 [ROOMS]
```

- **`users`**: `id`, `name`, `email`, `password`, `role` (`admin`/`user`), `identity_number`, `phone`
- **`rooms`**: `id`, `room_number`, `room_type`, `price`, `status` (`available`/`occupied`)
- **`bookings`**: `id`, `guest_id`, `room_id`, `check_in`, `check_in_time`, `check_out`, `check_out_time`, `total_nights`, `late_hours`, `late_fee`, `total_price`, `payment_method`, `status`

---

## 🚀 Panduan Instalasi & Penggunaan

### 1. Prasyarat
- PHP >= 8.2
- Composer
- MySQL Database

### 2. Langkah Langkah Setup

```bash
# 1. Clone repository
git clone https://github.com/<USERNAME>/<REPO_NAME>.git
cd UJIKOM

# 2. Install dependensi Composer
composer install

# 3. Salin file environment
cp .env.example .env

# 4. Generate Application Key
php artisan key:generate

# 5. Konfigurasi .env (Database & SMTP Email)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_booking
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=emailanda@gmail.com
MAIL_PASSWORD=app_password_google
MAIL_ENCRYPTION=tls

# 6. Jalankan Migrasi & Seeder
php artisan migrate:refresh --seed

# 7. Jalankan Server Lokal
php artisan serve
```

Akses aplikasi di browser: **`http://127.0.0.1:8000`**

---

## 🔑 Akun Demo Kredensial

| Role | Email | Password | Alur Login |
|---|---|---|---|
| **Administrator** | `admin@hotel.com` | `password` | Email + Password + OTP 2FA Email |
| **Tamu** | `tamu@hotel.com` | `password` | Email + Password (Langsung) |

---

## 🛠️ Library & Dependencies

- **Framework**: `laravel/framework ^12.0`
- **Date/Time**: `nesbot/carbon`
- **PDF Engine**: `barryvdh/laravel-dompdf` / HTML Print Stream
- **Payment SDK**: `midtrans/midtrans-php ^2.6`
- **Styling**: `Tailwind CSS v3` (CDN)
- **UI Micro-framework**: `Alpine.js v3` (CDN)
- **Charts**: `Chart.js v4` (CDN)
- **Icons**: `Font Awesome v6` (CDN)

---

## 📝 Lisensi

Dikembangkan untuk keperluan **Tugas Akhir / Uji Kompetensi Keahlian (UJIKOM)**. Open source di bawah lisensi MIT.
