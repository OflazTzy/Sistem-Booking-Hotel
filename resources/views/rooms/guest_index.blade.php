{{-- Partial view untuk Guest Search Results (Stitch Nginap - Search Results) --}}
<!-- Top Search Summary Pill Bar -->
<div class="flex items-center justify-center mb-8">
    <div class="inline-flex items-center space-x-3 bg-white px-5 py-2.5 rounded-full shadow-sm border border-stone-200 text-xs font-bold text-stone-700">
        <span class="text-stone-900"><i class="fa-solid fa-location-dot text-amber-700 me-1"></i> Semua Kamar</span>
        <span class="text-stone-300">|</span>
        <span class="text-stone-600"><i class="fa-regular fa-calendar me-1"></i> {{ date('d M') }} - {{ date('d M', strtotime('+1 day')) }}</span>
        <span class="text-stone-300">|</span>
        <span class="text-stone-600"><i class="fa-solid fa-user me-1"></i> 2 Tamu</span>
        <a href="{{ route('home') }}" class="px-3 py-1 bg-amber-50 text-[#8a6225] rounded-full text-[10px] font-black hover:bg-amber-100 transition uppercase tracking-wider ms-2">
            Ubah
        </a>
    </div>
</div>

<!-- Page Header Title -->
<div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl sm:text-4xl font-black text-stone-900 tracking-tight font-serif">Properti & Kamar Nginap</h1>
        <p class="text-xs text-stone-500 mt-1">Menampilkan {{ $rooms->count() }} hasil pilihan kamar hotel terbaik</p>
    </div>
</div>

