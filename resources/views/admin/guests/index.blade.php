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
                    <div>
                        <a href="{{ route('admin.guests.create') }}" class="px-6 py-3 rounded-full bg-stone-900 hover:bg-[#8a6225] text-white font-extrabold text-xs shadow-md transition inline-flex items-center gap-2">
                            <i class="fa-solid fa-user-plus"></i> Tambah Tamu Baru
                        </a>
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
                                        <th class="py-3 px-4">NAMA TAMU</th>
                                        <th class="py-3 px-4">EMAIL</th>
                                        <th class="py-3 px-4">KTP / SIM</th>
                                        <th class="py-3 px-4">NO. HANDPHONE</th>
                                        <th class="py-3 px-4 text-center">TOTAL BOOKING</th>
                                        <th class="py-3 px-4 text-right">TERDAFTAR</th>
                                        <th class="py-3 px-4 text-center">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-stone-100 font-medium">
                                    <!-- Tampilkan Data Tamu Terdaftar -->
                                    @foreach ($guests as $guest)
                                        <tr class="hover:bg-stone-50 transition">
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
                                            <td class="py-4 px-4 text-center">
                                                <div class="inline-flex items-center space-x-1">
                                                    <a href="{{ route('admin.guests.edit', $guest) }}" class="px-3 py-1.5 rounded-full bg-amber-50 hover:bg-amber-100 text-amber-700 font-extrabold text-[10px] border border-amber-200 transition" title="Edit Akun Tamu">
                                                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.guests.destroy', $guest) }}" method="POST" onsubmit="confirmAction(event, 'Hapus Data Tamu?', 'Apakah Anda yakin ingin menghapus data tamu {{ $guest->name }} dari database?', 'Ya, Hapus Tamu!');" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-3 py-1.5 rounded-full bg-rose-50 hover:bg-rose-100 text-rose-600 font-extrabold text-[10px] border border-rose-200 transition" title="Hapus Akun Tamu">
                                                            <i class="fa-solid fa-trash me-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
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
