@extends('layouts.app')

@section('content')

{{-- Google Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">

<style>
    body { font-family: 'DM Sans', sans-serif; background: #f5f4f0; }

    .page-title { font-family: 'Instrument Serif', serif; }

    /* Sidebar checkbox style */
    .filter-checkbox { display: none; }
    .filter-label {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        color: #3a3a3a;
        letter-spacing: 0.02em;
        padding: 7px 0;
        transition: color 0.2s;
    }
    .filter-label:hover { color: #000; }
    .custom-check {
        width: 16px; height: 16px;
        border: 1.5px solid #bbb;
        border-radius: 3px;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.2s;
        flex-shrink: 0;
    }
    .filter-checkbox:checked + .filter-label .custom-check {
        background: #111;
        border-color: #111;
    }
    .filter-checkbox:checked + .filter-label .custom-check::after {
        content: '';
        width: 8px; height: 8px;
        background: white;
        clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
        display: block;
    }

    /* Badge */
    .badge-new {
        background: #111; color: #fff;
        font-size: 9px; font-weight: 700;
        letter-spacing: 0.12em;
        padding: 3px 7px;
        border-radius: 2px;
        text-transform: uppercase;
    }
    .badge-oos {
        background: #fff; color: #555;
        border: 1px solid #ccc;
        font-size: 9px; font-weight: 600;
        letter-spacing: 0.08em;
        padding: 3px 7px;
        border-radius: 2px;
        text-transform: uppercase;
    }

    /* Product card */
    .product-card {
        background: #ededea;
        border-radius: 16px;
        overflow: hidden;
        transition: transform 0.3s cubic-bezier(.22,.61,.36,1), box-shadow 0.3s;
        cursor: pointer;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 40px rgba(0,0,0,0.10);
    }
    .product-img-wrap {
        background: #e8e7e3;
        aspect-ratio: 1/1;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }
    .product-img-wrap img {
        width: 70%;
        height: 70%;
        object-fit: contain;
        transition: transform 0.4s cubic-bezier(.22,.61,.36,1);
    }
    .product-card:hover .product-img-wrap img {
        transform: scale(1.07);
    }

    /* Sort dropdown */
    .sort-select {
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        border: none;
        background: transparent;
        color: #333;
        cursor: pointer;
        outline: none;
        border-bottom: 1.5px solid #333;
        padding-bottom: 2px;
    }

    /* Divider */
    .sidebar-divider {
        height: 1px;
        background: #ddd;
        margin: 18px 0;
    }

    /* Section label */
    .section-label {
        font-size: 10px;
        letter-spacing: 0.14em;
        font-weight: 700;
        text-transform: uppercase;
        color: #888;
        margin-bottom: 10px;
    }

    /* Add to cart button on hover */
    .card-action {
        opacity: 0;
        transform: translateY(6px);
        transition: opacity 0.25s, transform 0.25s;
    }
    .product-card:hover .card-action {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<div class="min-h-screen" style="background:#f5f4f0;">
   
    
    {{-- TOP HEADER --}}
    <div class="text-center pt-12 pb-6">
        <p class="section-label">Jelajahi Koleksi</p>
        <h1 class="page-title text-5xl text-gray-900" style="letter-spacing:-0.01em;">Kamera</h1>
    </div>

    <div class="flex gap-8 px-10 pb-16 max-w-screen-x32 mx-auto">

        {{-- ─────────── SIDEBAR ─────────── --}}
        @include('camera.camera_categories.sb_categori_camera')

        {{-- ─────────── PRODUCT GRID ─────────── --}}
        <main class="flex-1">

            {{-- Result count --}}
            <div class="flex items-center justify-between mb-6">
                <p class="text-xs text-gray-400 tracking-wide">{{ count($items) }} produk</p>
            </div>

            <div class="grid grid-cols-4 gap-5">

                @foreach($items as $index => $item)
                <a href="{{ route('camera.show', $item->id) }}" class="product-card block">

                    {{-- Image area --}}
                    <div class="product-img-wrap">

                        {{-- Badges top-left --}}
                        <div class="absolute top-3 left-3 flex gap-1.5 z-10">
                            @if($item->is_new ?? false)
                                <span class="badge-new">New</span>
                            @endif
                            @if($item->is_out_of_stock ?? false)
                                <span class="badge-oos">Out of Stock</span>
                            @endif
                        </div>

                        <img
                            src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=400&q=80"
                            alt="{{ $item->name }}"
                        >
                    </div>

                    {{-- Info --}}
                    <div class="p-4">
                        <p class="text-xs font-semibold text-gray-900 leading-snug mb-1" style="letter-spacing:0.01em;">
                            {{ $item->name }}
                        </p>
                        <div class="flex items-end justify-between mt-2">
                            <p class="text-sm font-bold text-gray-900">
                                Rp {{ number_format($item->price) }}
                            </p>
                            <button class="card-action text-xs font-semibold tracking-wider uppercase bg-gray-900 text-white px-3 py-1.5 rounded-full hover:bg-gray-700 transition">
                                + Tambah
                            </button>
                        </div>
                    </div>

                </a>
                @endforeach

            </div>

            {{-- Empty state --}}
            @if(count($items) === 0)
            <div class="text-center py-24 text-gray-400">
                <p class="text-4xl mb-3">📷</p>
                <p class="text-sm font-medium">No products found.</p>
            </div>
            @endif

        </main>
    </div>

</div>

@endsection