@extends('layouts.landingpage')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">


<div class="max-w-4xl mx-auto px-4 py-8 pb-36 bg-white min-h-screen">

    <h2 class="text-2xl font-extrabold text-gray-900 mb-6">Keranjang Rental</h2>

    {{-- Header tabel --}}
    <div class="hidden md:grid grid-cols-[auto_1fr_160px_120px_140px_48px] gap-4 px-4 pb-2 border-b border-gray-200 mb-1">
        <div class="w-5"></div>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Item Rental</p>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Harga /Hari</p>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Satuan</p>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Subtotal</p>
        <div></div>
    </div>

    <div id="cartContainer" class="flex flex-col">

        @forelse($carts as $cart)
        @php
        $days = ($cart->start_date && $cart->end_date)
        ? max(1, \Carbon\Carbon::parse($cart->start_date)->diffInDays($cart->end_date))
        : 1;
        $subtotal = ($cart->item->price ?? 0) * $cart->quantity * $days;
        @endphp

        <div class="card-item border-b border-gray-100"
            data-id="{{ $cart->id }}"
            data-price="{{ $cart->item->price ?? 0 }}">

            {{-- Baris utama --}}
            <div class="grid grid-cols-[auto_1fr_160px_120px_140px_48px] gap-4 items-center px-4 py-5">

                {{-- Checkbox --}}
                <input type="checkbox" checked
                class="item-checkbox w-5 h-5 cursor-pointer flex-shrink-0 accent-[#FF6B95]"
                    onchange="updateSummary()">

                {{-- Thumbnail + Nama --}}
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-14 h-14 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0 overflow-hidden text-2xl">
                        @if($cart->item && $cart->item->image)
                        <img src="{{ str_starts_with($cart->item->image, 'http') ? $cart->item->image : asset('storage/'.$cart->item->image) }}"
                            class="w-full h-full object-cover" alt="{{ $cart->item->name }}">
                        @else
                        📦
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-gray-900 truncate">{{ $cart->item->name ?? '-' }}</p>
                        <p class="text-[11px] font-semibold text-[#FF6B95] uppercase tracking-wide mt-0.5">
                            Kategori: {{ $cart->item->category ?? '-' }}
                        </p>
                    </div>
                </div>

                {{-- Harga/hari --}}
                <div class="text-center">
                    <p class="text-sm font-bold text-gray-700">
                        Rp{{ number_format($cart->item->price ?? 0, 0, ',', '.') }}
                    </p>
                </div>

                {{-- Qty --}}
                <div class="flex items-center justify-center">
                    <div class="flex items-center border border-gray-200 rounded-xl h-8 overflow-hidden">
                        <button onclick="changeQty(this, -1)"
                            class="w-7 h-8 flex items-center justify-center text-gray-600 font-bold text-sm hover:bg-gray-100 transition">
                            −
                        </button>
                        <span class="qty-val px-2 text-sm font-bold text-gray-800 min-w-[24px] text-center">
                            {{ $cart->quantity }}
                        </span>
                        <button onclick="changeQty(this, 1)"
                            class="w-7 h-8 flex items-center justify-center text-gray-600 font-bold text-sm hover:bg-gray-100 transition">
                            +
                        </button>
                    </div>
                </div>

                {{-- Subtotal --}}
                <div class="text-right">
                    <p class="text-sm font-bold text-[#FF6B95]">
                        Rp<span class="subtotal-detail">{{ number_format($subtotal, 0, ',', '.') }}</span>
                    </p>
                </div>

                {{-- Hapus --}}
                <div class="flex justify-center">
                    <button onclick="removeItem(this)"
                        class="p-1.5 text-gray-300 hover:text-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>

            </div>

            {{-- Strip tanggal --}}
            <div class="flex items-center justify-between px-4 py-2.5 border-t border-gray-100 cursor-pointer hover:bg-gray-50 transition"
                onclick="toggleDate(this)">
                <div class="flex items-center gap-2 flex-wrap">
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2" />
                        <path stroke-width="2" d="M16 2v4M8 2v4M3 10h18" />
                    </svg>
                    <span class="text-[11px] text-gray-400 font-medium">Tanggal sewa:</span>
                    <span class="date-summary text-[11px] font-bold text-[#FF6B95]">
                        @if($cart->start_date && $cart->end_date)
                        {{ \Carbon\Carbon::parse($cart->start_date)->format('d/m/Y') }}
                        –
                        {{ \Carbon\Carbon::parse($cart->end_date)->format('d/m/Y') }}
                        @else
                        <span class="text-gray-300 font-normal">— Belum ada tanggal</span>
                        @endif
                    </span>
                    @if($cart->start_date && $cart->end_date)
                    <span class="strip-pill bg-pink-100 text-[#FF6B95] text-[10px] font-bold px-2.5 py-0.5 rounded-full">
                        {{ $days }} hari
                    </span>
                    @endif
                </div>
                <svg class="toggle-arrow w-3.5 h-3.5 text-gray-400 transition-transform flex-shrink-0"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            {{-- Panel edit tanggal (collapsible) --}}
            <div class="date-row hidden border-t border-gray-100 px-4 py-4 bg-gray-50">
                <div class="flex flex-col sm:flex-row gap-3 max-w-lg">
                    <div class="flex-1">
                        <label class="block text-[10px] font-bold uppercase text-gray-400 tracking-widest mb-1.5">Mulai</label>
                        <input type="date"
                            class="start-date w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 focus:border-[#FF6B95] focus:outline-none transition bg-white [&::-webkit-calendar-picker-indicator]:cursor-pointer [&::-webkit-calendar-picker-indicator]:opacity-60"
                            value="{{ $cart->start_date ? \Carbon\Carbon::parse($cart->start_date)->format('Y-m-d') : '' }}"
                            onchange="onDateChange(this)">
                    </div>
                    <div class="flex-1">
                        <label class="block text-[10px] font-bold uppercase text-gray-400 tracking-widest mb-1.5">Selesai</label>
                        <input type="date"
                            class="end-date w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-800 focus:border-[#FF6B95] focus:outline-none transition bg-white [&::-webkit-calendar-picker-indicator]:cursor-pointer [&::-webkit-calendar-picker-indicator]:opacity-60"
                            value="{{ $cart->end_date ? \Carbon\Carbon::parse($cart->end_date)->format('Y-m-d') : '' }}"
                            onchange="onDateChange(this)">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-3 max-w-lg flex-wrap gap-2">
                    <div class="flex items-center gap-2">
                        <span class="days-badge bg-pink-100 text-[#FF6B95] text-[11px] font-bold px-3 py-1.5 rounded-lg
                            {{ $cart->start_date && $cart->end_date ? '' : 'hidden' }}">
                            {{ $days }} hari
                        </span>
                        <span class="date-error hidden text-xs text-red-500">Tanggal tidak valid</span>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-gray-400 font-semibold mb-0.5">Subtotal</p>
                        <p class="text-sm font-bold text-gray-900">
                            Rp<span class="subtotal-detail-panel">{{ number_format($subtotal, 0, ',', '.') }}</span>
                        </p>
                    </div>
                </div>
            </div>

        </div>
        @empty
        <div class="py-20 text-center text-gray-400 italic">Keranjang kosong.</div>
        @endforelse

    </div>
