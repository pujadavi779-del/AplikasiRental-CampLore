@extends('layouts.landingpage')

@section('content')

{{--
    VARIABEL YANG DIBUTUHKAN DARI CONTROLLER:
    - $item          : object produk
    - $Kategori_data      : string, misal 'camera' atau 'camping'
    - $categoryLabel : string label untuk breadcrumb, misal 'Kamera' atau 'Camping'
    - $accordions    : array accordion (opsional, kalau tidak dikirim akan pakai default di bawah)

    CONTOH CONTROLLER (camera):
    return view('catalog_details', [
        'item'          => $item,
        'Kategori_data'      => 'camera',
        'categoryLabel' => 'Kamera',
        'accordions'    => [
            ['title' => 'Tentang Kamera ini',  'deskripsi' => $item->deskripsi ?? 'Deskripsi tidak tersedia.', 'open' => true],
            ['title' => 'Sorotan',             'deskripsi' => 'Spesifikasi unggulan untuk ' . $item->name . '.', 'open' => false],
            ['title' => 'Isi Paket',           'deskripsi' => $item->stok > 0 ? 'Tersedia — '.$item->stok.' unit siap disewa.' : 'Stok sedang kosong.', 'open' => false],
        ],
    ]);

    CONTOH CONTROLLER (camping):
    return view('catalog_details', [
        'item'          => $item,
        'Kategori_data'      => 'camping',
        'categoryLabel' => 'Camping',
        'accordions'    => [
            ['title' => 'Tentang Alat ini', 'deskripsi' => $item->description ?? 'Deskripsi belum tersedia.', 'open' => true],
            ['title' => 'Sorotan',          'deskripsi' => 'Kualitas premium untuk perlengkapan outdoor ' . $item->name . '.', 'open' => false],
            ['title' => 'Isi Paket',        'deskripsi' => $item->stok > 0 ? 'Tersedia — '.$item->stok.' unit siap disewa.' : 'Produk ini sedang habis disewa.', 'open' => false],
        ],
    ]);
--}}

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">

@php
if (!isset($accordions)) {
$accordions = [
['title' => 'Tentang Produk ini', 'deskripsi' => $item->deskripsi ?? $item->description ?? 'Deskripsi tidak tersedia.', 'open' => true],
['title' => 'Sorotan', 'deskripsi' => 'Spesifikasi unggulan untuk ' . $item->name . '.', 'open' => false],
['title' => 'Isi Paket', 'deskripsi' => $item->stok > 0 ? 'Tersedia — '.$item->stok.' unit siap disewa.' : 'Maaf, stok sedang kosong.', 'open' => false],
];
}
@endphp

