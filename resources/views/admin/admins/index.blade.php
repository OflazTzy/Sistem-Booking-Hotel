{{-- Halaman Kelola Pengelola Administrator (100% Persis Screenshot Stitch Admin Theme) --}}
@extends('layouts.app')

@section('title', 'Nginap Admin - Kelola Pengelola Administrator')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- LEFT DARK GREEN SIDEBAR -->
            <div class="lg:col-span-3">
                @include('admin.sidebar')
            </div>

            <!-- RIGHT MAIN CONTENT: ADMINS TABLE -->
            <div class="lg:col-span-9 space-y-6">

                <!-- Header Title & Add Button (Match Image 2) -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-stone-900 font-serif tracking-tight">Kelola Pengelola Administrator</h1>
                        <p class="text-xs text-stone-400 mt-1">Daftar seluruh pengelola aplikasi dengan hak akses Administrator Nginap</p>
                    </div>

                    <a href="{{ route('admin.admins.create') }}" class="px-6 py-3 rounded-full bg-[#8a6225] hover:bg-[#73501d] text-white font-extrabold text-xs shadow-lg transition flex items-center gap-2">
                        <i class="fa-solid fa-user-plus"></i> Tambah Admin Baru
                    </a>
                </div>

                <!-- Table Admins (Match Image 2 Black Header Table) -->
                <div class="bg-white rounded-3xl border border-stone-200/80 shadow-sm overflow-hidden p-6 space-y-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-stone-600">
                            <thead class="bg-stone-900 text-white uppercase tracking-wider font-extrabold text-[10px]">
                                <tr>
                                    <th class="py-3.5 px-4 rounded-l-xl">NAMA ADMINISTRATOR</th>
                                    <th class="py-3.5 px-4">EMAIL</th>
                                    <th class="py-3.5 px-4">NO. KTP/SIM</th>
                                    <th class="py-3.5 px-4">NO. HP/WA</th>
                                    <th class="py-3.5 px-4 text-center">ROLE</th>
                                    <th class="py-3.5 px-4 text-right">TGL DIBUAT</th>
                                    <th class="py-3.5 px-4 text-center rounded-r-xl">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-100 font-medium">
                                @foreach ($admins as $admin)
                                    <tr class="hover:bg-stone-50 transition">
                                        <td class="py-4 px-4 font-bold text-stone-900 font-serif text-sm">{{ $admin->name }}</td>
                                        <td class="py-4 px-4 text-stone-600 font-mono">{{ $admin->email }}</td>
                                        <td class="py-4 px-4 font-mono text-stone-700">{{ $admin->identity_number ?? '-' }}</td>
                                        <td class="py-4 px-4">{{ $admin->phone ?? '-' }}</td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-800 font-extrabold text-[10px] uppercase border border-rose-200">
                                                Administrator
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-right text-stone-400 font-mono">
                                            {{ $admin->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <a href="{{ route('admin.admins.edit', $admin) }}" class="px-3 py-1.5 rounded-full bg-amber-50 hover:bg-amber-100 text-amber-700 font-extrabold text-[10px] border border-amber-200 transition" title="Edit Akun Admin">
                                                <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
