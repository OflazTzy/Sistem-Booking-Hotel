{{-- Halaman Konfirmasi Booking (Screen 4: Nginap Theme) --}}
@extends('layouts.app')

@section('title', 'Konfirmasi Pemesanan - Nginap')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-stone-900 tracking-tight font-serif flex items-center gap-2">
                    Form Konfirmasi Pemesanan
                </h1>
                <p class="text-xs text-stone-400 mt-1">Lengkapi rincian tanggal, jam check-in & check-out, serta metode pembayaran</p>
            </div>
            <a href="{{ route('rooms.index') }}" class="px-5 py-2.5 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold text-xs transition inline-flex items-center gap-1.5 self-start sm:self-auto">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog Kamar
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Informational Room Summary Card -->
            <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-stone-100">
                        <span class="px-3 py-1 rounded-full bg-stone-900 text-white font-extrabold text-xs">
                            Kamar {{ $room->room_number }}
                        </span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase bg-emerald-100 text-emerald-800 border border-emerald-200">
                            <i class="fa-solid fa-circle text-[6px] text-emerald-500"></i> AVAILABLE
                        </span>
                    </div>

                    <h3 class="text-2xl font-black text-stone-900 mb-1 font-serif">{{ $room->room_type }}</h3>
                    <p class="text-3xl font-black text-[#8a6225] mb-6">
                        Rp {{ number_format($room->price, 0, ',', '.') }} <span class="text-xs font-medium text-stone-400">/ malam</span>
                    </p>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between py-2.5 px-3.5 rounded-2xl bg-[#f7f4ee] border border-stone-200/60">
                            <span class="text-stone-500"><i class="fa-solid fa-clock text-amber-600 me-2"></i> Standar Check-in</span>
                            <span class="font-bold text-stone-800">14:00 WIB</span>
                        </div>
                        <div class="flex items-center justify-between py-2.5 px-3.5 rounded-2xl bg-[#f7f4ee] border border-stone-200/60">
                            <span class="text-stone-500"><i class="fa-solid fa-clock text-rose-500 me-2"></i> Standar Check-out</span>
                            <span class="font-bold text-stone-800">12:00 WIB</span>
                        </div>
                        <div class="flex items-center justify-between py-2.5 px-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800">
                            <span class="text-rose-700 font-bold"><i class="fa-solid fa-circle-exclamation me-1"></i> Denda Late Checkout</span>
                            <span class="font-extrabold">Rp 50.000 / jam</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-stone-100 text-center">
                    <p class="text-[11px] text-stone-400"><i class="fa-solid fa-shield-halved me-1 text-emerald-500"></i> Terproteksi Keamanan Transaksi Nginap</p>
                </div>
            </div>

            <!-- Form Booking Entry -->
            <div class="lg:col-span-2 bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 sm:p-8">

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                        <p class="font-bold flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation text-rose-500"></i> Kesalahan Input Form:</p>
                        <ul class="list-disc list-inside space-y-0.5 opacity-90">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('bookings.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->id }}">

                    <div>
                        <label for="name" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">NAMA TAMU PEMESAN <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required placeholder="Nama lengkap sesuai KTP"
                            class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="identity_number" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">NOMOR KTP / SIM <span class="text-rose-500">*</span></label>
                            <input type="text" id="identity_number" name="identity_number" value="{{ old('identity_number', Auth::user()->identity_number) }}" required placeholder="Nomor KTP"
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                        </div>

                        <div>
                            <label for="phone" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">NOMOR HP / WHATSAPP <span class="text-rose-500">*</span></label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" required placeholder="0812..."
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                        </div>
                    </div>

                    <!-- Tanggal & Waktu Check-in & Check-out Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-3 border-t border-stone-100">
                        <div>
                            <label for="check_in" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">TANGGAL CHECK-IN <span class="text-rose-500">*</span></label>
                            <input type="date" id="check_in" name="check_in" value="{{ old('check_in') }}" min="{{ date('Y-m-d') }}" required
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition mb-2">
                            
                            <label for="check_in_time" class="block text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-1">Jam Check-in</label>
                            <input type="time" id="check_in_time" name="check_in_time" value="{{ old('check_in_time', '14:00') }}" required
                                class="w-full px-4 py-2.5 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                        </div>

                        <div>
                            <label for="check_out" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">TANGGAL CHECK-OUT <span class="text-rose-500">*</span></label>
                            <input type="date" id="check_out" name="check_out" value="{{ old('check_out') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition mb-2">
                            
                            <label for="check_out_time" class="block text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-1">Jam Check-out (Batas: 12:00 WIB)</label>
                            <input type="time" id="check_out_time" name="check_out_time" value="{{ old('check_out_time', '12:00') }}" required
                                class="w-full px-4 py-2.5 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                        </div>
                    </div>

                    <!-- Info Notice Denda Late Checkout -->
                    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex items-start gap-2.5">
                        <i class="fa-solid fa-clock-triangle-exclamation text-amber-600 text-base mt-0.5"></i>
                        <div>
                            <p class="font-bold">Ketentuan Jam Check-out & Denda Keterlambatan:</p>
                            <p class="text-[11px] opacity-90 mt-0.5">Batas standar check-out adalah pukul <strong>12:00 WIB</strong>. Jika Anda memilih jam check-out lebih dari jam 12:00 WIB (misal 17:00 atau 18:00 WIB), sistem Nginap secara otomatis menambahkan denda keterlambatan sebesar <strong>Rp 50.000 / jam</strong>.</p>
                        </div>
                    </div>

                    <!-- Pilihan Metode Pembayaran -->
                    <div class="pt-3 border-t border-stone-100">
                        <label class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-3">PILIH METODE PEMBAYARAN <span class="text-rose-500">*</span></label>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Option 1: QRIS Code Online -->
                            <label class="relative flex flex-col p-4 rounded-2xl border-2 border-stone-200 cursor-pointer transition hover:border-amber-700 has-[:checked]:border-amber-700 has-[:checked]:bg-amber-50/40">
                                <input type="radio" name="payment_method" value="qris" {{ old('payment_method', 'qris') === 'qris' ? 'checked' : '' }} class="sr-only">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-extrabold text-stone-900 text-xs flex items-center gap-1.5">
                                        <i class="fa-solid fa-qrcode text-emerald-600"></i> QRIS Code Online
                                    </span>
                                </div>
                                <p class="text-[11px] text-stone-500 leading-relaxed">Bayar instan via QRIS Code (GoPay, OVO, ShopeePay, m-Banking) atau Virtual Account.</p>
                            </label>

                            <!-- Option 2: Cash / Bayar di Tempat -->
                            <label class="relative flex flex-col p-4 rounded-2xl border-2 border-stone-200 cursor-pointer transition hover:border-amber-700 has-[:checked]:border-amber-700 has-[:checked]:bg-amber-50/40">
                                <input type="radio" name="payment_method" value="cash" {{ old('payment_method') === 'cash' ? 'checked' : '' }} class="sr-only">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-extrabold text-stone-900 text-xs flex items-center gap-1.5">
                                        <i class="fa-solid fa-money-bill-wave text-amber-600"></i> Bayar di Tempat
                                    </span>
                                </div>
                                <p class="text-[11px] text-stone-500 leading-relaxed">Bayar secara tunai / cash langsung di meja Resepsionis Nginap saat Check-in.</p>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-stone-100">
                        <button type="submit" class="w-full py-4 px-6 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs shadow-lg transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-circle-check"></i> Konfirmasi Booking Kamar Ini
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

@endsection