<div style="font-family:'DM Sans',sans-serif;">

    {{-- ── BREADCRUMB ─────────────────────────────────────────── --}}
    <nav class="flex items-center gap-2 px-4 py-4 text-xs text-gray-400 max-w-6xl mx-auto">
        <a href="/" class="hover:text-gray-900 transition-colors">BERANDA</a>
        <span>/</span>
        <a href="{{ route($kategori . '.LP') }}" class="hover:text-gray-900 transition-colors">{{ $categoryLabel }}</a>
        <span>/</span>
        <span class="text-orange-600 font-medium truncate">{{ $item->name }}</span>
    </nav>

    {{-- ══════════════════════════════════════════════════════════
         MOBILE LAYOUT (< lg)
    ══════════════════════════════════════════════════════════ --}}
    <div class="lg:hidden">

        {{-- Main Image --}}
        <div class="relative bg-gray-100 w-full" style="aspect-ratio:1/1;">
            <!-- <img id="mainImgMobile"
                src="{{ str_starts_with($item->gambar_barang, 'http') ? $item->gambar_barang : asset('storage/'.$item->gambar_barang) }}" -->
            <img id="mainImgMobile"
                src="{{ str_starts_with($item->gambar_barang, 'http') 
        ? $item->gambar_barang 
        : asset($item->gambar_barang) }}"
                alt="{{ $item->name }}"
                class="w-full h-full object-cover">
        </div>

        {{-- Thumbnail horizontal scroll --}}
        <div class="flex gap-2 px-4 py-3 overflow-x-auto no-scrollbar">
            {{-- Uncomment jika fitur multi-gambar diaktifkan
            <button onclick="switchImgMobile(this, '...', 1, total)"
                class="shrink-0 w-16 h-16 rounded-xl overflow-hidden border-2 border-gray-900">
                <img src="..." class="w-full h-full object-cover">
            </button>
            --}}
        </div>

        {{-- Info --}}
        <div class="px-4 pb-32">

            {{-- Badge --}}
            <div class="flex items-center justify-between mb-2">
                <div>
                    @if($item->is_new ?? false)
                    <span class="bg-gray-900 text-white text-xs font-bold tracking-widest uppercase px-3 py-1 rounded">Baru</span>
                    @endif
                </div>
            </div>

            <h1 class="text-xl font-bold text-gray-900 leading-snug mb-2">{{ $item->name }}</h1>
            <p class="text-2xl font-bold text-orange-600 mb-1">Rp {{ number_format($item->harga_per_hari, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mb-5" id="totalPriceNoteMobile"></p>

            {{-- Tanggal --}}
            <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-2">Tanggal Penyewaan</p>
            <div class="flex gap-3 mb-3">
                <div class="flex-1">
                    <label class="block text-xs text-gray-400 mb-1">Mulai</label>
                    <input type="date" id="startDateM" onchange="onStartChangeM()"
                        class="w-full border-2 border-gray-100 rounded-xl px-3 py-3 text-sm focus:border-gray-400 focus:outline-none transition-colors">
                </div>
                <div class="flex-1">
                    <label class="block text-xs text-gray-400 mb-1">Selesai</label>
                    <input type="date" id="endDateM" onchange="onDateChangeM()"
                        class="w-full border-2 border-gray-100 rounded-xl px-3 py-3 text-sm focus:border-gray-400 focus:outline-none transition-colors">
                </div>
            </div>
            <div id="durationBadgeM" class="hidden mb-4">
                <span id="durationTextM" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium"
                    style="background:#FFF0F6;color:#C2185B;border:1px solid #F8BBD9;"></span>
            </div>
            <p id="dateErrorM" class="hidden text-xs text-red-500 mb-4">Tanggal selesai harus setelah tanggal mulai.</p>

            {{-- Jumlah --}}
            <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-2">Jumlah</p>
            <div class="flex items-center w-fit border-2 border-gray-100 rounded-xl overflow-hidden mb-6">
                <button onclick="changeQty(-1)" class="w-12 h-12 flex items-center justify-center bg-white text-xl text-gray-500 hover:bg-gray-50 select-none">−</button>
                <div id="qtyDisplay" class="w-12 h-12 flex items-center justify-center border-x-2 border-gray-100 text-sm font-bold text-gray-900">1</div>
                <button onclick="changeQty(1)" class="w-12 h-12 flex items-center justify-center bg-white text-xl text-gray-500 hover:bg-gray-50 select-none">+</button>
            </div>

            {{-- Accordion --}}
            <div class="border-t border-gray-100">
                @foreach($accordions as $ac)
                <div class="border-b border-gray-100">
                    <button onclick="toggleAcc(this)" class="w-full flex items-center justify-between py-4 text-sm font-semibold text-gray-900 text-left">
                        {{ $ac['title'] }}
                        <span class="acc-icon transition-transform duration-300 {{ $ac['open'] ? 'rotate-180' : '' }}">▾</span>
                    </button>
                    <div class="acc-deskripsi overflow-hidden transition-all duration-300" style="{{ $ac['open'] ? 'max-height:200px;' : 'max-height:0;' }}">
                        <div class="pb-4 text-sm text-gray-500 leading-relaxed">{{ $ac['deskripsi'] }}</div>
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

    {{-- ══════════════════════════════════════════════════════════
         DESKTOP LAYOUT (>= lg)
    ══════════════════════════════════════════════════════════ --}}
    <div class="hidden lg:block max-w-6xl mx-auto px-10 pb-20">
        <div class="flex gap-5 items-start">

            {{-- Thumbnail column (uncomment jika multi-gambar aktif) --}}
            <div class="flex flex-col items-center gap-2 shrink-0" style="width:72px;">
                {{--
                <button onclick="scrollThumbs(-1)" class="...">▲</button>
                <div id="thumbList" class="flex flex-col gap-2 overflow-hidden" style="max-height:400px;">
                    @foreach($relatedItems as $related)
                    <a href="{{ route($Kategori_data . '.show', $related->id) }}" class="block rounded-lg overflow-hidden border-2 border-gray-200 hover:border-gray-900 transition-all" style="width:72px;height:72px;">
                <img src="{{ str_starts_with($related->gambar_barang, 'http') ? $related->gambar_barang : asset('storage/'.$related->gambar_barang) }}" class="w-full h-full object-cover">
                </a>
                @endforeach
            </div>
            <button onclick="scrollThumbs(1)" class="...">▼</button>
            --}}
        </div>

        {{-- Main Image --}}
        <div class="flex-1 rounded-2xl overflow-hidden bg-gray-100 group" style="aspect-ratio:1/1;min-width:0;">
            <img id="mainImg"
                src="{{ str_starts_with($item->gambar_barang, 'http') 
        ? $item->gambar_barang 
        : asset($item->gambar_barang) }}"
                
            alt="{{ $item->name }}"
            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
        </div>

        {{-- Info column --}}
        <div class="shrink-0 flex flex-col" style="width:360px;">

            @if($item->is_new ?? false)
            <span class="mb-3 self-start bg-gray-900 text-white text-xs font-bold tracking-widest uppercase px-3 py-1 rounded">Baru</span>
            @endif

            <h1 class="text-xl font-bold text-gray-900 leading-snug mb-1">{{ $item->name }}</h1>
            <div class="flex items-baseline gap-1 mb-1">
                <p class="text-2xl font-bold text-orange-600" id="displayPrice">Rp {{ number_format($item->harga_per_hari, 0, ',', '.') }}</p>
                <span class="text-sm text-gray-400">/ hari</span>
            </div>
            <p class="text-xs text-gray-400 mb-5" id="totalPriceNote"></p>

            {{-- Tanggal --}}
            <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-3">Tanggal Penyewaan</p>
            <div class="flex gap-3 mb-3">
                <div class="flex-1">
                    <label class="block text-xs text-gray-400 mb-1">Mulai</label>
                    <input type="date" id="startDate" onchange="onStartChange()"
                        class="w-full border-2 border-gray-100 rounded-xl px-3 py-3 text-sm focus:border-gray-400 focus:outline-none transition-colors">
                </div>
                <div class="flex-1">
                    <label class="block text-xs text-gray-400 mb-1">Selesai</label>
                    <input type="date" id="endDate" onchange="onDateChange()"
                        class="w-full border-2 border-gray-100 rounded-xl px-3 py-3 text-sm focus:border-gray-400 focus:outline-none transition-colors">
                </div>
            </div>
            <div id="durationBadge" class="hidden mb-5">
                <span id="durationText" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium"
                    style="background:#FFF0F6;color:#C2185B;border:1px solid #F8BBD9;"></span>
            </div>
            <p id="dateError" class="hidden text-xs text-red-500 mb-4">Tanggal selesai harus setelah tanggal mulai.</p>

            {{-- Jumlah --}}
            <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-3">Jumlah</p>
            <div class="flex items-center w-fit border-2 border-gray-100 rounded-xl overflow-hidden mb-8">
                <button onclick="changeQty(-1)" class="w-12 h-12 flex items-center justify-center bg-white text-xl text-gray-500 hover:bg-gray-50 active:bg-gray-100 transition-colors select-none">−</button>
                <div id="qtyDisplay2" class="w-12 h-12 flex items-center justify-center border-x-2 border-gray-100 text-sm font-bold text-gray-900">1</div>
                <button onclick="changeQty(1)" class="w-12 h-12 flex items-center justify-center bg-white text-xl text-gray-500 hover:bg-gray-50 active:bg-gray-100 transition-colors select-none">+</button>
            </div>

            {{-- CTA --}}
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

            {{-- Accordion --}}
            <div>
                @foreach($accordions as $ac)
                <div class="border-b border-gray-100">
                    <button onclick="toggleAcc(this)" class="w-full flex items-center justify-between py-4 text-sm font-semibold text-gray-900 text-left">
                        {{ $ac['title'] }}
                        <span class="acc-icon transition-transform duration-300 {{ $ac['open'] ? 'rotate-180' : '' }}">▾</span>
                    </button>
                    <div class="acc-deskripsi overflow-hidden transition-all duration-300" style="{{ $ac['open'] ? 'max-height:200px;' : 'max-height:0;' }}">
                        <div class="pb-4 text-sm text-gray-500 leading-relaxed">{{ $ac['deskripsi'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</div>

{{-- Toast --}}
<div id="toast"
    class="fixed bottom-6 left-1/2 -translate-x-1/2 px-5 py-3 rounded-xl text-sm font-medium text-white shadow-lg transition-all duration-300 opacity-0 pointer-events-none z-50"
    style="background:#1a1a1a;min-width:220px;text-align:center;"></div>

<script>
    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

    let thumbOffset = 0,
        qty = 1;
        
    const PRICE_PER_DAY = {{ $item->harga_per_hari }};

    const MAX_STOCK = {{ $item->stok ?? 99 }};

    // ── Qty ────────────────────────────────────────────────────
    function syncQty() {
        ['qtyDisplay', 'qtyDisplay2'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = qty;
        });
    }

    function changeQty(d) {
        const next = qty + d;
        if (next < 1) return;
        if (next > MAX_STOCK) {
            showToast(`Stok tersedia hanya ${MAX_STOCK} unit`, 'error');
            return;
        }
        qty = next;
        syncQty();
        updatePrice();
    }

    // ── Image helpers ──────────────────────────────────────────
    function switchImgMobile(btn, src, idx, total) {
        document.getElementById('mainImgMobile').src = src;
        document.getElementById('imgCounter').textContent = `${idx} / ${total}`;
        btn.parentElement.querySelectorAll('button').forEach(b => {
            b.classList.remove('border-gray-900');
            b.classList.add('border-gray-200');
        });
        btn.classList.add('border-gray-900');
        btn.classList.remove('border-gray-200');
    }

    function scrollThumbs(dir) {
        const list = document.getElementById('thumbList');
        const max = Math.max(0, list.scrollHeight - list.clientHeight);
        thumbOffset = Math.min(max, Math.max(0, thumbOffset + dir * 80));
        list.style.transform = `translateY(-${thumbOffset}px)`;
        list.style.transition = 'transform .25s ease';
    }

    // ── Accordion ──────────────────────────────────────────────
    function toggleAcc(button) {
        const deskripsi = button.nextElementSibling;
        const icon = button.querySelector('.acc-icon');
        const open = deskripsi.style.maxHeight && deskripsi.style.maxHeight !== '0px';
        deskripsi.style.maxHeight = open ? '0px' : deskripsi.scrollHeight + 'px';
        icon.classList.toggle('rotate-180', !open);
    }

    // ── Date ───────────────────────────────────────────────────
    const today = new Date().toISOString().split('T')[0];
    ['startDate', 'endDate', 'startDateM', 'endDateM'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.min = today;
    });

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

    function onDateChange() {
        handleDateChange('');
    }

    function onDateChangeM() {
        handleDateChange('M');
    }

    function handleDateChange(sfx) {
        const s = document.getElementById('startDate' + sfx)?.value;
        const e = document.getElementById('endDate' + sfx)?.value;
        const err = document.getElementById('dateError' + sfx);
        const badge = document.getElementById('durationBadge' + sfx);
        const text = document.getElementById('durationText' + sfx);

        if (err) err.classList.add('hidden');
        if (badge) badge.classList.add('hidden');

        if (s && e) {
            if (e <= s) {
                if (err) err.classList.remove('hidden');
            } else {
                const days = Math.round((new Date(e) - new Date(s)) / 86400000);
                if (badge && text) {
                    badge.classList.remove('hidden');
                    text.textContent = `🗓 ${days} hari sewa`;
                }
            }
        }
        updatePrice();
    }

    // ── Price ──────────────────────────────────────────────────
    function fmtRp(n) {
        return 'Rp ' + Math.round(n).toLocaleString('id-ID');
    }

    function getDays(sfx = '') {
        const s = document.getElementById('startDate' + sfx)?.value;
        const e = document.getElementById('endDate' + sfx)?.value;
        if (!s || !e) return 0;
        const d = Math.round((new Date(e) - new Date(s)) / 86400000);
        return d > 0 ? d : 0;
    }

    function updatePrice() {
        const days = getDays('') || getDays('M');
        const txt = days > 0 ?
            `Total ${days} hari × ${qty} unit = ${fmtRp(PRICE_PER_DAY * days * qty)}` :
            (qty > 1 ? `${qty} unit dipilih` : '');
        ['totalPriceNote', 'totalPriceNoteMobile'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = txt;
        });
    }

    // ── Toast ──────────────────────────────────────────────────
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

    // ── Form data ──────────────────────────────────────────────
    function getFormData() {
        return {
            startDate: document.getElementById('startDate')?.value || document.getElementById('startDateM')?.value,
            endDate: document.getElementById('endDate')?.value || document.getElementById('endDateM')?.value,
        };
    }

    // ── Cart & Checkout ────────────────────────────────────────
    function addToCart(itemId) {
        if (!isLoggedIn) {
            window.location.href = "{{ route('login') }}";
            return;
        }
        const {
            startDate,
            endDate
        } = getFormData();
        if (!startDate || !endDate) {
            showToast('Pilih tanggal penyewaan terlebih dahulu', 'error');
            return;
        }

        const btns = ['addToCartBtn', 'addToCartBtnD'].map(id => document.getElementById(id)).filter(Boolean);
        btns.forEach(b => {
            b.disabled = true;
            b.textContent = 'Menambahkan...';
        });

        fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: itemId,
                    quantity: qty,
                    start_date: startDate,
                    end_date: endDate
                })
            })
            .then(r => r.status === 401 ? window.location.href = "{{ route('login') }}" : r.json())
            .then(data => {
            if (data?.success) {

                showToast('Berhasil ditambahkan ke keranjang ✓');

                const badge = document.getElementById('cart-badge');

                if (badge) {
                    badge.textContent = data.total;
                }

            } else {
                showToast(data?.message ?? 'Gagal menambahkan', 'error');
            }
            })
            .catch(() => showToast('Terjadi kesalahan, coba lagi', 'error'))
            .finally(() => btns.forEach(b => {
                b.disabled = false;
                b.textContent = b.id === 'addToCartBtn' ? '+ Keranjang' : 'Tambahkan ke Keranjang';
            }));
    }

