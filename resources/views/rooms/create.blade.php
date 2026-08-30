{{-- Halaman Form Tambah Kamar Baru (Admin Dark Sidebar Theme) --}}
@extends('layouts.app')

@section('title', 'Tambah Kamar Baru - Nginap Admin')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- LEFT DARK GREEN SIDEBAR -->
            <div class="lg:col-span-3">
                @include('admin.sidebar')
            </div>

            <!-- RIGHT MAIN CONTENT: CREATE ROOM FORM -->
            <div class="lg:col-span-9 space-y-6">

                <!-- Header Title -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-stone-900 font-serif tracking-tight">Tambah Kamar Baru</h1>
                        <p class="text-xs text-stone-400 mt-1">Masukkan data kamar hotel baru untuk ditambahkan ke daftar katalog</p>
                    </div>

                    <a href="{{ route('rooms.index') }}" class="px-5 py-2.5 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold text-xs transition inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Properti
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

                    <form action="{{ route('rooms.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="room_number" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">NOMOR KAMAR <span class="text-rose-500">*</span></label>
                            <input type="text" id="room_number" name="room_number" value="{{ old('room_number') }}" required placeholder="Contoh: 101, 102, 201"
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                        </div>

                        <div>
                            <label for="room_type" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">TIPE KAMAR <span class="text-rose-500">*</span></label>
                            <select id="room_type" name="room_type" required class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                                <option value="">-- Pilih Tipe Kamar --</option>
                                @foreach($roomTypes as $type)
                                    <option value="{{ $type }}" {{ old('room_type') == $type ? 'selected' : '' }}>
                                        {{ $type }} Room
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="price" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">HARGA PER MALAM (RP) <span class="text-rose-500">*</span></label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" required min="0" step="10000" placeholder="450000"
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                        </div>

                        <div>
                            <label for="status" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">STATUS KETERSEDIAAN <span class="text-rose-500">*</span></label>
                            <select id="status" name="status" required class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available (Tersedia)</option>
                                <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Occupied (Terisi / Terpesan)</option>
                            </select>
                        </div>

                        <div class="pt-4 border-t border-stone-100">
                            <button type="submit" class="w-full py-3.5 px-6 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs shadow-lg transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-plus"></i> Simpan Data Kamar Baru
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>

@endsection
