{{-- Form Tambah Tamu Baru (Admin Portal Theme) --}}
@extends('layouts.app')

@section('title', 'Nginap Admin - Tambah Tamu Baru')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- LEFT DARK GREEN SIDEBAR -->
            <div class="lg:col-span-3">
                @include('admin.sidebar')
            </div>

            <!-- RIGHT MAIN CONTENT: FORM TAMBAH TAMU -->
            <div class="lg:col-span-9 space-y-6">

                <!-- Header Title -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-black text-stone-900 font-serif tracking-tight">Tambah Tamu Baru</h1>
                        <p class="text-xs text-stone-400 mt-1">Daftarkan data tamu baru ke dalam sistem Nginap</p>
                    </div>
                    <a href="{{ route('admin.guests.index') }}" class="px-4 py-2 rounded-full border border-stone-300 text-stone-700 font-bold text-xs hover:bg-stone-50 transition">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 sm:p-8">
                    <form action="{{ route('admin.guests.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                Nama Lengkap Tamu <span class="text-rose-600">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                            @error('name')
                                <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                Alamat Email <span class="text-rose-600">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh: budi@gmail.com" required class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                            @error('email')
                                <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No. KTP/SIM & No. HP -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Nomor KTP / SIM <span class="text-rose-600">*</span>
                                </label>
                                <input type="text" name="identity_number" value="{{ old('identity_number') }}" placeholder="3271..." required class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                @error('identity_number')
                                    <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Nomor HP / WhatsApp <span class="text-rose-600">*</span>
                                </label>
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="081234567890" required class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                @error('phone')
                                    <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Password & Konfirmasi Password -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-stone-100">
                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Password Akses <span class="text-rose-600">*</span>
                                </label>
                                <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                @error('password')
                                    <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Konfirmasi Password <span class="text-rose-600">*</span>
                                </label>
                                <input type="password" name="password_confirmation" required placeholder="Ulangi password" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="pt-4 flex items-center justify-end gap-3">
                            <a href="{{ route('admin.guests.index') }}" class="px-6 py-3 rounded-full border border-stone-200 text-stone-600 font-bold text-xs hover:bg-stone-50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 rounded-full bg-stone-900 hover:bg-stone-800 text-white font-extrabold text-xs shadow-md transition flex items-center gap-2">
                                <i class="fa-solid fa-user-plus"></i> Simpan Tamu Baru
                            </button>
                        </div>

                    </form>
                </div>

            </div>

        </div>

    </div>

@endsection
