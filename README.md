# Nginap — Hotel Booking Platform (UJIKOM)

Nginap adalah platform pemesanan kamar hotel berbasis web yang dibangun menggunakan framework Laravel 12 dengan arsitektur MVC (Model-View-Controller). Aplikasi ini dirancang untuk memenuhi 8 Unit Persyaratan Uji Kompetensi Keahlian (UJIKOM) dengan desain modern bertema Luxury Dark Emerald & Gold, terintegrasi dengan fitur autentikasi OTP 2FA via email, verifikasi pembayaran QRIS & Tunai, CRUD lengkap (Properti, Reservasi, Tamu, Admin), SweetAlert2 dialogs, serta cetak e-Tiket / Kuitansi PDF resmi.

---

## Fitur Utama Sistem

### 1. Autentikasi 2FA & Keamanan Transaksi
- Administrator Login (2FA OTP Email): Login Admin dilindungi kode OTP 6-digit yang dikirimkan langsung ke email Gmail resmi.
- Registrasi Tamu + Email Verification: Tamu baru wajib memverifikasi kode OTP email sebelum akun dibuat.
- Pessimistic Locking (lockForUpdate): Mencegah double booking atau race condition jika dua tamu memesan kamar yang sama di milidetik yang sama.
- Enkripsi Password (Bcrypt): Meng-hash seluruh password pengguna menggunakan algoritma Bcrypt ($2y$).

### 2. Katalog & Reservasi Kamar
- Katalog & Filter Kamar: Pencarian kamar berdasarkan tipe (Standard, Deluxe, Suite) dan status ketersediaan.
- Pickers Waktu (Carbon): Input tanggal & jam check-in serta jam check-out aktual.
- Perhitungan Denda Late Checkout: Mengalkulasi keterlambatan jam check-out dan denda secara dinamis.

### 3. Pembayaran & Reservasi Offline Resepsionis
- QRIS Code Online: Kode QRIS visual + Simulasi Transfer Bank Instant.
- Reservasi Offline Resepsionis: Resepsionis dapat membelikan tiket untuk tamu walk-in / offline secara langsung di meja resepsionis.
- Verifikasi Lunas Instan: Mengubah status pesanan dari PENDING menjadi CONFIRMED / LUNAS.

### 4. Fitur CRUD Lengkap (Admin Portal)
- CRUD Properti Kamar: Tambah, Lihat, Edit Tipe/Harga, dan Hapus Kamar.
- CRUD Reservasi & Jam Check-out: Edit tanggal/jam check-in, jam check-out aktual, denda late checkout, dan status.
- CRUD Data Tamu: Tambah, Lihat, Edit Biodata, dan Hapus Akun Tamu dari database.
- CRUD Pengelola Administrator: Tambah, Lihat, Edit Biodata, dan Kelola Akun Admin.

### 5. Dashboard Analitis Admin (Chart.js & SweetAlert2)
- Ringkasan Kartu Statistik: Total Booking, Pendapatan Omset (Rupiah utuh), Okupansi Kamar, dan Pembatalan.
- Line Chart: Grafik Tren Pendapatan 7 Hari Terakhir.
- SweetAlert2 Modern Dialogs: Seluruh alert dan konfirmasi hapus/batal menggunakan modal SweetAlert2 teranimasi.

### 6. Cetak e-Tiket & Invoice PDF Resmi
- Halaman cetak e-Voucher kuitansi resmi lengkap dengan Watermark Stamp Dinamis (CONFIRMED / LUNAS, PENDING, CANCELLED).

---

## Arsitektur Sistem (MVC)

Aplikasi dibangun murni menggunakan arsitektur Model-View-Controller:

- Model: User.php, Room.php, Booking.php
- View: Blade templates (resources/views/) dengan Tailwind CSS v4, Alpine.js, SweetAlert2, dan Chart.js
- Controller: AuthController, DashboardController, RoomController, BookingController, UserController

---

## Skema Database (ERD)

[USERS] 1 ----- N [BOOKINGS] N ----- 1 [ROOMS]

- users: id, name, email, password, role (admin/user), identity_number, phone
- rooms: id, room_number, room_type, price, status (available/occupied)
- bookings: id, booking_code, guest_id, room_id, check_in, check_in_time, check_out, check_out_time, total_nights, late_hours, late_fee, total_price, payment_method, status

---

## Panduan Instalasi & Penggunaan

### 1. Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL Database

### 2. Langkah-Langkah Setup

```bash
# 1. Clone repository
git clone https://github.com/<USERNAME>/Sistem-Booking-Hotel.git
cd UJIKOM

# 2. Install dependensi Composer & NPM
composer install
npm install

# 3. Salin file environment
cp .env.example .env

# 4. Generate Application Key
php artisan key:generate

# 5. Konfigurasi .env (Database & SMTP Email Gmail)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_booking_hotel
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

# 7. Jalankan Server Lokal & Vite Bundler
php artisan serve
npm run dev
```

Akses aplikasi di browser: http://127.0.0.1:8000

---

## Akun Demo Kredensial (Seeder)

| Role | Email | Password | Alur Login |
|---|---|---|---|
| Administrator | admin@gmail.com | password123 | Email + Password + OTP 2FA Email |
| Tamu | tamu@gmail.com | password123 | Email + Password (Langsung) |

---

## Library & Dependencies

- Backend Framework: laravel/framework ^12.0
- Date/Time Engine: nesbot/carbon
- Asset Bundler: vite & laravel-vite-plugin
- Styling UI: Tailwind CSS v4
- Modern Alerting: SweetAlert2 v11 (CDN)
- UI Micro-framework: Alpine.js v3 (CDN)
- Analytics Charts: Chart.js (CDN)
- Icons: Font Awesome v6 (CDN)

---

## Lisensi

Dikembangkan untuk keperluan Tugas Akhir / Uji Kompetensi Keahlian (UJIKOM). Open source di bawah lisensi MIT.
