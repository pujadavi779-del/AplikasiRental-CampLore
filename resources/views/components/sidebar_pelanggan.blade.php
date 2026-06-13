<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap');

    * {
        font-family: 'Inter', sans-serif;
    }

    .font-serif {
        font-family: 'Playfair Display', serif !important;
    }
</style>

<aside class="h-full bg-white p-6 rounded-[35px] shadow-sm border border-gray-100 flex flex-col overflow-y-auto no-scrollbar">

    @if(Auth::guard('admin')->check())
    {{-- ===================== TAMPILAN ADMIN ===================== --}}

    {{-- Header Admin --}}
    <div class="flex items-center gap-4 mb-8 px-2">
        <div class="relative flex-shrink-0">
            <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-emerald-700 to-emerald-500 flex items-center justify-center text-white text-lg font-bold shadow-md border-2 border-white ring-2 ring-emerald-50">
                {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 2)) }}
            </div>
            <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full"></span>
        </div>
        <div class="flex flex-col min-w-0">
            <h2 class="text-[15px] font-extrabold text-gray-900 truncate tracking-tight leading-none mb-1">
                {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
            </h2>
            <p class="text-[11px] text-emerald-600 font-semibold truncate">
                Admin
            </p>
        </div>
    </div>

    {{-- Menu Admin --}}
    <div class="px-2">
        <p class="mb-4 text-gray-300 text-[10px] font-bold tracking-[0.2em] uppercase">menu admin</p>
        <nav class="flex flex-col gap-1.5">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 border-l-4
                          {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-50 text-emerald-700 border-emerald-500 shadow-sm' : 'text-gray-500 border-transparent hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard Admin
            </a>
            <a href="{{ route('admin.customers.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 border-l-4
                          {{ request()->routeIs('admin.customers*') ? 'bg-emerald-50 text-emerald-700 border-emerald-500 shadow-sm' : 'text-gray-500 border-transparent hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Kelola Pengguna
            </a>
            <a href="{{ route('admin.products') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 border-l-4
                          {{ request()->routeIs('admin.products*') ? 'bg-emerald-50 text-emerald-700 border-emerald-500 shadow-sm' : 'text-gray-500 border-transparent hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Kelola Produk
            </a>
            <a href="{{ route('admin.pesanan.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 border-l-4
                          {{ request()->routeIs('admin.pesanan*') ? 'bg-emerald-50 text-emerald-700 border-emerald-500 shadow-sm' : 'text-gray-500 border-transparent hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Kelola Pesanan
            </a>
        </nav>
    </div>

    {{-- Footer Logout Admin --}}
    <div class="mt-auto pt-6 border-t border-gray-50">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="w-full group flex items-center justify-between px-4 py-2 rounded-xl hover:bg-red-50 transition-all duration-200">
                <span class="text-xs font-black text-gray-400 group-hover:text-red-500 uppercase tracking-widest">Keluar</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300 group-hover:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                </svg>
            </button>
        </form>
    </div>

    @else
    {{-- ===================== TAMPILAN PELANGGAN ===================== --}}

    {{-- Header Pelanggan --}}
    <div class="flex items-center gap-4 mb-8 px-2">
        <div class="relative flex-shrink-0">
            @if(auth()->user()->foto_profile)
            <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}"
                class="w-14 h-14 rounded-full object-cover border-2 border-white ring-2 ring-green-50 shadow-md">
            @else
            <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-green-600 to-green-400 flex items-center justify-center text-white text-lg font-bold shadow-md border-2 border-white ring-2 ring-green-50">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
            </div>
            @endif
            <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-pink-500 border-2 border-white rounded-full"></span>
        </div>
        <div class="flex flex-col min-w-0">
            <h2 class="text-[15px] font-extrabold text-gray-900 truncate tracking-tight leading-none mb-1">
                {{ auth()->user()->name ?? 'Pelanggan' }}
            </h2>
            <p class="text-[11px] text-gray-400 font-medium truncate italic">
                {{ auth()->user()->email ?? 'user@email.com' }}
            </p>
        </div>
    </div>

    {{-- Menu Pelanggan --}}
    <div class="px-2">
        <p class="mb-4 text-gray-300 text-[10px] font-bold tracking-[0.2em] uppercase">menu</p>
        <nav class="flex flex-col gap-1.5">
            <a href="{{ route('dashboard_pelanggan') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 border-l-4
                          {{ request()->routeIs('dashboard_pelanggan') ? 'bg-pink-50 text-pink-600 border-pink-500 shadow-sm' : 'text-gray-500 border-transparent hover:bg-gray-50 hover:text-green-600 hover:border-green-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Pesanan Saya
            </a>
            <a href="{{ route('change-password') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 border-l-4
                          {{ request()->routeIs('change-password') ? 'bg-pink-50 text-pink-600 border-pink-500 shadow-sm' : 'text-gray-500 border-transparent hover:bg-gray-50 hover:text-green-600 hover:border-green-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Ubah Kata Sandi
            </a>
            <a href="{{ route('pages.pelanggan.settings') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 border-l-4
                          {{ request()->routeIs('pages.pelanggan.settings') ? 'bg-pink-50 text-pink-600 border-pink-500 shadow-sm' : 'text-gray-500 border-transparent hover:bg-gray-50 hover:text-green-600 hover:border-green-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Pengaturan
            </a>
            <a href="{{ route('pages.pelanggan.alamat_pengiriman') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 border-l-4
                          {{ request()->routeIs('pages.pelanggan.alamat_pengiriman') ? 'bg-pink-50 text-pink-600 border-pink-500 shadow-sm' : 'text-gray-500 border-transparent hover:bg-gray-50 hover:text-green-600 hover:border-green-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Alamat pengiriman
            </a>
        </nav>
    </div>

    {{-- Footer Logout Pelanggan --}}
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

    @endif

</aside>