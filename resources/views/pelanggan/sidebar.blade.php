<aside class="w-full lg:w-72 space-y-8 bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex-shrink-0">
    <div class="text-center">
        <img src="https://ui-avatars.com/api/?name=M+Falih+Hilmy&background=16a34a&color=fff&size=120&bold=true" alt="Foto M. Falih Hilmy" class="w-28 h-28 rounded-full border-4 border-green-100 object-cover shadow-sm mx-auto mb-5">
        <h2 class="text-lg font-semibold text-gray-900">M. Falih Hilmy</h2>
        <p class="text-xs text-green-700">falihhilmy72@gmail.com</p>
    </div>

    <nav class="space-y-3 pt-6 border-t border-gray-100">
        <a href="/riwayat" class="flex items-center gap-3 px-3.5 py-2.5 text-sm {{ Request::is('riwayat*') ? 'font-semibold text-pink-700 rounded-xl bg-pink-50 shadow-inner' : 'font-medium text-gray-600 rounded-xl hover:bg-gray-50 hover:text-green-800' }} transition">
            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Riwayat Sewa
        </a>

        <a href="/ubah-password" class="flex items-center gap-3 px-3.5 py-2.5 text-sm {{ Request::is('ubah-password*') ? 'font-semibold text-pink-700 rounded-xl bg-pink-50 shadow-inner' : 'font-medium text-gray-600 rounded-xl hover:bg-gray-50 hover:text-green-800' }} transition">
            <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            Ubah Password
        </a>

        <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50 hover:text-green-800 transition">
            <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Pengaturan
        </a>
    </nav>

    <form action="/logout" method="POST">
        @csrf
        <button type="submit" class="w-full text-center flex items-center justify-center gap-3 px-3 py-2 text-xs font-semibold text-gray-400 rounded-xl hover:bg-pink-50 hover:text-pink-700 transition mt-6">
            Keluar
        </button>
    </form>
</aside>