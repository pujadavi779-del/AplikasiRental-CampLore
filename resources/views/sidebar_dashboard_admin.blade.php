{{-- ═══ SIDEBAR ═══ --}}
<aside id="top-bar-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">

    <div class="flex flex-col h-full pb-4 pt-5"
        style="background:#e5e6d8; font-family:'DM Sans',sans-serif;">

        {{-- Logo --}}
        <div class="flex items-center gap-2.5 px-[18px] pb-[18px]"
            style="border-bottom:0.5px solid #c8c9b4;">
            <div class="flex items-center justify-center flex-shrink-0 w-[34px] h-[34px] rounded-lg"
                style="background:#5a7a3a;">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="#dff0c0" stroke-width="2">
                    <path d="M12 2L2 7l10 5 10-5-10-5z" />
                    <path d="M2 17l10 5 10-5" />
                    <path d="M2 12l10 5 10-5" />
                </svg>
            </div>
            <span class="text-[17px]" style="font-family:'DM Serif Display',serif; color:#2a3020;">CampLore</span>
        </div>

        {{-- Nav --}}
        <div class="flex flex-col flex-1 gap-0.5 px-2.5 py-3.5">
            <a href="{{ url('/dashboard_admin') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('dashboard_admin')
                          ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]'
                          : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('dashboard_admin') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('dashboard_admin') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('dashboard_admin') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="2">
                    <path d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z" />
                    <path d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975A7.5 7.5 0 0 0 13.5 3Z" />
                </svg>
                Beranda
            </a>
            
            <p class="text-[9.5px] font-semibold tracking-[.12em] uppercase px-2 pt-2.5 pb-1"
                style="color:#7a8060;">Manajemen Pesanan</p>

            {{-- Nav Link Macro --}}
            @php
            $link = fn($url, $match, $icon, $label, $badge = null) => [$url, $match, $icon, $label, $badge];
            @endphp

            <a href="{{ url('/Pemesanan') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('Pemesanan') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('Pemesanan') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('Pemesanan') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('Pemesanan') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="2">
                    <path d="M15 5v14M9 5v14M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                </svg>
                <span class="flex-1">Pemesanan</span>
                <span class="text-[10px] font-semibold px-[7px] py-[1px] rounded-full"
                    style="background:#c8d0a8;color:#3a4820;border:0.5px solid #a8b088;">Pro</span>
            </a>

            <a href="{{ url('/Transaksi Pembayaran') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('Transaksi Pembayaran') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('Transaksi Pembayaran') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('Transaksi Pembayaran') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('Transaksi Pembayaran') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="2">
                    <path d="M4 13h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H20M4 13v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M4 13l2-9h12l2 9" />
                </svg>
                <span class="flex-1">Transaksi Pembayaran</span>
                <span class="text-[10px] font-semibold px-[7px] py-[1px] rounded-full"
                    style="background:#f0c8c0;color:#802018;border:0.5px solid #dca898;">2</span>
            </a>

            <div class="my-2 mx-2.5" style="height:0.5px;background:#c8c9b4;"></div>

            <p class="text-[9.5px] font-semibold tracking-[.12em] uppercase px-2 pt-2.5 pb-1"
                style="color:#7a8060;">Manajemen Operasional</p>

            {{-- Nav Link Macro --}}
            @php
            $link = fn($url, $match, $icon, $label, $badge = null) => [$url, $match, $icon, $label, $badge];
            @endphp


            <a href="{{ url('/users') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('users') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('users') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('users') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('users') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="2">
                    <path d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Users
            </a>

            <a href="{{ url('/pengiriman') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('pengiriman') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('pengiriman') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('pengiriman') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('pengiriman') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="2">
                    <path d="M15 5v14M9 5v14M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                </svg>
                <span class="flex-1">Pengiriman</span>
                <span class="text-[10px] font-semibold px-[7px] py-[1px] rounded-full"
                    style="background:#c8d0a8;color:#3a4820;border:0.5px solid #a8b088;">Pro</span>
            </a>

            <a href="{{ url('/Pengembalian') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('Pengembalian') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('Penjemputan') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('Pengembalian') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('Pengembalian') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="2">
                    <path d="M4 13h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H20M4 13v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M4 13l2-9h12l2 9" />
                </svg>
                <span class="flex-1">Pengembalian</span>
                <span class="text-[10px] font-semibold px-[7px] py-[1px] rounded-full"
                    style="background:#f0c8c0;color:#802018;border:0.5px solid #dca898;">2</span>
            </a>

            <div class="my-2 mx-2.5" style="height:0.5px;background:#c8c9b4;"></div>
            <p class="text-[9.5px] font-semibold tracking-[.12em] uppercase px-2 pt-2.5 pb-1"
                style="color:#7a8060;">Manajemen Rental</p>

            <a href="{{ route('camera.index') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('camera*') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('camera*') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('camera*') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('camera*') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="2">
                    <path d="M4 7h4l2-2h4l2 2h4v12H4z" />
                    <circle cx="12" cy="13" r="3" />
                </svg>
                Data Kamera
            </a>

            <a href="{{ route('camping.index') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('camping') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('camping') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('camping') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('camping') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="2">
                    <path d="M3 20l9-16 9 16H3z" />
                </svg>
                Data Camping
            </a>



            <a href="{{ url('/products') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('products') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('products') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('products') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('products') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="2">
                    <path d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z" />
                </svg>
                Products
            </a>

            <a href="{{ url('/login') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('login') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('login') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('login') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('login') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="2">
                    <path d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2" />
                </svg>
                <span class="flex-1">Sign In</span>
                <span class="text-[10px] font-semibold px-[7px] py-[1px] rounded-full"
                    style="background:#c8d8e8;color:#1a3a60;border:0.5px solid #a0b8d0;">New</span>
            </a>

            <div class="flex-1"></div>
            <div class="my-2 mx-2.5" style="height:0.5px;background:#c8c9b4;"></div>

            <a href="{{ url('/settings') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('settings') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('settings') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('settings') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('settings') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="2">
                    <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                Settings
            </a>
        </div>

        {{-- User Card --}}
        <div class="mx-2.5" style="height:0.5px;background:#c8c9b4;"></div>
        <div class="flex items-center gap-[9px] p-2.5 mx-2.5 mt-2 rounded-[10px] cursor-pointer"
            style="background:#d4d6c4;border:0.5px solid #c8c9b4;">
            <img class="w-[30px] h-[30px] rounded-full object-cover flex-shrink-0"
                style="border:1.5px solid #a8b890;"
                src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'User').'&background=5a7a3a&color=dff0c0' }}"
                alt="Profile">
            <div class="flex-1 min-w-0">
                <p class="text-[12px] font-semibold m-0 whitespace-nowrap overflow-hidden text-ellipsis"
                    style="color:#2a3020;">
                    {{ Auth::user()->name ?? 'Lulu Khaira' }}
                </p>
                <p class="text-[10px] m-0" style="color:#6a7858;">
                    {{ Auth::user()->email ?? 'Administrator' }}
                </p>
            </div>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8a9070" stroke-width="2">
                <circle cx="12" cy="5" r="1" />
                <circle cx="12" cy="12" r="1" />
                <circle cx="12" cy="19" r="1" />
            </svg>
        </div>

    </div>
</aside>