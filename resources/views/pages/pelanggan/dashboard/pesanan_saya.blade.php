@extends('layouts.pelanggan')

@section('title', 'Sewa Saya - Camplore')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; }

    :root {
        --green: #1a5c3a;
        --green-light: #eef5f0;
        --green-mid: #2d7a52;
        --pink: #e8567a;
        --gray-bg: #f5f6f4;
        --card-bg: #ffffff;
        --text-main: #1a1a1a;
        --text-muted: #6b7280;
        --text-light: #9ca3af;
        --border: #e5e7eb;
        --radius: 18px;
    }

    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--gray-bg); }

    /* ── LAYOUT ── */
    .sewa-layout {
        display: flex;
        max-width: 1100px;
        margin: 0 auto;
        padding: 32px 16px;
        gap: 24px;
    }

    /* ── SIDEBAR ── */
    .sewa-sidebar { width: 240px; flex-shrink: 0; }

    .sidebar-profile {
        background: #fff;
        border-radius: var(--radius);
        border: 1.5px solid var(--border);
        padding: 24px 20px;
        text-align: center;
        margin-bottom: 14px;
    }
    .s-avatar {
        width: 72px; height: 72px;
        border-radius: 50%;
        background: var(--green-light);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 12px;
        position: relative;
    }
    .s-avatar svg { width: 32px; height: 32px; color: var(--green); }
    .s-avatar-dot {
        position: absolute; bottom: 4px; right: 4px;
        width: 12px; height: 12px;
        background: var(--pink); border-radius: 50%; border: 2px solid #fff;
    }
    .s-name { font-size: 15px; font-weight: 800; color: var(--text-main); }
    .s-email { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

    .sidebar-menu {
        background: #fff;
        border-radius: var(--radius);
        border: 1.5px solid var(--border);
        overflow: hidden;
    }
    .menu-label {
        font-size: 10px; font-weight: 700; color: var(--text-light);
        letter-spacing: 1px; padding: 14px 16px 6px;
    }
    .menu-item {
        display: flex; align-items: center; gap: 10px;
        padding: 11px 16px;
        font-size: 13px; font-weight: 600;
        color: var(--text-muted);
        text-decoration: none;
        transition: all .2s;
    }
    .menu-item:hover { color: var(--green); background: var(--green-light); }
    .menu-item.active { color: var(--green); background: var(--green-light); }
    .menu-item svg { width: 16px; height: 16px; flex-shrink: 0; }
    .menu-item .menu-arrow { margin-left: auto; width: 14px; height: 14px; }
    .menu-divider { height: 1px; background: var(--border); margin: 4px 0; }
    .menu-logout { color: #ef4444 !important; }
    .menu-logout:hover { background: #fff5f5 !important; color: #dc2626 !important; }

    /* ── MAIN ── */
    .sewa-main { flex: 1; min-width: 0; }

    .page-title { font-size: 26px; font-weight: 900; color: var(--green); letter-spacing: -0.5px; }
    .page-subtitle { font-size: 13px; color: var(--text-muted); margin-top: 4px; }

    /* ── FILTER PILLS ── */
    .filter-pills { display: flex; flex-wrap: wrap; gap: 8px; margin: 18px 0 22px; }
    .pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 16px;
        border-radius: 100px;
        border: 1.5px solid var(--border);
        font-size: 12px; font-weight: 700;
        color: var(--text-muted);
        background: #fff;
        text-decoration: none;
        transition: all .2s;
    }
    .pill:hover { border-color: var(--green); color: var(--green); }
    .pill.active { background: var(--green); border-color: var(--green); color: #fff; }
    .pill-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; opacity: 0.65; }

    /* ── RENTAL CARD ── */
    .rental-card {
        background: #fff;
        border-radius: var(--radius);
        border: 1.5px solid var(--border);
        margin-bottom: 14px;
        overflow: hidden;
        transition: box-shadow .25s, transform .25s;
        animation: fadeUp .4s ease both;
    }
    .rental-card:hover {
        box-shadow: 0 8px 32px rgba(26,92,58,0.12);
        transform: translateY(-2px);
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Card Header */
    .card-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 16px 10px;
        border-bottom: 1px solid var(--border);
    }
    .seller-info { display: flex; align-items: center; gap: 8px; }
    .seller-icon {
        width: 28px; height: 28px;
        background: var(--green-light); border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
    }
    .seller-icon svg { width: 14px; height: 14px; color: var(--green); }
    .seller-name { font-size: 13px; font-weight: 700; color: var(--text-main); }

    /* Status Badges */
    .badge {
        padding: 4px 12px; border-radius: 100px;
        font-size: 11px; font-weight: 700;
    }
    .badge-belum_bayar  { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }
    .badge-dikemas      { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-dikirim      { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .badge-selesai      { background: #f0fdf4; color: #166534; border: 1px solid #86efac; }
    .badge-dibatalkan   { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
    .badge-pengembalian { background: #faf5ff; color: #7e22ce; border: 1px solid #e9d5ff; }
    .badge-default      { background: #f3f4f6; color: #6b7280; border: 1px solid #e5e7eb; }

    /* Card Body */
    .card-body { padding: 14px 16px; }
    .product-row { display: flex; gap: 14px; align-items: flex-start; }
    .product-thumb {
        width: 76px; height: 76px; border-radius: 12px;
        border: 1.5px solid var(--border);
        overflow: hidden; flex-shrink: 0;
        background: var(--green-light);
        display: flex; align-items: center; justify-content: center;
    }
    .product-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .product-thumb svg { width: 28px; height: 28px; color: var(--green); opacity: 0.4; }
    .product-name { font-size: 15px; font-weight: 800; color: var(--text-main); }
    .product-meta { font-size: 12px; color: var(--text-muted); margin-top: 3px; }
    .product-price { font-size: 16px; font-weight: 800; color: var(--green); margin-top: 6px; }
    .product-qty { font-size: 11px; color: var(--text-light); margin-top: 2px; }

    /* Timer Bar */
    .timer-bar {
        margin: 12px 0 0;
        background: #fff7ed;
        border-radius: 10px;
        padding: 9px 14px;
        display: flex; align-items: center; gap: 8px;
        border: 1px solid #fed7aa;
    }
    .timer-bar svg { width: 15px; height: 15px; color: #c2410c; flex-shrink: 0; }
    .timer-text { font-size: 12px; font-weight: 700; color: #c2410c; }
    .timer-countdown {
        margin-left: auto;
        font-size: 14px; font-weight: 800; color: #c2410c;
        font-variant-numeric: tabular-nums;
    }

    .order-num { font-size: 11px; color: var(--text-light); margin-top: 10px; }

    /* Progress Bar */
    .prog-wrap { margin-top: 14px; }
    .prog-row { display: flex; align-items: center; }
    .prog-dot { width: 13px; height: 13px; border-radius: 50%; background: var(--green); flex-shrink: 0; }
    .prog-dot.off { background: var(--border); }
    .prog-line { flex: 1; height: 3px; background: var(--green); }
    .prog-line.off { background: var(--border); }
    .prog-labels { display: flex; margin-top: 6px; }
    .prog-lbl { flex: 1; text-align: center; font-size: 10px; font-weight: 600; color: var(--text-light); }
    .prog-lbl.on { color: var(--green); font-weight: 700; }

    /* Card Footer */
    .card-footer {
        border-top: 1px solid var(--border);
        padding: 12px 16px;
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
    }
    .total-label { font-size: 13px; color: var(--text-muted); font-weight: 500; }
    .total-price { font-size: 16px; font-weight: 900; color: var(--text-main); margin-top: 1px; }
    .card-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; justify-content: flex-end; }

    .btn {
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 12px; font-weight: 700;
        cursor: pointer; border: none;
        transition: all .2s;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 5px;
    }
    .btn-outline {
        background: #fff; border: 1.5px solid var(--border); color: var(--text-main);
    }
    .btn-outline:hover { border-color: var(--green); color: var(--green); }
    .btn-primary { background: var(--green); color: #fff; }
    .btn-primary:hover { background: var(--green-mid); }
    .btn-pink { background: var(--pink); color: #fff; }
    .btn-pink:hover { background: #d4466a; }

    /* Flash */
    .flash-success {
        display: flex; align-items: center; gap: 10px;
        background: #f0fdf4; border: 1px solid #bbf7d0;
        color: #166534; padding: 12px 16px;
        border-radius: 14px; font-size: 13px; font-weight: 600;
        margin-bottom: 18px;
    }
    .flash-success svg { width: 18px; height: 18px; flex-shrink: 0; }
    .flash-close {
        margin-left: auto; background: none; border: none;
        cursor: pointer; color: #166534; font-size: 15px; line-height: 1;
    }

    /* Empty State */
    .empty-state {
        background: #fff;
        border-radius: var(--radius);
        border: 1.5px solid var(--border);
        padding: 64px 32px;
        text-align: center;
    }
    .empty-icon {
        width: 88px; height: 88px;
        background: var(--green-light); border-radius: 22px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
    }
    .empty-icon svg { width: 40px; height: 40px; color: var(--green); opacity: 0.3; }
    .empty-title { font-size: 20px; font-weight: 900; color: var(--green); margin-bottom: 8px; }
    .empty-cta {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--green); color: #fff;
        padding: 12px 28px; border-radius: 100px;
        font-weight: 700; font-size: 13px;
        text-decoration: none; margin-top: 4px;
        box-shadow: 0 4px 14px rgba(26,92,58,0.25);
        transition: all .2s;
    }
    .empty-cta:hover { background: var(--pink); box-shadow: 0 4px 14px rgba(232,86,122,0.3); }
    .empty-cta svg { width: 16px; height: 16px; }

    /* Responsive */
    @media (max-width: 700px) {
        .sewa-sidebar { display: none; }
        .sewa-layout { padding: 16px 12px; }
    }
</style>
@endpush

@section('content')

<div class="sewa-layout">

    {{-- ══════════════ MAIN CONTENT ══════════════ --}}
    <main class="sewa-main">

        {{-- Flash Message --}}
        @if(session('success'))
        <div class="flash-success" id="flash-msg">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
            <button class="flash-close" onclick="document.getElementById('flash-msg').remove()">✕</button>
        </div>
        @endif

        {{-- Page Heading --}}
        <div class="page-title">Sewa Saya</div>
        <div class="page-subtitle">Tinjau semua transaksi penyewaan Anda berdasarkan statusnya.</div>

        {{-- Filter Pills --}}
        @php
            $activeStatus = request('status', 'semua');
            $filters = [
                ['label' => 'Semua',        'value' => 'semua'],
                ['label' => 'Belum Bayar',  'value' => 'belum_bayar'],
                ['label' => 'Dikemas',      'value' => 'dikemas'],
                ['label' => 'Dikirim',      'value' => 'dikirim'],
                ['label' => 'Selesai',      'value' => 'selesai'],
                ['label' => 'Pengembalian', 'value' => 'pengembalian'],
                ['label' => 'Dibatalkan',   'value' => 'dibatalkan'],
            ];
        @endphp
        <div class="filter-pills">
            @foreach($filters as $f)
            <a href="?status={{ $f['value'] }}"
               class="pill {{ $activeStatus === $f['value'] ? 'active' : '' }}">
                <span class="pill-dot"></span>
                {{ $f['label'] }}
            </a>
            @endforeach
        </div>

        {{-- Rental List --}}
@php
$rentals = [
    (object)[
        'id'               => 1,
        'order_number'     => 'CPL-20260430-001',
        'status'           => 'belum_bayar',
        'total_price'      => 450000,
        'quantity'         => 1,
        'duration'         => 3,
        'start_date'       => '2026-04-30',
        'end_date'         => '2026-05-02',
        'payment_deadline' => now()->addHours(23)->addMinutes(47),
        'product'          => (object)[
            'name'  => 'Sony A7 III Body Only',
            'image' => null,
        ],
    ],
    (object)[
        'id'               => 2,
        'order_number'     => 'CPL-20260428-002',
        'status'           => 'dikirim',
        'total_price'      => 300000,
        'quantity'         => 1,
        'duration'         => 2,
        'start_date'       => '2026-04-28',
        'end_date'         => '2026-04-29',
        'payment_deadline' => null,
        'product'          => (object)[
            'name'  => 'DJI Ronin-S Gimbal Stabilizer',
            'image' => null,
        ],
    ],
    (object)[
        'id'               => 3,
        'order_number'     => 'CPL-20260425-003',
        'status'           => 'selesai',
        'total_price'      => 100000,
        'quantity'         => 1,
        'duration'         => 1,
        'start_date'       => '2026-04-25',
        'end_date'         => '2026-04-25',
        'payment_deadline' => null,
        'product'          => (object)[
            'name'  => 'Rode VideoMic Pro+',
            'image' => null,
        ],
    ],
    (object)[
        'id'               => 4,
        'order_number'     => 'CPL-20260420-004',
        'status'           => 'dikemas',
        'total_price'      => 200000,
        'quantity'         => 2,
        'duration'         => 2,
        'start_date'       => '2026-04-22',
        'end_date'         => '2026-04-23',
        'payment_deadline' => null,
        'product'          => (object)[
            'name'  => 'Zhiyun Crane 3S',
            'image' => null,
        ],
    ],
    (object)[
        'id'               => 5,
        'order_number'     => 'CPL-20260415-005',
        'status'           => 'dibatalkan',
        'total_price'      => 150000,
        'quantity'         => 1,
        'duration'         => 1,
        'start_date'       => '2026-04-15',
        'end_date'         => '2026-04-15',
        'payment_deadline' => null,
        'product'          => (object)[
            'name'  => 'Canon EF 50mm f/1.8',
            'image' => null,
        ],
    ],
    (object)[
        'id'               => 6,
        'order_number'     => 'CPL-20260410-006',
        'status'           => 'pengembalian',
        'total_price'      => 250000,
        'quantity'         => 1,
        'duration'         => 2,
        'start_date'       => '2026-04-10',
        'end_date'         => '2026-04-11',
        'payment_deadline' => null,
        'product'          => (object)[
            'name'  => 'GoPro Hero 11',
            'image' => null,
        ],
    ],
];

// FILTER BERDASARKAN TAB
if ($activeStatus !== 'semua') {
    $rentals = array_filter($rentals, function ($r) use ($activeStatus) {
        return $r->status === $activeStatus;
    });
}
@endphp

@forelse($rentals as $index => $rental)

@php
    $status = strtolower($rental->status);

    $badgeMap = [
        'belum_bayar'  => ['class' => 'badge-belum_bayar',  'label' => 'Belum Bayar'],
        'dikemas'      => ['class' => 'badge-dikemas',      'label' => 'Dikemas'],
        'dikirim'      => ['class' => 'badge-dikirim',      'label' => 'Dikirim'],
        'selesai'      => ['class' => 'badge-selesai',      'label' => 'Selesai'],
        'dibatalkan'   => ['class' => 'badge-dibatalkan',   'label' => 'Dibatalkan'],
        'pengembalian' => ['class' => 'badge-pengembalian', 'label' => 'Pengembalian'],
    ];

    $badge = $badgeMap[$status] ?? ['class' => 'badge-default', 'label' => ucfirst($status)];

    $stepIndex = match($status) {
        'belum_bayar' => 0,
        'dikemas' => 1,
        'dikirim' => 2,
        'selesai' => 3,
        default => 0,
    };

    $showProgress = in_array($status, ['dikemas','dikirim','selesai','pengembalian']);
@endphp

<div class="rental-card" style="animation-delay: {{ $index * 0.08 }}s">

    <div class="card-header">
        <div class="seller-info">
            <div class="seller-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M3 9a2 2 0 012-2h14a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                </svg>
            </div>
            <div class="seller-name">Camplore Official</div>
        </div>
        <span class="badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
    </div>

    <div class="card-body">

        {{-- 🔥 KHUSUS PENGEMBALIAN --}}
        @if($status === 'pengembalian')

        @php
            $lateDays = 3; // dummy
            $fine = 150000; // dummy
        @endphp

        <div class="product-row">
            <div class="product-thumb">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="12" cy="13" r="3"/>
                </svg>
            </div>

            <div style="flex:1">
                <div class="product-name">{{ $rental->product->name }}</div>
                <div class="product-meta">No. {{ $rental->order_number }}</div>
            </div>

            <span class="badge badge-dibatalkan">Overdue</span>
        </div>

        <div style="display:flex; gap:10px; margin-top:12px;">
            <div style="flex:1; background:#f3f4f6; padding:10px; border-radius:10px;">
                <div style="font-size:11px;">Tanggal sewa</div>
                <b>{{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }}</b>
            </div>

            <div style="flex:1; background:#fee2e2; padding:10px; border-radius:10px;">
                <div style="font-size:11px;">Keterlambatan</div>
                <b>{{ $lateDays }} hari</b>
            </div>
        </div>

        <div style="margin-top:12px; border:1px solid #fecaca; padding:12px; border-radius:10px; display:flex; justify-content:space-between; align-items:center;">
            <div>
                <div style="font-size:12px;">Total denda</div>
                <div style="font-weight:800; color:#b91c1c">
                    Rp {{ number_format($fine,0,',','.') }}
                </div>
            </div>

            <div style="display:flex; gap:8px;">
                <button class="btn btn-outline">Detail</button>
                <button class="btn btn-primary">Bayar</button>
            </div>
        </div>

        {{-- 🔥 DEFAULT (TIDAK DIUBAH) --}}
        @else

        <div class="product-row">
            <div class="product-thumb">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="12" cy="13" r="3"/>
                </svg>
            </div>

            <div>
                <div class="product-name">{{ $rental->product->name }}</div>
                <div class="product-meta">
                    Sewa {{ $rental->duration }} hari •
                    {{ \Carbon\Carbon::parse($rental->start_date)->format('d M') }} -
                    {{ \Carbon\Carbon::parse($rental->end_date)->format('d M') }}
                </div>
                <div class="product-price">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</div>
                <div class="product-qty">{{ $rental->quantity }} item</div>
            </div>
        </div>

        @if($status === 'belum_bayar' && $rental->payment_deadline)
        <div class="timer-bar">
            <span class="timer-text">Bayar dalam</span>
            <span class="timer-countdown"
                  data-deadline="{{ \Carbon\Carbon::parse($rental->payment_deadline)->timestamp }}">
                00:30:45
            </span>
        </div>
        @endif

        <div class="order-num">No. pemesanan: {{ $rental->order_number }}</div>

        @if($showProgress)
        <div class="prog-wrap">
            <div class="prog-row">
                <div class="prog-dot {{ $stepIndex >= 0 ? '' : 'off' }}"></div>
                <div class="prog-line {{ $stepIndex >= 1 ? '' : 'off' }}"></div>
                <div class="prog-dot {{ $stepIndex >= 1 ? '' : 'off' }}"></div>
                <div class="prog-line {{ $stepIndex >= 2 ? '' : 'off' }}"></div>
                <div class="prog-dot {{ $stepIndex >= 2 ? '' : 'off' }}"></div>
                <div class="prog-line {{ $stepIndex >= 3 ? '' : 'off' }}"></div>
                <div class="prog-dot {{ $stepIndex >= 3 ? '' : 'off' }}"></div>
            </div>
        </div>
        @endif

        @endif
    </div>

    <div class="card-footer">
        <div>
            <div class="total-label">Total sewa:</div>
            <div class="total-price">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</div>
        </div>

        <div class="card-actions">
            <a href="#" class="btn btn-outline">Detail</a>

            @if($status === 'belum_bayar')
                <button class="btn btn-outline">Batalkan</button>
                <a href="#" class="btn btn-primary">Bayar Sekarang</a>
            @endif

            @if($status === 'dikirim')
                <a href="#" class="btn btn-outline">Hubungi Penjual</a>
            @endif

            @if($status === 'selesai')
                <a href="#" class="btn btn-pink">Sewa Lagi</a>
            @endif
        </div>
    </div>
</div>

@empty
<div class="empty-state">
    <div class="empty-title">Tidak ada data</div>
</div>
@endforelse



        {{-- Pagination (aktifkan saat pakai database) --}}
        {{-- @if(isset($rentals) && method_exists($rentals, 'hasPages') && $rentals->hasPages())
        <div style="margin-top: 24px;">{{ $rentals->withQueryString()->links() }}</div>
        @endif --}}

    </main>
</div>

@endsection

@push('scripts')
<script>
    // Auto-hide flash message
    setTimeout(() => {
        const el = document.getElementById('flash-msg');
        if (el) {
            el.style.transition = 'opacity 0.4s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 400);
        }
    }, 4000);

    // Countdown timers
    function updateCountdowns() {
        document.querySelectorAll('.timer-countdown[data-deadline]').forEach(el => {
            const deadline = parseInt(el.dataset.deadline) * 1000;
            const now = Date.now();
            const diff = Math.max(0, Math.floor((deadline - now) / 1000));

            if (diff <= 0) {
                el.textContent = '00:00:00';
                return;
            }
            const h = String(Math.floor(diff / 3600)).padStart(2, '0');
            const m = String(Math.floor((diff % 3600) / 60)).padStart(2, '0');
            const s = String(diff % 60).padStart(2, '0');
            el.textContent = `${h}:${m}:${s}`;
        });
    }
    updateCountdowns();
    setInterval(updateCountdowns, 1000);
</script>
@endpush