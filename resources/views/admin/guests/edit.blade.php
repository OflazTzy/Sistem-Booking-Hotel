{{-- Form Edit Data Tamu (Admin Portal Theme) --}}
@extends('layouts.app')

@section('title', 'Nginap Admin - Edit Akun Tamu: ' . $user->name)

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- LEFT DARK GREEN SIDEBAR -->
            <div class="lg:col-span-3">
                @include('admin.sidebar')
            </div>

            <!-- RIGHT MAIN CONTENT: FORM EDIT TAMU -->
            <div class="lg:col-span-9 space-y-6">

                <!-- Header Title -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-black text-stone-900 font-serif tracking-tight">Edit Data Akun Tamu</h1>
                        <p class="text-xs text-stone-400 mt-1">Perbarui profil biodata tamu {{ $user->name }} ({{ $user->email }}).</p>
                    </div>

                    <a href="{{ route('admin.guests.index') }}" class="px-4 py-2 rounded-full border border-stone-300 text-stone-700 font-bold text-xs hover:bg-stone-50 transition">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 sm:p-8">
                    <form action="{{ route('admin.guests.update', $user) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nama Lengkap & Email -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Nama Lengkap Tamu <span class="text-rose-600">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                @error('name')
                                    <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Alamat Email <span class="text-rose-600">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                @error('email')
                                    <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- KTP & Phone -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Nomor KTP / SIM
                                </label>
                                <input type="text" name="identity_number" value="{{ old('identity_number', $user->identity_number) }}" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Nomor Telepon / WA
                                </label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                            </div>
                        </div>

                        <!-- Password Baru (Opsional) -->
                        <div class="pt-4 border-t border-stone-100">
                            <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                Password Baru (Opsional)
                            </label>
                            <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                            <span class="text-[10px] text-stone-400 mt-1 block">Minimal 6 karakter jika ingin mengganti password tamu.</span>
                            @error('password')
                                <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6 flex items-center justify-end gap-3 border-t border-stone-100">
                            <a href="{{ route('admin.guests.index') }}" class="px-6 py-3 rounded-full border border-stone-200 text-stone-600 font-bold text-xs hover:bg-stone-50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs shadow-md transition flex items-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Tamu
                            </button>
                        </div>

                    </form>
                </div>

            </div>

        </div>

    </div>

@endsection
