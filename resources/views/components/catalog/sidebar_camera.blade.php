<aside class="w-64 shrink-0 pt-2">

    {{-- KATEGORI --}}
    <div>
        <p class="text-xs font-bold tracking-[0.14em] uppercase text-gray-400 mb-3">
            Kategori
        </p>

        <div class="space-y-2">
            @foreach(['DSLR','Mirrorless','Kamera Aksi','Kamera Instan (Polaroid)','Kamera Video','Semua'] as $cat)
            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer hover:text-black transition">
                <input type="checkbox"
                       class="w-4 h-4 border-gray-300 rounded text-black focus:ring-black">
                {{ $cat }}
            </label>
            @endforeach
        </div>
    </div>

    {{-- DIVIDER --}}
    <div class="border-t my-6"></div>

    {{-- MEREK --}}
    <div>
        <p class="text-xs font-bold tracking-[0.14em] uppercase text-gray-400 mb-3">
            Merek
        </p>

        <div class="grid grid-cols-3 gap-3">

            @foreach($ipCategories as $i => $ip)
            <div class="cursor-pointer text-center group">

                {{-- BOX --}}
                <div class="aspect-square rounded-xl border border-gray-200 bg-white
                            flex items-center justify-center overflow-hidden
                            transition-all duration-300
                            group-hover:border-gray-400 group-hover:shadow-sm">

                    <img
                        src="{{ $ip->image ? asset('storage/'.$ip->image) : 'https://placehold.co/60x60/e8e7e3/aaa?text='.urlencode(Str::limit($ip->name,3,'')) }}"
                        alt="{{ $ip->name }}"
                        class="w-4/5 h-4/5 object-contain"
                    >
                </div>

                {{-- NAME --}}
                <p class="mt-1 text-[10px] text-gray-400 font-semibold uppercase tracking-wide">
                    {{ $ip->name }}
                </p>

            </div>
            @endforeach

        </div>
    </div>

</aside>