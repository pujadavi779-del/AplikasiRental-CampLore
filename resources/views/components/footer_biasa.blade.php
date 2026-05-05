@once
    @push('styles')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
        <style>
            footer, footer * {
                font-family: 'Inter', sans-serif;
            }
        </style>
    @endpush
@endonce

<!-- <footer class="py-8">
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
</footer> -->

<footer class="bg-[#1e3d2f] text-[#7aad8a] text-xs text-center py-5 mt-auto">
    <div class="flex items-center justify-center gap-2">
        <img src="{{ asset('images/logo.png') }}" alt="Camplore" class="h-4 w-auto opacity-60 brightness-200">
        <span>© 2026 Camplore Adventure Ltd. Batam, Indonesia. Seluruh hak dilindungi undang-undang.</span>
    </div>
</footer>