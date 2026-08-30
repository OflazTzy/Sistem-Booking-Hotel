<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Nginap - {{ $booking->booking_code }}</title>
    <!-- Tailwind CSS CDN for styling PDF -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .print-container { border: none !important; box-shadow: none !important; margin: 0 !important; width: 100% !important; max-width: 100% !important; }
        }
    </style>
</head>
<body class="bg-stone-100 min-h-screen p-4 sm:p-8 font-sans text-stone-800 antialiased">

    <!-- Action Toolbar (Hidden during PDF print) -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('bookings.show', $booking) }}" class="px-4 py-2 rounded-xl bg-stone-900 hover:bg-stone-950 text-white font-bold text-xs shadow-md transition inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Detail Booking
        </a>
        <div class="flex items-center space-x-2">
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs shadow-lg shadow-rose-500/25 transition inline-flex items-center gap-2">
                <i class="fa-solid fa-print text-sm"></i> Cetak / Simpan ke PDF (DomPDF)
            </button>
        </div>
    </div>

    <!-- Printable Invoice Sheet Nginap Style -->
    <div class="print-container max-w-4xl mx-auto bg-white rounded-3xl border border-stone-200/80 shadow-xl overflow-hidden p-8 sm:p-12 relative">

        <!-- Watermark Status Stamp -->
        @if($booking->status === 'active')
            <div class="absolute right-12 top-28 opacity-15 transform rotate-12 pointer-events-none select-none">
                <div class="border-8 border-emerald-600 text-emerald-600 font-black text-6xl tracking-widest px-8 py-3 rounded-3xl uppercase">
                    PAID / LUNAS
                </div>
            </div>
        @elseif($booking->status === 'pending')
            <div class="absolute right-12 top-28 opacity-15 transform rotate-12 pointer-events-none select-none">
                <div class="border-8 border-amber-500 text-amber-500 font-black text-5xl tracking-widest px-6 py-3 rounded-3xl uppercase">
                    PENDING / BELUM DIBAYAR
                </div>
            </div>
        @else
            <div class="absolute right-12 top-28 opacity-15 transform rotate-12 pointer-events-none select-none">
                <div class="border-8 border-rose-600 text-rose-600 font-black text-6xl tracking-widest px-8 py-3 rounded-3xl uppercase">
                    CANCELLED
                </div>
            </div>
        @endif

        <!-- Invoice Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start border-b border-stone-200 pb-8 mb-8 gap-6">
            <div>
                <div class="flex items-center space-x-2.5 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-stone-900 text-white flex items-center justify-center text-xl font-black">
                        <i class="fa-solid fa-hotel"></i>
                    </div>
                    <span class="text-2xl font-black text-stone-900 tracking-tight">Nginap<span class="text-rose-600">.</span></span>
                </div>
                <p class="text-xs text-stone-500 max-w-xs">Jl. Raya Nginap Utama No. 88, Jakarta &bull; Telp: (021) 555-8899 &bull; Email: info@nginap.com</p>
            </div>
            <div class="text-left sm:text-right">
                <span class="px-3 py-1 bg-stone-100 text-stone-800 rounded-lg text-xs font-black border border-stone-200 uppercase tracking-wider">
                    KUITANSI INVOICE RESMI
                </span>
                <h2 class="text-2xl font-black text-stone-900 mt-2">{{ $booking->booking_code }}</h2>
                <p class="text-xs text-stone-500 mt-1">Tanggal Terbit: {{ $booking->created_at->format('d F Y, H:i') }} WIB</p>
            </div>
        </div>

        <!-- Guest & Booking Metadata Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-8 pb-8 border-b border-stone-200">
            <!-- Ditagihkan Kepada (Tamu) -->
            <div>
                <h4 class="text-xs font-black uppercase tracking-wider text-stone-400 mb-2">Ditagihkan Kepada (Tamu)</h4>
                <h3 class="text-lg font-bold text-stone-900">{{ $booking->guest->name }}</h3>
                <p class="text-xs text-stone-600 mt-1"><i class="fa-solid fa-id-card text-stone-400 me-1"></i> No. KTP/SIM: <strong>{{ $booking->guest->identity_number }}</strong></p>
                <p class="text-xs text-stone-600 mt-0.5"><i class="fa-solid fa-phone text-stone-400 me-1"></i> No. HP/WA: <strong>{{ $booking->guest->phone }}</strong></p>
                <p class="text-xs text-stone-600 mt-0.5"><i class="fa-solid fa-envelope text-stone-400 me-1"></i> Email: <strong>{{ $booking->guest->email }}</strong></p>
            </div>

            <!-- Detail Metode Bayar & Status -->
            <div class="sm:text-right">
                <h4 class="text-xs font-black uppercase tracking-wider text-stone-400 mb-2">Metode Pembayaran</h4>
                @if($booking->payment_method === 'cash')
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-amber-50 text-amber-800 border border-amber-200 text-xs font-bold">
                        <i class="fa-solid fa-money-bill-wave text-amber-600"></i> Tunai saat Check-in (Bayar di Tempat)
                    </div>
                @else
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-sky-50 text-sky-800 border border-sky-200 text-xs font-bold">
                        <i class="fa-solid fa-qrcode text-sky-600"></i> QRIS Code / Transfer Virtual Account
                    </div>
                @endif

                <p class="text-xs text-stone-500 mt-2">Status Pembayaran: 
                    @if($booking->status === 'active')
                        <strong class="text-emerald-600 uppercase">LUNAS (PAID)</strong>
                    @elseif($booking->status === 'pending')
                        <strong class="text-amber-600 uppercase">MENUNGGU VERIFIKASI (PENDING)</strong>
                    @else
                        <strong class="text-rose-600 uppercase">DIBATALKAN</strong>
                    @endif
                </p>
                <p class="text-xs text-stone-500 mt-0.5">Waktu Update: {{ $booking->updated_at->format('d F Y, H:i') }} WIB</p>
            </div>
        </div>

        <!-- Table Details -->
        <div class="overflow-x-auto mb-8">
            <table class="w-full text-left text-sm text-stone-700">
                <thead class="bg-stone-900 text-white text-xs uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-4 py-3 rounded-l-xl">Deskripsi Item Pemesanan</th>
                        <th class="px-4 py-3">Tipe Kamar</th>
                        <th class="px-4 py-3">Tgl & Jam Check-in/Out</th>
                        <th class="px-4 py-3 text-center">Durasi / Denda</th>
                        <th class="px-4 py-3 text-right rounded-r-xl">Total Biaya</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 font-medium">
                    <!-- Sewa Kamar -->
                    <tr>
                        <td class="px-4 py-4">
                            <strong class="text-stone-900 text-base">Sewa Kamar Hotel Nomor {{ $booking->room->room_number }}</strong>
                            <p class="text-xs text-stone-400">Fasilitas lengkap (AC, Wi-Fi, TV LED, Kamar Mandi Air Hangat)</p>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-2.5 py-1 bg-stone-100 text-stone-800 text-xs font-bold rounded-lg border border-stone-200">
                                {{ $booking->room->room_type }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-xs">
                            <div>In: {{ $booking->check_in->format('d/m/Y') }} ({{ substr($booking->check_in_time ?? '14:00', 0, 5) }} WIB)</div>
                            <div>Out: {{ $booking->check_out->format('d/m/Y') }} ({{ substr($booking->check_out_time ?? '12:00', 0, 5) }} WIB)</div>
                        </td>
                        <td class="px-4 py-4 text-center font-bold">
                            {{ $booking->total_nights }} Malam
                        </td>
                        <td class="px-4 py-4 text-right font-bold text-stone-900">
                            Rp {{ number_format($booking->total_nights * $booking->room->price, 0, ',', '.') }}
                        </td>
                    </tr>

                    <!-- Denda Late Checkout (Jika ada) -->
                    @if($booking->late_hours > 0)
                        <tr class="bg-rose-50/50">
                            <td class="px-4 py-3 text-rose-800 font-bold">
                                <i class="fa-solid fa-triangle-exclamation text-rose-600 me-1"></i> Denda Late Check-out (Melebihi Jam 12:00 WIB)
                            </td>
                            <td class="px-4 py-3 text-xs text-rose-600">Rp 50.000 / jam</td>
                            <td class="px-4 py-3 text-xs text-rose-600">Jam Out: {{ substr($booking->check_out_time, 0, 5) }} WIB</td>
                            <td class="px-4 py-3 text-center font-black text-rose-700">+ {{ $booking->late_hours }} Jam</td>
                            <td class="px-4 py-3 text-right font-black text-rose-700">
                                + Rp {{ number_format($booking->late_fee, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Total Calculation Box -->
        <div class="flex justify-end mb-12">
            <div class="w-full sm:w-80 bg-stone-50 p-6 rounded-2xl border border-stone-200/80 space-y-2 text-sm">
                <div class="flex justify-between text-stone-600 text-xs">
                    <span>Subtotal Sewa Kamar</span>
                    <span>Rp {{ number_format($booking->total_nights * $booking->room->price, 0, ',', '.') }}</span>
                </div>
                @if($booking->late_hours > 0)
                    <div class="flex justify-between text-rose-600 text-xs font-bold">
                        <span>Denda Late Check-out ({{ $booking->late_hours }} Jam)</span>
                        <span>+ Rp {{ number_format($booking->late_fee, 0, ',', '.') }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-stone-600 text-xs">
                    <span>Pajak & Layanan Hotel (0%)</span>
                    <span>Rp 0</span>
                </div>
                <div class="pt-2 border-t border-stone-200 flex justify-between items-center">
                    <span class="font-extrabold text-stone-900 text-base">TOTAL KESELURUHAN</span>
                    <span class="font-black text-rose-600 text-xl">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Footer Signatures -->
        <div class="grid grid-cols-2 gap-8 text-center text-xs text-stone-500 pt-8 border-t border-stone-200">
            <div>
                <p class="mb-12 font-medium">Tanda Tangan Tamu Pemesan,</p>
                <p class="font-bold text-stone-800 underline">{{ $booking->guest->name }}</p>
            </div>
            <div>
                <p class="mb-12 font-medium">Manajemen Nginap Platform,</p>
                <p class="font-bold text-stone-800 underline">Administrator Pengelola</p>
            </div>
        </div>

    </div>

    <!-- Auto Print Script -->
    <script>
        if (window.location.search.includes('print=true')) {
            window.addEventListener('load', function() {
                window.print();
            });
        }
    </script>

</body>
</html>
