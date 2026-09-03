-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Agu 2026 pada 08.33
-- Versi server: 10.4.32-MariaDB-log
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_booking`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guest_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `check_in` date NOT NULL,
  `check_in_time` time NOT NULL DEFAULT '14:00:00',
  `check_out` date NOT NULL,
  `check_out_time` time NOT NULL DEFAULT '12:00:00',
  `total_nights` int(11) NOT NULL,
  `late_hours` int(11) NOT NULL DEFAULT 0,
  `late_fee` int(11) NOT NULL DEFAULT 0,
  `total_price` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'qris',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`id`, `guest_id`, `room_id`, `check_in`, `check_in_time`, `check_out`, `check_out_time`, `total_nights`, `late_hours`, `late_fee`, `total_price`, `payment_method`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2026-08-27', '14:00:00', '2026-08-31', '12:00:00', 4, 0, 0, 1200000, 'qris', 'active', '2026-08-29 10:04:03', '2026-08-29 10:04:03'),
(2, 4, 2, '2026-08-28', '14:00:00', '2026-09-01', '12:00:00', 4, 0, 0, 2000000, 'cash', 'active', '2026-08-29 10:04:03', '2026-08-29 10:04:03'),
(3, 5, 3, '2026-08-30', '14:00:00', '2026-09-02', '12:00:00', 3, 0, 0, 1500000, 'qris', 'active', '2026-08-29 10:04:03', '2026-08-30 04:57:37'),
(4, 6, 4, '2026-08-31', '14:00:00', '2026-09-03', '12:00:00', 3, 0, 0, 2400000, 'cash', 'cancelled', '2026-08-29 10:04:03', '2026-08-29 10:04:03'),
(5, 2, 5, '2026-08-24', '14:00:00', '2026-08-26', '12:00:00', 2, 0, 0, 1600000, 'qris', 'active', '2026-08-29 10:04:03', '2026-08-29 10:04:03'),
(6, 2, 1, '2026-08-31', '14:00:00', '2026-09-01', '12:00:00', 1, 0, 0, 300000, 'cash', 'cancelled', '2026-08-30 04:36:46', '2026-08-30 04:44:32'),
(7, 2, 11, '2026-09-01', '14:00:00', '2026-09-03', '12:00:00', 2, 0, 0, 600000, 'qris', 'active', '2026-08-30 04:37:24', '2026-08-30 04:37:29'),
(8, 2, 6, '2026-08-30', '14:00:00', '2026-08-31', '12:00:00', 1, 0, 0, 300000, 'cash', 'cancelled', '2026-08-30 04:41:59', '2026-08-30 04:53:28'),
(9, 2, 5, '2026-08-31', '14:00:00', '2026-09-01', '12:00:00', 1, 0, 0, 800000, 'cash', 'pending', '2026-08-30 06:16:34', '2026-08-30 06:16:34'),
(10, 2, 1, '2026-08-31', '14:00:00', '2026-09-01', '12:00:00', 1, 0, 0, 300000, 'cash', 'pending', '2026-08-30 16:44:17', '2026-08-30 16:44:17'),
(11, 2, 2, '2026-08-31', '14:00:00', '2026-09-01', '12:00:00', 1, 0, 0, 500000, 'cash', 'active', '2026-08-30 16:45:36', '2026-08-30 16:45:49'),
(12, 2, 6, '2026-08-31', '14:00:00', '2026-09-01', '12:00:00', 1, 0, 0, 300000, 'cash', 'active', '2026-08-30 21:06:07', '2026-08-30 21:07:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(21, '0001_01_01_000000_create_users_table', 1),
(22, '0001_01_01_000001_create_cache_table', 1),
(23, '0001_01_01_000002_create_jobs_table', 1),
(24, '2026_08_28_000001_create_rooms_table', 1),
(25, '2026_08_28_000003_create_bookings_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_number` varchar(255) NOT NULL,
  `room_type` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `room_type`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, '101', 'Standard', 300000, 'occupied', '2026-08-29 08:08:59', '2026-08-30 16:44:17'),
