@extends('layouts.dashboard_pelanggan')
@section('title', 'Home - Camplore')

@section('content')

{{-- HERO --}}
<section class="relative min-h-[90vh] flex items-center justify-center bg-[#22543D] text-white overflow-hidden">
    <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1510312305653-8ed496efae75?auto=format&fit=crop&q=80')] bg-cover bg-center"></div>
    <div class="absolute -top-16 -left-16 w-64 h-64 bg-[#ED64A6]/20 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-16 -right-16 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
    <div class="relative z-10 text-center px-4 max-w-4xl" data-aos="zoom-in">
        <p class="text-emerald-300 text-sm font-bold tracking-widest uppercase mb-3">Welcome back, {{ auth()->user()->name ?? 'Explorer' }} </p>
        <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight tracking-tighter">Capture <span class="text-[#ED64A6]">Nature</span>,<br>Experience Freedom.</h1>
        <p class="text-lg text-emerald-100 mb-10 max-w-2xl mx-auto leading-relaxed">Sewakan perlengkapan Camping premium dan Kamera profesional dalam satu tempat.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('catalog.camera') }}" class="bg-[#ED64A6] text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-[#22543D] transition-all shadow-lg transform hover:scale-105">Browse Camera</a>
            <a href="{{ route('catalog.camping') }}" class="bg-white/10 border border-white/20 text-white px-10 py-4 rounded-full font-semibold text-lg hover:bg-white/20 transition">Browse Camping</a>
        </div>
    </div>
</section>

{{-- ===== CATALOG SECTION (WIREFRAME STYLE) ===== --}}
<section class="py-20 bg-gray-100">
    <div class="max-w-7xl mx-auto px-6">

        {{-- Section Header --}}
        <div class="text-center mb-12" data-aos="fade-up">
            <p class="text-[#ED64A6] font-bold tracking-widest uppercase text-sm mb-2">Perpustakaan Perlengkapan Kami</p>
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">Perlengkapan Petualangan Unggulan</h2>
            <p class="text-gray-500 mt-4 text-base max-w-xl mx-auto">Peralatan terpopuler yang siap menemani perjalananmu minggu ini.</p>
        </div>

        {{-- Grid 4 Kolom - Semua item digabung --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- CAMERAS --}}
            @foreach($cameras as $i => $item)
            <a href="{{ route('product.detail', $item['id']) }}"
               class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200 flex flex-col"
               data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">

                {{-- Image area --}}
                <div class="relative bg-gray-100 aspect-square overflow-hidden flex items-center justify-center">
                    @if(!empty($item['img']))
                        <img src="{{ $item['img'] }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             alt="{{ $item['name'] }}"
                             onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center\'><svg xmlns=\'http://www.w3.org/2000/svg\' class=\'h-16 w-16 text-gray-300\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg></div>'">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    @endif
                    {{-- Badge kategori --}}
                    <span class="absolute top-3 left-3 bg-[#22543D] text-white text-xs font-bold px-2.5 py-1 rounded-full"> Camera</span>
                </div>

                {{-- Card body --}}
                <div class="p-5 flex flex-col flex-1">
                    <h3 class="font-bold text-gray-800 text-base leading-tight mb-1">{{ $item['name'] }}</h3>
                    <p class="text-[#ED64A6] font-extrabold text-lg mb-4">{{ $item['price_label'] }}</p>
                    <div class="mt-auto">
                        <button class="w-full py-2.5 bg-white border-2 border-[#22543D] text-[#22543D] rounded-xl font-bold text-sm hover:bg-[#22543D] hover:text-white transition-all duration-200 group-hover:bg-[#22543D] group-hover:text-white">
                            Book Gear
                        </button>
                    </div>
                </div>
            </a>
            @endforeach

            {{-- CAMPINGS --}}
            @foreach($campings as $i => $item)
            <a href="{{ route('product.detail', $item['id']) }}"
               class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200 flex flex-col"
               data-aos="fade-up" data-aos-delay="{{ ($i + count($cameras)) * 80 }}">

                {{-- Image area --}}
                <div class="relative bg-gray-100 aspect-square overflow-hidden flex items-center justify-center">
                    @if(!empty($item['img']))
                        <img src="{{ $item['img'] }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             alt="{{ $item['name'] }}"
                             onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center\'><svg xmlns=\'http://www.w3.org/2000/svg\' class=\'h-16 w-16 text-gray-300\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg></div>'">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    @endif
                    {{-- Badge kategori --}}
                    <span class="absolute top-3 left-3 bg-[#ED64A6] text-white text-xs font-bold px-2.5 py-1 rounded-full"> Camping</span>
                </div>

                {{-- Card body --}}
                <div class="p-5 flex flex-col flex-1">
                    <h3 class="font-bold text-gray-800 text-base leading-tight mb-1">{{ $item['name'] }}</h3>
                    <p class="text-[#ED64A6] font-extrabold text-lg mb-4">{{ $item['price_label'] }}</p>
                    <div class="mt-auto">
                        <button class="w-full py-2.5 bg-white border-2 border-[#22543D] text-[#22543D] rounded-xl font-bold text-sm hover:bg-[#22543D] hover:text-white transition-all duration-200 group-hover:bg-[#22543D] group-hover:text-white">
                            Book Gear
                        </button>
                    </div>
                </div>
            </a>
            @endforeach

        </div>

        {{-- View All Button --}}
        <div class="text-center mt-12" data-aos="fade-up">
            <a href="{{ route('catalog.camera') }}"
               class="inline-flex items-center gap-2 border-2 border-[#22543D] text-[#22543D] px-10 py-3.5 rounded-full font-bold hover:bg-[#22543D] hover:text-white transition group">
                View Full Catalog
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

    </div>
</section>

@endsection