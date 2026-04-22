<aside class="h-full bg-white p-8 rounded-[35px] shadow-sm border border-gray-100 flex flex-col overflow-y-auto no-scrollbar">
        <div class="text-center">
        <img src="https://ui-avatars.com/api/?name=Rizka+Nur&background=16a34a&color=fff&size=120&bold=true" alt="Foto Profil" class="w-24 h-24 rounded-full border-4 border-green-50 object-cover shadow-sm mx-auto mb-5">
        <h2 class="text-lg font-extrabold text-gray-900 tracking-tight">Rizka Nur</h2>
        <p class="text-[11px] text-green-700 font-medium">rizkaanurr@gmail.com</p>
    </div>

    <nav class="space-y-2 pt-6 border-t border-gray-50 flex-1">
        @php
        $menus = [
        ['url' => 'profil', 'label' => 'Riwayat Sewa', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['url' => 'ubah_password', 'label' => 'Ubah Password', 'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
        ['url' => 'settings', 'label' => 'Pengaturan', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
        ['url' => 'alamat_pengiriman', 'label' => 'Alamat Pengiriman', 'icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z'],
        ];
        @endphp

        @foreach($menus as $menu)
        <a href="{{ url($menu['url']) }}"
            class="flex items-center gap-3 px-4 py-3 text-[13px] font-bold rounded-2xl transition-all duration-200 
           {{ request()->is($menu['url']) ? 'text-pink-700 bg-pink-50 shadow-sm' : 'text-gray-400 hover:bg-gray-50 hover:text-green-800' }}">
            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}" />
            </svg>
            {{ $menu['label'] }}
        </a>
        @endforeach
    </nav>

    <form method="POST" action="{{ route('logout') }}" class="pt-6 border-t border-gray-50">
        @csrf
        <button type="submit" class="w-full text-center text-xs font-bold text-gray-400 hover:text-pink-700 transition">
            Keluar
        </button>
    </form>
</aside>