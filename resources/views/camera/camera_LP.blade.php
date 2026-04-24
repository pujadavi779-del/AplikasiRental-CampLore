@extends('layouts.navbar_LP')

@section('content')

{{-- Google Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">

<div class="min-h-screen bg-[#f5f4f0] font-[DM_Sans]">

    {{-- HEADER --}}
    <div class="text-center pt-12 pb-6">
        <p class="text-[10px] tracking-[0.14em] font-bold uppercase text-gray-400">
            Jelajahi Koleksi
        </p>
        <h1 class="text-5xl text-gray-900 font-serif tracking-tight">
            Kamera
        </h1>
    </div>

    <div class="flex gap-8 px-10 pb-16 max-w-[1400px] mx-auto">

        {{-- SIDEBAR --}}
        @include('components.catalog.sidebar_camera')
        

        {{-- PRODUCT GRID --}}
        <main class="flex-1">

            {{-- COUNT --}}
            <div class="flex justify-between mb-6">
                <p class="text-xs text-gray-400 tracking-wide">
                    {{ count($items) }} produk
                </p>
            </div>

            {{-- GRID --}}
            <div class="grid grid-cols-4 gap-5">

                @foreach($items as $item)
                <a href="{{ route('camera.show', $item->id) }}"
                   class="group bg-[#ededea] rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">

                    {{-- IMAGE --}}
                    <div class="relative bg-[#e8e7e3] aspect-square flex items-center justify-center overflow-hidden">

                        {{-- BADGES --}}
                        <div class="absolute top-3 left-3 flex gap-2 z-10">
                            @if($item->is_new ?? false)
                                <span class="text-[9px] font-bold uppercase tracking-widest bg-black text-white px-2 py-1 rounded">
                                    New
                                </span>
                            @endif
                            {{-- Ganti logika Out of Stock menggunakan kolom stock --}}
                            @if($item->stock <= 0)
                                <span class="text-[9px] font-semibold uppercase tracking-wide bg-red-500 text-white px-2 py-1 rounded">
                                Out of Stock
                                </span>
                                @endif
                        </div>

                        <img
                            src="{{ $item->image }}" alt="{{ $item->name }}"
                            class="w-[70%] h-[70%] object-contain transition-transform duration-300 group-hover:scale-105"
                        >
                    </div>

                    {{-- INFO --}}
                    <div class="p-4">
                        <p class="text-xs font-semibold text-gray-900 mb-1">
                            {{ $item->name }}
                        </p>

                        <div class="flex justify-between items-end mt-2">
                            <p class="text-sm font-bold text-gray-900">
                                Rp {{ number_format($item->price_per_day) }}
                            </p>

                            {{-- BUTTON --}}
                            <button
                                class="opacity-0 translate-y-1 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200 text-xs font-semibold uppercase tracking-wider bg-gray-900 text-white px-3 py-1.5 rounded-full hover:bg-gray-700">
                                + Tambah
                            </button>
                        </div>
                    </div>

                </a>
                @endforeach

            </div>

            {{-- EMPTY --}}
            @if(count($items) === 0)
            <div class="text-center py-24 text-gray-400">
                <p class="text-4xl mb-3">📷</p>
                <p class="text-sm font-medium">Tidak ada produk yang ditemukan.</p>
            </div>
            @endif

        </main>
    </div>

</div>

@endsection