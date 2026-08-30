{{-- Halaman Daftar Pesanan (Admin Dark Sidebar & User View) --}}
@extends('layouts.app')

@section('title', Auth::check() && Auth::user()->isAdmin() ? 'Nginap Admin - Kelola Pesanan' : 'Nginap - Pesanan Saya')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        @auth
            @if(Auth::user()->isAdmin())
                <!-- ADMIN VIEW: KELOLA PESANAN DASHBOARD (Match Stitch Admin Theme) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    <!-- LEFT DARK GREEN SIDEBAR -->
                    <div class="lg:col-span-3">
                        @include('admin.sidebar')
                    </div>

                    <!-- RIGHT MAIN CONTENT: PESANAN TABLE -->
                    <div class="lg:col-span-9 space-y-6">

                        <!-- Header Title -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h1 class="text-3xl sm:text-4xl font-black text-stone-900 font-serif tracking-tight">Pesanan</h1>
                                <p class="text-xs text-stone-400 mt-1">Daftar seluruh riwayat reservasi kamar hotel terintegrasi</p>
                            </div>
                        </div>

                        <!-- Table Transaksi Bookings (Match Stitch Admin Screenshot) -->
                        <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden p-6 space-y-6">
                            @if ($bookings->isEmpty())
                                <div class="text-center py-12 text-stone-400 text-xs">
                                    <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-stone-100 text-stone-300 flex items-center justify-center text-2xl">
                                        <i class="fa-solid fa-inbox"></i>
                                    </div>
                                    <h3 class="text-base font-bold text-stone-800 font-serif mb-1">Belum Ada Transaksi Booking</h3>
                                    <p class="text-xs text-stone-400">Belum ada pemesanan kamar yang dilakukan di sistem saat ini.</p>
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left text-xs text-stone-600">
                                        <thead class="border-b border-stone-200 uppercase tracking-wider font-extrabold text-[10px] text-stone-400">
                                            <tr>
                                                <th class="py-3 px-4">KODE BOOKING</th>
                                                <th class="py-3 px-4">TAMU</th>
                                                <th class="py-3 px-4">KAMAR</th>
                                                <th class="py-3 px-4">CHECK-IN / OUT</th>
                                                <th class="py-3 px-4 text-right">TOTAL BIAYA</th>
                                                <th class="py-3 px-4 text-center">METODE</th>
                                                <th class="py-3 px-4 text-center">STATUS</th>
                                                <th class="py-3 px-4 text-center">AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-stone-100 font-medium">
                                            @foreach ($bookings as $booking)
                                                <tr class="hover:bg-stone-50 transition">
                                                    <td class="py-4 px-4 font-black font-mono text-stone-900">#{{ $booking->booking_code }}</td>
                                                    <td class="py-4 px-4 font-bold text-stone-800">
                                                        {{ $booking->guest->name }}
                                                        <span class="block text-[10px] text-stone-400 font-normal">{{ $booking->guest->phone ?? '-' }}</span>
                                                    </td>
                                                    <td class="py-4 px-4">
                                                        <span class="font-bold text-stone-900 block font-serif">Kamar {{ $booking->room->room_number }}</span>
                                                        <span class="text-[11px] text-stone-400">({{ $booking->room->room_type }})</span>
                                                    </td>
                                                    <td class="py-4 px-4">
                                                        <div class="font-bold text-stone-800">{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</div>
                                                        <div class="text-stone-400 text-[11px]">s/d {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</div>
                                                    </td>
                                                    <td class="py-4 px-4 text-right font-black text-stone-900">
                                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                                    </td>
                                                    <td class="py-4 px-4 text-center">
                                                        @if($booking->payment_method === 'cash')
                                                            <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-800 font-extrabold text-[10px] border border-amber-200">TUNAI</span>
                                                        @else
                                                            <span class="px-2.5 py-1 rounded-full bg-sky-50 text-sky-800 font-extrabold text-[10px] border border-sky-200">QRIS</span>
                                                        @endif
                                                    </td>
                                                    <td class="py-4 px-4 text-center">
                                                        @if ($booking->status === 'active')
                                                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase border border-emerald-200">CONFIRMED</span>
                                                        @elseif ($booking->status === 'pending')
                                                            <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 font-extrabold text-[10px] uppercase border border-amber-200">PENDING</span>
                                                        @else
                                                            <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-800 font-extrabold text-[10px] uppercase border border-rose-200">CANCELLED</span>
                                                        @endif
                                                    </td>
                                                    <td class="py-4 px-4 text-center">
                                                        <div class="inline-flex items-center space-x-1">
                                                            <a href="{{ route('bookings.show', $booking) }}" class="px-3 py-1.5 rounded-full bg-stone-900 text-white font-extrabold text-[10px] hover:bg-[#8a6225] transition">
                                                                Detail
                                                            </a>
                                                            <a href="{{ route('bookings.pdf', $booking) }}" target="_blank" class="px-2.5 py-1.5 rounded-full bg-rose-50 text-rose-600 font-extrabold text-[10px] hover:bg-rose-100 transition">
                                                                PDF
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                    </div>

                </div>

            @else
                <!-- GUEST VIEW -->
                @include('dashboard.user')
            @endif
        @else
            <!-- GUEST VIEW -->
            @include('dashboard.user')
        @endauth

    </div>

@endsection
