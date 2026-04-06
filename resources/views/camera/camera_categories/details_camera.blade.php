@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">

<style>
    body { font-family: 'DM Sans', sans-serif; background: #f5f4f0; }

    /* Breadcrumb */
    .breadcrumb a { color: #aaa; font-size: 12px; text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: #111; }
    .breadcrumb span { color: #e05a2b; font-size: 12px; font-weight: 500; }
    .breadcrumb .sep { color: #ccc; margin: 0 6px; font-size: 12px; }

    /* Thumbnail */
    .thumb-item {
        width: 72px; height: 72px;
        border: 1.5px solid #ddd; border-radius: 8px;
        background: #ececea;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; cursor: pointer;
        transition: border-color .2s;
        flex-shrink: 0;
    }
    .thumb-item:hover { border-color: #999; }
    .thumb-item.active { border-color: #111; box-shadow: 0 0 0 1px #111; }
    .thumb-item img { width: 85%; height: 85%; object-fit: contain; }

    /* Main image */
    .main-img-wrap {
        flex: 1; background: #ececea; border-radius: 16px;
        aspect-ratio: 1/1; display: flex; align-items: center; justify-content: center;
        overflow: hidden;
    }
    .main-img-wrap img { width: 70%; height: 70%; object-fit: contain; transition: transform .4s cubic-bezier(.22,.61,.36,1); }
    .main-img-wrap:hover img { transform: scale(1.05); }

    /* Badge */
    .badge-new {
        display: inline-block;
        background: #111; color: #fff;
        font-size: 10px; font-weight: 800; letter-spacing: .12em;
        padding: 4px 10px; border-radius: 3px; text-transform: uppercase;
    }

    /* Size selector */
    .size-btn {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 18px; border: 1.5px solid #ddd; border-radius: 8px;
        cursor: pointer; background: #fff; transition: border-color .2s, box-shadow .2s;
        font-size: 13px; font-weight: 500; color: #333;
    }
    .size-btn:hover { border-color: #aaa; }
    .size-btn.active { border-color: #111; box-shadow: 0 0 0 1px #111; color: #111; }
    .size-btn img { width: 32px; height: 32px; object-fit: contain; }

    /* Qty */
    .qty-btn {
        width: 36px; height: 36px; border: 1.5px solid #ccc; border-radius: 6px;
        background: #fff; font-size: 18px; font-weight: 300; color: #333;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: border-color .2s;
        line-height: 1;
    }
    .qty-btn:hover { border-color: #888; }
    .qty-display {
        width: 44px; height: 36px; border: 1.5px solid #ccc; border-radius: 6px;
        background: #fff; font-size: 14px; font-weight: 600; color: #111;
        display: flex; align-items: center; justify-content: center;
    }

    /* CTA Buttons */
    .btn-cart {
        flex: 1; padding: 16px; font-size: 13px; font-weight: 800;
        letter-spacing: .1em; text-transform: uppercase;
        background: #111; color: #fff; border: none; border-radius: 8px;
        cursor: pointer; transition: background .2s;
    }
    .btn-cart:hover { background: #333; }
    .btn-buy {
        flex: 1; padding: 16px; font-size: 13px; font-weight: 800;
        letter-spacing: .1em; text-transform: uppercase;
        background: #e05a2b; color: #fff; border: none; border-radius: 8px;
        cursor: pointer; transition: background .2s;
    }
    .btn-buy:hover { background: #c44a1f; }

    /* Accordion */
    .accordion-item { border-top: 1px solid #e0e0e0; }
    .accordion-item:last-child { border-bottom: 1px solid #e0e0e0; }
    .accordion-btn {
        width: 100%; display: flex; align-items: center; justify-content: space-between;
        padding: 16px 0; font-size: 14px; font-weight: 600; color: #111;
        background: transparent; border: none; cursor: pointer; text-align: left;
    }
    .accordion-icon { font-size: 18px; color: #aaa; transition: transform .25s; }
    .accordion-body { font-size: 13px; color: #666; padding-bottom: 16px; line-height: 1.7; display: none; }
    .accordion-item.open .accordion-body { display: block; }
    .accordion-item.open .accordion-icon { transform: rotate(180deg); }

    /* Icon buttons */
    .icon-btn {
        width: 38px; height: 38px; border-radius: 50%; border: 1.5px solid #ddd;
        background: #fff; display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: border-color .2s; font-size: 16px;
    }
    .icon-btn:hover { border-color: #999; }

    /* Thumb nav arrow */
    .thumb-arrow {
        width: 32px; height: 32px; border-radius: 50%; border: 1px solid #ddd;
        background: #fff; display: flex; align-items: center; justify-content: center;
        cursor: pointer; font-size: 12px; color: #666;
        transition: border-color .2s;
        flex-shrink: 0;
    }
    .thumb-arrow:hover { border-color: #aaa; }
    .thumb-arrow:disabled { opacity: .35; cursor: not-allowed; }
</style>

@include('navbar')

<div class="max-w-screen-xl mx-auto px-10 py-8">

    {{-- Breadcrumb --}}
    <div class="breadcrumb flex items-center mb-8">
        <a href="/">HOME</a>
        <span class="sep">/</span>
        <a href="{{ route('camera.LP') }}">Camera</a>
        <span class="sep">/</span>
        <span>{{ $item->name }}</span>
    </div>

    <div class="flex gap-10">

        {{-- ═══ LEFT: Gallery ═══ --}}
        <div class="flex gap-3" style="width: 56%;">

            {{-- Thumbnails --}}
            <div class="flex flex-col gap-2 items-center" style="width:80px;">
                <button class="thumb-arrow" id="thumbUp" onclick="scrollThumbs(-1)">▲</button>

                <div class="flex flex-col gap-2 overflow-hidden" style="max-height: 380px;" id="thumbList">
                    {{-- Main image thumb --}}
                    <div class="thumb-item active" onclick="switchImg(this, '{{ $item->image ? asset('storage/'.$item->image) : 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=600&q=80' }}')">
                        <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=600&q=80' }}" alt="">
                    </div>
                    {{-- Extra placeholder thumbnails --}}
                    <div class="thumb-item" onclick="switchImg(this, 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=600&q=80')">
                        <img src="https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=120&q=80" alt="">
                    </div>
                    <div class="thumb-item" onclick="switchImg(this, 'https://images.unsplash.com/photo-1608236415053-8b2c36886875?w=600&q=80')">
                        <img src="https://images.unsplash.com/photo-1608236415053-8b2c36886875?w=120&q=80" alt="">
                    </div>
                    <div class="thumb-item" onclick="switchImg(this, 'https://images.unsplash.com/photo-1617005082133-548c4dd27f35?w=600&q=80')">
                        <img src="https://images.unsplash.com/photo-1617005082133-548c4dd27f35?w=120&q=80" alt="">
                    </div>
                    <div class="thumb-item" onclick="switchImg(this, 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=600&q=80')">
                        <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=120&q=80" alt="">
                    </div>
                </div>

                <button class="thumb-arrow" id="thumbDown" onclick="scrollThumbs(1)">▼</button>
            </div>

            {{-- Main image --}}
            <div class="main-img-wrap">
                <img id="mainImg"
                     src="{{ $item->image ? asset('storage/'.$item->image) : 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=600&q=80' }}"
                     alt="{{ $item->name }}">
            </div>
        </div>

        {{-- ═══ RIGHT: Info ═══ --}}
        <div class="flex-1 flex flex-col" style="padding-top: 4px;">

            {{-- Badge + actions --}}
            <div class="flex items-center justify-between mb-4">
                @if($item->is_new ?? false)
                    <span class="badge-new">New</span>
                @else
                    <span></span>
                @endif
                <div class="flex gap-2">
                    <div class="icon-btn" title="Wishlist">♡</div>
                    <div class="icon-btn" title="Share">↗</div>
                </div>
            </div>

            {{-- Name --}}
            <h1 style="font-size:22px; font-weight:700; color:#111; line-height:1.3; margin-bottom:14px;">
                {{ $item->name }}
            </h1>

            {{-- Price --}}
            <p style="font-size:22px; font-weight:700; color:#e05a2b; margin-bottom:24px;">
                Rp {{ number_format($item->price, 0, ',', '.') }}
            </p>

            {{-- Size selector --}}
            <p style="font-size:10px; font-weight:700; letter-spacing:.14em; text-transform:uppercase; color:#aaa; margin-bottom:10px;">Size</p>
            <div class="flex gap-3 mb-6">
                <button class="size-btn active" onclick="selectSize(this)">
                    <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=60&q=80" alt="">
                    Single Item
                </button>
                <button class="size-btn" onclick="selectSize(this)">
                    <img src="https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=60&q=80" alt="">
                    Whole Set
                </button>
            </div>

            {{-- Quantity --}}
            <p style="font-size:10px; font-weight:700; letter-spacing:.14em; text-transform:uppercase; color:#aaa; margin-bottom:10px;">Quantity</p>
            <div class="flex items-center gap-2 mb-8">
                <button class="qty-btn" onclick="changeQty(-1)">−</button>
                <div class="qty-display" id="qtyDisplay">1</div>
                <button class="qty-btn" onclick="changeQty(1)">+</button>
            </div>

            {{-- CTA --}}
            <div class="flex gap-3 mb-8">
                <button class="btn-cart" onclick="addToCart({{ $item->id }})">Add to Cart</button>
                <button class="btn-buy">Buy Now</button>
            </div>

            {{-- Accordion --}}
            <div>
                <div class="accordion-item open">
                    <button class="accordion-btn" onclick="toggleAccordion(this)">
                        Details
                        <span class="accordion-icon">▾</span>
                    </button>
                    <div class="accordion-body">
                        {{ $item->description ?? 'No product description available.' }}
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-btn" onclick="toggleAccordion(this)">
                        Shipping & Returns
                        <span class="accordion-icon">▾</span>
                    </button>
                    <div class="accordion-body">
                        Standard shipping 3–7 business days. Free shipping on orders over Rp 500.000. Returns accepted within 14 days of delivery.
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-btn" onclick="toggleAccordion(this)">
                        Stock Info
                        <span class="accordion-icon">▾</span>
                    </button>
                    <div class="accordion-body">
                        {{ $item->stock > 0 ? 'In stock — ' . $item->stock . ' units available.' : 'Currently out of stock.' }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
// ── Thumbnail switch ──
function switchImg(el, src) {
    document.getElementById('mainImg').src = src;
    document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}

// ── Thumb scroll ──
let thumbOffset = 0;
function scrollThumbs(dir) {
    const list = document.getElementById('thumbList');
    thumbOffset = Math.max(0, thumbOffset + dir * 78);
    list.style.transform = `translateY(-${thumbOffset}px)`;
    list.style.transition = 'transform .25s';
}

// ── Qty ──
let qty = 1;
function changeQty(delta) {
    qty = Math.max(1, qty + delta);
    document.getElementById('qtyDisplay').textContent = qty;
}

// ── Size select ──
function selectSize(el) {
    document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
}

// ── Accordion ──
function toggleAccordion(btn) {
    const item = btn.closest('.accordion-item');
    item.classList.toggle('open');
}

// ── Add to cart ──
function addToCart(itemId) {
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ item_id: itemId, quantity: qty })
    })
    .then(res => res.json())
    .then(data => {
        const badge = document.getElementById('cartCount');
        if (badge && data.total) badge.textContent = data.total;
    });
}
</script>

@endsection