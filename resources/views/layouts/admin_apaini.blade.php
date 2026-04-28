<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Camplore')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .nav-item {
            transition: all 0.18s ease;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.08);
            border-left-color: #ED64A6;
        }

        .nav-item.active {
            background: rgba(255, 255, 255, 0.12);
            border-left-color: #ED64A6;
            color: white;
        }

        .nav-badge {
            min-width: 20px;
            height: 20px;
            font-size: 0.65rem;
        }

        @yield('extra-style') [x-cloak] {
            display: none !important;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-[#EEF3F0] text-gray-800">
    <div class="flex min-h-screen">

        {{-- ===== SIDEBAR ===== --}}
        <aside class="w-[240px] min-h-screen bg-gradient-to-b from-[#22543D] to-[#163527] fixed top-0 left-0 bottom-0 flex flex-col z-40 overflow-y-auto">

            {{-- Logo --}}
            <a href="{{ url('/dashboard_admin') }}" class="flex items-center gap-3 px-6 py-6 border-b border-white/10">
                <div class="w-9 h-9 bg-white rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#22543D]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    </svg>
                </div>
                <span class="text-white font-extrabold text-lg tracking-tight">Camp<span class="text-[#ED64A6]">lore</span></span>
            </a>

            {{-- Nav --}}
            <nav class="flex-1 px-3 py-4 space-y-0.5">

                {{-- Beranda --}}
                <a href="{{ url('/dashboard_admin') }}"
                    class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Beranda
                </a>

                {{-- MANAJEMEN PESANAN --}}
                <p class="px-4 pt-4 pb-1 text-[10px] font-bold text-emerald-400 tracking-widest uppercase">Manajemen Pesanan</p>

                <a href="#" class="nav-item flex items-center justify-between px-4 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Pemesanan
                    </span>
                </a>

                <a href="#" class="nav-item flex items-center justify-between px-4 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Transaksi Pembayaran
                    </span>
                    <span class="nav-badge bg-[#ED64A6] text-white rounded-full flex items-center justify-center px-1.5 font-bold">2</span>
                </a>

                {{-- MANAJEMEN OPERASIONAL --}}
                <p class="px-4 pt-4 pb-1 text-[10px] font-bold text-emerald-400 tracking-widest uppercase">Manajemen Operasional</p>

                <a href="{{ route('admin.customers.index') }}"
                    class="nav-item {{ request()->routeIs('admin.customers.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Pengguna / Pelanggan
                </a>

                <a href="#" class="nav-item flex items-center gap-3 px-4 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                    Pengiriman
                </a>

                <a href="#" class="nav-item flex items-center justify-between px-4 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                        </svg>
                        Pengembalian
                    </span>
                    <span class="nav-badge bg-[#ED64A6] text-white rounded-full flex items-center justify-center px-1.5 font-bold">2</span>
                </a>

                {{-- MANAJEMEN RENTAL --}}
                <p class="px-4 pt-4 pb-1 text-[10px] font-bold text-emerald-400 tracking-widest uppercase">Manajemen Rental</p>

                <a href="#" class="nav-item flex items-center gap-3 px-4 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    </svg>
                    Data Kamera
                </a>

                <a href="#" class="nav-item flex items-center gap-3 px-4 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    </svg>
                    Data Camping
                </a>

                <a href="#" class="nav-item flex items-center gap-3 px-4 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Produk
                </a>
            </nav>

            {{-- Admin info --}}
            <div class="px-4 py-4 border-t border-white/10 flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-[#ED64A6]/30 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-xs font-bold truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-emerald-400 text-[10px]">Administrator</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="button" title="Logout" class="text-emerald-400 hover:text-[#ED64A6] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </aside>

        {{-- ===== MAIN ===== --}}
        <div class="ml-[240px] flex-1 flex flex-col min-h-screen">

            {{-- Topbar --}}
            <header class="bg-white border-b border-gray-100 px-8 py-4 flex items-center justify-between sticky top-0 z-30">
                <div>
                    <h1 class="text-lg font-extrabold text-[#22543D] tracking-tight">@yield('page-title', 'Dashboard')</h1>
                    <div class="flex items-center gap-1.5 text-xs text-gray-400 mt-0.5">
                        <a href="{{ url('/dashboard_admin') }}" class="hover:text-[#22543D]">Beranda</a>
                        @yield('breadcrumb')
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-[#22543D]/10 flex items-center justify-center text-[#22543D] font-bold text-sm">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 p-8">
                @if(session('success'))
                <div class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-xl text-sm font-semibold" id="flash">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                    <button onclick="document.getElementById('flash').remove()" class="ml-auto text-emerald-500 hover:text-emerald-800">✕</button>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-5 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-xl text-sm font-semibold" id="flash-err">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('error') }}
                    <button onclick="document.getElementById('flash-err').remove()" class="ml-auto text-red-500">✕</button>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('btn-riwayat');
            const menu = document.getElementById('menu-riwayat');
            const arrow = document.getElementById('arrow-riwayat');

            if (btn && menu) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Toggle Class Hidden
                    menu.classList.toggle('hidden');
                    // Putar Panah
                    arrow.classList.toggle('rotate-180');

                    console.log('Dropdown diklik!'); // Cek di console (F12) untuk mastiin
                });
            }
        });
    </script>
</body>

</html>