<!-- Main 2-Column Layout Grid (Left: Map & Filters, Right: Horizontal Property Cards) -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

    <!-- LEFT COLUMN: MAP PREVIEW & FILTER SIDEBAR -->
    <div class="space-y-6">

        <!-- Map Thumbnail Box (LIHAT PETA) -->
        <div class="relative h-36 rounded-3xl overflow-hidden border border-stone-200/80 shadow-sm bg-stone-200 group">
            <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=400&q=80" alt="Map Preview" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
            <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                <span class="px-4 py-2 rounded-full bg-white/95 backdrop-blur-sm text-stone-900 font-extrabold text-xs shadow-lg flex items-center gap-1.5 cursor-pointer hover:bg-white transition">
                    <i class="fa-solid fa-map-location-dot text-amber-700"></i> LIHAT PETA
                </span>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 space-y-6">
            <div class="flex items-center justify-between border-b border-stone-100 pb-3">
                <h3 class="text-lg font-black text-stone-900 font-serif">Filter</h3>
                <a href="{{ route('rooms.index') }}" class="text-[11px] font-bold text-amber-700 hover:underline">Reset</a>
            </div>

            <form action="{{ route('rooms.index') }}" method="GET" class="space-y-6">
                <!-- Filter: Tipe Kamar -->
                <div>
                    <h4 class="text-xs font-bold text-stone-900 mb-3">Tipe Kamar & Harga</h4>
                    <div class="space-y-2 text-xs text-stone-600">
                        <label class="flex items-center space-x-2.5 cursor-pointer">
                            <input type="radio" name="type" value="" onchange="this.form.submit()" {{ !request('type') ? 'checked' : '' }} class="accent-[#8a6225]">
                            <span class="font-semibold">Semua Tipe Kamar</span>
                        </label>
                        @foreach($roomTypes as $type)
                            <label class="flex items-center space-x-2.5 cursor-pointer">
                                <input type="radio" name="type" value="{{ $type }}" onchange="this.form.submit()" {{ request('type') == $type ? 'checked' : '' }} class="accent-[#8a6225]">
                                <span>{{ $type }} Room</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Filter: Urutan Harga -->
                <div>
                    <h4 class="text-xs font-bold text-stone-900 mb-3">Urutan Harga</h4>
                    <select name="sort" onchange="this.form.submit()" class="w-full bg-stone-50 border border-stone-200 rounded-xl px-3 py-2 text-xs font-bold text-stone-800 focus:outline-none focus:border-amber-700">
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Termurah (Ascending)</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Tertinggi (Descending)</option>
                    </select>
                </div>

                <!-- Filter: Bintang -->
                <div class="border-t border-stone-100 pt-4">
                    <h4 class="text-xs font-bold text-stone-900 mb-3">Bintang Hotel</h4>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 rounded-lg bg-stone-100 text-stone-600 text-xs font-bold border cursor-pointer hover:bg-stone-200">3★</span>
                        <span class="px-3 py-1 rounded-lg bg-stone-900 text-white text-xs font-bold shadow cursor-pointer">4★</span>
                        <span class="px-3 py-1 rounded-lg bg-stone-100 text-stone-600 text-xs font-bold border cursor-pointer hover:bg-stone-200">5★</span>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <!-- RIGHT COLUMN: HORIZONTAL PROPERTY TICKET CARDS -->
    <div class="lg:col-span-3 space-y-6">
        @if ($rooms->isEmpty())
            <div class="bg-white rounded-3xl border border-stone-200/80 p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-stone-100 text-stone-400 flex items-center justify-center text-3xl">
                    <i class="fa-solid fa-inbox"></i>
                </div>
                <h3 class="text-lg font-bold text-stone-700 mb-1 font-serif">Tidak Ada Kamar Ditemukan</h3>
                <p class="text-xs text-stone-400">Silakan ubah kriteria filter pencarian Anda.</p>
            </div>
        @else
            @foreach ($rooms as $room)
                <!-- Horizontal Ticket Card -->
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden grid grid-cols-1 md:grid-cols-12 hover:shadow-md transition">
                    
                    <!-- Left Column: Image with Status Badge (4 cols) -->
                    <div class="md:col-span-4 relative h-48 md:h-full bg-stone-100">
                        <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=600&q=80" alt="{{ $room->room_type }}" class="w-full h-full object-cover">
                        
                        <div class="absolute top-3 left-3">
                            @if ($room->status === 'available')
                                <span class="px-3 py-1 rounded-md bg-emerald-100/90 backdrop-blur-sm text-emerald-800 font-extrabold text-[10px] uppercase border border-emerald-200">
                                    AVAILABLE
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-md bg-rose-100/90 backdrop-blur-sm text-rose-800 font-extrabold text-[10px] uppercase border border-rose-200">
                                    OCCUPIED
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Middle Column: Info & Details (5 cols) -->
                    <div class="md:col-span-5 p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="px-2.5 py-0.5 rounded-md bg-stone-100 text-stone-800 font-extrabold text-[11px] border border-stone-200">
                                    Kamar {{ $room->room_number }}
                                </span>
                            </div>
                            <h3 class="text-xl font-black text-stone-900 mb-1 font-serif">
                                {{ $room->room_type }} Suite
                            </h3>
                            <p class="text-xs text-stone-500 mb-3 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-amber-700"></i> Nginap Hotel Utama &bull; Pusat Kota
                            </p>
                            <p class="text-xs text-stone-500 leading-relaxed line-clamp-2">
                                Kamar elegan dengan pemandangan indah, AC split, LED TV, Wi-Fi kecepatan tinggi, serta kamar mandi air hangat.
                            </p>
                        </div>

                        <div class="flex items-center space-x-3 text-xs text-stone-400 pt-3 border-t border-stone-100 mt-4">
                            <span><i class="fa-solid fa-wifi text-stone-400 me-1"></i> Free Wi-Fi</span>
                            <span><i class="fa-solid fa-utensils text-stone-400 me-1"></i> Breakfast</span>
                        </div>
                    </div>

                    <!-- Right Column: Price & Action Pill Button (3 cols) -->
                    <div class="md:col-span-3 p-6 bg-stone-50/50 md:border-l md:border-dashed border-stone-200 flex flex-col justify-between items-end text-right">
                        <div class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-bold border border-amber-200 inline-flex items-center gap-1">
                            <i class="fa-solid fa-star text-amber-500 text-[10px]"></i> 4.8
                        </div>

                        <div class="my-4">
                            <span class="text-[10px] text-stone-400 font-bold block uppercase">Mulai dari</span>
                            <strong class="text-xl font-black text-stone-900 block">Rp {{ number_format($room->price, 0, ',', '.') }}</strong>
                            <span class="text-[10px] text-stone-400 block">/ malam</span>
                        </div>

                        <div class="w-full">
                            @if($room->isAvailable())
                                <a href="{{ route('rooms.show', $room) }}" class="w-full block py-2.5 px-4 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs text-center shadow transition">
                                    LIHAT KAMAR
                                </a>
                            @else
                                <button disabled class="w-full py-2.5 px-4 rounded-full bg-stone-200 text-stone-400 font-bold text-xs cursor-not-allowed">
                                    TERISI
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        @endif
    </div>

</div>
