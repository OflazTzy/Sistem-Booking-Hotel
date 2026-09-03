{{-- Reusable Admin Dark Green Sidebar (Mobile Responsive Toggle + Alpine.js) --}}
<div x-data="{ sidebarOpen: false }" class="bg-[#0c1e18] text-white rounded-3xl p-5 sm:p-6 shadow-xl border border-stone-800 space-y-6 lg:space-y-8 sticky top-4 lg:top-6 z-40">
    
    <!-- Admin Portal Brand & Mobile Toggle Button -->
    <div class="flex items-center justify-between border-stone-800 pb-2 lg:pb-6 lg:border-b">
        <div>
            <span class="text-xl sm:text-2xl font-black tracking-tight text-white block">Nginap</span>
            <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-stone-400 block">ADMIN PORTAL</span>
        </div>

        <!-- Mobile Toggle Button (Visible on mobile screens) -->
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-xl bg-stone-800/80 text-stone-300 hover:text-white focus:outline-none transition">
            <i class="fa-solid" :class="sidebarOpen ? 'fa-xmark text-lg' : 'fa-bars text-lg'"></i>
        </button>
    </div>

    <!-- Navigation Links (Collapsible on Mobile, Always Visible on Desktop) -->
    <div :class="sidebarOpen ? 'block' : 'hidden lg:block'" class="space-y-6 pt-2 lg:pt-0">
        <nav class="space-y-2 text-xs font-bold">
            <!-- 1. Ringkasan / Dashboard -->
            <a href="{{ route('dashboard') }}" class="w-full flex items-center space-x-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white font-extrabold shadow-sm' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-chart-pie w-4 {{ request()->routeIs('dashboard') ? 'text-emerald-400' : '' }}"></i>
                <span>Ringkasan</span>
            </a>

            <!-- 2. Pesanan -->
            <a href="{{ route('bookings.index') }}" class="w-full flex items-center space-x-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('bookings.*') ? 'bg-white/10 text-white font-extrabold shadow-sm' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-receipt w-4 {{ request()->routeIs('bookings.*') ? 'text-emerald-400' : '' }}"></i>
                <span>Pesanan</span>
            </a>

            <!-- 3. Properti / Kamar -->
            <a href="{{ route('rooms.index') }}" class="w-full flex items-center space-x-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('rooms.*') ? 'bg-white/10 text-white font-extrabold shadow-sm' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-hotel w-4 {{ request()->routeIs('rooms.*') ? 'text-emerald-400' : '' }}"></i>
                <span>Properti / Kamar</span>
            </a>

            <!-- 4. Tamu -->
            <a href="{{ route('admin.guests.index') }}" class="w-full flex items-center space-x-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.guests.*') ? 'bg-white/10 text-white font-extrabold shadow-sm' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-users w-4 {{ request()->routeIs('admin.guests.*') ? 'text-emerald-400' : '' }}"></i>
                <span>Tamu</span>
            </a>

            <!-- 5. Laporan & Rekapan Keuangan Bulanan -->
            <a href="{{ route('admin.reports.index') }}" class="w-full flex items-center space-x-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.reports.*') ? 'bg-white/10 text-white font-extrabold shadow-sm' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-file-invoice-dollar w-4 {{ request()->routeIs('admin.reports.*') ? 'text-emerald-400' : '' }}"></i>
                <span>Laporan & Rekapan</span>
            </a>

            <!-- 6. Pengelola Admin -->
            <a href="{{ route('admin.admins.index') }}" class="w-full flex items-center space-x-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.admins.*') ? 'bg-white/10 text-white font-extrabold shadow-sm' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-user-shield w-4 {{ request()->routeIs('admin.admins.*') ? 'text-emerald-400' : '' }}"></i>
                <span>Pengelola Admin</span>
            </a>

            <!-- 6. Profil Saya -->
            <a href="{{ route('profile.show') }}" class="w-full flex items-center space-x-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('profile.*') ? 'bg-white/10 text-white font-extrabold shadow-sm' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-user-gear w-4 {{ request()->routeIs('profile.*') ? 'text-emerald-400' : '' }}"></i>
                <span>Profil Saya</span>
            </a>
        </nav>

        <!-- Bottom Actions -->
        <div class="pt-6 border-t border-stone-800 space-y-2 text-xs font-bold text-stone-400">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2.5 rounded-xl hover:text-rose-400 hover:bg-rose-500/10 transition">
                    <i class="fa-solid fa-arrow-right-from-bracket w-4"></i>
                    <span>Keluar Sesi</span>
                </button>
            </form>
        </div>
    </div>
</div>
