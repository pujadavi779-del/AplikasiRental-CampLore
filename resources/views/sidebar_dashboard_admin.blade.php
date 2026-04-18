<aside class="w-[272px] min-h-screen bg-gradient-to-b from-[#22543D] to-[#163527] fixed top-0 left-0 bottom-0 flex flex-col z-40 overflow-y-auto">
    {{-- Logo --}}
    <a href="{{ url('/dashboard_admin') }}" class="flex items-center gap-3 px-6 py-6 border-b border-white/10">
        <div class="w-9 h-9 bg-white rounded-xl flex items-center justify-center flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#22543D]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
            </svg>
        </div>
        <span class="text-white font-extrabold text-lg tracking-tight">Camp<span class="text-[#ED64A6]">lore</span></span>
    </a>

    {{-- Nav Container dengan Alpine.js untuk handle Dropdown --}}
    <nav class="flex-1 px-3 py-4 space-y-0.5" x-data="{ openRiwayat: {{ request()->is('dashboard/admin/riwayat*') ? 'true' : 'false' }} }">

        <a href="{{ url('/dashboard_admin') }}"
            class="nav-item {{ request()->is('dashboard_admin') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Beranda
        </a>

        <p class="px-4 pt-4 pb-1 text-[10px] font-bold text-emerald-400 tracking-widest uppercase font-sans">Manajemen Pesanan</p>

        <a href="{{ url('/pemesanan') }}"
            class="nav-item {{ request()->is('dashboard/admin/pemesanan') ? 'active' : '' }} flex items-center justify-between px-4 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold transition-all">
            <span class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Pemesanan
            </span>
        </a>

        <a href="{{ url('/pembayaran') }}"
            class="nav-item {{ request()->is('dashboard/admin/pembayaran') ? 'active' : '' }} flex items-center justify-between px-4 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold transition-all">
            <span class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Transaksi Pembayaran
            </span>
            <span class="nav-badge bg-[#ED64A6] text-white rounded-full flex items-center justify-center px-1.5 font-bold text-[10px] min-w-[20px] h-5">2</span>
        </a>

        <p class="px-4 pt-4 pb-1 text-[10px] font-bold text-emerald-400 tracking-widest uppercase font-sans">Manajemen Operasional</p>

        <a href="{{ url('/customers') }}"
            class="nav-item {{ request()->is('dashboard/admin/customers') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Users / Customer
        </a>

        <a href="{{ url('/pengiriman') }}"
            class="nav-item {{ request()->is('pengiriman') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
            </svg>
            Pengiriman
        </a>

        <a href="{{ url('/pengembalian') }}"
            class="nav-item {{ request()->is('Pengembalian') ? 'active' : '' }} flex items-center justify-between px-4 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold transition-all">
            <span class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                </svg>
                Pengembalian
            </span>
            <span class="nav-badge bg-[#ED64A6] text-white rounded-full flex items-center justify-center px-1.5 font-bold text-[10px] min-w-[20px] h-5">2</span>
        </a>

        <p class="px-4 pt-4 pb-1 text-[10px] font-bold text-emerald-400 tracking-widest uppercase font-sans">Manajemen Rental</p>

        <a href="{{ url('/admin/products') }}"
            class="nav-item {{ request()->is('products') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            Products
        </a>

        {{-- Dropdown Riwayat Produk --}}
        <div class="px-0"> {{-- Pastikan padding luar 0 agar sejajar dengan nav-item lain --}}
            <details class="group outline-none list-none">
                <summary class="flex items-center justify-between px-4 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold transition-all cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                    <span class="flex items-center gap-3">
                        {{-- Icon Jam --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Riwayat Produk
                    </span>
                    {{-- Icon Panah --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transition-transform duration-200 group-open:rotate-180 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </summary>

                {{-- Sub-menu: pl-11 agar teks 'Kamera' sejajar dengan teks 'Riwayat Produk' di atasnya --}}
                <div class="pl-11 pr-4 py-1 space-y-1">
                    <a href="{{ url('/dashboard/admin/riwayat/kamera') }}"
                        class="block py-2 text-[13px] text-emerald-200/80 hover:text-white transition-colors relative before:content-[''] before:absolute before:left-[-12px] before:top-1/2 before:-translate-y-1/2 before:w-1 before:h-1 before:bg-emerald-500 before:rounded-full">
                        Kamera
                    </a>
                    <a href="{{ url('/dashboard/admin/riwayat/camping') }}"
                        class="block py-2 text-[13px] text-emerald-200/80 hover:text-white transition-colors relative before:content-[''] before:absolute before:left-[-12px] before:top-1/2 before:-translate-y-1/2 before:w-1 before:h-1 before:bg-emerald-500 before:rounded-full">
                        Alat Camping
                    </a>
                </div>
            </details>
        </div>
    </nav>

    {{-- User Card --}}
    <div class="px-4 py-4 border-t border-white/10 flex items-center gap-3 mt-auto">
        <div class="w-9 h-9 rounded-full bg-[#ED64A6]/30 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-white text-xs font-bold truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
            <p class="text-emerald-400 text-[10px]">Administrator</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" title="Logout" class="text-emerald-400 hover:text-[#ED64A6] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
        </form>
    </div>
</aside>