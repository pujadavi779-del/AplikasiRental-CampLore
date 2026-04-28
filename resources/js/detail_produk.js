
    // ── State ──────────────────────────────────────────────
    let thumbOffset = 0;
    let qty = 1;
    const PRICE_PER_DAY = {{ $item->price_per_day }};
    const MAX_STOCK = {{ $item->stock ?? 99 }};

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

    // ── Date helpers (FIXED) ────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date().toISOString().split('T')[0];
        const start = document.getElementById('startDate');
        const end = document.getElementById('endDate');

        if (start) start.min = today;
        if (end) end.min = today;

        updatePrice();
    });

    function getDays() {
        const s = document.getElementById('startDate').value;
        const e = document.getElementById('endDate').value;
        if (!s || !e) return 0;
        const diff = Math.round((new Date(e) - new Date(s)) / 86400000);
        return diff > 0 ? diff : 0;
    }

    function onStartChange() {
        const s = document.getElementById('startDate').value;
        const end = document.getElementById('endDate');
        end.min = s;
        if (end.value && end.value <= s) end.value = '';
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

    // ── Add to Cart (FIXED) ─────────────────────────────────
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
