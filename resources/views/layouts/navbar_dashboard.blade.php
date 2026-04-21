<nav class="bg-white/95 backdrop-blur-md sticky top-0 z-50 border-b border-pink-100">
    <div class="max-w-7xl mx-auto px-4 h-20 flex justify-between items-center">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Camplore Logo"
                class="h-10 md:h-12 w-auto object-contain transition-transform duration-300 hover:scale-105">
        </a>

        {{-- Menu Tengah --}}
        <div class="hidden md:flex space-x-8 font-bold text-xs uppercase tracking-widest text-[#1A392D]">
            <a href="{{ route('about') }}" class="hover:text-[#ED64A6] transition">About</a>

            {{-- Catalog Dropdown --}}
            <div class="relative group">
                <a href="#" class="hover:text-[#ED64A6] transition flex items-center gap-1">Catalog ▼</a>
                <div class="fixed left-0 top-[80px] w-full bg-white shadow-2xl border-t border-pink-100
                    opacity-0 invisible group-hover:opacity-100 group-hover:visible
                    transition-all duration-300 z-40">
                    <div class="w-full flex justify-center">
                        <div class="w-full max-w-4xl px-6 py-10">
                            <div class="grid grid-cols-2 gap-8 max-w-lg mx-auto text-center">
                                <a href="{{ route('catalog.camera') }}" class="group/item">
                                    <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&q=80&w=400"
                                        class="w-full h-40 object-cover rounded-2xl mb-3 group-hover/item:scale-105 transition shadow">
                                    <p class="text-sm font-bold text-[#22543D]">📷 Camera</p>
                                </a>
                                <a href="{{ route('catalog.camping') }}" class="group/item">
                                    <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&q=80&w=400"
                                        class="w-full h-40 object-cover rounded-2xl mb-3 group-hover/item:scale-105 transition shadow">
                                    <p class="text-sm font-bold text-[#22543D]">⛺ Camping</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kanan: Search + Cart + Profile --}}
        <div class="flex items-center gap-2">
            {{-- Search --}}
            <button class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 bg-white text-[#1A392D] hover:text-[#ED64A6] hover:border-pink-200 hover:bg-pink-50 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>

            {{-- Cart --}}
            <a href="/rental" class="relative w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 bg-white text-[#1A392D] hover:text-[#ED64A6] hover:border-pink-200 hover:bg-pink-50 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="absolute -top-1.5 -right-1.5 bg-[#ED64A6] text-white text-[10px] font-bold min-w-[18px] h-[18px] px-1 flex items-center justify-center rounded-full border-2 border-white">0</span>
            </a>

            {{-- Profile Dropdown --}}
            <div class="relative group">
                <button class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 bg-white text-[#1A392D] hover:text-[#ED64A6] hover:border-pink-200 hover:bg-pink-50 transition-all overflow-hidden">
                    @if(auth()->check() && auth()->user()->photo)
                        <img src="{{ asset('storage/'.auth()->user()->photo) }}" class="w-full h-full object-cover">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    @endif
                </button>

                {{-- Dropdown --}}
                <div class="absolute right-0 top-12 w-52 bg-white rounded-2xl shadow-xl border border-gray-100
                    opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-bold text-gray-800">{{ auth()->user()->name ?? 'Pelanggan' }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                    <div class="py-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-[#ED64A6] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Rent History
                        </a>
                        <a href="{{ route('shipping-address') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-[#ED64A6] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Shipping Address
                        </a>
                        <div class="border-t border-gray-100 mt-1 pt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>