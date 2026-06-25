// ── Config dari blade (via data attributes) ──────────────────
const _cfg = document.getElementById('app-config')?.dataset ?? {};
const isLoggedIn   = _cfg.loggedIn === '1';
const PRICE_PER_DAY = parseFloat(_cfg.price ?? 0);
const MAX_STOCK     = parseInt(_cfg.stock ?? 0);
const CSRF_TOKEN    = _cfg.csrf ?? '';
const LOGIN_URL     = _cfg.loginUrl ?? '/login';

let qty = 1;

// ── Qty ──────────────────────────────────────────────────────
function syncQty() {
    ['qtyDisplay', 'qtyDisplay2'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.textContent = qty;
    });
}

function changeQty(d) {
    if (MAX_STOCK === 0) { showToast('Produk ini sedang habis stok', 'error'); return; }
    const next = qty + d;
    if (next < 1) return;
    if (next > MAX_STOCK) { showToast(`Stok tersedia hanya ${MAX_STOCK} unit`, 'error'); return; }
    qty = next;
    syncQty();
    updatePrice();
}

// ── Accordion ────────────────────────────────────────────────
function toggleAcc(button) {
    const deskripsi = button.nextElementSibling;
    const icon      = button.querySelector('.acc-icon');
    const open      = deskripsi.style.maxHeight && deskripsi.style.maxHeight !== '0px';
    deskripsi.style.maxHeight = open ? '0px' : deskripsi.scrollHeight + 'px';
    icon.classList.toggle('rotate-180', !open);
}

// ── Tanggal ──────────────────────────────────────────────────
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

function onDateChange()  { handleDateChange(''); }
function onDateChangeM() { handleDateChange('M'); }

function handleDateChange(sfx) {
    const s     = document.getElementById('startDate' + sfx)?.value;
    const e     = document.getElementById('endDate'   + sfx)?.value;
    const err   = document.getElementById('dateError'    + sfx);
    const badge = document.getElementById('durationBadge' + sfx);
    const text  = document.getElementById('durationText'  + sfx);

    if (err)   err.classList.add('hidden');
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

function fmtRp(n) { return 'Rp ' + Math.round(n).toLocaleString('id-ID'); }

function getDays(sfx = '') {
    const s = document.getElementById('startDate' + sfx)?.value;
    const e = document.getElementById('endDate'   + sfx)?.value;
    if (!s || !e) return 0;
    const d = Math.round((new Date(e) - new Date(s)) / 86400000);
    return d > 0 ? d : 0;
}

function updatePrice() {
    const days = getDays('') || getDays('M');
    const txt  = days > 0
        ? `Total ${days} hari × ${qty} unit = ${fmtRp(PRICE_PER_DAY * days * qty)}`
        : (qty > 1 ? `${qty} unit dipilih` : '');
    ['totalPriceNote', 'totalPriceNoteMobile'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.textContent = txt;
    });
}

// ── Toast ────────────────────────────────────────────────────
function showToast(msg, type = 'success') {
    const t = document.getElementById('toast');
    if (!t) return;
    t.textContent = msg;
    t.style.background = type === 'error' ? '#e53e3e' : '#1a1a1a';
    t.classList.remove('opacity-0', 'pointer-events-none');
    t.classList.add('opacity-100');
    setTimeout(() => {
        t.classList.remove('opacity-100');
        t.classList.add('opacity-0', 'pointer-events-none');
    }, 2500);
}

// ── Form Data ────────────────────────────────────────────────
function getFormData() {
    return {
        startDate: document.getElementById('startDate')?.value  || document.getElementById('startDateM')?.value,
        endDate:   document.getElementById('endDate')?.value    || document.getElementById('endDateM')?.value,
    };
}

