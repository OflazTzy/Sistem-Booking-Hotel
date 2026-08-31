{{-- Halaman Daftar Kamar & Kelola Properti Admin (100% Persis Screenshot Stitch Admin Kelola Properti) --}}
@extends('layouts.app')

@section('title', Auth::check() && Auth::user()->isAdmin() ? 'Nginap Admin - Kelola Properti' : 'Properti & Kamar - Nginap')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        @auth
            @if(Auth::user()->isAdmin())
                <!-- ADMIN VIEW: KELOLA PROPERTI DASHBOARD (Match Image 2) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    <!-- LEFT DARK GREEN SIDEBAR MENU -->
                    <div class="lg:col-span-3">
                        @include('admin.sidebar')
                    </div>

                    <!-- RIGHT MAIN CONTENT: KELOLA PROPERTI TABLE -->
                    <div class="lg:col-span-9 space-y-6">

                        <!-- Header Title & Add Button -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h1 class="text-3xl sm:text-4xl font-black text-stone-900 font-serif tracking-tight">Properti</h1>
                                <p class="text-xs text-stone-400 mt-1">Kelola daftar kamar dan properti Anda.</p>
                            </div>

                            <a href="{{ route('rooms.create') }}" class="px-6 py-3 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs shadow-lg transition flex items-center gap-2">
                                <i class="fa-solid fa-plus"></i> TAMBAH PROPERTI
                            </a>
                        </div>

                        <!-- Filter & Search Control Bar (Match Image 2) -->
                        <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-4 flex flex-col sm:flex-row items-center justify-between gap-3">
                            <!-- Search Field -->
                            <div class="relative w-full sm:w-72">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400 text-xs">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <input type="text" placeholder="Cari nama properti..." class="w-full pl-10 pr-4 py-2 bg-stone-50 border border-stone-200 rounded-full text-xs font-semibold text-stone-800 focus:outline-none focus:border-amber-700">
                            </div>

                            <!-- Filter Dropdowns -->
                            <div class="flex flex-wrap items-center gap-2 text-xs">
                                <select class="bg-stone-50 border border-stone-200 rounded-full px-3 py-2 text-xs font-bold text-stone-700 focus:outline-none">
                                    <option value="">Status: Semua</option>
                                    <option value="available">Available</option>
                                    <option value="occupied">Occupied</option>
                                </select>

                                <select class="bg-stone-50 border border-stone-200 rounded-full px-3 py-2 text-xs font-bold text-stone-700 focus:outline-none">
                                    <option value="">Tipe: Semua</option>
                                    <option value="Standard">Standard</option>
                                    <option value="Deluxe">Deluxe</option>
                                    <option value="Suite">Suite</option>
                                </select>

                                <button class="px-4 py-2 rounded-full border border-stone-200 text-stone-700 font-bold hover:bg-stone-50 transition">
                                    Filter Lanjutan
                                </button>
                            </div>
                        </div>

                        <!-- Table Properti / Kamar (Match Image 2) -->
                        <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden p-6 space-y-6">
                            @if ($rooms->isEmpty())
                                <div class="text-center py-12 text-stone-400 text-xs">Belum ada kamar terdaftar.</div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left text-xs text-stone-600">
                                        <thead class="border-b border-stone-200 uppercase tracking-wider font-extrabold text-[10px] text-stone-400">
                                            <tr>
                                                <th class="py-3 px-4">NAMA PROPERTI / KAMAR</th>
                                                <th class="py-3 px-4">TIPE</th>
                                                <th class="py-3 px-4 text-right">HARGA DASAR</th>
                                                <th class="py-3 px-4 text-center">STATUS</th>
                                                <th class="py-3 px-4 text-center">AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-stone-100 font-medium">
                                            @foreach ($rooms as $room)
                                                <tr class="hover:bg-stone-50 transition">
                                                    <!-- Property Name & Thumbnail -->
                                                    <td class="py-4 px-4">
                                                        <div class="flex items-center space-x-3">
                                                            <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=100&q=80" alt="Thumbnail" class="w-12 h-10 rounded-xl object-cover border border-stone-200">
                                                            <div>
                                                                <strong class="text-stone-900 font-bold text-sm block font-serif">Kamar {{ $room->room_number }} &bull; {{ $room->room_type }}</strong>
                                                                <span class="text-stone-400 text-[11px]">Nginap Hotel Utama &bull; Indonesia</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <!-- Type Badge -->
                                                    <td class="py-4 px-4">
                                                        <span class="px-2.5 py-1 rounded-md bg-stone-100 text-stone-800 text-[10px] font-extrabold uppercase border border-stone-200">
                                                            {{ strtoupper($room->room_type) }}
                                                        </span>
                                                    </td>

                                                    <!-- Price Base -->
                                                    <td class="py-4 px-4 text-right font-black text-stone-900">
                                                        Rp {{ number_format($room->price, 0, ',', '.') }}
                                                    </td>

                                                    <!-- Status Badge / Toggle -->
                                                    <td class="py-4 px-4 text-center">
                                                        @if($room->status === 'available')
                                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase border border-emerald-200">
                                                                <i class="fa-solid fa-circle text-[6px] text-emerald-500"></i> Available
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-rose-100 text-rose-800 font-extrabold text-[10px] uppercase border border-rose-200">
                                                                <i class="fa-solid fa-circle text-[6px] text-rose-500"></i> Occupied
                                                            </span>
                                                        @endif
                                                    </td>

                                                    <!-- Action Controls (Edit / Delete) -->
                                                    <td class="py-4 px-4 text-center">
                                                        <div class="inline-flex items-center space-x-2">
                                                            <a href="{{ route('rooms.edit', $room) }}" class="p-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs transition" title="Edit Kamar">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                                            <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="inline" onsubmit="confirmAction(event, 'Hapus Kamar?', 'Apakah Anda yakin ingin menghapus kamar {{ $room->room_number }} dari database?', 'Ya, Hapus!');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs transition" title="Hapus Kamar">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            <!-- Bottom Pagination Footer -->
                            <div class="flex items-center justify-between text-xs text-stone-400 pt-4 border-t border-stone-100">
                                <span>Menampilkan 1-{{ $rooms->count() }} dari {{ $rooms->count() }} properti</span>
                                <div class="flex items-center space-x-1">
                                    <button disabled class="p-1 px-2 rounded-lg bg-stone-100 text-stone-400 cursor-not-allowed text-xs">&lt;</button>
                                    <button disabled class="p-1 px-2 rounded-lg bg-stone-100 text-stone-400 cursor-not-allowed text-xs">&gt;</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            @else
                <!-- GUEST VIEW: SEARCH RESULTS LAYOUT -->
                @include('rooms.guest_index')
            @endif
        @else
            <!-- GUEST VIEW: SEARCH RESULTS LAYOUT -->
            @include('rooms.guest_index')
        @endauth

    </div>

@endsection
