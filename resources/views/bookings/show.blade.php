{{-- Halaman Detail Booking / Pemesanan Berhasil (100% Persis Screenshot Stitch Image 1) --}}
@extends('layouts.app')

@section('title', 'Pemesanan Berhasil - Nginap')

@section('content')

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- Top Checkmark Success Header (Match Image 1) -->
        <div class="text-center mb-10">
            <div class="w-14 h-14 mx-auto mb-4 rounded-full border-2 border-stone-900 flex items-center justify-center text-stone-900 text-2xl">
                <i class="fa-solid fa-check"></i>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-stone-900 font-serif tracking-tight mb-2">
                Pemesanan Berhasil
            </h1>
            <p class="text-xs text-stone-500">
                Kemas barang bawaan Anda, perjalanan Anda telah dikonfirmasi.
            </p>
        </div>

        <!-- Ticket Voucher Card with Dotted Line (Match Image 1) -->
        <div class="bg-white rounded-3xl border border-stone-200/80 shadow-lg overflow-hidden grid grid-cols-1 md:grid-cols-12 mb-8 relative">
            
            <!-- Left Ticket Main Content (8 Cols) -->
            <div class="md:col-span-8 p-6 sm:p-8 flex flex-col justify-between">
                <div>
                    <!-- Hotel & Room Title -->
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                        <h2 class="text-xl sm:text-2xl font-black text-stone-900 font-serif">
                            Kamar {{ $booking->room->room_number }} &bull; {{ $booking->room->room_type }}
                        </h2>
                        @if($booking->status === 'active')
                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase border border-emerald-200">
                                TERKONFIRMASI
                            </span>
                        @elseif($booking->status === 'pending')
                            <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 font-extrabold text-[10px] uppercase border border-amber-200">
                                MENUNGGU PENGESAHAN
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-800 font-extrabold text-[10px] uppercase border border-rose-200">
                                DIBATALKAN
                            </span>
                        @endif
                    </div>
                    
                    <p class="text-xs text-stone-500 mb-6 flex items-center gap-1">
                        <i class="fa-solid fa-location-dot text-amber-700"></i> Nginap Hotel Utama &bull; Pusat Kota, Indonesia
                    </p>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-2 gap-4 text-xs mb-6">
                        <div>
                            <span class="text-[10px] font-black uppercase text-stone-400 block tracking-wider mb-1">NAMA TAMU</span>
                            <strong class="text-stone-900 text-sm block font-bold">{{ $booking->guest->name }}</strong>
                        </div>
                        <div>
                            <span class="text-[10px] font-black uppercase text-stone-400 block tracking-wider mb-1">TIPE KAMAR</span>
                            <strong class="text-stone-900 text-sm block font-bold">{{ $booking->room->room_type }} Room</strong>
                        </div>
                    </div>

                    <!-- Check-in & Check-out Box (Warm Beige Rounded Container) -->
                    <div class="bg-[#f7f4ee] p-4 rounded-2xl grid grid-cols-2 gap-4 border border-stone-200/60 text-xs">
                        <div>
                            <span class="text-[10px] font-black uppercase text-stone-400 block tracking-wider mb-1">CHECK-IN</span>
                            <strong class="text-stone-900 text-sm block font-bold">{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</strong>
                            <span class="text-stone-500 font-medium text-[11px]">{{ substr($booking->check_in_time ?? '14:00', 0, 5) }} WIB</span>
                        </div>
                        <div>
                            <span class="text-[10px] font-black uppercase text-stone-400 block tracking-wider mb-1">CHECK-OUT</span>
                            <strong class="text-stone-900 text-sm block font-bold">{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</strong>
                            <span class="text-stone-500 font-medium text-[11px]">{{ substr($booking->check_out_time ?? '12:00', 0, 5) }} WIB</span>
                        </div>
                    </div>
                </div>

                @if($booking->late_hours > 0)
                    <div class="mt-4 p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center justify-between">
                        <span class="font-bold"><i class="fa-solid fa-clock-triangle-exclamation me-1"></i> Denda Late Checkout ({{ $booking->late_hours }} Jam)</span>
                        <strong class="font-black text-rose-700">+ Rp {{ number_format($booking->late_fee, 0, ',', '.') }}</strong>
                    </div>
                @endif
            </div>

            <!-- Right Ticket Stub with QR Code & Booking Code (4 Cols, Dotted Separator) -->
            <div class="md:col-span-4 p-6 sm:p-8 bg-stone-50/50 md:border-l md:border-dashed border-stone-200 flex flex-col justify-between items-center text-center relative">
                
                <!-- Ticket Notch Circles -->
                <div class="hidden md:block absolute -top-3 -left-3 w-6 h-6 rounded-full bg-[#f7f4ee] border border-stone-200"></div>
                <div class="hidden md:block absolute -bottom-3 -left-3 w-6 h-6 rounded-full bg-[#f7f4ee] border border-stone-200"></div>

                <div>
                    <span class="text-[10px] font-black uppercase tracking-wider text-stone-400 block mb-1">KODE BOOKING</span>
                    <strong class="text-base font-black text-stone-900 font-mono tracking-wider block mb-4 bg-white px-3 py-1 rounded-lg border border-stone-200">
                        {{ $booking->booking_code }}
                    </strong>

                    <!-- QR Code Image Box -->
                    <div class="w-32 h-32 mx-auto bg-white p-2 rounded-xl border border-stone-200 shadow-inner flex items-center justify-center mb-4">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=NGINAP-{{ $booking->booking_code }}" alt="QR Code" class="w-full h-full object-contain">
                    </div>
                </div>

                <div>
                    @if($booking->status === 'active')
                        <span class="px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-xs uppercase border border-emerald-200 inline-block">
                            LUNAS
                        </span>
                    @elseif($booking->status === 'pending')
                        <span class="px-4 py-1.5 rounded-full bg-amber-100 text-amber-800 font-extrabold text-xs uppercase border border-amber-200 inline-block mb-2">
                            PENDING
                        </span>
                        <form action="{{ route('bookings.verify.payment', $booking) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2 px-3 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-[10px] shadow transition">
                                Verifikasi Lunas
                            </button>
                        </form>
                    @else
                        <span class="px-4 py-1.5 rounded-full bg-stone-100 text-stone-600 font-bold text-xs uppercase border border-stone-200 inline-block">
                            CANCELLED
                        </span>
                    @endif
                </div>

            </div>

        </div>

        <!-- Action Buttons Row (Match Image 1) -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-6">
            <a href="{{ route('bookings.pdf', $booking) }}" target="_blank" class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs shadow-lg transition text-center flex items-center justify-center gap-2">
                <i class="fa-solid fa-download"></i> Unduh e-Tiket (PDF)
            </a>

            <button onclick="alert('Jadwal booking {{ $booking->booking_code }} ditambahkan ke kalender!')" class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-white border border-stone-900 text-stone-900 font-extrabold text-xs hover:bg-stone-50 transition text-center flex items-center justify-center gap-2">
                <i class="fa-regular fa-calendar-plus"></i> Tambah ke Kalender
            </button>

            @if($booking->status !== 'cancelled')
                <form action="{{ route('bookings.cancel', $booking) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?');" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-rose-100 hover:bg-rose-200 text-rose-800 border border-rose-300 font-extrabold text-xs transition text-center flex items-center justify-center gap-2">
                        <i class="fa-solid fa-ban"></i> Batalkan Pesanan
                    </button>
                </form>
            @endif
        </div>

        <div class="text-center">
            <a href="{{ route('home') }}" class="text-xs font-bold text-stone-600 hover:text-stone-900 underline transition">
                Kembali ke Beranda
            </a>
        </div>

    </div>

@endsection
