@extends('layouts.navbar_LP')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">

<div class="max-w-6xl mx-auto px-10 pb-20" style="font-family:'DM Sans',sans-serif;">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 py-5 text-xs text-gray-400">
        <a href="/" class="hover:text-gray-900 transition-colors">HOME</a>
        <span>/</span>
        <a href="{{ route('camping.LP') }}" class="hover:text-gray-900 transition-colors">Camping</a>
        <span>/</span>
        <span class="text-orange-600 font-medium">{{ $item->name }}</span>
    </nav>

    <div class="flex gap-5 items-start">

        {{-- ── Thumbnail column ── --}}
        <div class="flex flex-col items-center gap-2 shrink-0" style="width:72px;">

            <button onclick="scrollThumbs(-1)"
                class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center
                           text-xs text-gray-400 hover:border-gray-500 hover:text-gray-700 transition-colors shrink-0">▲</button>

            <div id="thumbList" class="flex flex-col gap-2 overflow-hidden" style="max-height:400px;">
                @php $imgs = [
                $item->image ? asset('storage/'.$item->image) : 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=800&q=80',
                'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=800&q=80',
                'https://images.unsplash.com/photo-1608236415053-8b2c36886875?w=800&q=80',
                'https://images.unsplash.com/photo-1617005082133-548c4dd27f35?w=800&q=80',
                'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=800&q=80',
                ]; @endphp

                @foreach($relatedItems as $related)
                <a href="{{ route('camping.show', $related->id) }}"
                    class="block rounded-lg overflow-hidden border-2 border-gray-200 hover:border-gray-900 transition-all"
                    style="width:72px; height:72px;">

                    <img src="{{ asset('storage/'.$related->image) }}"
                        class="w-full h-full object-cover">

                </a>
                @endforeach
            </div>

            <button onclick="scrollThumbs(1)"
                class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center
                           text-xs text-gray-400 hover:border-gray-500 hover:text-gray-700 transition-colors shrink-0">▼</button>
        </div>

        {{-- ── Main image — strict 1:1 ── --}}
        <div class="flex-1 rounded-2xl overflow-hidden bg-gray-100 group" style="aspect-ratio:1/1; min-width:0;">
            <img id="mainImg"
                src="{{ asset('storage/'.$item->image) }}"
                alt="{{ $item->name }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
        </div>

        {{-- ── Info column ── --}}
        <div class="shrink-0 flex flex-col" style="width:360px;">

            {{-- Icons --}}
            <div class="flex justify-end gap-2 mb-5">
                <button onclick="toggleLove(this)"
                    class="love-btn w-9 h-9 rounded-full border border-gray-200 bg-white flex items-center justify-center
                     text-gray-400 hover:border-pink-400 hover:text-pink-500 transition-all duration-300">

                    <span class="love-icon text-lg">♡</span>
                </button>
                <button onclick="shareProduct()"
                    class="w-9 h-9 rounded-full border border-gray-200 bg-white flex items-center justify-center
                        text-gray-400 hover:border-blue-400 hover:text-blue-500 transition-all duration-300">↗
                </button>
            </div>

            {{-- Badge --}}
            @if($item->is_new ?? false)
            <span class="mb-3 self-start bg-gray-900 text-white text-xs font-bold tracking-widest uppercase px-3 py-1 rounded">New</span>
            @endif

            {{-- Name --}}
            <h1 class="text-xl font-bold text-gray-900 leading-snug mb-1">{{ $item->name }}</h1>

            {{-- Price --}}
            <p class="text-2xl font-bold text-orange-600 mb-5">Rp {{ number_format($item->price, 0, ',', '.') }}</p>

            {{-- Size --}}
            <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-2">Opsi Pengiriman</p>
            <div class="flex gap-2 mb-6">
                <button onclick="pickSize(this)" class="size-btn flex-1 py-3 px-4 rounded-xl border-2 border-gray-900 bg-white text-[11px] font-bold text-gray-900 ring-1 ring-gray-900 transition-all text-left">
                    📍 AMBIL DI TEMPAT
                </button>
                <button onclick="pickSize(this)" class="size-btn flex-1 py-3 px-4 rounded-xl border-2 border-gray-100 bg-white text-[11px] font-bold text-gray-400 hover:border-gray-300 transition-all text-left">
                    🚚 DIANTAR KURIR
                </button>
            </div>

            {{-- Quantity --}}
            <p class="text-[10px] font-bold tracking-[0.2em] uppercase text-gray-400 mb-3">Jumlah</p>
            <div class="flex items-center w-fit border-2 border-gray-100 rounded-xl overflow-hidden mb-8">
                <button onclick="changeQty(-1)" class="w-12 h-12 flex items-center justify-center bg-white text-xl text-gray-500 hover:bg-gray-50 transition-colors">−</button>
                <div id="qtyDisplay" class="w-12 h-12 flex items-center justify-center border-x-2 border-gray-100 text-sm font-bold text-gray-900">1</div>
                <button onclick="changeQty(1)" class="w-12 h-12 flex items-center justify-center bg-white text-xl text-gray-500 hover:bg-gray-50 transition-colors">+</button>
            </div>

            {{-- CTA --}}
            <div class="flex gap-3 mb-6">
                <button onclick="addToCart({{ $item->id }})"
                    class="flex-1 py-4 rounded-xl bg-gray-900 text-white text-xs font-black tracking-widest uppercase
               hover:bg-gray-700 transition-all duration-200">
                    Add to Cart
                </button>

                <button
                    class="flex-1 py-4 rounded-xl bg-[#ED64A6] text-white text-xs font-black tracking-widest uppercase
               hover:bg-[#d45592] transition-all duration-200">
                    Buy Now
                </button>
            </div>

            {{-- Accordion --}}
            <div class="border-gray-100">

                @php
                $accordions = [
                [
                'title' => 'Tentang Kamera ini',
                'body' => $item->tentang_kamera ?? 'Deskripsi tidak tersedia.',
                'open' => true,
                ],
                [
                'title' => 'Highlights',
                'body' => 'tidak ada highlights untuk produk ini.',
                'open' => false,
                ],
                [
                'title' => 'Isi Paket',
                'body' => $item->isi > 0 ? 'In stock — '.$item->isi.' units available.' : 'Tidak ada informasi isi paket.',
                'open' => false,
                ],
                ];
                @endphp

                @foreach($accordions as $ac)
                <div class="border-b border-gray-100">

                    <button onclick="toggleAcc(this)"
                        class="w-full flex items-center justify-between py-4 text-sm font-semibold text-gray-900 text-left">

                        {{ $ac['title'] }}

                        <span class="acc-icon transition-transform duration-300 {{ $ac['open'] ? 'rotate-180' : '' }}">
                            ▾
                        </span>
                    </button>

                    <div class="acc-body overflow-hidden transition-all duration-300"
                        style="{{ $ac['open'] ? 'max-height: 200px;' : 'max-height: 0;' }}">

                        <div class="pb-4 text-sm text-gray-500 leading-relaxed">
                            {{ $ac['body'] }}
                        </div>

                    </div>

                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>

<script>
    let thumbOffset = 0;
    let qty = 1;

    function toggleAcc(button) {
        const body = button.nextElementSibling;
        const icon = button.querySelector('.acc-icon');

        if (body.style.maxHeight && body.style.maxHeight !== "0px") {
            body.style.maxHeight = "0px";
            icon.classList.remove("rotate-180");
        } else {
            body.style.maxHeight = body.scrollHeight + "px";
            icon.classList.add("rotate-180");
        }
    }

    function switchImg(el, src) {
        document.getElementById('mainImg').src = src;

        document.querySelectorAll('.thumb-btn').forEach(b => {
            b.classList.remove('border-gray-900');
            b.classList.add('border-gray-200');
        });

        el.classList.remove('border-gray-200');
        el.classList.add('border-gray-900');
    }

    function scrollThumbs(dir) {
        const list = document.getElementById('thumbList');
        const max = Math.max(0, list.scrollHeight - list.clientHeight);

        thumbOffset = Math.min(max, Math.max(0, thumbOffset + dir * 80));

        list.style.transform = `translateY(-${thumbOffset}px)`;
        list.style.transition = 'transform .25s ease';
    }

    function changeQty(d) {
        qty = Math.max(1, qty + d);
        document.getElementById('qtyDisplay').textContent = qty;
    }

    function pickSize(el) {
        document.querySelectorAll('.size-btn').forEach(b => {
            b.classList.remove('border-gray-900', 'ring-1', 'ring-gray-900', 'text-gray-900');
            b.classList.add('border-gray-200', 'text-gray-400');
        });

        el.classList.remove('border-gray-200', 'text-gray-400');
        el.classList.add('border-gray-900', 'ring-1', 'ring-gray-900', 'text-gray-900');
    }

    function addToCart(itemId) {
        fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    item_id: itemId,
                    quantity: qty
                })
            })
            .then(r => r.json())
            .then(data => {
                const b = document.getElementById('cartCount');
                if (b && data.total) b.textContent = data.total;
            });
    }

    function toggleLove(btn) {
        const icon = btn.querySelector('.love-icon');

        btn.classList.toggle('liked');

        if (btn.classList.contains('liked')) {
            btn.classList.add('border-pink-500', 'text-pink-500', 'scale-110');
            icon.textContent = '♥';
        } else {
            btn.classList.remove('border-pink-500', 'text-pink-500', 'scale-110');
            icon.textContent = '♡';
        }

        setTimeout(() => {
            btn.classList.remove('scale-110');
        }, 200);
    }

    function shareProduct() {
        if (navigator.share) {
            navigator.share({
                title: document.title,
                text: 'Check out this product!',
                url: window.location.href
            });
        } else {
            navigator.clipboard.writeText(window.location.href);

            alert('Link copied to clipboard!');
        }
    }
</script>

@endsection