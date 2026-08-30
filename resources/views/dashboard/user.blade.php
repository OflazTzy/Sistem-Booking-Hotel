{{-- Halaman Dashboard User / Pesanan Saya (100% Persis Screenshot Stitch Image 2) --}}
@extends('layouts.app')

@section('title', 'Nginap - Pesanan Saya')

@section('content')

    @php
        $bookingsCollection = $myActiveBookings ?? ($bookings ?? collect());
        $activeBookingsList = isset($myActiveBookings) ? $myActiveBookings : $bookingsCollection->where('status', 'active');
        $activeCount = isset($myActiveBookingsCount) ? $myActiveBookingsCount : $activeBookingsList->count();
        $totalCount = isset($myBookingsCount) ? $myBookingsCount : $bookingsCollection->count();
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Top Greeting (Match Image 2) -->
        <div class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-black text-stone-900 font-serif tracking-tight flex items-center gap-3">
                Halo, {{ Auth::user()->name }} <span class="text-2xl">👋</span>
            </h1>
            <p class="text-xs text-stone-500 mt-1">
                Punya {{ $activeCount }} pesanan yang akan datang.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <!-- LEFT SIDEBAR PILL TAB MENU (Responsive Row on Mobile, Column on Desktop) -->
            <div class="flex flex-row overflow-x-auto lg:flex-col space-x-2 lg:space-x-0 lg:space-y-2 pb-3 lg:pb-0 no-scrollbar shrink-0">
                <a href="{{ route('dashboard') }}" class="shrink-0 flex items-center space-x-2.5 px-4 py-2.5 sm:px-5 sm:py-3 rounded-2xl text-xs font-bold transition {{ request()->routeIs('dashboard') ? 'bg-[#e7d8ca] text-stone-900 font-extrabold shadow-sm' : 'bg-white text-stone-600 hover:bg-stone-100' }}">
                    <i class="fa-solid fa-list-check w-4"></i>
                    <span>Pesanan Saya</span>
                </a>
                <a href="{{ route('rooms.index') }}" class="shrink-0 flex items-center space-x-2.5 px-4 py-2.5 sm:px-5 sm:py-3 rounded-2xl text-xs font-bold text-stone-600 bg-white hover:bg-stone-100 transition">
                    <i class="fa-solid fa-compass w-4"></i>
                    <span>Jelajahi Kamar</span>
                </a>
                <a href="#" class="shrink-0 flex items-center space-x-2.5 px-4 py-2.5 sm:px-5 sm:py-3 rounded-2xl text-xs font-bold text-stone-600 bg-white hover:bg-stone-100 transition">
                    <i class="fa-regular fa-heart w-4"></i>
                    <span>Favorit</span>
                </a>
                <a href="#" class="shrink-0 flex items-center space-x-2.5 px-4 py-2.5 sm:px-5 sm:py-3 rounded-2xl text-xs font-bold text-stone-600 bg-white hover:bg-stone-100 transition">
                    <i class="fa-regular fa-user w-4"></i>
                    <span>Profil Saya</span>
                </a>
            </div>

            <!-- RIGHT MAIN CONTENT (Match Image 2) -->
            <div class="lg:col-span-3 space-y-6">

                @if($activeBookingsList->isEmpty())
                    <div class="bg-white rounded-3xl border border-stone-200/80 p-12 text-center shadow-sm">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-stone-100 text-stone-400 flex items-center justify-center text-3xl">
                            <i class="fa-solid fa-inbox"></i>
                        </div>
                        <h3 class="text-lg font-bold text-stone-900 font-serif mb-1">Belum Ada Pesanan Aktif</h3>
                        <p class="text-xs text-stone-400 mb-6">Anda belum memiliki pemesanan kamar yang akan datang.</p>
                        <a href="{{ route('rooms.index') }}" class="px-6 py-3 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs shadow-md transition inline-flex items-center gap-2">
                            <i class="fa-solid fa-magnifying-glass"></i> Cari & Pesan Kamar
                        </a>
                    </div>
                @else
                    @foreach($activeBookingsList as $booking)
                        <!-- Active Booking Card (Match Image 2 Layout) -->
                        <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden grid grid-cols-1 md:grid-cols-12 hover:shadow-md transition">
                            
                            <!-- Left Column: Details (8 cols) -->
                            <div class="md:col-span-8 p-6 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase border border-emerald-200">
                                            AKAN DATANG
                                        </span>
                                    </div>

                                    <h3 class="text-xl font-black text-stone-900 font-serif mb-1">
                                        Kamar {{ $booking->room->room_number }} &bull; {{ $booking->room->room_type }}
                                    </h3>
                                    <p class="text-xs text-stone-500 mb-4 flex items-center gap-1">
                                        <i class="fa-solid fa-location-dot text-amber-700"></i> Nginap Hotel Utama, Indonesia
                                    </p>

                                    <div class="grid grid-cols-2 gap-4 text-xs pt-3 border-t border-stone-100">
                                        <div>
                                            <span class="text-[10px] font-black uppercase text-stone-400 block tracking-wider mb-0.5">CHECK-IN</span>
                                            <strong class="text-stone-900 text-xs block font-bold">{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</strong>
                                            <span class="text-stone-500 text-[11px]">{{ substr($booking->check_in_time ?? '14:00', 0, 5) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-[10px] font-black uppercase text-stone-400 block tracking-wider mb-0.5">CHECK-OUT</span>
                                            <strong class="text-stone-900 text-xs block font-bold">{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</strong>
                                            <span class="text-stone-500 text-[11px]">{{ substr($booking->check_out_time ?? '12:00', 0, 5) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Booking Code & Action (4 cols, Warm Beige Background) -->
                            <div class="md:col-span-4 p-6 bg-[#f7f4ee] md:border-l md:border-dashed border-stone-200 flex flex-col justify-between items-center text-center">
                                <div>
                                    <span class="text-[10px] font-black uppercase tracking-wider text-stone-400 block mb-1">KODE BOOKING</span>
                                    <strong class="text-sm font-black text-stone-900 font-mono tracking-wider block mb-4 bg-white px-3 py-1 rounded-lg border border-stone-200">
                                        {{ $booking->booking_code }}
                                    </strong>
                                </div>

                                <a href="{{ route('bookings.show', $booking) }}" class="w-full py-2.5 px-4 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs text-center shadow transition">
                                    Lihat e-Tiket
                                </a>
                            </div>

                        </div>
                    @endforeach
                @endif

                <!-- Bottom Stat Widgets (Match Image 2) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-stone-200/80 shadow-sm flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-[#8a6225] flex items-center justify-center text-lg shrink-0">
                            <i class="fa-solid fa-bed"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-black uppercase tracking-wider text-stone-400 block">TOTAL MALAM MENGINAP</span>
                            <strong class="text-lg font-black text-stone-900">
                                {{ $activeBookingsList->sum('total_nights') }} Malam
                            </strong>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-stone-200/80 shadow-sm flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-lg shrink-0">
                            <i class="fa-solid fa-plane-departure"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-black uppercase tracking-wider text-stone-400 block">TOTAL RESERVASI</span>
                            <strong class="text-lg font-black text-stone-900">
                                {{ $totalCount }} Pesanan
                            </strong>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
