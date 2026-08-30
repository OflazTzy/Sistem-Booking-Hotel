{{-- Halaman Dashboard Admin Ringkasan (Dynamic Database Metrics & Chart Analytics) --}}
@extends('layouts.app')

@section('title', 'Nginap Admin - Ringkasan')

@section('content')

    @php
        $finalLabels = $chartLabels ?? ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $finalData = $chartData ?? [0.3, 0.5, 0.8, 1.2, 1.5, 2.0, 1.8];
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- LEFT DARK GREEN SIDEBAR MENU -->
            <div class="lg:col-span-3">
                @include('admin.sidebar')
            </div>

            <!-- RIGHT MAIN CONTENT -->
            <div class="lg:col-span-9 space-y-8">

                <!-- Header Bar: Title + Date Filter Dropdown + Avatar -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-stone-900 font-serif tracking-tight">Ringkasan</h1>
                        <p class="text-xs text-stone-400 mt-1">Performa transaksi dan status okupansi properti Nginap</p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="bg-white px-4 py-2 rounded-2xl border border-stone-200 shadow-sm text-xs font-bold text-stone-700 flex items-center space-x-2">
                            <i class="fa-regular fa-calendar me-1"></i>
                            <span>Hari Ini</span>
                            <i class="fa-solid fa-chevron-down text-[10px] text-stone-400"></i>
                        </div>

                        <div class="w-10 h-10 rounded-full bg-[#8a6225] text-white font-extrabold text-xs flex items-center justify-center shadow">
                            AD
                        </div>
                    </div>
                </div>

                <!-- 4 Top Stat Cards (Real Database Calculation) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Card 1: Total Booking -->
                    <div class="bg-white p-5 rounded-3xl border border-stone-200/80 shadow-sm space-y-2">
                        <div class="flex items-center justify-between text-stone-400 text-xs">
                            <span class="font-bold">Total Booking</span>
                            <i class="fa-solid fa-receipt text-stone-300"></i>
                        </div>
                        <h3 class="text-2xl font-black text-stone-900 font-serif">{{ number_format($totalBookings ?? 0) }}</h3>
                        <span class="text-[11px] font-bold text-emerald-600 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-up text-[9px]"></i> {{ $activeBookings ?? 0 }} aktif
                        </span>
                    </div>

                    <!-- Card 2: Pendapatan -->
                    <div class="bg-white p-5 rounded-3xl border border-stone-200/80 shadow-sm space-y-2">
                        <div class="flex items-center justify-between text-stone-400 text-xs">
                            <span class="font-bold">Pendapatan</span>
                            <i class="fa-solid fa-wallet text-stone-300"></i>
                        </div>
                        <h3 class="text-2xl font-black text-stone-900 font-serif">
                            Rp {{ number_format(($totalRevenue ?? 0) / 1000000, 1, ',', '.') }}M
                        </h3>
                        <span class="text-[11px] font-bold text-emerald-600 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-up text-[9px]"></i> Total Lunas
                        </span>
                    </div>

                    <!-- Card 3: Okupansi -->
                    <div class="bg-white p-5 rounded-3xl border border-stone-200/80 shadow-sm space-y-2">
                        <div class="flex items-center justify-between text-stone-400 text-xs">
                            <span class="font-bold">Okupansi</span>
                            <i class="fa-solid fa-chart-line text-stone-300"></i>
                        </div>
                        <h3 class="text-2xl font-black text-stone-900 font-serif">{{ $occupancyRate ?? 0 }}%</h3>
                        <span class="text-[11px] font-bold text-emerald-600 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-up text-[9px]"></i> {{ $occupiedRooms ?? 0 }}/{{ $totalRooms ?? 0 }} kamar
                        </span>
                    </div>

                    <!-- Card 4: Pembatalan -->
                    <div class="bg-white p-5 rounded-3xl border border-stone-200/80 shadow-sm space-y-2">
                        <div class="flex items-center justify-between text-stone-400 text-xs">
                            <span class="font-bold">Pembatalan</span>
                            <i class="fa-solid fa-xmark text-stone-300"></i>
                        </div>
                        <h3 class="text-2xl font-black text-stone-900 font-serif">{{ number_format($cancelledBookings ?? 0) }}</h3>
                        <span class="text-[11px] font-bold text-rose-600 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-down text-[9px]"></i> Transaksi Batal
                        </span>
                    </div>

                </div>

                <!-- Table "Pesanan Terbaru" Card -->
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden p-6 space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-black text-stone-900 font-serif">Pesanan Terbaru</h3>
                        <a href="{{ route('bookings.index') }}" class="text-xs font-bold text-amber-800 hover:underline uppercase tracking-wider">
                            LIHAT SEMUA
                        </a>
                    </div>

                    @if($recentBookings->isEmpty())
                        <div class="text-center py-8 text-stone-400 text-xs">Belum ada transaksi pesanan terbaru.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-stone-600">
                                <thead class="border-b border-stone-200 uppercase tracking-wider font-extrabold text-[10px] text-stone-400">
                                    <tr>
                                        <th class="py-3 px-4">KODE BOOKING</th>
                                        <th class="py-3 px-4">TAMU</th>
                                        <th class="py-3 px-4">HOTEL / KAMAR</th>
                                        <th class="py-3 px-4">CHECK-IN / OUT</th>
                                        <th class="py-3 px-4">TOTAL</th>
                                        <th class="py-3 px-4 text-center">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-stone-100 font-medium">
                                    @foreach($recentBookings as $booking)
                                        <tr class="hover:bg-stone-50 transition">
                                            <td class="py-4 px-4 font-black font-mono text-stone-900">#{{ $booking->booking_code }}</td>
                                            <td class="py-4 px-4 font-bold text-stone-800">{{ $booking->guest->name }}</td>
                                            <td class="py-4 px-4">Kamar {{ $booking->room->room_number }} ({{ $booking->room->room_type }})</td>
                                            <td class="py-4 px-4">{{ $booking->check_in->format('d M') }} - {{ $booking->check_out->format('d M') }}</td>
                                            <td class="py-4 px-4 font-black text-stone-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                            <td class="py-4 px-4 text-center">
                                                @if($booking->status === 'active')
                                                    <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase border border-emerald-200">CONFIRMED</span>
                                                @elseif($booking->status === 'pending')
                                                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 font-extrabold text-[10px] uppercase border border-amber-200">PENDING</span>
                                                @else
                                                    <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-800 font-extrabold text-[10px] uppercase border border-rose-200">CANCELLED</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- ANALYTICS GRID: CHART TREN PENDAPATAN & OKUPANSI PER TIPE KAMAR -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                    <!-- Left: Grafik Tren Pendapatan 7 Hari (8 Cols) -->
                    <div class="lg:col-span-8 bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-stone-100 pb-4">
                            <div>
                                <h3 class="text-lg font-black text-stone-900 font-serif">Tren Pendapatan 7 Hari Terakhir</h3>
                                <p class="text-xs text-stone-400">Statistik performa reservasi & omset transaksi harian real database</p>
                            </div>
                            <div class="flex items-center space-x-1 text-[11px] font-bold text-stone-600 bg-stone-100 p-1 rounded-full border border-stone-200">
                                <span class="px-3 py-1 bg-white text-stone-900 rounded-full shadow-sm">7 Hari</span>
                                <span class="px-3 py-1 hover:text-stone-900 cursor-pointer">30 Hari</span>
                                <span class="px-3 py-1 hover:text-stone-900 cursor-pointer">Bulan Ini</span>
                            </div>
                        </div>

                        <!-- Canvas Chart.js -->
                        <div class="relative h-64 w-full pt-2">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>

                    <!-- Right: Tingkat Okupansi Per Tipe Kamar (4 Cols) -->
                    <div class="lg:col-span-4 bg-white rounded-3xl border border-stone-200/80 shadow-sm p-6 flex flex-col justify-between space-y-6">
                        <div>
                            <h3 class="text-lg font-black text-stone-900 font-serif mb-1">Okupansi Kamar</h3>
                            <p class="text-xs text-stone-400 mb-6">Persentase tingkat keterisian properti per tipe</p>

                            @php
                                $types = [
                                    'Standard' => ['label' => 'Standard Room', 'color' => '#8a6225', 'text' => 'text-amber-800'],
                                    'Deluxe' => ['label' => 'Deluxe Suite', 'color' => '#059669', 'text' => 'text-emerald-700'],
                                    'Suite' => ['label' => 'Presidential Suite', 'color' => '#0284c7', 'text' => 'text-sky-700'],
                                ];
                            @endphp

                            @foreach($types as $key => $meta)
                                @php
                                    $stat = $roomOccupancyStats[$key] ?? ['total' => 0, 'occupied' => 0, 'rate' => 0];
                                @endphp
                                <div class="space-y-2 mb-5">
                                    <div class="flex items-center justify-between text-xs font-bold">
                                        <span class="text-stone-800">{{ $meta['label'] }}</span>
                                        <span class="{{ $meta['text'] }} font-extrabold">{{ $stat['rate'] }}%</span>
                                    </div>
                                    <div class="w-full bg-stone-100 h-2.5 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full" style="width: {{ $stat['rate'] }}%; background-color: {{ $meta['color'] }};"></div>
                                    </div>
                                    <span class="text-[10px] text-stone-400 font-medium block">{{ $stat['occupied'] }} dari {{ $stat['total'] }} unit terisi</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- System Status Footer Pill -->
                        <div class="p-3.5 rounded-2xl bg-[#0c1e18] text-white text-[11px] flex items-center justify-between">
                            <span class="flex items-center gap-2 font-bold">
                                <i class="fa-solid fa-circle text-emerald-400 text-[8px]"></i> System Sync
                            </span>
                            <span class="text-stone-400 font-mono text-[10px]">Real-time 🟢</span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        // Gradient fill background
        const gradient = ctx.createLinearGradient(0, 0, 0, 250);
        gradient.addColorStop(0, 'rgba(138, 98, 37, 0.25)');
        gradient.addColorStop(1, 'rgba(138, 98, 37, 0.0)');

        const labels = {!! json_encode($finalLabels ?? ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']) !!};
        const chartData = {!! json_encode($finalData ?? [0.3, 0.5, 0.8, 1.2, 1.5, 2.0, 1.8]) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan (Juta Rp)',
                    data: chartData,
                    borderColor: '#8a6225',
                    borderWidth: 3,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#8a6225',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11, family: 'Plus Jakarta Sans' }, color: '#78716c' }
                    },
                    y: {
                        grid: { color: '#f5f5f4' },
                        ticks: { font: { size: 11, family: 'Plus Jakarta Sans' }, color: '#78716c', callback: (value) => 'Rp ' + value + 'M' }
                    }
                }
            }
        });
    });
</script>
@endpush
