<!DOCTYPE html>
<html>

<head>
    <title>@yield('title', 'Rental App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>

<body>

    {{-- Navbar --}}
    @if(!request()->routeIs('alamat_pengiriman', 'dashboard'))
    <!-- Navbar -->
    <nav class="bg-white/95 backdrop-blur-md sticky top-0 z-50 border-b border-pink-100">
        <div class="max-w-7xl mx-auto px-4 h-20 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <a href="{{ route('pages.landing.landing') }}" class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}"
                        alt="Camplore Logo"
                        class="h-10 md:h-12 w-auto object-contain transition-transform duration-300 hover:scale-105">
                </a>
            </div>

            <!-- Menu Tengah (Desktop) -->
            <div class="hidden md:flex space-x-8 font-bold text-xs uppercase tracking-widest text-[#1A392D]">
                <a href="{{ route('pages.landing.about') }}" class="hover:text-[#FF6B95] transition">About</a>
                <div class="relative group">

                    <!-- tombol -->
                    <a href="#"
                        class="flex items-center gap-1 font-mediumhover:text-[#FF6B95] transition">
                        Kategori
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-black transition-transform duration-300 group-hover:rotate-180"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>

                    <!-- mega menu -->
                    <div class="fixed left-0 top-[80px] w-full bg-white shadow-2xl border-t border-pink-100
                opacity-0 invisible
                group-hover:opacity-100 group-hover:visible
                transition-all duration-300 z-40">

                        <div class="w-full flex justify-center">
                            <div class="w-full max-w-6xl px-6 py-10">
                                <div class="grid grid-cols-2 gap-12 text-center justify-center max-w-xl mx-auto">

                                    <a href="{{ route('camera.LP') }}" class="group">
                                        <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32"
                                            class="w-full h-32 object-cover rounded-xl mb-3
                                   group-hover:scale-105 transition">
                                        <p class="text-sm font-semibold">Camera</p>
                                    </a>

                                    <a href="{{ route('camping.LP') }}" class="group">
                                        <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4"
                                            class="w-full h-32 object-cover rounded-xl mb-3
                                   group-hover:scale-105 transition">
                                        <p class="text-sm font-semibold">Camping</p>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Kanan: Search & Cart (Login dihapus) -->
            <div class="flex items-center gap-2">

                <!-- Search Icon -->
                <button class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 bg-white text-[#1A392D] hover:text-[#FF6B95] hover:border-pink-200 hover:bg-pink-50 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Cart Icon with Badge -->
                <a href="{{ route('pages.landing.rental') }}" class="relative w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 bg-white text-[#1A392D] hover:text-[#FF6B95] hover:border-pink-200 hover:bg-pink-50 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <!-- Badge Angka -->
                    <span id="nav-cart-count" class="absolute -top-1.5 -right-1.5 bg-[#FF6B95] text-white text-[10px] font-bold min-w-[18px] h-[18px] px-1 flex items-center justify-center rounded-full border-2 border-white">1</span>
                </a>
                <div class="relative group">

                    @guest
                    <!-- Tombol Login -->
                    <a href="{{ route('login') }}"
                        class="text-[#1A392D] bg-gray-200 border border-[#1A392D] hover:bg-[#1A392D] hover:text-white px-4 py-2 rounded inline-block text-sm font-bold">
                        Login
                    </a>
                    @endguest

                    @auth
                    <!-- Trigger (nama / icon user) -->
                    <button class="flex items-center gap-2 px-3 py-2 rounded-xl border border-gray-200 hover:bg-gray-50">
                        <span class="text-sm font-semibold text-[#1A392D]">
                            {{ auth()->user()->name }}
                        </span>
                    </button>

                    <!-- Dropdown -->
                    <div class="absolute right-0 top-12 w-52 bg-white rounded-2xl shadow-xl border border-gray-100
                        opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">

                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-bold text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                        </div>

                        <!-- PROFILE -->
                        <a href="{{ route('dashboard_pelanggan') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            Profile
                        </a>

                        <!-- LOGOUT -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">
                                Logout
                            </button>
                        </form>
                    </div>
                    @endauth

                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-[#22543D] text-[10px] font-bold uppercase tracking-widest">
                @yield('NavParent')
            </span>
            <!-- <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#22543D" stroke-width="3">
            <path d="M9 18l6-6-6-6" />
        </svg> -->
            <span class="text-[#ED64A6] text-[10px] font-bold uppercase tracking-widest">
                @yield('section')
            </span>
        </div>
    </nav>
    @endif
    @yield('content')

    @stack('scripts')



</body>

</html>