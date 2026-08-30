<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Nginap - Platform Pemesanan Hotel & Penginapan Modern">
    <title>@yield('title', 'Nginap - Nginap di mana malam ini?')</title>

    <!-- Google Fonts: Plus Jakarta Sans & Playfair Display for Serif Accents -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS v3 CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Tailwind Configuration (Nginap Exact Color Tokens) -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        nginap: {
                            bg: '#f7f4ee',
                            card: '#ffffff',
                            dark: '#132a22',
                            footer: '#0c1e18',
                            brown: '#8a6225',
                            brownHover: '#73501d',
                            accent: '#966a2b',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Font Awesome 6 Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-[#f7f4ee] font-sans text-stone-800 flex flex-col min-h-screen antialiased">

    @php
        $isAdminPage = Auth::check() && Auth::user()->isAdmin() && !request()->routeIs('home');
    @endphp

    <!-- Header Navigation Bar (Only for Guest / Non-Admin Portal views) -->
    @if(!$isAdminPage)
        <header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-stone-200/60" x-data="{ mobileMenuOpen: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">

                    <!-- Logo & Brand (Nginap) -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('home') }}" class="flex items-center space-x-2 text-2xl font-extrabold tracking-tight text-stone-900">
                            <span>Nginap</span>
                        </a>
                    </div>

                    <!-- Desktop Navigation Links -->
                    <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold">
                        <a href="{{ route('home') }}" class="transition {{ request()->routeIs('home') ? 'text-stone-900 border-b-2 border-stone-900 py-1 font-bold' : 'text-stone-500 hover:text-stone-900' }}">
                            Beranda
                        </a>

                        <a href="{{ route('rooms.index') }}" class="transition {{ request()->routeIs('rooms.*') ? 'text-stone-900 border-b-2 border-stone-900 py-1 font-bold' : 'text-stone-500 hover:text-stone-900' }}">
                            Kamar
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}" class="transition {{ request()->routeIs('dashboard') ? 'text-stone-900 border-b-2 border-stone-900 py-1 font-bold' : 'text-stone-500 hover:text-stone-900' }}">
                                Dashboard
                            </a>
                        @endauth
                    </nav>

                    <!-- Right Auth Action Button (Dark Pill Button) -->
                    <div class="hidden md:flex items-center space-x-3">
                        @auth
                            <a href="{{ route('profile.show') }}" class="flex items-center space-x-3 bg-stone-100 hover:bg-amber-50 px-3.5 py-1.5 rounded-full border border-stone-200 transition group" title="Lihat & Edit Profil Saya">
                                <span class="text-xs font-bold text-stone-800 group-hover:text-amber-900"><i class="fa-solid fa-user-gear text-amber-700 me-1"></i> {{ Auth::user()->name }}</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ Auth::user()->isAdmin() ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-800' }}">
                                    {{ Auth::user()->isAdmin() ? 'Admin' : 'Tamu' }}
                                </span>
                            </a>

                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" title="Logout" class="p-2 text-stone-400 hover:text-rose-600 transition">
                                    <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-full bg-stone-900 hover:bg-stone-800 text-white text-xs font-bold transition shadow">
                                Masuk
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden flex items-center">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-xl text-stone-600 hover:text-stone-900 focus:outline-none">
                            <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark text-xl' : 'fa-bars text-xl'"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Dropdown Menu -->
            <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white border-t border-stone-200 px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-stone-800 hover:bg-stone-50">Beranda</a>
                <a href="{{ route('rooms.index') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-stone-800 hover:bg-stone-50">Kamar</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-stone-800 hover:bg-stone-50">Dashboard</a>
                    <a href="{{ route('profile.show') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-amber-800 bg-amber-50">
                        <i class="fa-solid fa-user-gear me-1.5"></i> Profil Saya
                    </a>
                    <div class="pt-3 border-t border-stone-200 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-stone-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-stone-400">{{ Auth::user()->email }}</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3.5 py-1.5 rounded-full bg-rose-600 text-white text-xs font-bold">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <div class="pt-2">
                        <a href="{{ route('login') }}" class="w-full block text-center px-4 py-2.5 rounded-full text-xs font-bold text-white bg-stone-900">Masuk</a>
                    </div>
                @endauth
            </div>
        </header>
    @endif

    <!-- Main Content Area -->
    <main class="flex-1 w-full">

        <!-- Flash Messages -->
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-sm">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 text-sm">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center justify-between shadow-sm">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-rose-500 hover:text-rose-700 text-sm">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        @endif

        @yield('content')

    </main>

    <!-- Footer (Only for Guest / Non-Admin Portal views) -->
    @if(!$isAdminPage)
        <footer class="bg-[#0e261f] text-stone-300 text-xs mt-20 pt-16 pb-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-start gap-8 pb-12 border-b border-stone-800">
                    <div class="max-w-sm">
                        <span class="text-3xl font-black text-white tracking-tight block mb-3">Nginap</span>
                        <p class="text-stone-400 text-xs leading-relaxed">
                            Platform pemesanan kamar hotel modern, efisien dan terpercaya untuk kelancaran liburan & pengalaman menginap.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-8 text-xs">
                        <div>
                            <h5 class="font-bold text-white uppercase tracking-wider mb-3">Tipe Kamar</h5>
                            <ul class="space-y-2 text-stone-400">
                                <li><a href="{{ route('rooms.index', ['type' => 'Standard']) }}" class="hover:text-white transition">Standard Room</a></li>
                                <li><a href="{{ route('rooms.index', ['type' => 'Deluxe']) }}" class="hover:text-white transition">Deluxe Suite</a></li>
                                <li><a href="{{ route('rooms.index', ['type' => 'Suite']) }}" class="hover:text-white transition">Presidential Suite</a></li>
                            </ul>
                        </div>

                        <div>
                            <h5 class="font-bold text-white uppercase tracking-wider mb-3">Fitur Layanan</h5>
                            <ul class="space-y-2 text-stone-400">
                                <li><a href="#" class="hover:text-white transition">Pembayaran QRIS</a></li>
                                <li><a href="#" class="hover:text-white transition">Bayar di Tempat</a></li>
                                <li><a href="#" class="hover:text-white transition">Kuitansi PDF</a></li>
                            </ul>
                        </div>

                        <div>
                            <h5 class="font-bold text-white uppercase tracking-wider mb-3">Keamanan</h5>
                            <ul class="space-y-2 text-stone-400">
                                <li><a href="#" class="hover:text-white transition">OTP 2FA Email</a></li>
                                <li><a href="#" class="hover:text-white transition">Double Booking Guard</a></li>
                                <li><a href="#" class="hover:text-white transition">Verifikasi Instan</a></li>
                            </ul>
                        </div>

                        <div>
                            <h5 class="font-bold text-white uppercase tracking-wider mb-3">Bantuan</h5>
                            <ul class="space-y-2 text-stone-400">
                                <li><a href="#" class="hover:text-white transition">Pusat Bantuan</a></li>
                                <li><a href="#" class="hover:text-white transition">Syarat & Ketentuan</a></li>
                                <li><a href="#" class="hover:text-white transition">Hubungi Kami</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="pt-8 text-center text-stone-500 text-xs">
                    <p>&copy; {{ date('Y') }} Nginap Hotel Booking Platform. All rights reserved.</p>
                </div>
            </div>
        </footer>
    @endif

    @stack('scripts')

</body>
</html>
