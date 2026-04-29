
<aside class="h-full bg-white p-6 rounded-[35px] shadow-sm border border-gray-100 flex flex-col overflow-y-auto no-scrollbar">
    
    {{-- Header: Profile Info (Horizontal Layout) --}}
    <div class="flex items-center gap-4 mb-8 px-2">
        {{-- Avatar Lingkaran --}}
        <div class="relative flex-shrink-0">
            <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-green-600 to-green-400 flex items-center justify-center text-white text-lg font-bold shadow-md border-2 border-white ring-2 ring-green-50">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
            </div>
            <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-pink-500 border-2 border-white rounded-full"></span>
        </div>

        {{-- Nama & Email --}}
        <div class="flex flex-col min-w-0">
            <h2 class="text-[15px] font-extrabold text-gray-900 truncate tracking-tight leading-none mb-1">
                {{ auth()->user()->name ?? 'Pelanggan' }}
            </h2>
            <p class="text-[11px] text-gray-400 font-medium truncate italic">
                {{ auth()->user()->email ?? 'user@email.com' }}
            </p>
        </div>
    </div>

    {{-- Menu Label --}}
    <div class="px-2">
        <p class="mb-4 text-gray-300 text-[10px] font-bold tracking-[0.2em] uppercase">menu</p>
        
        <nav class="flex flex-col gap-1.5">
            {{-- Rent History --}}
            <a href="{{ route('dashboard_pelanggan') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 border-l-4
                      {{ request()->routeIs('dashboard_pelanggan')
                        ? 'bg-pink-50 text-pink-600 border-pink-500 shadow-sm'
                        : 'text-gray-500 border-transparent hover:bg-gray-50 hover:text-green-600 hover:border-green-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Pesanan Saya
            </a>

            {{-- Change Password --}}
            <a href="{{ route('change-password') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 border-l-4
                      {{ request()->routeIs('change-password')
                        ? 'bg-pink-50 text-pink-600 border-pink-500 shadow-sm'
                        : 'text-gray-500 border-transparent hover:bg-gray-50 hover:text-green-600 hover:border-green-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Ubah Kata Sandi
            </a>

            {{-- Settings --}}
            <a  href="{{ route('pages.pelanggan.settings') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 border-l-4
                      {{ request()->routeIs('pages.pelanggan.settings')
                        ? 'bg-pink-50 text-pink-600 border-pink-500 shadow-sm'
                        : 'text-gray-500 border-transparent hover:bg-gray-50 hover:text-green-600 hover:border-green-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Pengaturan
            </a>

            {{-- Shipping Address --}}
            <a href="{{ route('pages.pelanggan.alamat_pengiriman') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 border-l-4
                      {{ request()->routeIs('pages.pelanggan.alamat_pengiriman')
                        ? 'bg-pink-50 text-pink-600 border-pink-500 shadow-sm'
                        : 'text-gray-500 border-transparent hover:bg-gray-50 hover:text-green-600 hover:border-green-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Alamat pengiriman
            </a>
        </nav>
    </div>

    {{-- Footer: Logout --}}
    <div class="mt-auto pt-6 border-t border-gray-50">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full group flex items-center justify-between px-4 py-2 rounded-xl hover:bg-red-50 transition-all duration-200">
                <span class="text-xs font-black text-gray-400 group-hover:text-red-500 uppercase tracking-widest">Keluar</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300 group-hover:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                </svg>
            </button>
        </form>
    </div>
</aside>