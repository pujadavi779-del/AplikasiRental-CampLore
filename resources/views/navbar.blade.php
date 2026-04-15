    <!-- Navbar -->
    <nav class="bg-white/95 backdrop-blur-md sticky top-0 z-50 border-b border-pink-100">
        <div class="max-w-7xl mx-auto px-4 h-20 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <a href="{{ route('landing') }}" class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}"
                        alt="Camplore Logo"
                        class="h-10 md:h-12 w-auto object-contain transition-transform duration-300 hover:scale-105">
                </a>
            </div>

            <!-- Menu Tengah (Desktop) -->
            <div class="hidden md:flex space-x-8 font-bold text-xs uppercase tracking-widest text-[#1A392D]">
                <a href="{{ route('about') }}" class="hover:text-[#FF6B95] transition">About</a>
                <div class="relative group">

                    <!-- tombol -->
                    <a href="#" class="hover:text-[#FF6B95] transition flex items-center gap-1">
                        Catalog ▼
                    </a>

                    <div class="fixed left-0 top-[80px] w-full bg-white shadow-2xl border-t border-pink-100 
            opacity-0 invisible group-hover:opacity-100 group-hover:visible 
            transition-all duration-300 z-40">

                        <!-- CENTER FIX -->
                        <div class="w-full flex justify-center">

                            <div class="w-full max-w-6xl px-6 py-10">

                                <div class="grid grid-cols-4 gap-8 text-center justify-center">

                                    <a href="{{ route('camera.LP') }}" class="group">
                                        <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32"
                                            class="w-full h-32 object-cover rounded-xl mb-3 group-hover:scale-105 transition">
                                        <p class="text-sm font-semibold">Camera</p>
                                    </a>

                                    <a href="#" class="group">
                                        <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4"
                                            class="w-full h-32 object-cover rounded-xl mb-3 group-hover:scale-105 transition">
                                        <p class="text-sm font-semibold">Camping</p>
                                    </a>

                                    <a href="#" class="group">
                                        <img src="https://images.unsplash.com/photo-1520390138845-fd2d229dd553"
                                            class="w-full h-32 object-cover rounded-xl mb-3 group-hover:scale-105 transition">
                                        <p class="text-sm font-semibold">Accessories</p>
                                    </a>

                                    <a href="#" class="group">
                                        <div class="w-full h-32 bg-gray-100 rounded-xl flex items-center justify-center mb-3">
                                            <span class="text-2xl">+</span>
                                        </div>
                                        <p class="text-sm font-semibold">All Products</p>
                                    </a>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Kanan: Search, Cart, Login -->
            <div class="flex items-center space-x-5">
                <!-- Search Icon -->
                <button class="p-2 text-[#1A392D] hover:text-[#FF6B95] transition transform hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Cart Icon with Badge -->
                <a href="rental" class="relative p-2 text-[#1A392D] hover:text-[#FF6B95] transition transform hover:scale-110 inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <!-- Badge Angka -->
                    <span id="nav-cart-count" class="absolute top-0 right-0 bg-[#FF6B95] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">1</span>
                </a>

                <!-- Login Button -->
                <a href="/login" class="bg-[#1A392D] text-white px-6 py-2.5 rounded-full font-bold text-sm hover:bg-[#FF6B95] hover:shadow-lg transition-all transform active:scale-95">
                    Login
                </a>
            </div>
        </div>
    </nav>