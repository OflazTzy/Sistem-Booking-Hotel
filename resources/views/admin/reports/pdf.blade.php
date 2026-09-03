<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan_Rekapan_Transaksi_{{ str_replace(' ', '_', $periodLabel) }}</title>
    
    <!-- Google Fonts: Plus Jakarta Sans & Playfair Display -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 12mm;
            }
            body {
                background-color: #ffffff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body class="bg-stone-100 p-4 sm:p-8 font-sans text-stone-900 antialiased" onload="window.print()">

    <!-- Printable Container Card (A4 Sized Frame) -->
    <div class="max-w-4xl mx-auto bg-white rounded-3xl border border-stone-300 p-8 sm:p-10 shadow-lg print:shadow-none print:border-none print:p-0">

        <!-- KOP SURAT RESMI HOTEL NGINAP -->
        <div class="flex items-center justify-between border-b-2 border-stone-900 pb-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-stone-900 text-white flex items-center justify-center font-serif text-2xl font-black shadow-md">
                    N
                </div>
                <div>
                    <h1 class="text-2xl font-black tracking-tight text-stone-900 font-serif">NGINAP HOTEL UTAMA</h1>
                    <p class="text-xs text-stone-600 font-medium">Jl. Malioboro No. 123, Pusat Kota, Yogyakarta &bull; Telp: (0274) 555-888</p>
                    <p class="text-[10px] text-stone-400 font-mono">Email: info@nginap-hotel.com &bull; Website: www.nginap-hotel.com</p>
                </div>
            </div>

            <div class="text-right">
                <span class="px-3 py-1 bg-stone-900 text-white font-extrabold text-[10px] rounded-full uppercase tracking-widest block mb-1">
                    LAPORAN RESMI
                </span>
                <span class="text-xs font-mono font-bold text-stone-500">TGL DICETAK: {{ date('d/m/Y H:i') }}</span>
            </div>
        </div>

        <!-- JUDUL & PERIODE LAPORAN -->
        <div class="text-center mb-8">
            <h2 class="text-xl font-black text-stone-900 uppercase tracking-wide font-serif">LAPORAN REKAPAN TRANSAKSI & KEUANGAN</h2>
            <p class="text-xs font-bold text-stone-600 mt-1 uppercase">
                PERIODE: <span class="text-amber-800 font-black">{{ strtoupper($periodLabel) }}</span>
            </p>
        </div>

        <!-- SUMMARY STATS BAR -->
        <div class="grid grid-cols-3 gap-4 mb-6 text-xs">
            <div class="p-4 rounded-2xl bg-stone-50 border border-stone-200">
                <span class="text-[10px] font-bold text-stone-500 uppercase block">TOTAL RESERVASI</span>
                <strong class="text-base font-black text-stone-900 font-serif block mt-0.5">{{ $totalBookings }} Transaksi</strong>
            </div>

            <div class="p-4 rounded-2xl bg-stone-50 border border-stone-200">
                <span class="text-[10px] font-bold text-stone-500 uppercase block">TOTAL MALAM DILAYANI</span>
                <strong class="text-base font-black text-stone-900 font-serif block mt-0.5">{{ $totalNights }} Malam</strong>
            </div>

            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200">
                <span class="text-[10px] font-bold text-emerald-800 uppercase block">TOTAL OMSET PENDAPATAN</span>
                <strong class="text-base font-black text-emerald-800 font-serif block mt-0.5">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong>
            </div>
        </div>

        <!-- TABLE DETAIL TRANSAKSI BULANAN -->
        <div class="overflow-x-auto mb-8">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-stone-900 text-white uppercase text-[9px] font-black tracking-wider">
                        <th class="py-2.5 px-3 border border-stone-800 text-center">NO</th>
                        <th class="py-2.5 px-3 border border-stone-800">KODE BOOKING</th>
                        <th class="py-2.5 px-3 border border-stone-800">NAMA TAMU</th>
                        <th class="py-2.5 px-3 border border-stone-800">KAMAR</th>
                        <th class="py-2.5 px-3 border border-stone-800 text-center">CHECK-IN</th>
                        <th class="py-2.5 px-3 border border-stone-800 text-center">CHECK-OUT</th>
                        <th class="py-2.5 px-3 border border-stone-800 text-center">STATUS</th>
                        <th class="py-2.5 px-3 border border-stone-800 text-right">TOTAL BIAYA</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200">
                    @if($bookings->isEmpty())
                        <tr>
                            <td colspan="8" class="py-6 text-center text-stone-400 italic">
                                Tidak ada data transaksi pada periode {{ $periodLabel }}.
                            </td>
                        </tr>
                    @else
                        @foreach($bookings as $index => $b)
                            <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-stone-50/50' }}">
                                <td class="py-2.5 px-3 border border-stone-200 text-center font-mono text-stone-400">{{ $index + 1 }}</td>
                                <td class="py-2.5 px-3 border border-stone-200 font-mono font-bold text-stone-900">{{ $b->booking_code }}</td>
                                <td class="py-2.5 px-3 border border-stone-200 font-bold text-stone-800">{{ $b->guest ? $b->guest->name : '-' }}</td>
                                <td class="py-2.5 px-3 border border-stone-200">
                                    Kmr {{ $b->room ? $b->room->room_number : '-' }} ({{ $b->room ? $b->room->room_type : '' }})
                                </td>
                                <td class="py-2.5 px-3 border border-stone-200 text-center font-mono">
                                    {{ \Carbon\Carbon::parse($b->check_in)->format('d/m/Y') }}
                                </td>
                                <td class="py-2.5 px-3 border border-stone-200 text-center font-mono">
                                    {{ \Carbon\Carbon::parse($b->check_out)->format('d/m/Y') }}
                                </td>
                                <td class="py-2.5 px-3 border border-stone-200 text-center font-bold">
                                    @if(in_array($b->status, ['active', 'confirmed', 'completed']))
                                        <span class="text-emerald-700">LUNAS</span>
                                    @elseif($b->status === 'pending')
                                        <span class="text-amber-700">PENDING</span>
                                    @else
                                        <span class="text-rose-700">BATAL</span>
                                    @endif
                                </td>
                                <td class="py-2.5 px-3 border border-stone-200 text-right font-mono font-bold text-stone-900">
                                    Rp {{ number_format($b->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                @if($bookings->isNotEmpty())
                    <tfoot>
                        <tr class="bg-stone-100 font-black text-stone-900 text-xs">
                            <td colspan="7" class="py-3 px-3 border border-stone-300 text-right uppercase">TOTAL REKAPAN PENDAPATAN (LUNAS):</td>
                            <td class="py-3 px-3 border border-stone-300 text-right font-mono text-emerald-800 text-sm">
                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>

        <!-- TANDA TANGAN & PENGESAHAN LAPORAN -->
        <div class="grid grid-cols-2 gap-8 pt-8 border-t border-stone-200 text-xs">
            <div>
                <p class="text-[10px] text-stone-400 font-bold uppercase tracking-wider mb-1">CATATAN PENGESAHAN:</p>
                <p class="text-stone-500 text-[11px] leading-relaxed">
                    Dokumen ini merupakan hasil cetakan komputerisasi resmi dari sistem Nginap Hotel Booking Platform dan dinyatakan sah tanpa memerlukan tanda tangan basah jika telah tercetak stempel verifikasi.
                </p>
            </div>

            <div class="text-right flex flex-col items-end">
                <p class="text-stone-600 font-medium">Yogyakarta, {{ date('d F Y') }}</p>
                <p class="font-bold text-stone-900 mb-12">Manager / Finance Nginap Hotel</p>
                <p class="font-black text-stone-900 underline font-serif text-sm">{{ Auth::user() ? Auth::user()->name : 'Administrator System' }}</p>
                <p class="text-[10px] text-stone-400 font-mono">NIP / ID: ADM-{{ date('Ym') }}-01</p>
            </div>
        </div>

        <!-- PRINT BUTTON (FLOATING NO-PRINT BAR) -->
        <div class="mt-8 pt-4 border-t border-stone-100 text-center no-print">
            <button onclick="window.print()" class="px-6 py-2.5 rounded-full bg-stone-900 hover:bg-stone-800 text-white font-extrabold text-xs shadow-md transition">
                <i class="fa-solid fa-print me-1"></i> Cetak / Simpan PDF Halaman Ini
            </button>
        </div>

    </div>

</body>
</html>
