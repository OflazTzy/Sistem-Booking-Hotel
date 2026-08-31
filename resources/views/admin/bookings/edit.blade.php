{{-- Form Edit Data Reservasi Tamu (Admin Portal Theme) --}}
@extends('layouts.app')

@section('title', 'Nginap Admin - Edit Reservasi #' . $booking->booking_code)

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- LEFT DARK GREEN SIDEBAR -->
            <div class="lg:col-span-3">
                @include('admin.sidebar')
            </div>

            <!-- RIGHT MAIN CONTENT: FORM EDIT RESERVASI -->
            <div class="lg:col-span-9 space-y-6">

                <!-- Header Title -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-black text-stone-900 font-serif tracking-tight">Edit Reservasi #{{ $booking->booking_code }}</h1>
                        <p class="text-xs text-stone-400 mt-1">Perbarui data reservasi tamu, tanggal/jam check-in & check-out asli, denda keterlambatan, serta status.</p>
                    </div>
                    <a href="{{ route('bookings.show', $booking) }}" class="px-4 py-2 rounded-full border border-stone-300 text-stone-700 font-bold text-xs hover:bg-stone-50 transition">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Detail
                    </a>
                </div>

                <!-- Info Ringkas Tamu & Kamar -->
                <div class="bg-amber-50 rounded-2xl border border-amber-200/80 p-4 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
                    <div>
                        <span class="text-stone-500 font-bold uppercase tracking-wider block text-[10px]">Tamu Pemesan</span>
                        <strong class="text-stone-900 text-sm font-extrabold">{{ $booking->guest->name }}</strong>
                        <span class="text-stone-500 block text-[11px]">{{ $booking->guest->email }} (HP: {{ $booking->guest->phone ?? '-' }})</span>
                    </div>

                    <div>
                        <span class="text-stone-500 font-bold uppercase tracking-wider block text-[10px]">Kamar Dipesan</span>
                        <strong class="text-stone-900 text-sm font-extrabold">Kamar {{ $booking->room->room_number }} ({{ $booking->room->room_type }})</strong>
                        <span class="text-stone-500 block text-[11px]">Rp {{ number_format($booking->room->price, 0, ',', '.') }} / malam</span>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 sm:p-8">
                    <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Grid Tanggal & Jam Check-in -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Tanggal Check-in <span class="text-rose-600">*</span>
                                </label>
                                <input type="date" name="check_in" value="{{ old('check_in', \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d')) }}" required class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                @error('check_in')
                                    <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Jam Check-in Asli <span class="text-rose-600">*</span>
                                </label>
                                <input type="time" name="check_in_time" value="{{ old('check_in_time', substr($booking->check_in_time ?? '14:00', 0, 5)) }}" required class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                @error('check_in_time')
                                    <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Grid Tanggal & Jam Check-out Asli -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Tanggal Check-out Asli <span class="text-rose-600">*</span>
                                </label>
                                <input type="date" name="check_out" value="{{ old('check_out', \Carbon\Carbon::parse($booking->check_out)->format('Y-m-d')) }}" required class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                @error('check_out')
                                    <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Jam Check-out Asli / Aktual <span class="text-rose-600">*</span>
                                </label>
                                <input type="time" name="check_out_time" value="{{ old('check_out_time', substr($booking->check_out_time ?? '12:00', 0, 5)) }}" required class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                <span class="text-[10px] text-stone-400 mt-1 block">Waktu aktual saat tamu melakukan kunci kamar / check-out.</span>
                                @error('check_out_time')
                                    <p class="text-rose-600 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Denda Keterlambatan & Jam Late Checkout (Opsional) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-stone-100">
                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Keterlambatan (Jam)
                                </label>
                                <input type="number" name="late_hours" value="{{ old('late_hours', $booking->late_hours ?? 0) }}" min="0" placeholder="0" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                <span class="text-[10px] text-stone-400 mt-1 block">Isi 0 jika tidak ada keterlambatan jam check-out.</span>
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Biaya Denda Keterlambatan (Rp)
                                </label>
                                <input type="number" name="late_fee" value="{{ old('late_fee', $booking->late_fee ?? 0) }}" min="0" placeholder="0" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-semibold text-stone-900 focus:outline-none focus:border-amber-700 transition">
                                <span class="text-[10px] text-stone-400 mt-1 block">Denda tambahan jika terlambat mengembalikan kunci.</span>
                            </div>
                        </div>

                        <!-- Status & Metode Pembayaran -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-stone-100">
                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Status Reservasi <span class="text-rose-600">*</span>
                                </label>
                                <select name="status" required class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-bold text-stone-900 focus:outline-none focus:border-amber-700">
                                    <option value="active" {{ old('status', $booking->status) === 'active' ? 'selected' : '' }}>Confirmed / LUNAS (Active)</option>
                                    <option value="pending" {{ old('status', $booking->status) === 'pending' ? 'selected' : '' }}>Pending (Menunggu Pembayaran)</option>
                                    <option value="cancelled" {{ old('status', $booking->status) === 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold text-stone-900 uppercase tracking-wider mb-2">
                                    Metode Pembayaran <span class="text-rose-600">*</span>
                                </label>
                                <select name="payment_method" required class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-3 text-xs font-bold text-stone-900 focus:outline-none focus:border-amber-700">
                                    <option value="cash" {{ old('payment_method', $booking->payment_method) === 'cash' ? 'selected' : '' }}>Tunai / Cash (Resepsionis)</option>
                                    <option value="qris" {{ old('payment_method', $booking->payment_method) === 'qris' ? 'selected' : '' }}>QRIS / Transfer Bank</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6 flex items-center justify-end gap-3 border-t border-stone-100">
                            <a href="{{ route('bookings.show', $booking) }}" class="px-6 py-3 rounded-full border border-stone-200 text-stone-600 font-bold text-xs hover:bg-stone-50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs shadow-md transition flex items-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Reservasi
                            </button>
                        </div>

                    </form>
                </div>

            </div>

        </div>

    </div>

@endsection
