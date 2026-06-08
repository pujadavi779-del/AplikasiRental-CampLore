{{-- Navbar --}}
@if(!request()->routeIs('alamat_pengiriman', 'dashboard'))

@once
@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
<style>
    nav,
    nav * {
        font-family: 'Inter', sans-serif;
    }

    nav .font-serif {
        font-family: 'Playfair Display', serif;
    }
</style>
@endpush
@endonce

@php
$cartCount = auth()->check()
? \App\Models\Cart::where('user_id', auth()->id())->count()
: 0;
@endphp

<nav class="bg-white/95 backdrop-blur-md sticky top-0 z-50 border-b border-pink-100 h-20 flex-shrink-0">
    <div class="max-w-7xl mx-auto px-4 h-full flex justify-between items-center">

        {{-- Logo --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('pages.landing.landing') }}" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Camplore Logo"
                    class="h-10 md:h-12 w-auto object-contain transition-transform duration-300 hover:scale-105">
            </a>
        </div>

        {{-- Nav Links (Desktop) --}}
        <div class="hidden md:flex space-x-8 font-bold text-xs uppercase tracking-widest text-[#1A392D]">
            <a href="{{ route('pages.landing.about') }}" class="hover:text-[#FF6B95] transition">Tentang Kami</a>
            <div class="relative group">
                <a href="#" class="flex items-center gap-1 hover:text-[#FF6B95] transition">
                    Kategori
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
                <div class="fixed left-0 top-[80px] w-full bg-white shadow-2xl border-t border-pink-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-40">
                    <div class="w-full flex justify-center">
                        <div class="w-full max-w-6xl px-6 py-10">
                            <div class="grid grid-cols-2 gap-12 text-center max-w-xl mx-auto">
                                <a href="{{ route('camera.LP') }}" class="group">
                                    <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32" class="w-full h-32 object-cover rounded-xl mb-3 group-hover:scale-105 transition">
                                    <p class="font-serif uppercase tracking-widest">Kamera</p>
                                </a>
                                <a href="{{ route('camping.LP') }}" class="group">
                                    <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4" class="w-full h-32 object-cover rounded-xl mb-3 group-hover:scale-105 transition">
                                    <p class="font-serif uppercase tracking-widest">Camping</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center gap-2">

            {{-- Keranjang (hanya untuk pelanggan, bukan admin) --}}
            @if(!Auth::guard('admin')->check())
            <a href="{{ route('pages.landing.keranjang') }}" class="relative w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 bg-white text-[#1A392D] hover:text-[#FF6B95] transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span id="cart-badge"
                    class="absolute -top-1.5 -right-1.5 bg-[#FF6B95] text-white text-[10px] font-bold min-w-[18px] h-[18px] px-1 flex items-center justify-center rounded-full border-2 border-white">
                    {{ $cartCount }}
                </span>
            </a>
            @endif

            {{-- User (Desktop) --}}
            <div class="relative group hidden md:block">

                {{-- Belum login sama sekali --}}
                @if(!Auth::guard('web')->check() && !Auth::guard('admin')->check())
                <a href="{{ route('login') }}" class="text-[#1A392D] border border-[#1A392D] px-4 py-2 rounded text-sm font-bold hover:bg-[#1A392D] hover:text-white transition">Masuk</a>

                {{-- Login sebagai ADMIN --}}
                @elseif(Auth::guard('admin')->check())
                <button class="flex items-center gap-2 px-3 py-2 rounded-xl border border-emerald-200 bg-emerald-50 hover:bg-emerald-100 transition">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                    <span class="text-sm font-semibold text-emerald-800">{{ Auth::guard('admin')->user()->name }}</span>
                </button>

                {{-- Dropdown Admin --}}
                <div class="absolute right-0 top-12 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 bg-emerald-50/50">
                        <p class="text-sm font-extrabold text-gray-800 truncate">{{ Auth::guard('admin')->user()->name }}</p>
                        <p class="text-xs text-emerald-600 truncate italic normal-case font-semibold">Admin</p>
                    </div>
                    <div class="py-1">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-5 py-3 text-sm font-bold text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-width="2" />
                            </svg>
                            Dashboard Admin
                        </a>
                        <form method="POST" action="{{ route('admin.logout') }}" class="border-t border-gray-100">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 text-left px-5 py-3 text-sm font-bold text-red-500 hover:bg-red-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M17 16l4-4m0 0l-4-4m4 4H7" stroke-width="2" />
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Login sebagai PELANGGAN --}}
                @else
                <button class="flex items-center gap-2 px-3 py-2 rounded-xl border border-gray-200 hover:bg-gray-50 transition">
                    <span class="text-sm font-semibold text-[#1A392D]">{{ auth()->user()->name }}</span>
                </button>

                {{-- Dropdown Pelanggan --}}
                <div class="absolute right-0 top-12 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50">
                        <p class="text-sm font-extrabold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate italic normal-case">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="py-1">
                        <a href="{{ route('dashboard_pelanggan') }}" class="flex items-center gap-3 px-5 py-3 text-sm font-bold text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" />
                            </svg>
                            Profil Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 text-left px-5 py-3 text-sm font-bold text-red-500 hover:bg-red-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M17 16l4-4m0 0l-4-4m4 4H7" stroke-width="2" />
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>

            {{-- Hamburger (Mobile) --}}
            <button id="mobile-menu-btn" class="md:hidden w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 bg-white text-[#1A392D] hover:text-[#FF6B95] transition-all duration-200">
                <svg id="icon-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg id="icon-close" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-pink-100 shadow-lg absolute w-full left-0 z-50 overflow-y-auto max-h-[80vh]">
        <div class="px-4 py-4 flex flex-col gap-1 font-bold text-xs uppercase tracking-widest text-[#1A392D]">

            <a href="{{ route('pages.landing.about') }}" class="px-3 py-3 rounded-xl hover:bg-pink-50 hover:text-[#FF6B95] transition">Tentang Kami</a>

            <div>
                <button id="kategori-btn" class="w-full flex items-center justify-between px-3 py-3 rounded-xl hover:bg-pink-50 hover:text-[#FF6B95] transition">
                    <span>Kategori</span>
                    <svg id="kategori-arrow" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="kategori-submenu" class="hidden px-3 pb-4">
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <a href="{{ route('camera.LP') }}" class="group text-center">
                            <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32" class="w-full h-20 object-cover rounded-xl mb-2">
                            <p class="text-[10px] normal-case">Kamera</p>
                        </a>
                        <a href="{{ route('camping.LP') }}" class="group text-center">
                            <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4" class="w-full h-20 object-cover rounded-xl mb-2">
                            <p class="text-[10px] normal-case">Camping</p>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Mobile: Admin --}}
            @if(Auth::guard('admin')->check())
            <div class="mt-4 border-t border-gray-100 pt-4">
                <div class="px-3 mb-4">
                    <p class="text-sm font-extrabold text-gray-800 normal-case">{{ Auth::guard('admin')->user()->name }}</p>
                    <p class="text-[10px] text-emerald-600 italic normal-case font-semibold">Admin</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-xs normal-case text-emerald-700 hover:bg-emerald-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-width="2" />
                    </svg>
                    Dashboard Admin
                </a>
                <form method="POST" action="{{ route('admin.logout') }}" class="mt-4 pt-2 border-t border-gray-100">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-xs normal-case text-red-500 hover:bg-red-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7" stroke-width="2" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>

            {{-- Mobile: Pelanggan --}}
            @elseif(Auth::guard('web')->check())
            <div class="mt-4 border-t border-gray-100 pt-4">
                <div class="px-3 mb-4">
                    <p class="text-sm font-extrabold text-gray-800 normal-case">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-gray-400 italic normal-case">{{ auth()->user()->email }}</p>
                </div>
                <a href="{{ route('dashboard_pelanggan') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-xs normal-case text-gray-600 hover:bg-pink-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" />
                    </svg>
                    Pesanan Saya
                </a>
                <a href="{{ route('change-password') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-xs normal-case text-gray-600 hover:bg-pink-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="2" />
                    </svg>
                    Ubah Kata Sandi
                </a>
                <a href="{{ route('pages.pelanggan.alamat_pengiriman') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-xs normal-case text-gray-600 hover:bg-pink-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2" />
                    </svg>
                    Alamat Pengiriman
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-4 pt-2 border-t border-gray-100">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-xs normal-case text-red-500 hover:bg-red-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7" stroke-width="2" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>

            {{-- Mobile: Belum login --}}
            @else
            <a href="{{ route('login') }}" class="mt-4 block px-3 py-3 rounded-xl text-center bg-[#1A392D] text-white">Masuk</a>
            @endif

        </div>
    </div>
</nav>

<script>
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const iconOpen = document.getElementById('icon-open');
    const iconClose = document.getElementById('icon-close');

    menuBtn.addEventListener('click', () => {
        const isHidden = mobileMenu.classList.toggle('hidden');
        iconOpen.classList.toggle('hidden', !isHidden);
        iconClose.classList.toggle('hidden', isHidden);
    });

    const kategoriBtn = document.getElementById('kategori-btn');
    const kategoriSubmenu = document.getElementById('kategori-submenu');
    const kategoriArrow = document.getElementById('kategori-arrow');

    kategoriBtn?.addEventListener('click', () => {
        kategoriSubmenu.classList.toggle('hidden');
        kategoriArrow.classList.toggle('rotate-180');
    });
</script>
@endif