function rentNow(itemId) {
    if (!isLoggedIn) {
        window.location.href = "{{ route('login') }}";
        return;
    }
    const { startDate, endDate } = getFormData();
    if (!startDate || !endDate) {
        showToast('Pilih tanggal penyewaan terlebih dahulu', 'error');
        return;
    }

    fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: itemId,
                quantity: qty,
                start_date: startDate,
                end_date: endDate
            })
        })
        .then(r => r.status === 401 ? window.location.href = "{{ route('login') }}" : r.json())
        .then(data => {
            if (data?.success && data?.cart_id) {
                window.location.href = '/checkout?ids[]=' + data.cart_id;
            } else {
                showToast(data?.message ?? 'Gagal', 'error');
            }
        })
        .catch(() => showToast('Terjadi kesalahan, coba lagi', 'error'));
}

    function shareProduct() {
        if (navigator.share) navigator.share({
            title: document.title,
            url: window.location.href
        });
        else {
            navigator.clipboard.writeText(window.location.href);
            showToast('Link berhasil disalin ✓');
        }
    }
</script>
{{-- ══════════════════════════════════════════════════════════
     SECTION ULASAN PELANGGAN
══════════════════════════════════════════════════════════ --}}
<div class="max-w-6xl mx-auto px-4 lg:px-10 py-14" style="font-family:'DM Sans',sans-serif;">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-8">
        <div>
            <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-1">Yang Mereka Bilang</p>
            <h2 class="text-2xl font-bold text-gray-900">Ulasan Pelanggan</h2>
        </div>
        @if(isset($reviews) && $reviews->count() > 0)
        <div class="flex items-center gap-3">
            <span class="text-5xl font-black text-gray-900">{{ $avgRating }}</span>
            <div>
                <div class="flex items-center gap-0.5 mb-1">
                    @for($i = 1; $i <= 5; $i++)
                    <svg width="18" height="18" viewBox="0 0 24 24"
                        fill="{{ $i <= round($avgRating) ? '#f59e0b' : '#e5e7eb' }}"
                        stroke="{{ $i <= round($avgRating) ? '#f59e0b' : '#d1d5db' }}"
                        stroke-width="1.5">
                        <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                    </svg>
                    @endfor
                </div>
                <p class="text-xs text-gray-400">{{ $reviews->count() }} ulasan</p>
            </div>
        </div>
        @endif
    </div>

    {{-- Form Tulis Ulasan --}}
    @if(isset($canReview) && $canReview && isset($reviewOrder))
    <div class="bg-[#f9fdfb] border border-[#d7e6de] rounded-2xl p-6 mb-8">
        <h3 class="text-base font-bold text-gray-900 mb-1">Tulis Ulasanmu</h3>
        <p class="text-xs text-gray-400 mb-5">Bagikan pengalamanmu menyewa produk ini.</p>

        @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('pelanggan.ulasan.store', $reviewOrder->id) }}" method="POST">
            @csrf
            <input type="hidden" name="bintang" id="rating-input-detail" value="{{ old('bintang', 0) }}">

            {{-- Bintang --}}
            <div class="mb-4">
                <p class="text-xs font-bold text-gray-700 mb-2">Rating <span class="text-pink-500">*</span></p>
                <div class="flex items-center gap-2" id="star-detail">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button" data-value="{{ $i }}"
                        class="star-btn-detail focus:outline-none transition-transform hover:scale-110">
                        <svg width="32" height="32" viewBox="0 0 24 24"
                            fill="#e5e7eb" stroke="#d1d5db" stroke-width="1.5" class="star-icon-detail">
                            <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                        </svg>
                    </button>
                    @endfor
                    <span id="rating-label-detail" class="text-sm font-bold text-amber-500 ml-1"></span>
                </div>
            </div>

            {{-- Komentar --}}
            <div class="mb-4">
                <p class="text-xs font-bold text-gray-700 mb-2">Komentar <span class="text-pink-500">*</span></p>
                <textarea name="komentar" rows="4" maxlength="1000"
                    placeholder="Ceritakan pengalamanmu menyewa produk ini..."
                    class="w-full text-sm bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#22543D] resize-none placeholder-gray-300">{{ old('komentar') }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-2.5 bg-gray-900 hover:bg-gray-700 text-white text-sm font-bold rounded-xl transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim Ulasan
                </button>
            </div>
        </form>
    </div>
    @endif

    {{-- Daftar Ulasan --}}
    @if(isset($reviews) && $reviews->count() > 0)
    @php $visibleReviews = $reviews->take(2); $hiddenReviews = $reviews->skip(2); @endphp

    <div class="space-y-4" id="review-list">
        @foreach($visibleReviews as $review)
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
                        style="background: linear-gradient(135deg,#22543D,#38a169)">
                        {{ strtoupper(substr($review->pelanggan->name ?? 'U', 0, 2)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-900">{{ $review->pelanggan->name ?? 'Pengguna' }}</span>
                            <span class="text-[10px] font-bold text-[#22543D] bg-[#d1fae5] px-2 py-0.5 rounded-full">✓ Terverifikasi</span>
                        </div>
                        <div class="flex items-center gap-0.5 mt-0.5">
                            @for($i = 1; $i <= 5; $i++)
                            <svg width="13" height="13" viewBox="0 0 24 24"
                                fill="{{ $i <= $review->bintang ? '#f59e0b' : '#e5e7eb' }}"
                                stroke="{{ $i <= $review->bintang ? '#f59e0b' : '#d1d5db' }}"
                                stroke-width="1.5">
                                <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                            </svg>
                            @endfor
                        </div>
                    </div>
                </div>
                <span class="text-xs text-gray-400 flex-shrink-0">{{ $review->created_at->diffForHumans() }}</span>
            </div>
            
            <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $review->komentar }}</p>

            @if($review->is_replied && $review->balas_pesan)
            <div class="mt-3 bg-gray-50 border-l-4 border-gray-900 rounded-r-xl px-4 py-3">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wide mb-1">Balasan Penjual</p>
                <p class="text-sm text-gray-600">{{ $review->balas_pesan }}</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    {{-- Hidden reviews --}}
    @if($hiddenReviews->count() > 0)
    <div id="hidden-reviews" style="display:none;" class="space-y-4 mt-4">
        @foreach($hiddenReviews as $review)
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
                        style="background: linear-gradient(135deg,#ED64A6,#f43f8e)">
                        {{ strtoupper(substr($review->pelanggan->name ?? 'U', 0, 2)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-900">{{ $review->pelanggan->name ?? 'Pengguna' }}</span>
                            <span class="text-[10px] font-bold text-[#22543D] bg-[#d1fae5] px-2 py-0.5 rounded-full">✓ Terverifikasi</span>
                        </div>
                        <div class="flex items-center gap-0.5 mt-0.5">
                            @for($i = 1; $i <= 5; $i++)
                            <svg width="13" height="13" viewBox="0 0 24 24"
                                fill="{{ $i <= $review->bintang ? '#f59e0b' : '#e5e7eb' }}"
                                stroke="{{ $i <= $review->bintang ? '#f59e0b' : '#d1d5db' }}"
                                stroke-width="1.5">
                                <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                            </svg>
                            @endfor
                        </div>
                    </div>
                </div>
                <span class="text-xs text-gray-400 flex-shrink-0">{{ $review->created_at->diffForHumans() }}</span>
            </div>
            <p class="text-sm text-gray-600 mt-3 leading-relaxed">{{ $review->komentar }}</p>
            @if($review->is_replied && $review->balas_pesan)
            <div class="mt-3 bg-gray-50 border-l-4 border-gray-900 rounded-r-xl px-4 py-3">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wide mb-1">Balasan Penjual</p>
                <p class="text-sm text-gray-600">{{ $review->balas_pesan }}</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <div class="text-center mt-6">
        <button onclick="toggleAllReviews(this)"
            class="px-6 py-2.5 border-2 border-gray-900 text-gray-900 text-sm font-bold rounded-full hover:bg-gray-900 hover:text-white transition-all">
            Lihat Semua {{ $reviews->count() }} Ulasan
        </button>
    </div>
    @endif

    @else
    <div class="text-center py-12 text-gray-400">
        <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        <p class="text-sm font-medium">Belum ada ulasan untuk produk ini.</p>
    </div>
    @endif

</div>

<script>
// Star rating untuk form di detail produk
document.addEventListener('DOMContentLoaded', function () {
    const labels = ['','Buruk','Kurang','Cukup','Bagus','Sangat Bagus'];
    const ratingInput = document.getElementById('rating-input-detail');
    const ratingLabel = document.getElementById('rating-label-detail');
    const stars = document.querySelectorAll('.star-btn-detail');
    if (!ratingInput) return;
    let currentRating = 0;

    function paintStars(count) {
        stars.forEach(btn => {
            const icon = btn.querySelector('.star-icon-detail');
            const idx = parseInt(btn.dataset.value);
            icon.setAttribute('fill', idx <= count ? '#f59e0b' : '#e5e7eb');
            icon.setAttribute('stroke', idx <= count ? '#f59e0b' : '#d1d5db');
        });
        if (ratingLabel) ratingLabel.textContent = labels[count] || '';
    }

    stars.forEach(btn => {
        btn.addEventListener('click', function () {
            currentRating = parseInt(this.dataset.value);
            ratingInput.value = currentRating;
            paintStars(currentRating);
        });
        btn.addEventListener('mouseenter', function () { paintStars(parseInt(this.dataset.value)); });
        btn.addEventListener('mouseleave', function () { paintStars(currentRating); });
    });
});

function toggleAllReviews(btn) {
    const hidden = document.getElementById('hidden-reviews');
    if (hidden.style.display === 'none') {
        hidden.style.display = 'block';
        btn.textContent = 'Sembunyikan';
    } else {
        hidden.style.display = 'none';
        btn.textContent = 'Lihat Semua {{ $reviews->count() }} Ulasan';
    }
}
</script>
@include('layouts.footer_biasa')
@endsection