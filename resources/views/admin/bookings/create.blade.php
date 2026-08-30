{{-- Form Pemesanan Offline Resepsionis (Belikan Tiket Tamu Offline) --}}
@extends('layouts.app')

@section('title', 'Nginap Admin - Pemesanan Offline Resepsionis')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- LEFT DARK GREEN SIDEBAR -->
            <div class="lg:col-span-3">
                @include('admin.sidebar')
            </div>

            <!-- RIGHT MAIN CONTENT: FORM OFFLINE BOOKING -->
            <div class="lg:col-span-9 space-y-6">

                <!-- Header Title -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-black text-stone-900 font-serif tracking-tight">Pemesanan Offline Resepsionis</h1>
                        <p class="text-xs text-stone-400 mt-1">Terbitkan tiket/kuitansi reservasi langsung atas nama tamu offline</p>
                    </div>
                    <a href="{{ route('bookings.index') }}" class="px-4 py-2 rounded-full border border-stone-300 text-stone-700 font-bold text-xs hover:bg-stone-50 transition">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 sm:p-8" x-data="{ guestOption: '{{ old('guest_option', 'new') }}' }">
                    <form action="{{ route('admin.bookings.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Opsi Tamu: Tamu Terdaftar vs Tamu Baru/Baru Datang -->
                        <div>
                            <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-3">
                                Pilih Data Tamu <span class="text-rose-600">*</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label class="flex items-center space-x-3 p-4 rounded-2xl border cursor-pointer transition" :class="guestOption === 'new' ? 'bg-amber-50/60 border-amber-600/80 text-amber-900' : 'bg-stone-50 border-stone-200 text-stone-700'">
                                    <input type="radio" name="guest_option" value="new" x-model="guestOption" class="accent-[#8a6225]">
                                    <div>
                                        <strong class="text-xs block font-bold">Tamu Baru / Offline</strong>
                                        <span class="text-[11px] text-stone-400">Input biodata tamu baru secara langsung</span>
                                    </div>
                                </label>

                                <label class="flex items-center space-x-3 p-4 rounded-2xl border cursor-pointer transition" :class="guestOption === 'existing' ? 'bg-amber-50/60 border-amber-600/80 text-amber-900' : 'bg-stone-50 border-stone-200 text-stone-700'">
                                    <input type="radio" name="guest_option" value="existing" x-model="guestOption" class="accent-[#8a6225]">
                                    <div>
                                        <strong class="text-xs block font-bold">Pilih Tamu Terdaftar</strong>
                                        <span class="text-[11px] text-stone-400">Pilih dari daftar database tamu terdaftar</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Panel Tamu Terdaftar (Jika Pilih Existing) -->
                        <div x-show="guestOption === 'existing'" class="p-4 bg-stone-50 rounded-2xl border border-stone-200 space-y-3">
                            <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider">
                                Cari Nama Tamu Terdaftar
                            </label>
                            <select name="guest_id" class="w-full bg-white border border-stone-200 rounded-xl px-4 py-3 text-xs font-bold text-stone-900 focus:outline-none focus:border-amber-700">
                                <option value="">-- Pilih Tamu --</option>
                                @foreach($guests as $guest)
                                    <option value="{{ $guest->id }}" {{ old('guest_id') == $guest->id ? 'selected' : '' }}>
                                        {{ $guest->name }} ({{ $guest->email }} - KTP: {{ $guest->identity_number ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('guest_id')
                                <p class="text-rose-600 text-[11px] font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Panel Input Biodata Tamu Baru (Jika Pilih New) -->
                        <div x-show="guestOption === 'new'" class="space-y-4 pt-2">
                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-1">
                                    Nama Lengkap Tamu <span class="text-rose-600">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Rina Wijaya" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                @error('name')
                                    <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-1">
                                    Email Tamu <span class="text-rose-600">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh: rina@gmail.com" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                @error('email')
                                    <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-1">
                                        No. KTP / SIM <span class="text-rose-600">*</span>
                                    </label>
                                    <input type="text" name="identity_number" value="{{ old('identity_number') }}" placeholder="3271..." class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                    @error('identity_number')
                                        <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-1">
                                        No. Handphone / WA <span class="text-rose-600">*</span>
                                    </label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="081234567890" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                    @error('phone')
                                        <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Pilih Kamar Yang Tersedia -->
                        <div class="pt-4 border-t border-stone-100 space-y-3">
                            <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider">
                                Pilih Kamar Yang Tersedia <span class="text-rose-600">*</span>
                            </label>
                            @if($rooms->isEmpty())
                                <p class="text-xs text-rose-600 font-bold bg-rose-50 p-3 rounded-xl border border-rose-200">
                                    Maaf, tidak ada kamar yang berstatus tersedia saat ini. Silakan tambah atau ubah status kamar di menu Properti/Kamar.
                                </p>
                            @else
                                <select name="room_id" required class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-bold text-stone-900 focus:outline-none focus:border-amber-700">
                                    <option value="">-- Pilih Kamar --</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            Kamar {{ $room->room_number }} ({{ $room->room_type }}) — Rp {{ number_format($room->price, 0, ',', '.') }} / malam
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            @error('room_id')
                                <p class="text-rose-600 text-[11px] font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Check-in & Check-out -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Tanggal Check-in <span class="text-rose-600">*</span>
                                </label>
                                <input type="date" name="check_in" value="{{ old('check_in', date('Y-m-d')) }}" required class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                @error('check_in')
                                    <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Tanggal Check-out <span class="text-rose-600">*</span>
                                </label>
                                <input type="date" name="check_out" value="{{ old('check_out', date('Y-m-d', strtotime('+1 day'))) }}" required class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                @error('check_out')
                                    <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Metode Pembayaran Offline -->
                        <div>
                            <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                Metode Pembayaran Di Resepsionis <span class="text-rose-600">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="flex items-center space-x-2.5 p-3 bg-stone-50 border border-stone-200 rounded-2xl cursor-pointer">
                                    <input type="radio" name="payment_method" value="cash" checked class="accent-[#8a6225]">
                                    <span class="text-xs font-bold text-stone-800">Tunai / Cash</span>
                                </label>
                                <label class="flex items-center space-x-2.5 p-3 bg-stone-50 border border-stone-200 rounded-2xl cursor-pointer">
                                    <input type="radio" name="payment_method" value="qris" class="accent-[#8a6225]">
                                    <span class="text-xs font-bold text-stone-800">QRIS / Non-Tunai</span>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4 flex items-center justify-end gap-3">
                            <a href="{{ route('bookings.index') }}" class="px-6 py-3 rounded-full border border-stone-200 text-stone-600 font-bold text-xs hover:bg-stone-50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs shadow-md transition flex items-center gap-2">
                                <i class="fa-solid fa-receipt"></i> Terbitkan Tiket Offline
                            </button>
                        </div>

                    </form>
                </div>

            </div>

        </div>

    </div>

@endsection