(2, '102', 'Deluxe', 500000, 'occupied', '2026-08-29 08:08:59', '2026-08-30 16:45:36'),
(3, '103', 'Deluxe', 500000, 'available', '2026-08-29 08:08:59', '2026-08-29 08:08:59'),
(4, '201', 'Suite', 800000, 'available', '2026-08-29 08:08:59', '2026-08-29 08:08:59'),
(5, '202', 'Suite', 800000, 'occupied', '2026-08-29 08:08:59', '2026-08-30 06:16:35'),
(6, '101', 'Standard', 300000, 'occupied', '2026-08-29 10:03:48', '2026-08-30 21:06:07'),
(7, '102', 'Deluxe', 500000, 'available', '2026-08-29 10:03:48', '2026-08-29 10:03:48'),
(8, '103', 'Deluxe', 500000, 'available', '2026-08-29 10:03:48', '2026-08-29 10:03:48'),
(9, '201', 'Suite', 800000, 'available', '2026-08-29 10:03:48', '2026-08-29 10:03:48'),
(10, '202', 'Suite', 800000, 'available', '2026-08-29 10:03:48', '2026-08-29 10:03:48'),
(11, '101', 'Standard', 300000, 'occupied', '2026-08-29 10:04:03', '2026-08-30 04:37:24'),
(12, '102', 'Deluxe', 500000, 'available', '2026-08-29 10:04:03', '2026-08-29 10:04:03'),
(13, '103', 'Deluxe', 500000, 'available', '2026-08-29 10:04:03', '2026-08-29 10:04:03'),
(14, '201', 'Suite', 800000, 'available', '2026-08-29 10:04:03', '2026-08-29 10:04:03'),
(15, '202', 'Suite', 800000, 'available', '2026-08-29 10:04:03', '2026-08-29 10:04:03'),
(16, '404', 'Suite', 80000, 'available', '2026-08-30 06:19:07', '2026-08-30 06:19:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('KznbKQJUdi7F3Gs2hCNZsv68G5V3V4OWrsTrviY7', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidGFPdGNNb2FGSnBGclhyMHR3UWVNVkF3a0g1WHlQTU9tRWl3Z2UxViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1788149294);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `identity_number` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `identity_number`, `phone`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator Hotel', 'admin@gmail.com', NULL, '$2y$12$Yu1k8mvDrcyKbUj34ZQEEuRs8ZSc7k7ulZoRtvpRBsifaHyoVgZbu', 'admin', '3201000000000001', '081234567890', NULL, '2026-08-29 08:08:58', '2026-08-29 08:08:58'),
(2, 'jamal', 'tamu@hotel.com', NULL, '$2y$12$bWiBrgETmiCpLWKEyLqJfO2AreU5wuO2sDcNCIjH/C9AB.p/X4Vs.', 'user', '3201234567890001', '081987654321', NULL, '2026-08-29 08:08:59', '2026-08-30 04:53:42'),
(3, 'Administrator Hotel', 'admin@hotel.com', NULL, '$2y$12$X7ItiwYc6YSu43uj6/R5TOv74BfOHudJVKJP/mbk8ddCFZkRxhhzG', 'admin', '3201000000000001', '081234567890', NULL, '2026-08-29 10:03:47', '2026-08-29 10:03:47'),
(4, 'Siti Rahmawati', 'siti@gmail.com', NULL, '$2y$12$HDcPVzYhbJ4vCvwO5gwg6OHnA2uzMCRuLNqE8GMFV0Rz6Wo48qXiu', 'user', '3201234567890002', '081298765432', NULL, '2026-08-29 10:03:47', '2026-08-29 10:03:47'),
(5, 'antony 2008', 'antony@gmail.com', NULL, '$2y$12$XBMhmiTopLuDjpBEBXOAGe1eF8W8HphLFSjO/TYQYcqP8KNHerDcy', 'user', '3201234567890003', '081345678901', NULL, '2026-08-29 10:03:48', '2026-08-30 19:40:13'),
(6, 'darwin nunez', 'darwin@gmail.com', NULL, '$2y$12$aPT2/qtWC/KzqW5ORnAhIeAQZxfha.i8TuryIr4nECVMMNxfkbmma', 'user', '3201234567890004', '081456789012', NULL, '2026-08-29 10:03:48', '2026-08-30 19:39:42');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_guest_id_foreign` (`guest_id`),
  ADD KEY `bookings_room_id_foreign` (`room_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_guest_id_foreign` FOREIGN KEY (`guest_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
