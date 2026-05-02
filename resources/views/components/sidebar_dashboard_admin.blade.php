{{--
    sidebar_dashboard_admin.blade.php
    Responsive sidebar dengan burger menu.
    Dipanggil dari layouts/admin.blade.php via @include
--}}

<div x-data="{
        sidebarOpen: false,
        openRiwayat: {{ request()->is('admin/riwayat*') ? 'true' : 'false' }}
     }"
     @keydown.escape.window="sidebarOpen = false"
>

    {{-- =====================================================
         BURGER BUTTON — hanya muncul di bawah lg (< 1024px)
         ===================================================== --}}
    <button
        @click="sidebarOpen = !sidebarOpen"
        class="fixed top-4 left-4 z-50 lg:hidden
               inline-flex items-center justify-center
               w-10 h-10 rounded-xl
               bg-emerald-800 text-white shadow-lg
               hover:bg-emerald-700 active:scale-95
               transition-all duration-150"
        aria-label="Toggle Sidebar"
        :aria-expanded="sidebarOpen"
    >
        {{-- Icon Hamburger --}}
        <svg x-show="!sidebarOpen"
             xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5 pointer-events-none"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        {{-- Icon X --}}
        <svg x-show="sidebarOpen" x-cloak
             xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5 pointer-events-none"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    {{-- =====================================================
         OVERLAY — klik area gelap untuk tutup sidebar (mobile)
         ===================================================== --}}
    <div
        x-show="sidebarOpen"
        x-cloak
        @click="sidebarOpen = false"
        x-transition:enter="transition-opacity duration-300 ease-out"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-200 ease-in"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50 backdrop-blur-[1px] z-30 lg:hidden"
        aria-hidden="true"
    ></div>

    {{-- =====================================================
         SIDEBAR
         - Mobile  : hidden by default, slide-in saat burger diklik
         - Desktop : selalu tampil di kiri
         ===================================================== --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full lg:translate-x-0'"
        class="w-[272px] min-h-screen
               bg-gradient-to-b from-[#22543D] to-[#163527]
               fixed top-0 left-0 bottom-0
               flex flex-col z-40 overflow-y-auto
               transition-transform duration-300 ease-in-out"
    >

        {{-- Logo --}}
        <a href="{{ url('/admin/dashboard_admin') }}"
           @click="sidebarOpen = false"
           class="flex items-center gap-3 px-6 py-6 border-b border-white/10 hover:bg-white/5 transition-colors">
            <span class="text-white font-extrabold text-lg tracking-tight">
                Camp<span class="text-[#ED64A6]">lore</span>
            </span>
        </a>

        {{-- Navigasi --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5">

            {{-- Beranda --}}
            <a href="{{ url('/admin/dashboard_admin') }}"
               @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all
                      {{ request()->is('admin/dashboard_admin') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:text-white hover:bg-white/10' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>

            {{-- Section: Manajemen Pesanan --}}
            <p class="px-4 pt-5 pb-1 text-[10px] font-bold text-emerald-400 tracking-widest uppercase">
                Manajemen Pesanan
            </p>

            {{-- Pemesanan --}}
            <a href="{{ url('/admin/pemesanan') }}"
               @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all
                      {{ request()->is('admin/pemesanan*') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:text-white hover:bg-white/10' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Pemesanan
            </a>

            {{-- Transaksi Pembayaran --}}
            <a href="{{ url('/admin/pembayaran') }}"
               @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all
                      {{ request()->is('admin/pembayaran*') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:text-white hover:bg-white/10' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Transaksi Pembayaran
            </a>

            {{-- Section: Manajemen Operasional --}}
            <p class="px-4 pt-5 pb-1 text-[10px] font-bold text-emerald-400 tracking-widest uppercase">
                Manajemen Operasional
            </p>

            {{-- Pengguna --}}
            <a href="{{ url('/admin/customers') }}"
               @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all
                      {{ request()->is('admin/customers*') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:text-white hover:bg-white/10' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Pengguna
            </a>

            {{-- Pengiriman --}}
            <a href="{{ url('/admin/pengiriman') }}"
               @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all
                      {{ request()->is('admin/pengiriman*') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:text-white hover:bg-white/10' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                Pengiriman
            </a>

            {{-- Pengembalian --}}
            <a href="{{ url('/admin/pengembalian') }}"
               @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all
                      {{ request()->is('admin/pengembalian*') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:text-white hover:bg-white/10' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                </svg>
                Pengembalian
            </a>

            {{-- Section: Manajemen Rental --}}
            <p class="px-4 pt-5 pb-1 text-[10px] font-bold text-emerald-400 tracking-widest uppercase">
                Manajemen Rental
            </p>

            {{-- Produk --}}
            <a href="{{ url('/admin/products') }}"
               @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all
                      {{ request()->is('admin/products*') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:text-white hover:bg-white/10' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Produk
            </a>

            {{-- Dropdown: Riwayat Produk --}}
            <div>
                <button
                    @click="openRiwayat = !openRiwayat"
                    :aria-expanded="openRiwayat"
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl text-sm font-semibold transition-all cursor-pointer
                           {{ request()->is('admin/riwayat*') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:text-white hover:bg-white/10' }}"
                >
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Riwayat Produk
                    </span>
                    <svg :class="openRiwayat ? 'rotate-180' : 'rotate-0'"
                         class="h-3 w-3 transition-transform duration-200 text-emerald-400 flex-shrink-0"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div
                    x-show="openRiwayat"
                    x-cloak
                    x-transition:enter="transition-all duration-200 ease-out"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition-all duration-150 ease-in"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="pl-11 pr-4 py-1 space-y-0.5"
                >
                    <a href="{{ url('/admin/riwayat/kamera') }}"
                       @click="sidebarOpen = false"
                       class="flex items-center gap-2 py-2 pl-3 rounded-lg text-[13px] font-medium transition-colors
                              {{ request()->is('admin/riwayat/kamera*') ? 'text-white bg-white/10' : 'text-emerald-200/80 hover:text-white hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 flex-shrink-0"></span>
                        Kamera
                    </a>
                    <a href="{{ url('/admin/riwayat/camping') }}"
                       @click="sidebarOpen = false"
                       class="flex items-center gap-2 py-2 pl-3 rounded-lg text-[13px] font-medium transition-colors
                              {{ request()->is('admin/riwayat/camping*') ? 'text-white bg-white/10' : 'text-emerald-200/80 hover:text-white hover:bg-white/5' }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 flex-shrink-0"></span>
                        Alat Camping
                    </a>
                </div>
            </div>

        </nav>

        {{-- User Card --}}
        <div class="px-4 py-4 border-t border-white/10 flex items-center gap-3 mt-auto">
            <div class="w-9 h-9 rounded-full bg-[#ED64A6]/30 flex items-center justify-center
                        text-white font-bold text-sm flex-shrink-0 select-none">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white text-xs font-bold truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                <p class="text-emerald-400 text-[10px]">Administrator</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Logout"
                        class="text-emerald-400 hover:text-[#ED64A6] transition-colors p-1 rounded-lg hover:bg-white/5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>

    </aside>
</div>