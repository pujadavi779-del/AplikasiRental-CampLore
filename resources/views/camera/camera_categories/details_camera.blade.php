@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Neue+Haas+Grotesk+Display+Pro:wght@400;500;600;700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">

<style>
    .pdp-wrap *, .pdp-wrap *::before, .pdp-wrap *::after { box-sizing: border-box; }

    /* ── Breadcrumb ── */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: #999;
        padding: 18px 0 28px;
    }
    .breadcrumb a { color: #999; text-decoration: none; }
    .breadcrumb a:hover { color: #111; }
    .breadcrumb .sep { color: #ccc; }
    .breadcrumb .current { color: #e05a2b; font-weight: 500; }

    /* ── Layout ── */
    .pdp-wrap {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 40px 80px;
    }

    .pdp-inner {
        display: grid;
        grid-template-columns: 68px 1fr 420px;
        gap: 20px;
        align-items: start;
    }

    /* ── Thumbnail Column ── */
    .thumb-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding-top: 0;
    }

    .thumb-nav {
        width: 32px; height: 32px;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        font-size: 11px;
        color: #888;
        transition: border-color .2s, color .2s;
        flex-shrink: 0;
    }
    .thumb-nav:hover { border-color: #333; color: #333; }
    .thumb-nav:disabled { opacity: .3; cursor: default; }

    .thumb-list-wrap {
        overflow: hidden;
        display: flex;
        flex-direction: column;
        gap: 8px;
        max-height: 476px;
    }

    .thumb-item {
        width: 68px; height: 68px;
        border: 1.5px solid #e8e8e8;
        border-radius: 6px;
        background: #f7f7f7;
        overflow: hidden;
        cursor: pointer;
        flex-shrink: 0;
        transition: border-color .2s;
        display: flex; align-items: center; justify-content: center;
    }
    .thumb-item img {
        width: 100%; height: 100%;
        object-fit: cover;
    }
    .thumb-item:hover { border-color: #bbb; }
    .thumb-item.active { border-color: #111; }

    /* ── Main Image ── */
    .main-img-col {
        position: relative;
        background: #f5f5f5;
        border-radius: 12px;
        overflow: hidden;
        aspect-ratio: 1 / 1;
    }

    .main-img-col img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .5s cubic-bezier(.25,.46,.45,.94);
    }
    .main-img-col:hover img { transform: scale(1.04); }

    /* ── Info Column ── */
    .info-col {
        padding-top: 4px;
    }

    /* Badge row */
    .badge-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .badge-new {
        display: inline-block;
        background: #111;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        padding: 5px 12px;
        border-radius: 4px;
    }

    .action-icons {
        display: flex;
        gap: 8px;
    }

    .icon-btn {
        width: 36px; height: 36px;
        border: 1.5px solid #e0e0e0;
        border-radius: 50%;
        background: #fff;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        font-size: 15px;
        color: #555;
        transition: border-color .2s;
    }
    .icon-btn:hover { border-color: #999; color: #111; }

    /* Product name */
    .product-name {
        font-size: 20px;
        font-weight: 700;
        line-height: 1.3;
        color: #111;
        margin-bottom: 12px;
    }

    /* Price */
    .product-price {
        font-size: 22px;
        font-weight: 700;
        color: #e05a2b;
        margin-bottom: 28px;
    }

    /* Section label */
    .section-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #aaa;
        margin-bottom: 10px;
    }

    /* Size buttons */
    .size-row {
        display: flex;
        gap: 10px;
        margin-bottom: 28px;
    }

    .size-btn {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 14px 16px;
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        background: #fff;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        color: #444;
        transition: border-color .2s, box-shadow .2s;
    }
    .size-btn:hover { border-color: #bbb; }
    .size-btn.active {
        border-color: #111;
        box-shadow: 0 0 0 1px #111;
        color: #111;
    }

    .size-btn .size-img {
        width: 28px; height: 28px;
        object-fit: contain;
        border: 1px solid #e8e8e8;
        border-radius: 4px;
        background: #f5f5f5;
    }

    /* Quantity */
    .qty-row {
        display: flex;
        align-items: center;
        gap: 0;
        margin-bottom: 28px;
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        width: fit-content;
    }

    .qty-btn {
        width: 44px; height: 44px;
        background: #fff;
        border: none;
        font-size: 20px;
        font-weight: 300;
        color: #555;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background .15s;
    }
    .qty-btn:hover { background: #f5f5f5; color: #111; }

    .qty-display {
        width: 52px; height: 44px;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px;
        font-weight: 600;
        color: #111;
        border-left: 1.5px solid #e0e0e0;
        border-right: 1.5px solid #e0e0e0;
    }

    /* CTA */
    .cta-row {
        display: flex;
        gap: 12px;
        margin-bottom: 36px;
    }

    .btn-cart {
        flex: 1;
        padding: 16px;
        background: #111;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        cursor: pointer;
        transition: background .2s;
    }
    .btn-cart:hover { background: #333; }

    .btn-buy {
        flex: 1;
        padding: 16px;
        background: #e05a2b;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        cursor: pointer;
        transition: background .2s;
    }
    .btn-buy:hover { background: #c44a1f; }

    /* Accordion */
    .accordion { border-top: 1px solid #ebebeb; }

    .accordion-item { border-bottom: 1px solid #ebebeb; }

    .accordion-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 17px 0;
        font-size: 13px;
        font-weight: 600;
        color: #111;
        background: transparent;
        border: none;
        cursor: pointer;
        text-align: left;
    }

    .accordion-chevron {
        width: 20px; height: 20px;
        border: 1.5px solid #ccc;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 10px;
        color: #aaa;
        transition: transform .25s, border-color .2s;
        flex-shrink: 0;
    }
    .accordion-item.open .accordion-chevron {
        transform: rotate(180deg);
        border-color: #999;
        color: #666;
    }

    .accordion-body {
        font-size: 13px;
        color: #666;
        line-height: 1.75;
        padding-bottom: 18px;
        display: none;
    }
    .accordion-item.open .accordion-body { display: block; }

    /* ── Responsive ── */
    @media (max-width: 900px) {
        .pdp-inner {
            grid-template-columns: 60px 1fr;
            grid-template-rows: auto auto;
        }
        .info-col {
            grid-column: 1 / -1;
        }
    }
</style>

@include('navbar')

<div class="pdp-wrap">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="/">HOME</a>
        <span class="sep">/</span>
        <a href="{{ route('camera.LP') }}">Camera</a>
        <span class="sep">/</span>
        <span class="current">{{ $item->name }}</span>
    </div>

    <div class="pdp-inner">

        {{-- ── Col 1: Thumbnails ── --}}
        <div class="thumb-col">
            <button class="thumb-nav" id="thumbUp" onclick="scrollThumbs(-1)">▲</button>

            <div class="thumb-list-wrap" id="thumbList">
                <div class="thumb-item active" onclick="switchImg(this, '{{ $item->image ? asset('storage/'.$item->image) : 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=600&q=80' }}')">
                    <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=600&q=80' }}" alt="">
                </div>
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

            <button class="thumb-nav" id="thumbDown" onclick="scrollThumbs(1)">▼</button>
        </div>

        {{-- ── Col 2: Main Image ── --}}
        <div class="main-img-col">
            <img id="mainImg"
                 src="{{ $item->image ? asset('storage/'.$item->image) : 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=600&q=80' }}"
                 alt="{{ $item->name }}">
        </div>

        {{-- ── Col 3: Product Info ── --}}
        <div class="info-col">

            {{-- Badge + icons --}}
            <div class="badge-row">
                @if($item->is_new ?? false)
                    <span class="badge-new">New</span>
                @else
                    <span></span>
                @endif
                <div class="action-icons">
                    <div class="icon-btn" title="Wishlist">♡</div>
                    <div class="icon-btn" title="Share">↗</div>
                </div>
            </div>

            {{-- Name --}}
            <h1 class="product-name">{{ $item->name }}</h1>

            {{-- Price --}}
            <div class="product-price">Rp {{ number_format($item->price, 0, ',', '.') }}</div>

            {{-- SIZE --}}
            <div class="section-label">SIZE</div>
            <div class="size-row">
                <button class="size-btn active" onclick="selectSize(this)">
                    📍 Ambil Ditempat
                </button>
                <button class="size-btn" onclick="selectSize(this)">
                    🚚 Diantar Ke Tujuan
                </button>
            </div>

            {{-- Quantity --}}
            <div class="section-label">Quantity</div>
            <div class="qty-row mb-7">
                <button class="qty-btn" onclick="changeQty(-1)">−</button>
                <div class="qty-display" id="qtyDisplay">1</div>
                <button class="qty-btn" onclick="changeQty(1)">+</button>
            </div>

            {{-- CTA --}}
            <div class="cta-row">
                <button class="btn-cart" onclick="addToCart({{ $item->id }})">Add to Cart</button>
                <button class="btn-buy">Buy Now</button>
            </div>

            {{-- Accordion --}}
            <div class="accordion">
                <div class="accordion-item open">
                    <button class="accordion-btn" onclick="toggleAccordion(this)">
                        Details
                        <span class="accordion-chevron">▾</span>
                    </button>
                    <div class="accordion-body">
                        {{ $item->description ?? 'No product description available.' }}
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-btn" onclick="toggleAccordion(this)">
                        Shipping & Returns
                        <span class="accordion-chevron">▾</span>
                    </button>
                    <div class="accordion-body">
                        Standard shipping 3–7 business days. Free shipping on orders over Rp 500.000. Returns accepted within 14 days of delivery.
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-btn" onclick="toggleAccordion(this)">
                        Stock Info
                        <span class="accordion-chevron">▾</span>
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
    const maxOffset = Math.max(0, list.scrollHeight - list.clientHeight);
    thumbOffset = Math.min(maxOffset, Math.max(0, thumbOffset + dir * 76));
    list.style.transform = `translateY(-${thumbOffset}px)`;
    list.style.transition = 'transform .25s ease';
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
    btn.closest('.accordion-item').classList.toggle('open');
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