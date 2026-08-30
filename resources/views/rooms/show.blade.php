{{-- Halaman Detail Kamar / Hotel (100% Persis Screenshot Stitch Screen 3: Nginap - Hotel Detail) --}}
@extends('layouts.app')

@section('title', 'Kamar ' . $room->room_number . ' - Nginap')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-10">

        <!-- 1. TOP PHOTO GALLERY GRID (5 Asymmetric Photo Grid - Match Screen 3) -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            
            <!-- Left Big Main Resort Photo (7 Cols) -->
            <div class="md:col-span-6 h-72 sm:h-96 rounded-3xl overflow-hidden shadow-sm border border-stone-200/80 group">
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1000&q=80" alt="Resort Pool" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            </div>

            <!-- Right 4 Grid Interior Photos (6 Cols 2x2 Grid) -->
            <div class="md:col-span-6 grid grid-cols-2 gap-4 h-72 sm:h-96">
                <div class="rounded-3xl overflow-hidden shadow-sm border border-stone-200/80 group">
                    <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=600&q=80" alt="Bedroom View" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="rounded-3xl overflow-hidden shadow-sm border border-stone-200/80 group">
                    <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=600&q=80" alt="Bed Linen" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="rounded-3xl overflow-hidden shadow-sm border border-stone-200/80 group">
                    <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=600&q=80" alt="Bathroom Tub" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="rounded-3xl overflow-hidden shadow-sm border border-stone-200/80 group">
                    <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=600&q=80" alt="Balcony Resort" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
            </div>

        </div>

        <!-- 2. MAIN CONTENT GRID (Left Details & Right Sticky Booking Card - Match Screen 3) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- LEFT COLUMN: HOTEL HEADER INFO & POPULAR FACILITIES (8 Cols) -->
            <div class="lg:col-span-8 space-y-8">
                
                <div>
                    <!-- Badge & Star Rating -->
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-md bg-amber-100 text-amber-800 font-extrabold text-[10px] uppercase tracking-wider border border-amber-200">
                            HOTEL
                        </span>
                        <div class="flex items-center text-amber-500 text-xs">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>

                    <!-- Hotel / Room Title -->
                    <h1 class="text-3xl sm:text-4xl font-black text-stone-900 font-serif tracking-tight mb-2">
                        The Azure Retreat & Spa
                    </h1>
                    <p class="text-xs text-stone-500 flex items-center gap-1.5">
                        <i class="fa-solid fa-location-dot text-amber-700"></i> Kamar {{ $room->room_number }} &bull; Ubud, Bali, Indonesia
                    </p>
                </div>

                <!-- Fasilitas Populer Section (Match Screen 3) -->
                <div class="space-y-4 pt-4 border-t border-stone-200/80">
                    <h3 class="text-xl font-black text-stone-900 font-serif">Fasilitas Populer</h3>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                        <div class="bg-white p-4 rounded-2xl border border-stone-200/80 shadow-sm text-center space-y-2 hover:border-amber-700 transition">
                            <div class="w-8 h-8 mx-auto rounded-xl bg-amber-50 text-[#8a6225] flex items-center justify-center text-sm">
                                <i class="fa-solid fa-water-ladder"></i>
                            </div>
                            <span class="text-[11px] font-bold text-stone-800 block">Kolam Renang</span>
                        </div>

                        <div class="bg-white p-4 rounded-2xl border border-stone-200/80 shadow-sm text-center space-y-2 hover:border-amber-700 transition">
                            <div class="w-8 h-8 mx-auto rounded-xl bg-amber-50 text-[#8a6225] flex items-center justify-center text-sm">
                                <i class="fa-solid fa-wifi"></i>
                            </div>
                            <span class="text-[11px] font-bold text-stone-800 block">WiFi Gratis</span>
                        </div>

                        <div class="bg-white p-4 rounded-2xl border border-stone-200/80 shadow-sm text-center space-y-2 hover:border-amber-700 transition">
                            <div class="w-8 h-8 mx-auto rounded-xl bg-amber-50 text-[#8a6225] flex items-center justify-center text-sm">
                                <i class="fa-solid fa-utensils"></i>
                            </div>
                            <span class="text-[11px] font-bold text-stone-800 block">Restoran</span>
                        </div>

                        <div class="bg-white p-4 rounded-2xl border border-stone-200/80 shadow-sm text-center space-y-2 hover:border-amber-700 transition">
                            <div class="w-8 h-8 mx-auto rounded-xl bg-amber-50 text-[#8a6225] flex items-center justify-center text-sm">
                                <i class="fa-solid fa-dumbbell"></i>
                            </div>
                            <span class="text-[11px] font-bold text-stone-800 block">Gym</span>
                        </div>

                        <div class="bg-white p-4 rounded-2xl border border-stone-200/80 shadow-sm text-center space-y-2 hover:border-amber-700 transition">
                            <div class="w-8 h-8 mx-auto rounded-xl bg-amber-50 text-[#8a6225] flex items-center justify-center text-sm">
                                <i class="fa-solid fa-spa"></i>
                            </div>
                            <span class="text-[11px] font-bold text-stone-800 block">Spa</span>
                        </div>
                    </div>
                </div>

                <!-- Room Description Text -->
                <div class="space-y-3 pt-4 border-t border-stone-200/80 text-xs text-stone-600 leading-relaxed">
                    <h3 class="text-xl font-black text-stone-900 font-serif">Tentang Kamar Ini</h3>
                    <p>
                        Nikmati pengalaman tinggal mewah dengan suasana alam terbuka yang memukau. Kamar tipe <strong>{{ $room->room_type }}</strong> ini dilengkapi tempat tidur ukuran King, balkon pribadi menghadap kolam renang utama, AC split, LED TV 50 inci, jaringan Wi-Fi kecepatan tinggi, minibar, serta kamar mandi dalam berdesain marmer lengkap dengan *bathtub*.
                    </p>
                </div>

            </div>

            <!-- RIGHT COLUMN: FLOATING STICKY BOOKING CARD (4 Cols - Match Screen 3) -->
            <div class="lg:col-span-4 sticky top-24">
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-lg p-6 space-y-6">
                    
                    <div>
                        <span class="text-xs text-stone-500 font-medium block">Mulai dari</span>
                        <div class="flex items-baseline space-x-1">
                            <strong class="text-2xl font-black text-[#8a6225]">
                                Rp {{ number_format($room->price, 0, ',', '.') }}
                            </strong>
                            <span class="text-xs text-stone-400 font-medium">/ malam</span>
                        </div>
                        <p class="text-[11px] text-stone-400 mt-1">Pesan sekarang untuk mengamankan harga terbaik.</p>
                    </div>

                    <!-- Date Selection Summary Box -->
                    <div class="bg-[#f7f4ee] p-4 rounded-2xl border border-stone-200/60 space-y-3 text-xs">
                        <div class="flex items-center justify-between pb-2 border-b border-stone-200/80">
                            <span class="text-stone-400 font-bold uppercase text-[10px]">CHECK-IN</span>
                            <strong class="text-stone-900 font-bold">{{ date('d M Y') }}</strong>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-stone-400 font-bold uppercase text-[10px]">CHECK-OUT</span>
                            <strong class="text-stone-900 font-bold">{{ date('d M Y', strtotime('+2 days')) }}</strong>
                        </div>
                    </div>

                    <!-- Action Submit Button -->
                    <div>
                        @if($room->isAvailable())
                            <a href="{{ route('bookings.create', $room) }}" class="w-full block py-3.5 px-6 rounded-full bg-stone-900 hover:bg-[#8a6225] text-white font-extrabold text-xs text-center shadow-lg transition">
                                Pesan Sekarang
                            </a>
                        @else
                            <button disabled class="w-full py-3.5 px-6 rounded-full bg-stone-200 text-stone-400 font-bold text-xs cursor-not-allowed text-center">
                                Terisi / Occupied
                            </button>
                        @endif
                    </div>

                    <div class="text-center text-[10px] text-stone-400">
                        <i class="fa-solid fa-shield-halved text-emerald-500 me-1"></i> Garansi Pemesanan Instan Nginap
                    </div>

                </div>
            </div>

        </div>

        <!-- 3. BOTTOM SECTION: PILIHAN KAMAR (Match Screen 3) -->
        <div class="pt-8 border-t border-stone-200/80 space-y-6">
            <h3 class="text-2xl font-black text-stone-900 font-serif">Pilihan Kamar</h3>

            <!-- Horizontal Room Card Container -->
            <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden grid grid-cols-1 md:grid-cols-12 max-w-4xl hover:shadow-md transition">
                
                <!-- Left Thumbnail Photo (4 cols) -->
                <div class="md:col-span-4 h-48 md:h-full bg-stone-100">
                    <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=600&q=80" alt="{{ $room->room_type }}" class="w-full h-full object-cover">
                </div>

                <!-- Middle Info (5 cols) -->
                <div class="md:col-span-5 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center space-x-2 mb-2">
                            <h4 class="text-xl font-black text-stone-900 font-serif">{{ $room->room_type }} Room</h4>
                            <span class="px-2.5 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-extrabold uppercase border border-emerald-200">
                                TERSEDIA
                            </span>
                        </div>

                        <div class="space-y-1.5 text-xs text-stone-500 font-medium">
                            <p class="flex items-center gap-2"><i class="fa-solid fa-bed text-amber-700 w-4"></i> 1 Kasur King</p>
                            <p class="flex items-center gap-2"><i class="fa-solid fa-user-group text-amber-700 w-4"></i> 2 Tamu Dewasa</p>
                        </div>
                    </div>
                </div>

                <!-- Right Price & Action Button (3 cols) -->
                <div class="md:col-span-3 p-6 bg-[#f7f4ee] md:border-l md:border-dashed border-stone-200 flex flex-col justify-between items-center text-center">
                    <div>
                        <strong class="text-lg font-black text-[#8a6225] block">
                            Rp {{ number_format($room->price, 0, ',', '.') }}
                        </strong>
                        <span class="text-[10px] text-stone-400 block font-medium">/ malam</span>
                    </div>

                    @if($room->isAvailable())
                        <a href="{{ route('bookings.create', $room) }}" class="w-full py-2.5 px-4 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs text-center shadow transition">
                            Pilih Kamar
                        </a>
                    @endif
                </div>

            </div>
        </div>

    </div>

@endsection
