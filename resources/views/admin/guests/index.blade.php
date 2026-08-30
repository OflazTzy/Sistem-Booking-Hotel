{{-- Halaman Kelola Data Tamu (Admin Dark Sidebar Theme) --}}
@extends('layouts.app')

@section('title', 'Nginap Admin - Data Tamu')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- LEFT DARK GREEN SIDEBAR -->
            <div class="lg:col-span-3">
                @include('admin.sidebar')
            </div>

            <!-- RIGHT MAIN CONTENT: GUESTS TABLE -->
            <div class="lg:col-span-9 space-y-6">

                <!-- Header Title -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-stone-900 font-serif tracking-tight">Data Tamu Terdaftar</h1>
                        <p class="text-xs text-stone-400 mt-1">Daftar pengguna dengan role tamu terdaftar di platform Nginap</p>
                    </div>
                </div>

                <!-- Table Guests -->
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden p-6 space-y-6">
                    @if ($guests->isEmpty())
                        <div class="text-center py-12 text-stone-400 text-xs">Belum ada tamu terdaftar saat ini.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-stone-600">
                                <thead class="bg-stone-900 text-white uppercase tracking-wider font-extrabold text-[10px]">
                                    <tr>
                                        <th class="py-3.5 px-4 rounded-l-xl">ID</th>
                                        <th class="py-3.5 px-4">NAMA TAMU</th>
                                        <th class="py-3.5 px-4">EMAIL</th>
                                        <th class="py-3.5 px-4">NO. KTP/SIM</th>
                                        <th class="py-3.5 px-4">NO. HP/WA</th>
                                        <th class="py-3.5 px-4 text-center">JUMLAH BOOKING</th>
                                        <th class="py-3.5 px-4 text-right rounded-r-xl">TGL TERDAFTAR</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-stone-100 font-medium">
                                    @foreach ($guests as $guest)
                                        <tr class="hover:bg-stone-50 transition">
                                            <td class="py-4 px-4 font-black text-stone-900">#{{ $guest->id }}</td>
                                            <td class="py-4 px-4 font-bold text-stone-900 font-serif text-sm">{{ $guest->name }}</td>
                                            <td class="py-4 px-4 text-stone-600 font-mono">{{ $guest->email }}</td>
                                            <td class="py-4 px-4 font-mono text-stone-700">{{ $guest->identity_number ?? '-' }}</td>
                                            <td class="py-4 px-4">{{ $guest->phone ?? '-' }}</td>
                                            <td class="py-4 px-4 text-center">
                                                <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 font-extrabold text-[10px] border border-amber-200">
                                                    {{ $guest->bookings_count }} Booking
                                                </span>
                                            </td>
                                            <td class="py-4 px-4 text-right text-stone-400 font-mono">
                                                {{ $guest->created_at->format('d/m/Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>

@endsection