// ── Add to Cart ──────────────────────────────────────────────
function addToCart(itemId) {
    if (!isLoggedIn) { window.location.href = LOGIN_URL; return; }
    if (MAX_STOCK === 0) { showToast('Produk ini sedang habis stok', 'error'); return; }

    const { startDate, endDate } = getFormData();
    if (!startDate || !endDate) {
        showToast('Pilih tanggal penyewaan terlebih dahulu', 'error');
        return;
    }

    const btns = ['addToCartBtnD'].map(id => document.getElementById(id)).filter(Boolean);
    btns.forEach(b => { b.disabled = true; b.textContent = 'Menambahkan...'; });

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN
        },
        body: JSON.stringify({ product_id: itemId, quantity: qty, start_date: startDate, end_date: endDate })
    })
    .then(r => {
        if (r.status === 401) { window.location.href = LOGIN_URL; return null; }
        return r.json();
    })
    .then(data => {
        if (!data) return;
        if (data.success) {
            showToast('Berhasil ditambahkan ke keranjang ✓');
            const badge = document.getElementById('cart-badge');
            if (badge) badge.textContent = data.total;
        } else {
            showToast(data.message ?? 'Gagal menambahkan', 'error');
        }
    })
    .catch(() => showToast('Terjadi kesalahan, coba lagi', 'error'))
    .finally(() => btns.forEach(b => {
        b.disabled = false;
        b.textContent = 'Tambahkan ke Keranjang';
    }));
}

// ── Rent Now ─────────────────────────────────────────────────
function rentNow(idBarang) {
    if (!isLoggedIn) { window.location.href = LOGIN_URL; return; }
    if (MAX_STOCK === 0) { showToast('Produk ini sedang habis stok', 'error'); return; }

    const { startDate, endDate } = getFormData();
    if (!startDate || !endDate) {
        showToast('Pilih tanggal penyewaan terlebih dahulu', 'error');
        return;
    }

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ product_id: idBarang, quantity: qty, start_date: startDate, end_date: endDate })
    })
    .then(r => {
        if (r.status === 401) { window.location.href = LOGIN_URL; return null; }
        return r.json();
    })
    .then(data => {
        if (!data) return;
        if (data.success && data.cart_id) {
            window.location.href = '/checkout?ids[]=' + data.cart_id;
        } else {
            showToast('Gagal: ' + (data.message || 'Terjadi kesalahan'), 'error');
        }
    })
    .catch(() => showToast('Terjadi kesalahan koneksi ke server.', 'error'));
}

// ── Bintang Ulasan ───────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    window.scrollTo({ top: 0, behavior: 'instant' });

    const ratingInput = document.getElementById('rating-input-detail');
    const starButtons = document.querySelectorAll('.star-btn-detail');
    const labelReview = document.getElementById('rating-label-detail');
    const labels = { 1: 'Buruk', 2: 'Cukup', 3: 'Bagus', 4: 'Sangat Bagus', 5: 'Sempurna 🎉' };

    starButtons.forEach(button => {
        button.addEventListener('click', () => {
            const value = parseInt(button.getAttribute('data-value'));
            if (ratingInput) ratingInput.value = value;
            if (labelReview) labelReview.textContent = labels[value];

            starButtons.forEach(btn => {
                const btnValue = parseInt(btn.getAttribute('data-value'));
                const icon     = btn.querySelector('.star-icon-detail');
                if (btnValue <= value) {
                    icon.setAttribute('fill',   '#f59e0b');
                    icon.setAttribute('stroke', '#f59e0b');
                } else {
                    icon.setAttribute('fill',   '#e5e7eb');
                    icon.setAttribute('stroke', '#d1d5db');
                }
            });
        });
    });
});

// expose ke global supaya onclick di HTML bisa akses
window.changeQty   = changeQty;
window.toggleAcc   = toggleAcc;
window.onStartChange  = onStartChange;
window.onStartChangeM = onStartChangeM;
window.onDateChange   = onDateChange;
window.onDateChangeM  = onDateChangeM;
window.addToCart   = addToCart;
window.rentNow     = rentNow;