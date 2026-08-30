{{-- Halaman Form Tambah Admin Baru (Admin Dark Sidebar Theme) --}}
@extends('layouts.app')

@section('title', 'Tambah Admin Baru - Nginap Admin')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- LEFT DARK GREEN SIDEBAR -->
            <div class="lg:col-span-3">
                @include('admin.sidebar')
            </div>

            <!-- RIGHT MAIN CONTENT: CREATE ADMIN FORM -->
            <div class="lg:col-span-9 space-y-6">

                <!-- Header Title -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-stone-900 font-serif tracking-tight">Tambah Administrator Baru</h1>
                        <p class="text-xs text-stone-400 mt-1">Buat akun pengelola baru dengan akses Administrator Nginap</p>
                    </div>

                    <a href="{{ route('admin.admins.index') }}" class="px-5 py-2.5 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold text-xs transition inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Admin
                    </a>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 sm:p-8 max-w-2xl">

                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                            <p class="font-bold flex items-center gap-2"><i class="fa-solid fa-circle-xmark text-rose-600"></i> Terdapat Kesalahan Input:</p>
                            <ul class="list-disc list-inside space-y-0.5 opacity-90">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.admins.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="name" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">NAMA ADMINISTRATOR <span class="text-rose-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Nama lengkap admin"
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                        </div>

                        <div>
                            <label for="email" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">ALAMAT EMAIL <span class="text-rose-500">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="adminbaru@hotel.com"
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="identity_number" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">NOMOR KTP/SIM (Opsional)</label>
                                <input type="text" id="identity_number" name="identity_number" value="{{ old('identity_number') }}" placeholder="3201..."
                                    class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                            </div>

                            <div>
                                <label for="phone" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">NOMOR HP/WA (Opsional)</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="0812..."
                                    class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">PASSWORD <span class="text-rose-500">*</span></label>
                                <input type="password" id="password" name="password" required placeholder="••••••••"
                                    class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">KONFIRMASI PASSWORD <span class="text-rose-500">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••"
                                    class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                            </div>
                        </div>

                        <div class="pt-4 border-t border-stone-100">
                            <button type="submit" class="w-full py-3.5 px-6 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs shadow-lg transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-user-shield"></i> Simpan Account Administrator
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>

@endsection
