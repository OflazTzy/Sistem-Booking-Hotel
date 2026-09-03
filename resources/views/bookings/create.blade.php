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

                <!-- Box Daftar Tanggal Terisi pada Kamar ini -->
                <div class="mb-6 p-4 rounded-2xl bg-amber-50/80 border border-amber-200 text-stone-800 text-xs">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-extrabold text-amber-900 flex items-center gap-1.5 font-serif">
                            <i class="fa-solid fa-calendar-xmark text-amber-700"></i> Jadwal Terisi Kamar {{ $room->room_number }}:
                        </h4>
                    </div>
                    @if(!isset($activeBookings) || $activeBookings->isEmpty())
                        <p class="text-emerald-700 font-semibold text-[11px] flex items-center gap-1">
                            <i class="fa-solid fa-circle-check text-emerald-500"></i> Kamar ini sepenuhnya KOSONG untuk semua tanggal mendatang!
                        </p>
                    @else
                        <ul class="space-y-1.5 mb-2">
                            @foreach($activeBookings as $b)
                                <li class="flex items-center justify-between text-[11px] bg-white px-3 py-2 rounded-xl border border-amber-200/60 font-medium">
                                    <span><i class="fa-solid fa-calendar-day text-amber-600 me-1.5"></i> {{ \Carbon\Carbon::parse($b->check_in)->format('d M Y') }} &mdash; {{ \Carbon\Carbon::parse($b->check_out)->format('d M Y') }}</span>
                                    <span class="px-2 py-0.5 rounded bg-rose-100 text-rose-800 font-black text-[9px] uppercase border border-rose-200">Terisi</span>
                                </li>
                            @endforeach
                        </ul>
                        <p class="text-[11px] text-stone-600 font-medium mt-1">
                            <i class="fa-solid fa-lightbulb text-amber-600 me-1"></i> Tanggal selain daftar di atas (misal tanggal <strong>03 Sep 2026 dan seterusnya</strong>) <strong>KOSONG & Siap dibooking!</strong>
                        </p>
                    @endif
                </div>

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
                            <input type="date" id="check_in" name="check_in" value="{{ old('check_in', $checkIn ?? request('check_in')) }}" min="{{ date('Y-m-d') }}" required
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition mb-2">
                            
                            <label for="check_in_time" class="block text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-1">Jam Check-in</label>
                            <input type="time" id="check_in_time" name="check_in_time" value="{{ old('check_in_time', '14:00') }}" required
                                class="w-full px-4 py-2.5 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                        </div>

                        <div>
                            <label for="check_out" class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">TANGGAL CHECK-OUT <span class="text-rose-500">*</span></label>
                            <input type="date" id="check_out" name="check_out" value="{{ old('check_out', $checkOut ?? request('check_out')) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition mb-2">
                            
                            <label for="check_out_time" class="block text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-1">Jam Check-out (Batas: 12:00 WIB)</label>
                            <input type="time" id="check_out_time" name="check_out_time" value="{{ old('check_out_time', '12:00') }}" required
                                class="w-full px-4 py-2.5 bg-stone-50 border border-stone-200 rounded-2xl text-stone-800 text-xs font-semibold focus:outline-none focus:border-amber-700 transition">
                        </div>
                    </div>

                    <!-- Live Date Conflict Alert Box -->
                    <div id="date-conflict-alert" class="hidden">
                        <div id="date-conflict-message"></div>
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
                                    <span class="font-black text-xs text-stone-900 uppercase">QRIS Online</span>
                                    <i class="fa-solid fa-qrcode text-amber-700 text-lg"></i>
                                </div>
                                <p class="text-[11px] text-stone-500">Scan QRIS BCA/Mandiri instan</p>
                            </label>

                            <!-- Option 2: Tunai Resepsionis -->
                            <label class="relative flex flex-col p-4 rounded-2xl border-2 border-stone-200 cursor-pointer transition hover:border-amber-700 has-[:checked]:border-amber-700 has-[:checked]:bg-amber-50/40">
                                <input type="radio" name="payment_method" value="cash" {{ old('payment_method') === 'cash' ? 'checked' : '' }} class="sr-only">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-black text-xs text-stone-900 uppercase">Bayar di Tempat</span>
                                    <i class="fa-solid fa-money-bill-wave text-emerald-700 text-lg"></i>
                                </div>
                                <p class="text-[11px] text-stone-500">Bayar tunai di meja resepsionis</p>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" id="btn-submit-booking" class="w-full py-4 px-6 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-black text-xs text-center shadow-lg hover:shadow-xl transition transform active:scale-95">
                            <i class="fa-solid fa-paper-plane me-2"></i> KONFIRMASI BOOKING SEKARANG
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Live JS Date Overlap Checker -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');
        const alertBox = document.getElementById('date-conflict-alert');
        const alertMsg = document.getElementById('date-conflict-message');
        const submitBtn = document.getElementById('btn-submit-booking');

        const activeBookings = {!! json_encode(isset($activeBookings) ? $activeBookings->map(function($b) {
            return ['check_in' => $b->check_in, 'check_out' => $b->check_out];
        }) : []) !!};

        function validateDates() {
            const cin = checkInInput.value;
            const cout = checkOutInput.value;

            if (!cin || !cout) {
                alertBox.classList.add('hidden');
                if (submitBtn) submitBtn.disabled = false;
                return;
            }

            let hasConflict = false;
            for (let b of activeBookings) {
                // Formula Overlap Hotel: existing.check_in < new.check_out AND existing.check_out > new.check_in
                if (b.check_in < cout && b.check_out > cin) {
                    hasConflict = true;
                    break;
                }
            }

            if (hasConflict) {
                alertBox.classList.remove('hidden');
                alertBox.className = "p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-start gap-2.5 my-3";
                alertMsg.innerHTML = '<div class="flex gap-2"><i class="fa-solid fa-circle-xmark text-rose-600 text-base mt-0.5"></i><div><strong>JADWAL TERISI: Tanggal ' + cin + ' s/d ' + cout + ' SUDAH DIPESAN TAMU LAIN!</strong><br><span class="opacity-90">Silakan pilih tanggal lain yang masih kosong (misal tanggal 3 Sep 2026 dan seterusnya).</span></div></div>';
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.className = "w-full py-4 px-6 rounded-full bg-stone-300 text-stone-500 font-extrabold text-xs text-center cursor-not-allowed shadow-none";
                }
            } else {
                alertBox.classList.remove('hidden');
                alertBox.className = "p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-start gap-2.5 my-3";
                alertMsg.innerHTML = '<div class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-600 text-base"></i><span><strong>TANGGAL KOSONG:</strong> Tanggal ' + cin + ' s/d ' + cout + ' TERSEDIA untuk dibooking!</span></div>';
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.className = "w-full py-4 px-6 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-black text-xs text-center shadow-lg hover:shadow-xl transition transform active:scale-95";
                }
            }
        }

        if (checkInInput && checkOutInput) {
            checkInInput.addEventListener('change', validateDates);
            checkOutInput.addEventListener('change', validateDates);
            validateDates();
        }
    });
</script>
@endsection
