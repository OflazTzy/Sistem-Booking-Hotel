{{-- Halaman Register Tamu (Nginap Split Screen Theme + Modal Email OTP) --}}
@extends('layouts.app')

@section('title', 'Daftar Akun Tamu - Nginap')

@section('content')

    <div class="max-w-4xl mx-auto bg-white rounded-3xl border border-stone-200/80 shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2 my-8"
         x-data="{ showRegOtpModal: {{ session('show_reg_otp_modal') ? 'true' : 'false' }} }">

        <!-- Left Column: Nginap Dark Brand Photo Banner -->
        <div class="relative hidden md:flex flex-col justify-between p-8 bg-[#0e261f] text-white overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-black/80 via-[#0e261f]/90 to-black/80 z-10"></div>
            <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=800&q=80" alt="Nginap Luxury Resort" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-40 scale-105">

            <div class="relative z-20">
                <span class="text-3xl font-black tracking-tight text-white block">Nginap<span class="text-[#8a6225]">.</span></span>
            </div>

            <div class="relative z-20 space-y-3">
                <span class="px-3.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/10 text-stone-200 border border-white/20">
                    REGISTRASI AKUN TAMU
                </span>
                <h2 class="text-2xl font-black leading-tight text-white font-serif">
                    Nikmati Kemudahan Booking Kamar dalam Beberapa Klik
                </h2>
                <p class="text-xs text-stone-300 leading-relaxed font-normal">
                    Daftar akun gratis hari ini untuk mendapatkan kemudahan reservasi instant, verifikasi pembayaran QRIS, dan akses invoice resmi.
                </p>
            </div>

            <div class="relative z-20 text-[11px] text-stone-400">
                <p><i class="fa-solid fa-shield-halved text-emerald-400 me-1.5"></i> Verifikasi OTP Email Otomatis</p>
            </div>
        </div>

        <!-- Right Column: Registration Form -->
        <div class="p-6 sm:p-8 flex flex-col justify-center bg-white">

            <div class="mb-6">
                <h2 class="text-2xl font-black text-stone-900 tracking-tight font-serif">Daftar Akun Baru</h2>
                <p class="text-xs text-stone-400 mt-1">Lengkapi form pendaftaran berikut untuk membuat akun</p>
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

            <form action="{{ route('register') }}" method="POST" class="space-y-3.5">
                @csrf

                <div>
                    <label for="name" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1">NAMA LENGKAP <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Budi Santoso"
                        class="w-full px-4 py-2.5 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                </div>

                <div>
                    <label for="email" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1">ALAMAT EMAIL <span class="text-rose-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="budi@email.com"
                        class="w-full px-4 py-2.5 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="identity_number" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1">NO. KTP/SIM <span class="text-rose-500">*</span></label>
                        <input type="text" id="identity_number" name="identity_number" value="{{ old('identity_number') }}" required placeholder="3201..."
                            class="w-full px-4 py-2.5 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                    </div>

                    <div>
                        <label for="phone" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1">NO. HP/WA <span class="text-rose-500">*</span></label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="0812..."
                            class="w-full px-4 py-2.5 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="password" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1">PASSWORD <span class="text-rose-500">*</span></label>
                        <input type="password" id="password" name="password" required placeholder="••••••••"
                            class="w-full px-4 py-2.5 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1">KONFIRMASI PASSWORD <span class="text-rose-500">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••"
                            class="w-full px-4 py-2.5 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                    </div>
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full py-3.5 px-6 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs shadow-lg transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-user-plus"></i> Kirim OTP Verifikasi Email
                    </button>
                </div>
            </form>

            <div class="mt-5 pt-4 border-t border-stone-100 text-center">
                <p class="text-xs text-stone-500">Sudah memiliki akun Nginap? 
                    <a href="{{ route('login') }}" class="font-extrabold text-[#8a6225] hover:underline">Masuk Sekarang</a>
                </p>
            </div>
        </div>

        <!-- MODAL VERIFIKASI OTP REGISTRASI TAMU (Alpine.js) -->
        <div x-show="showRegOtpModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm" style="display: none;">
            <div class="bg-white max-w-md w-full rounded-3xl border border-stone-200 shadow-2xl p-6 relative text-stone-800">
                <div class="text-center mb-6">
                    <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-amber-50 text-[#8a6225] flex items-center justify-center text-2xl shadow-sm border border-amber-200">
                        <i class="fa-solid fa-envelope-circle-check"></i>
                    </div>
                    <h3 class="text-xl font-black text-stone-900 font-serif">Verifikasi Email Pendaftaran</h3>
                    <p class="text-xs text-stone-500 mt-1">Kode OTP 6-digit telah dikirimkan ke email pendaftaran Anda.</p>
                </div>

                <form action="{{ route('register.otp.verify') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="reg_otp_code" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2 text-center">Masukkan Kode OTP 6-Digit</label>
                        <input type="text" id="reg_otp_code" name="reg_otp_code" maxlength="6" required autofocus placeholder="123456"
                            class="w-full text-center text-2xl font-mono font-black tracking-widest px-4 py-3 bg-stone-50 border border-stone-300 rounded-2xl text-[#8a6225] focus:outline-none focus:border-amber-700 transition">
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs shadow-lg transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-circle-check"></i> Selesaikan Registrasi & Masuk
                    </button>
                </form>
            </div>
        </div>

    </div>

@endsection