</div>

{{-- Bottom bar --}}
<div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 shadow-[0_-4px_20px_rgba(0,0,0,0.06)]">
    <div class="max-w-4xl mx-auto px-4 py-3 flex items-center justify-between gap-4">

        <div class="flex items-center gap-4">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" id="selectAll" class="w-5 h-5 cursor-pointer accent-[#FF6B95]" onchange="selAllChange(this)">
                <span class="text-sm font-bold text-gray-600">
                    Pilih Semua (<span id="totalChecked">0</span>)
                </span>
            </label>
            <button onclick="removeAllChecked()"
                class="text-xs font-bold text-gray-400 hover:text-red-500 uppercase underline transition">
                Hapus
            </button>
        </div>

        <div class="flex items-center gap-4">
            <div class="text-right">
                <p class="text-xs text-gray-500 font-semibold">
                    Total Sewa (<span id="countItems">0</span> Item)
                </p>
                <p class="text-2xl font-extrabold text-[#FF6B95]" id="grandTotal">Rp0</p>
            </div>
            <button onclick="goToCheckout()"
                class="bg-[#FF6B95] hover:bg-[#ff5282] text-white
                       px-7 py-3 rounded-xl font-bold text-xs uppercase tracking-widest transition-all active:scale-95 whitespace-nowrap">
                Checkout
            </button>
        </div>

    </div>
</div>

<script>
    const today = new Date().toISOString().split('T')[0];

    function getDays(card) {
        const s = card.querySelector('.start-date')?.value;
        const e = card.querySelector('.end-date')?.value;
        if (!s || !e) return 1;
        const diff = Math.round((new Date(e) - new Date(s)) / 86400000);
        return diff > 0 ? diff : 1;
    }

    function recalcCard(card) {
        const price = parseInt(card.dataset.price) || 0;
        const qty = parseInt(card.querySelector('.qty-val').textContent) || 1;
        const days = getDays(card);
        const subtotal = price * qty * days;
        const fmt = subtotal.toLocaleString('id-ID');
        card.querySelector('.subtotal-detail').textContent = fmt;
        const panel = card.querySelector('.subtotal-detail-panel');
        if (panel) panel.textContent = fmt;
    }

    function updateSummary() {
        let total = 0,
            count = 0;
        document.querySelectorAll('.card-item').forEach(card => {
            const cb = card.querySelector('.item-checkbox');
            if (cb && cb.checked) {
                const price = parseInt(card.dataset.price) || 0;
                const qty = parseInt(card.querySelector('.qty-val')?.textContent) || 1;
                const days = getDays(card);
                total += price * qty * days;
                count++;
            }
        });
        document.getElementById('grandTotal').textContent = 'Rp' + total.toLocaleString('id-ID');
        document.getElementById('countItems').textContent = count;
        document.getElementById('totalChecked').textContent = count;
        const all = document.querySelectorAll('.item-checkbox');
        const allCked = all.length > 0 && Array.from(all).every(c => c.checked);
        document.getElementById('selectAll').checked = allCked;
    }

    function toggleDate(strip) {
        const card = strip.closest('.card-item');
        const panel = card.querySelector('.date-row');
        const arrow = strip.querySelector('.toggle-arrow');
        panel.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }

    function onDateChange(input) {
        const card = input.closest('.card-item');
        const sEl = card.querySelector('.start-date');
        const eEl = card.querySelector('.end-date');
        const badge = card.querySelector('.days-badge');
        const errEl = card.querySelector('.date-error');
        const dsum = card.querySelector('.date-summary');
        const s = sEl.value;
        const e = eEl.value;

        badge.classList.add('hidden');
        errEl.classList.add('hidden');
        if (s) eEl.min = s;
        if (!s || !e) {
            recalcCard(card);
            updateSummary();
            return;
        }

        const diff = Math.round((new Date(e) - new Date(s)) / 86400000);
        if (diff <= 0) {
            errEl.classList.remove('hidden');
            recalcCard(card);
            updateSummary();
            return;
        }

        badge.textContent = diff + ' hari';
        badge.classList.remove('hidden');

        const fmt = d => {
            const [y, m, dy] = d.split('-');
            return `${dy}/${m}/${y}`;
        };
        dsum.textContent = `${fmt(s)} – ${fmt(e)}`;

        let stripPill = card.querySelector('.strip-pill');
        if (!stripPill) {
            stripPill = document.createElement('span');
            stripPill.className = 'strip-pill bg-pink-100 text-[#FF6B95] text-[10px] font-bold px-2.5 py-0.5 rounded-full';
            dsum.insertAdjacentElement('afterend', stripPill);
        }
        stripPill.textContent = diff + ' hari';

        recalcCard(card);

        // Update tanggal atau qty — ganti X-HTTP-Method-Override jadi PUT biasa
        fetch(`/cart/${card.dataset.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                start_date: s,
                end_date: e
            })
        }).catch(() => showToast('Gagal menyimpan tanggal'));

        // Bulk delete — ganti ke route baru
        fetch('/cart/bulk-delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                ids
            })
        })

        updateSummary();
    }

    function changeQty(btn, delta) {
        const card = btn.closest('.card-item');
        const span = card.querySelector('.qty-val');
        let val = parseInt(span.textContent) + delta;
        if (val < 1) val = 1;
        span.textContent = val;
        recalcCard(card);

        fetch(`/cart/${card.dataset.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                quantity: val
            })
        }).catch(() => showToast('Gagal menyimpan jumlah'));

        updateSummary();
    }

    function removeItem(btn) {
        if (!confirm('Hapus item ini?')) return;
        const card = btn.closest('.card-item');
        fetch(`/cart/${card.dataset.id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    card.remove();
                    updateSummary();
                    checkEmpty();
                }
            })
            .catch(() => showToast('Gagal menghapus item'));
    }

    function removeAllChecked() {
        const checked = document.querySelectorAll('.item-checkbox:checked');
        if (!checked.length) return;
        if (!confirm(`Hapus ${checked.length} item?`)) return;
        const ids = Array.from(checked).map(cb => cb.closest('.card-item').dataset.id);
        fetch('/cart/bulk-delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    ids
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    checked.forEach(cb => cb.closest('.card-item').remove());
                    updateSummary();
                    checkEmpty();
                }
            })
            .catch(() => showToast('Gagal menghapus item'));
    }

    function selAllChange(src) {
        document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = src.checked);
        updateSummary();
    }

    function checkEmpty() {
        const container = document.getElementById('cartContainer');
        if (!container.querySelector('.card-item')) {
            container.innerHTML = '<div class="py-20 text-center text-gray-400 italic">Keranjang kosong.</div>';
        }
    }

    function goToCheckout() {
        const checked = document.querySelectorAll('.item-checkbox:checked');
        if (!checked.length) {
            alert('Pilih barang dulu!');
            return;
        }
        const params = Array.from(checked).map(cb => `ids[]=${cb.closest('.card-item').dataset.id}`).join('&');
        window.location.href = `/checkout?${params}`;
    }

    function showToast(msg) {
        const t = document.createElement('div');
        t.textContent = msg;
        t.className = 'fixed bottom-24 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-4 py-2 rounded-xl z-[999] opacity-0 transition-opacity duration-300';
        document.body.appendChild(t);
        setTimeout(() => t.style.opacity = '1', 10);
        setTimeout(() => {
            t.style.opacity = '0';
            setTimeout(() => t.remove(), 300);
        }, 2500);
    }

    window.addEventListener('load', () => {
        document.querySelectorAll('.start-date').forEach(el => el.min = today);
        document.querySelectorAll('.card-item').forEach(card => {
            const s = card.querySelector('.start-date')?.value;
            const eEl = card.querySelector('.end-date');
            if (s && eEl) eEl.min = s;
            recalcCard(card);
        });
        updateSummary();
    });
</script>

@endsection