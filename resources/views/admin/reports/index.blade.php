@extends('layouts.app')

@section('title', 'Laporan & Rekapan Keuangan - Nginap Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- 2-Column Grid: Left Navigation Sidebar + Right Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
        
        <!-- Left Sidebar Navigation -->
        <div class="lg:col-span-3">
            @include('admin.sidebar')
        </div>

        <!-- Right Main Content Area -->
        <div class="lg:col-span-9 space-y-6">

            <!-- Page Title & Header Banner -->
            <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-900 font-extrabold text-[10px] uppercase border border-amber-200 tracking-wider">
                        REKAPAN TRANSAKSI
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-black text-stone-900 tracking-tight font-serif mt-2">Laporan Keuangan & Reservasi</h1>
                    <p class="text-xs text-stone-500 mt-1">Rekapan omset bulanan & filter tanggal spesifik, serta cetak PDF resmi.</p>
                </div>

                <div>
                    <a href="{{ route('admin.reports.pdf', ['filter_type' => $filterType, 'month' => $selectedMonth, 'year' => $selectedYear, 'start_date' => $startDate, 'end_date' => $endDate, 'status' => $selectedStatus]) }}" target="_blank" class="px-5 py-3 rounded-full bg-rose-700 hover:bg-rose-800 text-white font-extrabold text-xs shadow-md hover:shadow-lg transition inline-flex items-center gap-2">
                        <i class="fa-solid fa-file-pdf text-sm"></i> Download PDF Rekapan
                    </a>
                </div>
            </div>

            <!-- Filter Card (Tabs: Bulan vs Rentang Tanggal) -->
            <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 space-y-5" x-data="{ mode: '{{ $filterType }}' }">
                
                <!-- Filter Type Toggle Buttons -->
                <div class="flex items-center space-x-2 border-b border-stone-100 pb-3">
                    <button type="button" @click="mode = 'month'" :class="mode === 'month' ? 'bg-[#8a6225] text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200'" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                        <i class="fa-solid fa-calendar-days"></i> Filter Per Bulan
                    </button>
                    <button type="button" @click="mode = 'date_range'" :class="mode === 'date_range' ? 'bg-[#8a6225] text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200'" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                        <i class="fa-solid fa-calendar-week"></i> Filter Rentang Tanggal Spesifik
                    </button>
                </div>

                <!-- Form 1: Filter Per Bulan & Tahun -->
                <form action="{{ route('admin.reports.index') }}" method="GET" x-show="mode === 'month'" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
                    <input type="hidden" name="filter_type" value="month">

                    <div class="sm:col-span-4">
                        <label class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">PILIH BULAN</label>
                        <select name="month" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-2.5 text-xs font-bold text-stone-800 focus:outline-none focus:border-amber-700 transition">
                            @foreach($months as $mNum => $mName)
                                <option value="{{ $mNum }}" {{ $selectedMonth == $mNum ? 'selected' : '' }}>
                                    {{ $mName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">PILIH TAHUN</label>
                        <select name="year" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-2.5 text-xs font-bold text-stone-800 focus:outline-none focus:border-amber-700 transition">
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">STATUS TRANSAKSI</label>
                        <select name="status" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-2.5 text-xs font-bold text-stone-800 focus:outline-none focus:border-amber-700 transition">
                            <option value="all" {{ $selectedStatus == 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="active" {{ $selectedStatus == 'active' ? 'selected' : '' }}>Active / Lunas</option>
                            <option value="pending" {{ $selectedStatus == 'pending' ? 'selected' : '' }}>Pending / Menunggu</option>
                            <option value="cancelled" {{ $selectedStatus == 'cancelled' ? 'selected' : '' }}>Cancelled / Batal</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <button type="submit" class="w-full py-2.5 px-4 rounded-2xl bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs shadow transition">
                            <i class="fa-solid fa-filter me-1"></i> Filter
                        </button>
                    </div>
                </form>

                <!-- Form 2: Filter Rentang Tanggal Spesifik (Dari Tanggal s/d Sampai Tanggal) -->
                <form action="{{ route('admin.reports.index') }}" method="GET" x-show="mode === 'date_range'" style="display: none;" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
                    <input type="hidden" name="filter_type" value="date_range">

                    <div class="sm:col-span-4">
                        <label class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">DARI TANGGAL (START)</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-2.5 text-xs font-bold text-stone-800 focus:outline-none focus:border-amber-700 transition">
                    </div>

                    <div class="sm:col-span-4">
                        <label class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">SAMPAI TANGGAL (END)</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-4 py-2.5 text-xs font-bold text-stone-800 focus:outline-none focus:border-amber-700 transition">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1.5">STATUS</label>
                        <select name="status" class="w-full bg-stone-50 border border-stone-200 rounded-2xl px-3 py-2.5 text-xs font-bold text-stone-800 focus:outline-none focus:border-amber-700 transition">
                            <option value="all" {{ $selectedStatus == 'all' ? 'selected' : '' }}>Semua</option>
                            <option value="active" {{ $selectedStatus == 'active' ? 'selected' : '' }}>Lunas</option>
                            <option value="pending" {{ $selectedStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="cancelled" {{ $selectedStatus == 'cancelled' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <button type="submit" class="w-full py-2.5 px-4 rounded-2xl bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs shadow transition">
                            <i class="fa-solid fa-filter me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Summary Stat Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Stat 1: Total Omset Pendapatan -->
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-5">
                    <span class="text-[10px] font-black text-stone-400 uppercase tracking-wider block mb-1">TOTAL OMSET (LUNAS)</span>
                    <strong class="text-2xl font-black text-emerald-700 block font-serif">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong>
                    <span class="text-[10px] text-stone-500 mt-1 block">
                        @if($filterType === 'date_range' && $startDate && $endDate)
                            Periode {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                        @else
                            Periode {{ $months[$selectedMonth] }} {{ $selectedYear }}
                        @endif
                    </span>
                </div>

                <!-- Stat 2: Total Reservasi -->
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-5">
                    <span class="text-[10px] font-black text-stone-400 uppercase tracking-wider block mb-1">TOTAL RESERVASI</span>
                    <strong class="text-2xl font-black text-stone-900 block font-serif">{{ $totalBookings }} Pesanan</strong>
                    <span class="text-[10px] text-stone-500 mt-1 block">Total malam: {{ $totalNights }} malam</span>
                </div>

                <!-- Stat 3: Kamar Tersewa -->
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-5">
                    <span class="text-[10px] font-black text-stone-400 uppercase tracking-wider block mb-1">VARIASI KAMAR</span>
                    <strong class="text-2xl font-black text-amber-700 block font-serif">{{ $uniqueRooms }} Kamar</strong>
                    <span class="text-[10px] text-stone-500 mt-1 block">Tersewa pada periode ini</span>
                </div>

                <!-- Stat 4: Rata-rata per Transaksi -->
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-5">
                    <span class="text-[10px] font-black text-stone-400 uppercase tracking-wider block mb-1">RATA-RATA OMSET</span>
                    <strong class="text-xl font-black text-stone-800 block font-serif">Rp {{ number_format($avgPerBooking, 0, ',', '.') }}</strong>
                    <span class="text-[10px] text-stone-500 mt-1 block">Per transaksi lunas</span>
                </div>
            </div>

            <!-- Detailed Monthly Transactions Table Card -->
            <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-stone-100 pb-4">
                    <div>
                        <h3 class="text-lg font-black text-stone-900 font-serif">
                            Detail Rekapan Transaksi 
                            @if($filterType === 'date_range' && $startDate && $endDate)
                                ({{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} &mdash; {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }})
                            @else
                                ({{ $months[$selectedMonth] }} {{ $selectedYear }})
                            @endif
                        </h3>
                        <p class="text-xs text-stone-500 mt-0.5">Daftar seluruh transaksi yang tercatat pada kriteria pencarian pilihan.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-stone-600">
                        <thead class="bg-stone-900 text-white uppercase tracking-wider font-extrabold text-[10px]">
                            <tr>
                                <th class="py-3.5 px-4 rounded-l-xl">NO</th>
                                <th class="py-3.5 px-4">KODE</th>
                                <th class="py-3.5 px-4">NAMA TAMU</th>
                                <th class="py-3.5 px-4">KAMAR</th>
                                <th class="py-3.5 px-4 text-center">CHECK-IN</th>
                                <th class="py-3.5 px-4 text-center">CHECK-OUT</th>
                                <th class="py-3.5 px-4 text-center">STATUS</th>
                                <th class="py-3.5 px-4 text-right rounded-r-xl">TOTAL BIAYA</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100 font-medium">
                            @if($bookings->isEmpty())
                                <tr>
                                    <td colspan="8" class="py-8 text-center text-stone-400">
                                        <i class="fa-solid fa-inbox text-3xl mb-2 block text-stone-300"></i>
                                        Tidak ada data transaksi ditemukan untuk filter ini.
                                    </td>
                                </tr>
                            @else
                                @foreach($bookings as $index => $booking)
                                    <tr class="hover:bg-stone-50 transition">
                                        <td class="py-3.5 px-4 text-stone-400 font-mono">{{ $index + 1 }}</td>
                                        <td class="py-3.5 px-4 font-mono font-bold text-stone-900">{{ $booking->booking_code }}</td>
                                        <td class="py-3.5 px-4 font-bold text-stone-800">{{ $booking->guest ? $booking->guest->name : '-' }}</td>
                                        <td class="py-3.5 px-4">
                                            <span class="px-2 py-0.5 rounded bg-stone-100 text-stone-800 font-bold border border-stone-200 text-[11px]">
                                                Kmr {{ $booking->room ? $booking->room->room_number : '-' }}
                                            </span>
                                            <span class="text-[10px] text-stone-400 block">{{ $booking->room ? $booking->room->room_type : '' }}</span>
                                        </td>
                                        <td class="py-3.5 px-4 text-center font-mono text-stone-700">
                                            {{ \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-3.5 px-4 text-center font-mono text-stone-700">
                                            {{ \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-3.5 px-4 text-center">
                                            @if(in_array($booking->status, ['active', 'confirmed', 'completed']))
                                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-black text-[9px] uppercase border border-emerald-200">
                                                    LUNAS
                                                </span>
                                            @elseif($booking->status === 'pending')
                                                <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 font-black text-[9px] uppercase border border-amber-200">
                                                    PENDING
                                                </span>
                                            @else
                                                <span class="px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-800 font-black text-[9px] uppercase border border-rose-200">
                                                    BATAL
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-right font-mono font-bold text-stone-900">
                                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        @if($bookings->isNotEmpty())
                            <tfoot class="bg-stone-50 border-t-2 border-stone-200 font-black text-stone-900">
                                <tr>
                                    <td colspan="7" class="py-3.5 px-4 text-right uppercase tracking-wider text-[11px]">TOTAL REKAPAN OMSET (LUNAS):</td>
                                    <td class="py-3.5 px-4 text-right font-mono text-sm text-emerald-700">
                                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
