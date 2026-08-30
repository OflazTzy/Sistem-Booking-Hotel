{{-- Halaman Edit Profil Pengguna (Nginap Theme) --}}
@extends('layouts.app')

@section('title', 'Profil Saya - Nginap')

@section('content')

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- Header Title -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl sm:text-4xl font-black text-stone-900 font-serif tracking-tight">Profil Pengguna</h1>
                <p class="text-xs text-stone-500 mt-1">Kelola data pribadi dan informasi akun Nginap Anda</p>
            </div>
            <div>
                <span class="px-4 py-1.5 rounded-full text-xs font-extrabold uppercase border {{ $user->isAdmin() ? 'bg-rose-100 text-rose-800 border-rose-200' : 'bg-emerald-100 text-emerald-800 border-emerald-200' }}">
                    <i class="fa-solid {{ $user->isAdmin() ? 'fa-user-shield' : 'fa-user-check' }} me-1.5"></i>
                    Role: {{ $user->isAdmin() ? 'Administrator' : 'Tamu Terdaftar' }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">

            <!-- Left Profile Card Summary -->
            <div class="md:col-span-4 space-y-6">
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 text-center space-y-4">
                    <div class="w-24 h-24 mx-auto rounded-full bg-stone-900 text-amber-500 font-serif text-3xl font-black flex items-center justify-center border-4 border-amber-600/30 shadow-md">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-stone-900 font-serif">{{ $user->name }}</h2>
                        <p class="text-xs text-stone-400 font-mono">{{ $user->email }}</p>
                    </div>
                    <div class="pt-4 border-t border-stone-100 text-xs text-stone-500 space-y-2 text-left">
                        <div class="flex items-center justify-between">
                            <span class="text-stone-400">No. HP:</span>
                            <span class="font-bold text-stone-800">{{ $user->phone ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-stone-400">No. KTP/SIM:</span>
                            <span class="font-mono font-bold text-stone-800">{{ $user->identity_number ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-stone-400">Terdaftar:</span>
                            <span class="font-mono text-stone-600">{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Edit Profile Form -->
            <div class="md:col-span-8">
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 sm:p-8">
                    <h3 class="text-lg font-black text-stone-900 font-serif mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-user-pen text-amber-700"></i> Edit Informasi Akun
                    </h3>

                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                Nama Lengkap <span class="text-rose-600">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                            @error('name')
                                <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                Alamat Email <span class="text-rose-600">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                            @error('email')
                                <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No. HP / WhatsApp & No. KTP -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    No. Handphone / WA
                                </label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="081234567890" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                @error('phone')
                                    <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    No. Identitas (KTP/SIM)
                                </label>
                                <input type="text" name="identity_number" value="{{ old('identity_number', $user->identity_number) }}" placeholder="3271..." class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                @error('identity_number')
                                    <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Baru (Opsional) -->
                        <div class="pt-4 border-t border-stone-100">
                            <h4 class="text-xs font-black text-stone-900 uppercase tracking-wider mb-3 text-stone-400">Ganti Password (Kosongkan jika tidak diubah)</h4>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-stone-700 mb-1">Password Baru</label>
                                    <input type="password" name="password" placeholder="Minimal 6 karakter" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                    @error('password')
                                        <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-[11px] font-bold text-stone-700 mb-1">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" placeholder="Ulangi password baru" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4 flex items-center justify-end gap-3">
                            <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-full border border-stone-200 text-stone-600 font-bold text-xs hover:bg-stone-50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 rounded-full bg-stone-900 hover:bg-stone-800 text-white font-extrabold text-xs shadow-md transition flex items-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>

    </div>

@endsection
