{{-- Halaman Login (Nginap Split Screen Theme + OTP 2FA Modal) --}}
@extends('layouts.app')

@section('title', 'Masuk - Nginap')

@section('content')

    <div class="max-w-4xl mx-auto bg-white rounded-3xl border border-stone-200/80 shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2 my-8"
         x-data="{ showOtpModal: {{ session('show_otp_modal') ? 'true' : 'false' }} }">

        <!-- Left Column: Nginap Dark Brand Photo Banner -->
        <div class="relative hidden md:flex flex-col justify-between p-8 bg-[#0e261f] text-white overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-black/80 via-[#0e261f]/90 to-black/80 z-10"></div>
            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80" alt="Nginap Hotel" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-40 scale-105">

            <div class="relative z-20">
                <span class="text-3xl font-black tracking-tight text-white block">Nginap<span class="text-[#8a6225]">.</span></span>
            </div>

            <div class="relative z-20 space-y-3">
                <span class="px-3.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/10 text-stone-200 border border-white/20">
                    PLATFORM BOOKING HOTEL OFFICIAL
                </span>
                <h2 class="text-2xl font-black leading-tight text-white font-serif">
                    Pengalaman Menginap Mewah & Nyaman Untuk Anda
                </h2>
                <p class="text-xs text-stone-300 leading-relaxed font-normal">
                    Masuk ke akun Anda untuk melanjutkan reservasi kamar, memverifikasi pembayaran QRIS, atau mencetak kuitansi PDF resmi.
                </p>
            </div>

            <div class="relative z-20 text-[11px] text-stone-400">
                <p><i class="fa-solid fa-shield-halved text-emerald-400 me-1.5"></i> Keamanan Terproteksi OTP 2FA Email</p>
            </div>
        </div>

        <!-- Right Column: Login Form -->
        <div class="p-6 sm:p-10 flex flex-col justify-center bg-white">

            <div class="mb-6">
                <h2 class="text-2xl font-black text-stone-900 tracking-tight font-serif">Masuk ke Akun</h2>
                <p class="text-xs text-stone-400 mt-1">Silakan masukkan email dan password terdaftar Anda</p>
            </div>

            @if (session('success'))
                <div class="mb-4 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                    <p class="font-bold flex items-center gap-1.5"><i class="fa-solid fa-circle-xmark text-rose-600"></i> Terjadi Kesalahan:</p>
                    <ul class="list-disc list-inside space-y-0.5 opacity-90">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Login Email & Password -->
            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-2">ALAMAT EMAIL <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400 text-xs">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com"
                            class="w-full pl-10 pr-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-2">PASSWORD <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400 text-xs">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" required placeholder="••••••••"
                            class="w-full pl-10 pr-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                    </div>
                </div>

                <!-- Tombol Submit Solid Warna Coklat Olive / Dark Green (Stitch Style) -->
                <div class="pt-3">
                    <button type="submit" class="w-full py-3.5 px-6 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs shadow-lg transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-right-to-bracket"></i> Masuk Sekarang
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-stone-100 text-center">
                <p class="text-xs text-stone-500">Belum memiliki akun Nginap? 
                    <a href="{{ route('register') }}" class="font-extrabold text-[#8a6225] hover:underline">Daftar Akun Baru</a>
                </p>
            </div>

        </div>

        <!-- MODAL VERIFIKASI OTP 2FA ADMIN (Alpine.js) -->
        <div x-show="showOtpModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm" style="display: none;">
            <div class="bg-white max-w-md w-full rounded-3xl border border-stone-200 shadow-2xl p-6 relative text-stone-800">
                <div class="text-center mb-6">
                    <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-amber-50 text-[#8a6225] flex items-center justify-center text-2xl shadow-sm border border-amber-200">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="text-xl font-black text-stone-900 font-serif">Verifikasi OTP 2FA Admin</h3>
                    <p class="text-xs text-stone-500 mt-1">Kode OTP 6-digit telah dikirimkan ke email Gmail Anda.</p>
                </div>

                <form action="{{ route('otp.verify') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="otp_code" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2 text-center">Masukkan Kode OTP 6-Digit</label>
                        <input type="text" id="otp_code" name="otp_code" maxlength="6" required autofocus placeholder="123456"
                            class="w-full text-center text-2xl font-mono font-black tracking-widest px-4 py-3 bg-stone-50 border border-stone-300 rounded-2xl text-[#8a6225] focus:outline-none focus:border-amber-700 transition">
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs shadow-lg transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-circle-check"></i> Verifikasi OTP & Masuk
                    </button>
                </form>
            </div>
        </div>

    </div>

@endsection
