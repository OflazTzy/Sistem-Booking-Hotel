<?php
$fileLog    = "booking_logs.txt";
    $timestamp  = date('Y-m-d H:i:s');
    $logMessage = "[" . $timestamp . "] Booking Berhasil - Tamu: " . $guest["name"] . " - Kamar: " . $selectedRoom["room_number"] . " - Total: Rp " . number_format($booking["total_price"], 0, ',', '.') . "\n";
    // Menuliskan teks baris baru ke file booking_logs.txt
    file_put_contents($fileLog, $logMessage, FILE_APPEND);
    // B. Membaca Seluruh Isi File Log
    $isiLog = file_get_contents($fileLog);
    echo "CATATAN FILE LOG AKTIVITAS (booking_logs.txt) ";
    echo nl2br($isiLog);
} else {
    // Output Jika Kamar Tidak Ditemukan atau Sudah Terisi
    echo "<b>Pemesanan Gagal!</b><br>";
    echo "Maaf, Kamar nomor " . $selectedRoomNumber . " sedang terisi (occupied) atau tidak ditemukan.";
}