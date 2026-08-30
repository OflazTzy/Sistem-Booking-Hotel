{{-- Halaman Home (100% Persis Screenshot Design Stitch "Nginap di mana malam ini?") --}}
@extends('layouts.app')

@section('title', 'Nginap - Nginap di mana malam ini?')

@section('content')

    <!-- HERO SECTION (High Quality Tropical Resort Pool Photo + Centered Title + White Search Bar Pill) -->
    <div class="relative w-full min-h-[580px] sm:min-h-[640px] flex items-center justify-center overflow-hidden mb-16 shadow-2xl">
        <!-- Background Photo -->
        <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1600&q=80" alt="Nginap Luxury Resort" class="absolute inset-0 w-full h-full object-cover">
        
        <!-- Dark Overlay Gradient -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/40 to-black/60"></div>

        <div class="relative z-10 w-full max-w-5xl mx-auto px-4 text-center text-white pt-8">
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight mb-8 font-serif drop-shadow-lg">
                Nginap di mana malam ini?
            </h1>

            <!-- Floating White Search Bar Pill (Exact Stitch Screenshot Design) -->
            <div class="max-w-4xl mx-auto bg-white rounded-2xl sm:rounded-full shadow-2xl p-2.5 sm:p-3 text-stone-800 border border-stone-100">
                <form action="{{ route('rooms.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-2 items-center">
                    
                    <!-- Field 1: Lokasi / Tipe Kamar -->
                    <div class="px-4 py-2 text-left border-b sm:border-b-0 sm:border-r border-stone-200/80">
                        <label class="block text-[10px] font-black uppercase tracking-wider text-stone-400 mb-0.5">
                            <i class="fa-solid fa-location-dot text-amber-700 me-1"></i> Lokasi / Tipe
                        </label>
                        <select name="type" class="w-full bg-transparent text-xs font-bold text-stone-800 focus:outline-none cursor-pointer">
                            <option value="">Mau ke mana? (Semua)</option>
                            <option value="Standard">Standard Room</option>
                            <option value="Deluxe">Deluxe Suite</option>
                            <option value="Suite">Presidential Suite</option>
                        </select>
                    </div>

                    <!-- Field 2: Tanggal Check-in / Out -->
                    <div class="px-4 py-2 text-left border-b sm:border-b-0 sm:border-r border-stone-200/80">
                        <label class="block text-[10px] font-black uppercase tracking-wider text-stone-400 mb-0.5">
                            <i class="fa-regular fa-calendar-days text-amber-700 me-1"></i> Tanggal
                        </label>
                        <span class="text-xs font-bold text-stone-800 block truncate">Check-in - Check-out</span>
                    </div>

                    <!-- Field 3: Tamu & Kamar -->
                    <div class="px-4 py-2 text-left">
                        <label class="block text-[10px] font-black uppercase tracking-wider text-stone-400 mb-0.5">
                            <i class="fa-solid fa-user-group text-amber-700 me-1"></i> Tamu
                        </label>
                        <span class="text-xs font-bold text-stone-800 block truncate">2 Dewasa, 1 Kamar</span>
                    </div>

                    <!-- Button: Cari (Golden-Brown Olive Pill Button) -->
                    <div>
                        <button type="submit" class="w-full py-3.5 px-6 rounded-xl sm:rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs shadow-lg transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-magnifying-glass"></i> Cari
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- SECTION: DESTINASI POPULER -->
        <div class="mb-16">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black text-stone-900 tracking-tight font-serif">Destinasi Populer</h2>
                    <p class="text-xs text-stone-500 mt-1">Temukan penginapan terbaik di kota-kota favorit</p>
                </div>
                <a href="{{ route('rooms.index') }}" class="text-xs font-bold text-stone-900 hover:text-[#8a6225] flex items-center gap-1 transition">
                    Lihat Semua <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>

            <!-- 3 Cards Row (Match Stitch Screenshot) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Card 1: Bali -->
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="relative h-56 bg-stone-100 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=600&q=80" alt="Bali Resort" class="w-full h-full object-cover">
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full bg-emerald-100/90 backdrop-blur-sm text-emerald-800 text-[10px] font-extrabold uppercase border border-emerald-200">
                                    FAVORIT
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-black text-stone-900 mb-1 font-serif">Bali</h3>
                            <p class="text-xs text-stone-500 mb-4">Penginapan & resort mewah bernuansa alam</p>
                        </div>
                    </div>
                    <div class="p-6 pt-0 flex items-center justify-between border-t border-stone-100">
                        <span class="text-xs font-bold text-stone-400">Mulai Rp {{ number_format($standardPrice, 0, ',', '.') }}</span>
                        <a href="{{ route('rooms.index') }}" class="px-4 py-2 rounded-full bg-stone-900 hover:bg-[#8a6225] text-white font-extrabold text-xs transition">
                            Pilih Kamar
                        </a>
                    </div>
                </div>

                <!-- Card 2: Jakarta -->
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="relative h-56 bg-stone-100 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=600&q=80" alt="Jakarta Hotel" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-black text-stone-900 mb-1 font-serif">Jakarta</h3>
                            <p class="text-xs text-stone-500 mb-4">Hotel strategis di pusat kota & bisnis</p>
                        </div>
                    </div>
                    <div class="p-6 pt-0 flex items-center justify-between border-t border-stone-100">
                        <span class="text-xs font-bold text-stone-400">Mulai Rp {{ number_format($deluxePrice, 0, ',', '.') }}</span>
                        <a href="{{ route('rooms.index') }}" class="px-4 py-2 rounded-full bg-stone-900 hover:bg-[#8a6225] text-white font-extrabold text-xs transition">
                            Pilih Kamar
                        </a>
                    </div>
                </div>

                <!-- Card 3: Yogyakarta -->
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="relative h-56 bg-stone-100 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=600&q=80" alt="Yogyakarta Villa" class="w-full h-full object-cover">
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full bg-amber-100/90 backdrop-blur-sm text-amber-800 text-[10px] font-extrabold uppercase border border-amber-200">
                                    HEMAT PROMO
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-black text-stone-900 mb-1 font-serif">Yogyakarta</h3>
                            <p class="text-xs text-stone-500 mb-4">Penginapan bernuansa budaya & klasik</p>
                        </div>
                    </div>
                    <div class="p-6 pt-0 flex items-center justify-between border-t border-stone-100">
                        <span class="text-xs font-bold text-stone-400">Mulai Rp {{ number_format($suitePrice, 0, ',', '.') }}</span>
                        <a href="{{ route('rooms.index') }}" class="px-4 py-2 rounded-full bg-stone-900 hover:bg-[#8a6225] text-white font-extrabold text-xs transition">
                            Pilih Kamar
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- SECTION: KENAPA MEMILIH NGINAP? -->
        <div class="mb-16">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h2 class="text-2xl sm:text-3xl font-black text-stone-900 tracking-tight font-serif mb-2">Kenapa Memilih Nginap?</h2>
                <p class="text-xs text-stone-500 leading-relaxed">
                    Kami menyediakan pengalaman pemesanan mudah, transparan, dan terpercaya untuk seluruh kebutuhan menginap Anda.
                </p>
            </div>

            <!-- Asymmetric Cards Grid (Match Stitch Screenshot) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Column: 2 Cards -->
                <div class="space-y-6 flex flex-col justify-between">
                    <!-- Top Card: Gaya Perjalanan -->
                    <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-[#0e261f] text-white flex items-center justify-center text-base mb-4">
                            <i class="fa-solid fa-compass"></i>
                        </div>
                        <h3 class="text-base font-black text-stone-900 mb-2 font-serif">Gaya Perjalanan</h3>
                        <p class="text-xs text-stone-500 leading-relaxed">
                            Pilih tipe kamar yang tepat sesuai tren untuk memberikan liburan berkesan dan kenyamanan penuh saat perjalanan Anda.
                        </p>
                    </div>

                    <!-- Bottom Card: Tanpa Alasan Rumit -->
                    <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-base mb-4">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                        <h3 class="text-base font-black text-stone-900 mb-2 font-serif">Sistem Tanpa Alasan Rumit</h3>
                        <p class="text-xs text-stone-500 leading-relaxed">
                            Penyampaian sistem yang efisien dan transparan menghasilkan proses pemesanan aman dan memuaskan bagi pengguna.
                        </p>
                    </div>
                </div>

                <!-- Right Column: Large Split Card (Transparansi Total + Architecture Photo) -->
                <div class="lg:col-span-2 bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden grid grid-cols-1 md:grid-cols-2">
                    <div class="p-8 flex flex-col justify-between">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-[#0e261f] text-white flex items-center justify-center text-base mb-4">
                                <i class="fa-solid fa-eye"></i>
                            </div>
                            <h3 class="text-xl font-black text-stone-900 mb-2 font-serif">Transparansi Total</h3>
                            <p class="text-xs text-stone-500 leading-relaxed mb-6">
                                Harga yang Anda lihat adalah harga yang Anda bayar. Tanpa biaya tersembunyi, tanpa hambatan saat check-in atau check-out. Semua proses mudah dan terjamin.
                            </p>

                            <ul class="space-y-2.5 text-xs text-stone-700 font-semibold mb-6">
                                <li class="flex items-center gap-2">
                                    <i class="fa-solid fa-check text-emerald-600"></i> Proses pemesanan instan & mudah
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fa-solid fa-check text-emerald-600"></i> Rincian harga transparan & akurat
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fa-solid fa-check text-emerald-600"></i> Jaminan kenyamanan menginap
                                </li>
                            </ul>
                        </div>

                        <a href="{{ route('rooms.index') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-stone-900 hover:bg-[#8a6225] text-white font-extrabold text-xs transition">
                            Booking Kamar Sekarang
                        </a>
                    </div>

                    <!-- Right Side Photo (Modern White Hotel Architecture) -->
                    <div class="relative h-64 md:h-full bg-stone-100">
                        <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=800&q=80" alt="Nginap Modern Architecture" class="w-full h-full object-cover">
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection
