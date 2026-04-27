<footer class="py-8">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">

        {{-- Logo & Brand --}}
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Camplore" class="h-8 w-auto object-contain">
            <span class="text-xs font-black text-gray-300 uppercase tracking-widest">
                &copy; {{ date('Y') }} Camplore
            </span>
        </div>

        {{-- Links --}}
        <div class="flex items-center gap-6 text-[11px] font-bold text-gray-300 uppercase tracking-widest">
            <a href="{{ route('pages.landing.about') }}" class="hover:text-[#1B4332] transition">About</a>
            <a href="{{ route('camera.LP') }}" class="hover:text-[#1B4332] transition">Camera</a>
            <a href="{{ route('camping.LP') }}" class="hover:text-[#1B4332] transition">Camping</a>
        </div>

        {{-- Tagline --}}
        <p class="text-[11px] font-bold text-gray-300 uppercase tracking-widest">
            All Rights Reserved
        </p>

    </div>
</footer>