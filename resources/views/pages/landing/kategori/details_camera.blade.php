@extends('layouts.landingpage')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">

<div class="max-w-6xl mx-auto px-10 pb-20" style="font-family:'DM Sans',sans-serif;">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 py-5 text-xs text-gray-400">
        <a href="/" class="hover:text-gray-900 transition-colors">BERANDA</a>
        <span>/</span>
        <a href="{{ route('camera.LP') }}" class="hover:text-gray-900 transition-colors">Kamera</a>
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
                @foreach($relatedItems as $related)
                <a href="{{ route('camera.show', $related->id) }}"
                    class="block rounded-lg overflow-hidden border-2 border-gray-200 hover:border-gray-900 transition-all"
                    style="width:72px; height:72px;">
                    <img src="{{ str_starts_with($related->image, 'http') ? $related->image : asset('storage/'.$related->image) }}"
                        class="w-full h-full object-cover">
                </a>
                @endforeach
            </div>

            <button onclick="scrollThumbs(1)"
                class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center
                       text-xs text-gray-400 hover:border-gray-500 hover:text-gray-700 transition-colors shrink-0">▼</button>
        </div>

        {{-- ── Main image ── --}}
        <div class="flex-1 rounded-2xl overflow-hidden bg-gray-100 group" style="aspect-ratio:1/1; min-width:0;">
            <img id="mainImg"
                src="{{ str_starts_with($item->image, 'http') ? $item->image : asset('storage/'.$item->image) }}"
                alt="{{ $item->name }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                loading="lazy">
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
            <span class="mb-3 self-start bg-gray-900 text-white text-xs font-bold tracking-widest uppercase px-3 py-1 rounded">Baru</span>
            @endif

            {{-- Name --}}
            <h1 class="text-xl font-bold text-gray-900 leading-snug mb-1">{{ $item->name }}</h1>

            {{-- Price --}}
            <div class="flex items-baseline gap-2 mb-1">
                <p class="text-2xl font-bold text-orange-600" id="displayPrice">
                    Rp {{ number_format($item->price_per_day, 0, ',', '.') }}
                </p>
                <span class="text-sm text-gray-400" id="priceLabel">/ hari</span>
            </div>
            <p class="text-xs text-gray-400 mb-5" id="totalPriceNote"></p>

            {{-- ── Tanggal Penyewaan ── --}}
            <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-3">Tanggal Penyewaan</p>

            <div class="flex gap-3 mb-3">
                {{-- Mulai --}}
                <div class="flex-1">
                    <label class="block text-xs text-gray-400 mb-1">Mulai</label>
                    <input type="date" id="startDate"
                        class="w-full border-2 border-gray-100 rounded-xl px-3 py-3 text-sm text-gray-900 focus:border-gray-400 focus:outline-none transition-colors"
                        onchange="onStartChange()">
                </div>
                {{-- Selesai --}}
                <div class="flex-1">
                    <label class="block text-xs text-gray-400 mb-1">Selesai</label>
                    <input type="date" id="endDate"
                        class="w-full border-2 border-gray-100 rounded-xl px-3 py-3 text-sm text-gray-900 focus:border-gray-400 focus:outline-none transition-colors"
                        onchange="onDateChange()">
                </div>
            </div>

            {{-- Duration badge --}}
            <div id="durationBadge" class="hidden mb-5">
                <span id="durationText"
                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium"
                    style="background:#FFF0F6; color:#C2185B; border:1px solid #F8BBD9;">
                </span>
            </div>

            {{-- Error date message --}}
            <p id="dateError" class="hidden text-xs text-red-500 mb-4">Tanggal selesai harus setelah tanggal mulai.</p>

            {{-- ── Jumlah ── --}}
            <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-3">Jumlah</p>
            <div class="flex items-center w-fit border-2 border-gray-100 rounded-xl overflow-hidden mb-8">
                <button onclick="changeQty(-1)"
                    class="w-12 h-12 flex items-center justify-center bg-white text-xl text-gray-500 hover:bg-gray-50 active:bg-gray-100 transition-colors select-none">−</button>
                <div id="qtyDisplay"
                    class="w-12 h-12 flex items-center justify-center border-x-2 border-gray-100 text-sm font-bold text-gray-900">1</div>
                <button onclick="changeQty(1)"
                    class="w-12 h-12 flex items-center justify-center bg-white text-xl text-gray-500 hover:bg-gray-50 active:bg-gray-100 transition-colors select-none">+</button>
            </div>

            {{-- ── CTA ── --}}
            <div class="flex gap-3 mb-6">
                <button onclick="addToCart({{ $item->id }})"
                    id="addToCartBtn"
                    class="flex-1 py-4 rounded-xl bg-gray-900 text-white text-xs font-black tracking-widest uppercase
                           hover:bg-gray-700 active:scale-95 transition-all duration-200">
                    Tambahkan ke Keranjang
                </button>
                <button onclick="rentNow({{ $item->id }})"
                    class="flex-1 py-4 rounded-xl bg-[#ED64A6] text-white text-xs font-black tracking-widest uppercase
                           hover:bg-[#d45592] active:scale-95 transition-all duration-200">
                    Sewa Sekarang
                </button>
            </div>

            {{-- ── Accordion ── --}}
            <div class="border-gray-100">
                @php
                $accordions = [
                ['title' => 'Tentang Kamera ini', 'body' => $item->body ?? 'Deskripsi tidak tersedia.', 'open' => true],
                ['title' => 'Highlights', 'body' => 'Spesifikasi unggulan untuk ' . $item->name . '.', 'open' => false],
                ['title' => 'Isi Paket', 'body' => $item->stock > 0 ? 'Tersedia — '.$item->stock.' unit siap disewa.' : 'Maaf, stok unit ini sedang kosong.', 'open' => false],
                ];
                @endphp

                @foreach($accordions as $ac)
                <div class="border-b border-gray-100">
                    <button onclick="toggleAcc(this)"
                        class="w-full flex items-center justify-between py-4 text-sm font-semibold text-gray-900 text-left">
                        {{ $ac['title'] }}
                        <span class="acc-icon transition-transform duration-300 {{ $ac['open'] ? 'rotate-180' : '' }}">▾</span>
                    </button>
                    <div class="acc-body overflow-hidden transition-all duration-300"
                        style="{{ $ac['open'] ? 'max-height: 200px;' : 'max-height: 0;' }}">
                        <div class="pb-4 text-sm text-gray-500 leading-relaxed">{{ $ac['body'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>{{-- end info column --}}
    </div>
</div>

{{-- Toast notification --}}
<div id="toast"
    class="fixed bottom-6 left-1/2 -translate-x-1/2 px-5 py-3 rounded-xl text-sm font-medium text-white
           shadow-lg transition-all duration-300 opacity-0 pointer-events-none z-50"
    style="background:#1a1a1a; min-width:220px; text-align:center;">
</div>

<script>
    // ── State ──────────────────────────────────────────────
    let thumbOffset = 0;
    let qty = 1;
    const PRICE_PER_DAY = {{ $item -> price_per_day }};

    const MAX_STOCK = {{ $item -> stock ?? 99 }};

    // ── Accordion ──────────────────────────────────────────
    function toggleAcc(button) {
        const body = button.nextElementSibling;
        const icon = button.querySelector('.acc-icon');
        if (body.style.maxHeight && body.style.maxHeight !== '0px') {
            body.style.maxHeight = '0px';
            icon.classList.remove('rotate-180');
        } else {
            body.style.maxHeight = body.scrollHeight + 'px';
            icon.classList.add('rotate-180');
        }
    }

    // ── Thumbnails ─────────────────────────────────────────
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

    // ── Quantity ───────────────────────────────────────────
    function changeQty(d) {
        const next = qty + d;
        if (next < 1) return;
        if (next > MAX_STOCK) {
            showToast(`Stok tersedia hanya ${MAX_STOCK} unit`, 'error');
            return;
        }
        qty = next;
        document.getElementById('qtyDisplay').textContent = qty;
        updatePrice();
    }

    // ── Date helpers ───────────────────────────────────────
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('startDate').min = today;
    document.getElementById('endDate').min = today;

    function getDays() {
        const s = document.getElementById('startDate').value;
        const e = document.getElementById('endDate').value;
        if (!s || !e) return 0;
        const diff = Math.round((new Date(e) - new Date(s)) / 86400000);
        return diff > 0 ? diff : 0;
    }

    function onStartChange() {
        const s = document.getElementById('startDate').value;
        document.getElementById('endDate').min = s;
        const e = document.getElementById('endDate').value;
        if (e && e <= s) document.getElementById('endDate').value = '';
        onDateChange();
    }

    function onDateChange() {
        const s = document.getElementById('startDate').value;
        const e = document.getElementById('endDate').value;
        const err = document.getElementById('dateError');
        const badge = document.getElementById('durationBadge');
        const text = document.getElementById('durationText');

        err.classList.add('hidden');
        badge.classList.add('hidden');

        if (!s || !e) {
            updatePrice();
            return;
        }

        if (e <= s) {
            err.classList.remove('hidden');
            updatePrice();
            return;
        }

        const days = getDays();
        badge.classList.remove('hidden');
        text.textContent = `🗓 ${days} hari sewa`;
        updatePrice();
    }

    // ── Price display ──────────────────────────────────────
    function fmtRp(n) {
        return 'Rp ' + Math.round(n).toLocaleString('id-ID');
    }

    function updatePrice() {
        const days = getDays();
        const note = document.getElementById('totalPriceNote');
        const label = document.getElementById('priceLabel');
        const disp = document.getElementById('displayPrice');

        disp.textContent = fmtRp(PRICE_PER_DAY);
        label.textContent = '/ hari';

        if (days > 0) {
            const total = PRICE_PER_DAY * days * qty;
            note.textContent = `Total ${days} hari × ${qty} unit = ${fmtRp(total)}`;
        } else {
            note.textContent = qty > 1 ? `${qty} unit dipilih` : '';
        }
    }

    // ── Toast ──────────────────────────────────────────────
    function showToast(msg, type = 'success') {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.style.background = type === 'error' ? '#e53e3e' : '#1a1a1a';
        t.classList.remove('opacity-0');
        t.classList.add('opacity-100');
        setTimeout(() => {
            t.classList.remove('opacity-100');
            t.classList.add('opacity-0');
        }, 2500);
    }

    // ── Add to Cart ────────────────────────────────────────
    function addToCart(itemId) {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        const btn = document.getElementById('addToCartBtn');

        if (!startDate || !endDate) {
            showToast('Pilih tanggal penyewaan terlebih dahulu', 'error');
            return;
        }

        btn.disabled = true;
        btn.textContent = 'Menambahkan...';

        fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    item_id: itemId,
                    quantity: qty,
                    start_date: startDate,
                    end_date: endDate,
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showToast('Berhasil ditambahkan ke keranjang ✓');
                    const b = document.getElementById('cartCount');
                    if (b && data.total) b.textContent = data.total;
                } else {
                    showToast(data.message ?? 'Gagal menambahkan', 'error');
                }
            })
            .catch(() => showToast('Terjadi kesalahan, coba lagi', 'error'))
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Add to Cart';
            });
    }

    // ── Sewa Sekarang ──────────────────────────────────────
    function rentNow(itemId) {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        if (!startDate || !endDate) {
            showToast('Pilih tanggal penyewaan terlebih dahulu', 'error');
            return;
        }

        fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    item_id: itemId,
                    quantity: qty,
                    start_date: startDate,
                    end_date: endDate,
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/checkout?ids[]=' + data.cart_id;
                } else {
                    showToast(data.message ?? 'Gagal, coba lagi', 'error');
                }
            })
            .catch(() => showToast('Terjadi kesalahan, coba lagi', 'error'));
    }

    // ── Love / Share ───────────────────────────────────────
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
        setTimeout(() => btn.classList.remove('scale-110'), 200);
    }

    function shareProduct() {
        if (navigator.share) {
            navigator.share({
                title: document.title,
                url: window.location.href
            });
        } else {
            navigator.clipboard.writeText(window.location.href);
            showToast('Link berhasil disalin ✓');
        }
    }
</script>
@include('components.footer')
@endsection