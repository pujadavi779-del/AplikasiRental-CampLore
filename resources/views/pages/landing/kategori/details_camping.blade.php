@extends('layouts.landingpage')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">

@php
$accordions = [
    ['title' => 'Tentang Alat ini', 'body' => $item->description ?? 'Deskripsi alat camping ini belum tersedia.', 'open' => true],
    ['title' => 'Highlights', 'body' => 'Kualitas premium untuk perlengkapan outdoor ' . $item->name . '.', 'open' => false],
    ['title' => 'Isi Paket', 'body' => $item->stock > 0 ? 'Tersedia — '.$item->stock.' unit siap disewa.' : 'Maaf, produk ini sedang habis disewa.', 'open' => false],
];
@endphp

<div style="font-family:'DM Sans',sans-serif;">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 px-4 py-4 text-xs text-gray-400 max-w-6xl mx-auto">
        <a href="/" class="hover:text-gray-900 transition-colors">BERANDA</a>
        <span>/</span>
        <a href="{{ route('camping.LP') }}" class="hover:text-gray-900 transition-colors">Camping</a>
        <span>/</span>
        <span class="text-orange-600 font-medium truncate">{{ $item->name }}</span>
    </nav>

    {{-- ══════════════════════════════
         MOBILE (< lg)
    ══════════════════════════════ --}}
    <div class="lg:hidden">

        {{-- Main Image --}}
        <div class="relative bg-gray-100 w-full" style="aspect-ratio:1/1;">
            <img id="mainImgMobile"
                src="{{ str_starts_with($item->image, 'http') ? $item->image : asset('storage/'.$item->image) }}"
                alt="{{ $item->name }}" class="w-full h-full object-cover">
            <!-- <span id="imgCounter" class="absolute bottom-3 right-4 text-xs text-gray-500 bg-white/80 px-2 py-0.5 rounded-full">
                1 / {{ count($relatedItems) + 1 }}
            </span> -->
        </div>

        {{-- Thumbnails horizontal --}}
        <div class="flex gap-2 px-4 py-3 overflow-x-auto no-scrollbar">
            <!-- <button onclick="switchImgMobile(this, '{{ str_starts_with($item->image, 'http') ? $item->image : asset('storage/'.$item->image) }}', 1, {{ count($relatedItems) + 1 }})"
                class="shrink-0 w-16 h-16 rounded-xl overflow-hidden border-2 border-gray-900">
                <img src="{{ str_starts_with($item->image, 'http') ? $item->image : asset('storage/'.$item->image) }}" class="w-full h-full object-cover">
            </button>
            @foreach($relatedItems as $i => $related)
            <button onclick="switchImgMobile(this, '{{ str_starts_with($related->image, 'http') ? $related->image : asset('storage/'.$related->image) }}', {{ $i + 2 }}, {{ count($relatedItems) + 1 }})"
                class="shrink-0 w-16 h-16 rounded-xl overflow-hidden border-2 border-gray-200">
                <img src="{{ str_starts_with($related->image, 'http') ? $related->image : asset('storage/'.$related->image) }}" class="w-full h-full object-cover">
            </button>
            @endforeach -->
        </div>

        {{-- Info --}}
        <div class="px-4 pb-32">

            <div class="flex items-center justify-between mb-2">
                <div>
                    @if($item->is_new ?? false)
                    <span class="bg-gray-900 text-white text-xs font-bold tracking-widest uppercase px-3 py-1 rounded">Baru</span>
                    @endif
                </div>
                <button onclick="toggleLove(this)" class="love-btn w-9 h-9 rounded-full border border-gray-200 bg-white flex items-center justify-center text-gray-400 hover:border-pink-400 hover:text-pink-500 transition-all">
                    <span class="love-icon text-lg">♡</span>
                </button>
            </div>

            <h1 class="text-xl font-bold text-gray-900 leading-snug mb-2">{{ $item->name }}</h1>
            <p class="text-2xl font-bold text-orange-600 mb-1">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mb-5" id="totalPriceNoteMobile"></p>

            <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-2">Tanggal Penyewaan</p>
            <div class="flex gap-3 mb-3">
                <div class="flex-1">
                    <label class="block text-xs text-gray-400 mb-1">Mulai</label>
                    <input type="date" id="startDateM" class="w-full border-2 border-gray-100 rounded-xl px-3 py-3 text-sm focus:border-gray-400 focus:outline-none transition-colors" onchange="onStartChangeM()">
                </div>
                <div class="flex-1">
                    <label class="block text-xs text-gray-400 mb-1">Selesai</label>
                    <input type="date" id="endDateM" class="w-full border-2 border-gray-100 rounded-xl px-3 py-3 text-sm focus:border-gray-400 focus:outline-none transition-colors" onchange="onDateChangeM()">
                </div>
            </div>
            <div id="durationBadgeM" class="hidden mb-4">
                <span id="durationTextM" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium" style="background:#FFF0F6;color:#C2185B;border:1px solid #F8BBD9;"></span>
            </div>
            <p id="dateErrorM" class="hidden text-xs text-red-500 mb-4">Tanggal selesai harus setelah tanggal mulai.</p>

            <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-2">Jumlah</p>
            <div class="flex items-center w-fit border-2 border-gray-100 rounded-xl overflow-hidden mb-6">
                <button onclick="changeQty(-1)" class="w-12 h-12 flex items-center justify-center bg-white text-xl text-gray-500 hover:bg-gray-50 select-none">−</button>
                <div id="qtyDisplay" class="w-12 h-12 flex items-center justify-center border-x-2 border-gray-100 text-sm font-bold text-gray-900">1</div>
                <button onclick="changeQty(1)" class="w-12 h-12 flex items-center justify-center bg-white text-xl text-gray-500 hover:bg-gray-50 select-none">+</button>
            </div>

            <div class="border-t border-gray-100">
                @foreach($accordions as $ac)
                <div class="border-b border-gray-100">
                    <button onclick="toggleAcc(this)" class="w-full flex items-center justify-between py-4 text-sm font-semibold text-gray-900 text-left">
                        {{ $ac['title'] }}
                        <span class="acc-icon transition-transform duration-300 {{ $ac['open'] ? 'rotate-180' : '' }}">▾</span>
                    </button>
                    <div class="acc-body overflow-hidden transition-all duration-300" style="{{ $ac['open'] ? 'max-height:200px;' : 'max-height:0;' }}">
                        <div class="pb-4 text-sm text-gray-500 leading-relaxed">{{ $ac['body'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- CTA Fixed Bottom --}}
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 px-4 py-3 flex gap-3 z-50 lg:hidden">
            <button onclick="addToCart({{ $item->id }})" id="addToCartBtn"
                class="flex-1 py-3.5 rounded-xl bg-gray-900 text-white text-xs font-black tracking-widest uppercase hover:bg-gray-700 active:scale-95 transition-all">
                + Keranjang
            </button>
            <button onclick="rentNow({{ $item->id }})"
                class="flex-1 py-3.5 rounded-xl bg-[#ED64A6] text-white text-xs font-black tracking-widest uppercase hover:bg-[#d45592] active:scale-95 transition-all">
                Sewa Sekarang
            </button>
        </div>
    </div>

    {{-- ══════════════════════════════
         DESKTOP (>= lg)
    ══════════════════════════════ --}}
    <div class="hidden lg:block max-w-6xl mx-auto px-10 pb-20">
        <div class="flex gap-5 items-start">

            {{-- Thumbnails vertical --}}
            <div class="flex flex-col items-center gap-2 shrink-0" style="width:72px;">
                <!-- <button onclick="scrollThumbs(-1)" class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-xs text-gray-400 hover:border-gray-500 transition-colors shrink-0">▲</button>
                <div id="thumbList" class="flex flex-col gap-2 overflow-hidden" style="max-height:400px;">
                    @foreach($relatedItems as $related)
                    <a href="{{ route('camping.show', $related->id) }}" class="block rounded-lg overflow-hidden border-2 border-gray-200 hover:border-gray-900 transition-all" style="width:72px;height:72px;">
                        <img src="{{ str_starts_with($related->image, 'http') ? $related->image : asset('storage/'.$related->image) }}" class="w-full h-full object-cover">
                    </a>
                    @endforeach
                </div>
                <button onclick="scrollThumbs(1)" class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-xs text-gray-400 hover:border-gray-500 transition-colors shrink-0">▼</button> -->
            </div>

            {{-- Main image --}}
            <div class="flex-1 rounded-2xl overflow-hidden bg-gray-100 group" style="aspect-ratio:1/1;min-width:0;">
                <img id="mainImg"
                    src="{{ str_starts_with($item->image, 'http') ? $item->image : asset('storage/'.$item->image) }}"
                    alt="{{ $item->name }}"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
            </div>

            {{-- Info --}}
            <div class="shrink-0 flex flex-col" style="width:360px;">
                <div class="flex justify-end gap-2 mb-5">
                    <button onclick="toggleLove(this)" class="love-btn w-9 h-9 rounded-full border border-gray-200 bg-white flex items-center justify-center text-gray-400 hover:border-pink-400 hover:text-pink-500 transition-all duration-300">
                        <span class="love-icon text-lg">♡</span>
                    </button>
                    <button onclick="shareProduct()" class="w-9 h-9 rounded-full border border-gray-200 bg-white flex items-center justify-center text-gray-400 hover:border-blue-400 hover:text-blue-500 transition-all duration-300">↗</button>
                </div>

                @if($item->is_new ?? false)
                <span class="mb-3 self-start bg-gray-900 text-white text-xs font-bold tracking-widest uppercase px-3 py-1 rounded">Baru</span>
                @endif

                <h1 class="text-xl font-bold text-gray-900 leading-snug mb-1">{{ $item->name }}</h1>
                <div class="flex items-baseline gap-2 mb-1">
                    <p class="text-2xl font-bold text-orange-600" id="displayPrice">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</p>
                    <span class="text-sm text-gray-400" id="priceLabel">/ hari</span>
                </div>
                <p class="text-xs text-gray-400 mb-5" id="totalPriceNote"></p>

                <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-3">Tanggal Penyewaan</p>
                <div class="flex gap-3 mb-3">
                    <div class="flex-1">
                        <label class="block text-xs text-gray-400 mb-1">Mulai</label>
                        <input type="date" id="startDate" class="w-full border-2 border-gray-100 rounded-xl px-3 py-3 text-sm focus:border-gray-400 focus:outline-none transition-colors" onchange="onStartChange()">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs text-gray-400 mb-1">Selesai</label>
                        <input type="date" id="endDate" class="w-full border-2 border-gray-100 rounded-xl px-3 py-3 text-sm focus:border-gray-400 focus:outline-none transition-colors" onchange="onDateChange()">
                    </div>
                </div>
                <div id="durationBadge" class="hidden mb-4">
                    <span id="durationText" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium" style="background:#FFF0F6;color:#C2185B;border:1px solid #F8BBD9;"></span>
                </div>
                <p id="dateError" class="hidden text-xs text-red-500 mb-3">Tanggal selesai harus setelah tanggal mulai.</p>

                <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-3">Jumlah</p>
                <div class="flex items-center w-fit border-2 border-gray-100 rounded-xl overflow-hidden mb-8">
                    <button onclick="changeQty(-1)" class="w-12 h-12 flex items-center justify-center bg-white text-xl text-gray-500 hover:bg-gray-50 active:bg-gray-100 transition-colors select-none">−</button>
                    <div id="qtyDisplay2" class="w-12 h-12 flex items-center justify-center border-x-2 border-gray-100 text-sm font-bold text-gray-900">1</div>
                    <button onclick="changeQty(1)" class="w-12 h-12 flex items-center justify-center bg-white text-xl text-gray-500 hover:bg-gray-50 active:bg-gray-100 transition-colors select-none">+</button>
                </div>

                <div class="flex gap-3 mb-6">
                    <button onclick="addToCart({{ $item->id }})" id="addToCartBtnD"
                        class="flex-1 py-4 rounded-xl bg-gray-900 text-white text-xs font-black tracking-widest uppercase hover:bg-gray-700 active:scale-95 transition-all duration-200">
                        Tambahkan ke Keranjang
                    </button>
                    <button onclick="rentNow({{ $item->id }})"
                        class="flex-1 py-4 rounded-xl bg-[#ED64A6] text-white text-xs font-black tracking-widest uppercase hover:bg-[#d45592] active:scale-95 transition-all duration-200">
                        Sewa Sekarang
                    </button>
                </div>

                <div>
                    @foreach($accordions as $ac)
                    <div class="border-b border-gray-100">
                        <button onclick="toggleAcc(this)" class="w-full flex items-center justify-between py-4 text-sm font-semibold text-gray-900 text-left">
                            {{ $ac['title'] }}
                            <span class="acc-icon transition-transform duration-300 {{ $ac['open'] ? 'rotate-180' : '' }}">▾</span>
                        </button>
                        <div class="acc-body overflow-hidden transition-all duration-300" style="{{ $ac['open'] ? 'max-height:200px;' : 'max-height:0;' }}">
                            <div class="pb-4 text-sm text-gray-500 leading-relaxed">{{ $ac['body'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Toast --}}
<div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 px-5 py-3 rounded-xl text-sm font-medium text-white shadow-lg transition-all duration-300 opacity-0 pointer-events-none z-50" style="background:#1a1a1a;min-width:220px;text-align:center;"></div>

<script>
    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    let thumbOffset = 0, qty = 1;
    const PRICE_PER_DAY = {{ $item->price_per_day }};
    const MAX_STOCK = {{ $item->stock ?? 99 }};

    function syncQty() {
        ['qtyDisplay','qtyDisplay2'].forEach(id => { const el = document.getElementById(id); if (el) el.textContent = qty; });
    }

    function changeQty(d) {
        const next = qty + d;
        if (next < 1) return;
        if (next > MAX_STOCK) { showToast(`Stok tersedia hanya ${MAX_STOCK} unit`, 'error'); return; }
        qty = next; syncQty(); updatePrice();
    }

    function switchImgMobile(btn, src, idx, total) {
        document.getElementById('mainImgMobile').src = src;
        document.getElementById('imgCounter').textContent = `${idx} / ${total}`;
        btn.parentElement.querySelectorAll('button').forEach(b => { b.classList.remove('border-gray-900'); b.classList.add('border-gray-200'); });
        btn.classList.add('border-gray-900'); btn.classList.remove('border-gray-200');
    }

    function scrollThumbs(dir) {
        const list = document.getElementById('thumbList');
        const max = Math.max(0, list.scrollHeight - list.clientHeight);
        thumbOffset = Math.min(max, Math.max(0, thumbOffset + dir * 80));
        list.style.transform = `translateY(-${thumbOffset}px)`;
        list.style.transition = 'transform .25s ease';
    }

    function toggleAcc(button) {
        const body = button.nextElementSibling;
        const icon = button.querySelector('.acc-icon');
        const open = body.style.maxHeight && body.style.maxHeight !== '0px';
        body.style.maxHeight = open ? '0px' : body.scrollHeight + 'px';
        icon.classList.toggle('rotate-180', !open);
    }

    const today = new Date().toISOString().split('T')[0];
    ['startDate','endDate','startDateM','endDateM'].forEach(id => { const el = document.getElementById(id); if (el) el.min = today; });

    function onStartChange() {
        const s = document.getElementById('startDate').value;
        document.getElementById('endDate').min = s;
        if (document.getElementById('endDate').value <= s) document.getElementById('endDate').value = '';
        onDateChange();
    }
    function onStartChangeM() {
        const s = document.getElementById('startDateM').value;
        document.getElementById('endDateM').min = s;
        if (document.getElementById('endDateM').value <= s) document.getElementById('endDateM').value = '';
        onDateChangeM();
    }
    function onDateChange() { handleDateChange('', ''); }
    function onDateChangeM() { handleDateChange('M', 'M'); }

    function handleDateChange(sfx) {
        const s = document.getElementById('startDate' + sfx)?.value;
        const e = document.getElementById('endDate' + sfx)?.value;
        const err = document.getElementById('dateError' + sfx);
        const badge = document.getElementById('durationBadge' + sfx);
        const text = document.getElementById('durationText' + sfx);
        if (err) err.classList.add('hidden');
        if (badge) badge.classList.add('hidden');
        if (s && e) {
            if (e <= s) { if (err) err.classList.remove('hidden'); }
            else {
                const days = Math.round((new Date(e) - new Date(s)) / 86400000);
                if (badge && text) { badge.classList.remove('hidden'); text.textContent = `🗓 ${days} hari sewa`; }
            }
        }
        updatePrice();
    }

    function fmtRp(n) { return 'Rp ' + Math.round(n).toLocaleString('id-ID'); }

    function updatePrice() {
        const getD = sfx => { const s = document.getElementById('startDate'+sfx)?.value, e = document.getElementById('endDate'+sfx)?.value; if (!s||!e) return 0; const d = Math.round((new Date(e)-new Date(s))/86400000); return d>0?d:0; };
        const days = getD('') || getD('M');
        const txt = days > 0 ? `Total ${days} hari × ${qty} unit = ${fmtRp(PRICE_PER_DAY * days * qty)}` : (qty > 1 ? `${qty} unit dipilih` : '');
        ['totalPriceNote','totalPriceNoteMobile'].forEach(id => { const el = document.getElementById(id); if (el) el.textContent = txt; });
    }

    function showToast(msg, type = 'success') {
        const t = document.getElementById('toast');
        t.textContent = msg; t.style.background = type === 'error' ? '#e53e3e' : '#1a1a1a';
        t.classList.remove('opacity-0'); t.classList.add('opacity-100');
        setTimeout(() => { t.classList.remove('opacity-100'); t.classList.add('opacity-0'); }, 2500);
    }

    function getFormData() {
        return {
            startDate: document.getElementById('startDate')?.value || document.getElementById('startDateM')?.value,
            endDate: document.getElementById('endDate')?.value || document.getElementById('endDateM')?.value,
        };
    }

    function addToCart(itemId) {
        if (!isLoggedIn) { window.location.href = "{{ route('login') }}"; return; }
        const { startDate, endDate } = getFormData();
        if (!startDate || !endDate) { showToast('Pilih tanggal penyewaan terlebih dahulu', 'error'); return; }
        const btns = ['addToCartBtn','addToCartBtnD'].map(id => document.getElementById(id)).filter(Boolean);
        btns.forEach(b => { b.disabled = true; b.textContent = 'Menambahkan...'; });
        fetch('/cart/add', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ product_id: itemId, quantity: qty, start_date: startDate, end_date: endDate })
        })
        .then(r => r.status === 401 ? (window.location.href = "{{ route('login') }}") : r.json())
        .then(data => { if (data?.success) showToast('Berhasil ditambahkan ke keranjang ✓'); else showToast(data?.message ?? 'Gagal menambahkan', 'error'); })
        .catch(() => showToast('Terjadi kesalahan, coba lagi', 'error'))
        .finally(() => btns.forEach(b => { b.disabled = false; b.textContent = b.id === 'addToCartBtn' ? '+ Keranjang' : 'Tambahkan ke Keranjang'; }));
    }

    function rentNow(itemId) {
        if (!isLoggedIn) { window.location.href = "{{ route('login') }}"; return; }
        const { startDate, endDate } = getFormData();
        if (!startDate || !endDate) { showToast('Pilih tanggal penyewaan terlebih dahulu', 'error'); return; }
        fetch('/cart/add', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ product_id: itemId, quantity: qty, start_date: startDate, end_date: endDate })
        })
        .then(r => r.status === 401 ? (window.location.href = "{{ route('login') }}") : r.json())
        .then(data => { if (data?.success) window.location.href = '/checkout'; else showToast(data?.message ?? 'Gagal', 'error'); })
        .catch(() => showToast('Terjadi kesalahan, coba lagi', 'error'));
    }

    function toggleLove(btn) {
        const icon = btn.querySelector('.love-icon');
        btn.classList.toggle('liked');
        const liked = btn.classList.contains('liked');
        btn.classList.toggle('border-pink-500', liked); btn.classList.toggle('text-pink-500', liked);
        icon.textContent = liked ? '♥' : '♡';
    }

    function shareProduct() {
        if (navigator.share) navigator.share({ title: document.title, url: window.location.href });
        else { navigator.clipboard.writeText(window.location.href); showToast('Link berhasil disalin ✓'); }
    }
</script>

@include('layouts.footer_biasa')
@endsection