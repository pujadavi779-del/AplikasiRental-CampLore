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
        --text-main: #1a1a1a;
        --text-muted: #6b7280;
        --text-light: #9ca3af;
        --border: #e5e7eb;
        --radius: 18px;
    }

    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--gray-bg); }

    .sewa-layout {
        display: flex;
        max-width: 1100px;
        margin: 0 auto;
        padding: 32px 16px;
        gap: 24px;
    }

    /* ── MAIN ── */
    .sewa-main { flex: 1; min-width: 0; }
    .page-title    { font-size: 26px; font-weight: 900; color: var(--green); letter-spacing: -0.5px; }
    .page-subtitle { font-size: 13px; color: var(--text-muted); margin-top: 4px; }

    /* ── FILTER PILLS ── */
    .filter-pills { display: flex; flex-wrap: wrap; gap: 8px; margin: 18px 0 22px; }
    .pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 16px; border-radius: 100px;
        border: 1.5px solid var(--border); font-size: 12px; font-weight: 700;
        color: var(--text-muted); background: #fff; text-decoration: none; transition: all .2s;
    }
    .pill:hover  { border-color: var(--green); color: var(--green); }
    .pill.active { background: var(--green); border-color: var(--green); color: #fff; }
    .pill-dot    { width: 6px; height: 6px; border-radius: 50%; background: currentColor; opacity: 0.65; }

    /* ── RENTAL CARD ── */
    .rental-card {
        background: #fff; border-radius: var(--radius);
        border: 1.5px solid var(--border); margin-bottom: 14px; overflow: hidden;
        transition: box-shadow .25s, transform .25s; animation: fadeUp .4s ease both;
    }
    .rental-card:hover { box-shadow: 0 8px 32px rgba(26,92,58,0.12); transform: translateY(-2px); }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Card Header */
    .card-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 16px 10px; border-bottom: 1px solid var(--border);
    }
    .seller-info { display: flex; align-items: center; gap: 8px; }
    .seller-icon {
        width: 28px; height: 28px; background: var(--green-light); border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
    }
    .seller-icon svg  { width: 14px; height: 14px; color: var(--green); }
    .seller-name { font-size: 13px; font-weight: 700; color: var(--text-main); }

    /* Badges */
    .badge { padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 700; }
    .badge-belum_bayar  { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }
    .badge-dikemas      { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-dikirim      { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .badge-selesai      { background: #f0fdf4; color: #166534; border: 1px solid #86efac; }
    .badge-dibatalkan   { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
    .badge-pengembalian { background: #faf5ff; color: #7e22ce; border: 1px solid #e9d5ff; }
    .badge-overdue      { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .badge-default      { background: #f3f4f6; color: #6b7280; border: 1px solid #e5e7eb; }

    /* Card Body */
    .card-body { padding: 14px 16px; }

    /* ── MULTI-PRODUCT LIST ── */
    .product-list { display: flex; flex-direction: column; }
    .product-row {
        display: flex; gap: 14px; align-items: flex-start;
        padding: 10px 0; border-bottom: 1px solid var(--border);
    }
    .product-row:first-child { padding-top: 0; }
    .product-row:last-child  { border-bottom: none; padding-bottom: 0; }
    .product-thumb {
        width: 68px; height: 68px; border-radius: 12px;
        border: 1.5px solid var(--border); overflow: hidden; flex-shrink: 0;
        background: var(--green-light); display: flex; align-items: center; justify-content: center;
    }
    .product-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .product-thumb svg { width: 26px; height: 26px; color: var(--green); opacity: 0.4; }
    .product-info { flex: 1; min-width: 0; }
    .product-name-row { display: flex; align-items: center; gap: 8px; margin-bottom: 0; }
    .product-name {
        font-size: 14px; font-weight: 800; color: var(--text-main);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .product-meta { font-size: 12px; color: var(--text-muted); margin-top: 3px; }
    .product-price-row { display: flex; align-items: center; gap: 8px; margin-top: 5px; }
    .product-price { font-size: 14px; font-weight: 800; color: var(--green); }
    .qty-tag {
        display: inline-flex; align-items: center;
        background: var(--green-light); color: var(--green);
        border-radius: 6px; padding: 2px 8px; font-size: 11px; font-weight: 700;
    }

    /* Show-more */
    .show-more-btn {
        display: flex; align-items: center; gap: 6px;
        width: 100%; padding: 9px 0 2px;
        background: none; border: none; cursor: pointer;
        font-size: 12px; font-weight: 700; color: var(--green);
        font-family: 'Plus Jakarta Sans', sans-serif; text-align: left; transition: opacity .2s;
    }
    .show-more-btn:hover { opacity: 0.75; }
    .show-more-btn svg   { width: 14px; height: 14px; transition: transform .25s; flex-shrink: 0; }
    .show-more-btn.open svg { transform: rotate(180deg); }

    /* Return reminder note */
    .return-reminder {
        margin: 12px 0 0; background: #fffbeb; border-radius: 10px;
        padding: 10px 14px; display: flex; align-items: flex-start; gap: 10px;
        border: 1px solid #fde68a;
    }
    .return-reminder svg { width: 15px; height: 15px; color: #b45309; flex-shrink: 0; margin-top: 1px; }
    .return-reminder-text { font-size: 12px; font-weight: 600; color: #92400e; line-height: 1.5; }
    .return-reminder-date { font-size: 13px; font-weight: 800; color: #b45309; }

    /* Timer */
    .timer-bar {
        margin: 12px 0 0; background: #fff7ed; border-radius: 10px;
        padding: 9px 14px; display: flex; align-items: center; gap: 8px; border: 1px solid #fed7aa;
    }
    .timer-bar svg    { width: 15px; height: 15px; color: #c2410c; flex-shrink: 0; }
    .timer-text       { font-size: 12px; font-weight: 700; color: #c2410c; }
    .timer-countdown  {
        margin-left: auto; font-size: 14px; font-weight: 800;
        color: #c2410c; font-variant-numeric: tabular-nums;
    }

    /* Pengembalian info grid */
    .return-info-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 10px; margin: 14px 0 0;
    }
    .return-info-box {
        border-radius: 12px; padding: 12px 14px;
    }
    .return-info-box.neutral {
        background: var(--gray-bg); border: 1px solid var(--border);
    }
    .return-info-box.danger {
        background: #fef2f2; border: 1px solid #fecaca;
    }
    .return-info-label {
        font-size: 11px; font-weight: 600; color: var(--text-muted); margin-bottom: 4px;
    }
    .return-info-label.red { color: #dc2626; }
    .return-info-value {
        font-size: 15px; font-weight: 800; color: var(--text-main);
    }
    .return-info-value.red { color: #dc2626; }

    /* Denda row */
    .denda-row {
        display: flex; align-items: center; justify-content: space-between;
        margin: 10px 0 0; padding: 12px 14px;
        background: var(--gray-bg); border-radius: 12px; border: 1px solid var(--border);
    }
    .denda-label { font-size: 12px; color: var(--text-muted); font-weight: 500; margin-bottom: 2px; }
    .denda-value { font-size: 16px; font-weight: 900; color: #dc2626; }
    .denda-actions { display: flex; gap: 8px; align-items: center; }

    .order-num { font-size: 11px; color: var(--text-light); margin-top: 10px; }

    /* Progress */
    .prog-wrap   { margin-top: 14px; }
    .prog-row    { display: flex; align-items: center; }
    .prog-dot    { width: 13px; height: 13px; border-radius: 50%; background: var(--green); flex-shrink: 0; }
    .prog-dot.off{ background: var(--border); }
    .prog-line   { flex: 1; height: 3px; background: var(--green); }
    .prog-line.off{ background: var(--border); }
    .prog-labels { display: flex; margin-top: 6px; }
    .prog-lbl    { flex: 1; text-align: center; font-size: 10px; font-weight: 600; color: var(--text-light); }
    .prog-lbl.on { color: var(--green); font-weight: 700; }

    /* Card Footer */
    .card-footer {
        border-top: 1px solid var(--border); padding: 12px 16px;
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
    }
    .total-label { font-size: 12px; color: var(--text-muted); font-weight: 500; }
    .total-price { font-size: 17px; font-weight: 900; color: var(--text-main); margin-top: 1px; }
    .total-meta  { font-size: 11px; color: var(--text-light); margin-top: 2px; }
    .card-actions{ display: flex; gap: 8px; align-items: center; flex-wrap: wrap; justify-content: flex-end; }

    .btn {
        padding: 9px 18px; border-radius: 10px; font-size: 12px; font-weight: 700;
        cursor: pointer; border: none; transition: all .2s;
        text-decoration: none; display: inline-flex; align-items: center; gap: 5px;
    }
    .btn-outline { background: #fff; border: 1.5px solid var(--border); color: var(--text-main); }
    .btn-outline:hover { border-color: var(--green); color: var(--green); }
    .btn-primary { background: var(--green); color: #fff; }
    .btn-primary:hover { background: var(--green-mid); }
    .btn-pink    { background: var(--pink); color: #fff; }
    .btn-pink:hover { background: #d4466a; }
    .btn-danger  { background: #fff; border: 1.5px solid #fecaca; color: #dc2626; }
    .btn-danger:hover { background: #fef2f2; }

    /* Flash */
    .flash-success {
        display: flex; align-items: center; gap: 10px;
        background: #f0fdf4; border: 1px solid #bbf7d0;
        color: #166534; padding: 12px 16px; border-radius: 14px;
        font-size: 13px; font-weight: 600; margin-bottom: 18px;
    }
    .flash-success svg { width: 18px; height: 18px; flex-shrink: 0; }
    .flash-close {
        margin-left: auto; background: none; border: none;
        cursor: pointer; color: #166534; font-size: 15px; line-height: 1;
    }

    /* Empty */
    .empty-state {
        background: #fff; border-radius: var(--radius);
        border: 1.5px solid var(--border); padding: 64px 32px; text-align: center;
    }
    .empty-icon {
        width: 88px; height: 88px; background: var(--green-light); border-radius: 22px;
        display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;
    }
    .empty-icon svg { width: 40px; height: 40px; color: var(--green); opacity: 0.3; }
    .empty-title { font-size: 20px; font-weight: 900; color: var(--green); margin-bottom: 8px; }
    .empty-cta {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--green); color: #fff; padding: 12px 28px; border-radius: 100px;
        font-weight: 700; font-size: 13px; text-decoration: none; margin-top: 4px;
        box-shadow: 0 4px 14px rgba(26,92,58,0.25); transition: all .2s;
    }
    .empty-cta:hover { background: var(--pink); box-shadow: 0 4px 14px rgba(232,86,122,0.3); }
    .empty-cta svg { width: 16px; height: 16px; }

    @media (max-width: 700px) {
        .sewa-layout  { padding: 16px 12px; }
        .return-info-grid { grid-template-columns: 1fr 1fr; }
    }
</style>
@endpush

@section('content')
<div class="sewa-layout">

    {{-- ══ MAIN ══ --}}
    <main class="sewa-main">

        @if(session('success'))
        <div class="flash-success" id="flash-msg">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
            <button class="flash-close" onclick="document.getElementById('flash-msg').remove()">&#x2715;</button>
        </div>
        @endif

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
                <span class="pill-dot"></span>{{ $f['label'] }}
            </a>
            @endforeach
        </div>

        @php
            $allRentals = [
                (object)[
                    'id'               => 1,
                    'order_number'     => 'CPL-20260430-001',
                    'status'           => 'belum_bayar',
                    'total_price'      => 720000,
                    'payment_deadline' => now()->addHours(23)->addMinutes(47)->addSeconds(10),
                    'overdue_days'     => 0,
                    'late_fee'         => 0,
                    'items' => [
                        (object)['name' => 'Sony A7 III Body Only',        'image' => null, 'duration' => 3, 'start_date' => '2026-04-30', 'end_date' => '2026-05-02', 'price' => 450000, 'quantity' => 1, 'overdue' => false],
                        (object)['name' => 'DJI Ronin-S Gimbal Stabilizer','image' => null, 'duration' => 3, 'start_date' => '2026-04-30', 'end_date' => '2026-05-02', 'price' => 180000, 'quantity' => 1, 'overdue' => false],
                        (object)['name' => 'Rode VideoMic Pro+',           'image' => null, 'duration' => 3, 'start_date' => '2026-04-30', 'end_date' => '2026-05-02', 'price' => 90000,  'quantity' => 2, 'overdue' => false],
                    ],
                ],
                (object)[
                    'id'               => 2,
                    'order_number'     => 'CPL-20260428-002',
                    'status'           => 'dikirim',
                    'total_price'      => 400000,
                    'payment_deadline' => null,
                    'overdue_days'     => 0,
                    'late_fee'         => 0,
                    'items' => [
                        (object)['name' => 'Zhiyun Crane 3S',    'image' => null, 'duration' => 2, 'start_date' => '2026-04-28', 'end_date' => '2026-04-29', 'price' => 160000, 'quantity' => 2, 'overdue' => false],
                        (object)['name' => 'Canon EF 50mm f/1.8','image' => null, 'duration' => 2, 'start_date' => '2026-04-28', 'end_date' => '2026-04-29', 'price' => 80000,  'quantity' => 1, 'overdue' => false],
                    ],
                ],
                (object)[
                    'id'               => 3,
                    'order_number'     => 'CPL-20260425-003',
                    'status'           => 'selesai',
                    'total_price'      => 270000,
                    'payment_deadline' => null,
                    'return_date'      => '2026-05-05',
                    'overdue_days'     => 0,
                    'late_fee'         => 0,
                    'items' => [
                        (object)['name' => 'Sony A7 III Body Only',   'image' => null, 'duration' => 1, 'start_date' => '2026-04-25', 'end_date' => '2026-04-25', 'price' => 150000, 'quantity' => 1, 'overdue' => false],
                        (object)['name' => 'Rode VideoMic Pro+',      'image' => null, 'duration' => 1, 'start_date' => '2026-04-25', 'end_date' => '2026-04-25', 'price' => 30000,  'quantity' => 1, 'overdue' => false],
                        (object)['name' => 'LED Panel Light 100W',    'image' => null, 'duration' => 1, 'start_date' => '2026-04-25', 'end_date' => '2026-04-25', 'price' => 50000,  'quantity' => 2, 'overdue' => false],
                        (object)['name' => 'Background Stand + Kain', 'image' => null, 'duration' => 1, 'start_date' => '2026-04-25', 'end_date' => '2026-04-25', 'price' => 40000,  'quantity' => 1, 'overdue' => false],
                    ],
                ],
                (object)[
                    'id'               => 4,
                    'order_number'     => 'CPL-20260420-004',
                    'status'           => 'dikemas',
                    'total_price'      => 200000,
                    'payment_deadline' => null,
                    'overdue_days'     => 0,
                    'late_fee'         => 0,
                    'items' => [
                        (object)['name' => 'Zhiyun Crane 3S',           'image' => null, 'duration' => 2, 'start_date' => '2026-04-22', 'end_date' => '2026-04-23', 'price' => 120000, 'quantity' => 1, 'overdue' => false],
                        (object)['name' => 'GorillaPod Flexible Tripod', 'image' => null, 'duration' => 2, 'start_date' => '2026-04-22', 'end_date' => '2026-04-23', 'price' => 80000,  'quantity' => 1, 'overdue' => false],
                    ],
                ],
                (object)[
                    'id'               => 5,
                    'order_number'     => 'CPL-20260415-005',
                    'status'           => 'dibatalkan',
                    'total_price'      => 150000,
                    'payment_deadline' => null,
                    'overdue_days'     => 0,
                    'late_fee'         => 0,
                    'items' => [
                        (object)['name' => 'Canon EF 50mm f/1.8','image' => null, 'duration' => 1, 'start_date' => '2026-04-15', 'end_date' => '2026-04-15', 'price' => 100000, 'quantity' => 1, 'overdue' => false],
                        (object)['name' => 'Memory Card 64GB',   'image' => null, 'duration' => 1, 'start_date' => '2026-04-15', 'end_date' => '2026-04-15', 'price' => 50000,  'quantity' => 1, 'overdue' => false],
                    ],
                ],
                (object)[
                    'id'               => 6,
                    'order_number'     => 'CPL-20260410-006',
                    'status'           => 'pengembalian',
                    'total_price'      => 720000,
                    'payment_deadline' => null,
                    'overdue_days'     => 3,
                    'late_fee'         => 150000,
                    'items' => [
                        (object)['name' => 'Sony A7 III Body Only',        'image' => null, 'duration' => 3, 'start_date' => '2026-04-10', 'end_date' => '2026-04-12', 'price' => 450000, 'quantity' => 1, 'overdue' => true],
                        (object)['name' => 'DJI Ronin-S Gimbal Stabilizer','image' => null, 'duration' => 3, 'start_date' => '2026-04-10', 'end_date' => '2026-04-12', 'price' => 180000, 'quantity' => 1, 'overdue' => false],
                        (object)['name' => 'Rode VideoMic Pro+',           'image' => null, 'duration' => 3, 'start_date' => '2026-04-10', 'end_date' => '2026-04-12', 'price' => 90000,  'quantity' => 2, 'overdue' => false],
                    ],
                ],
            ];

            // Sorting: urutan status di tab "Semua"
            $statusOrder = [
                'belum_bayar'  => 1,
                'dikemas'      => 2,
                'dikirim'      => 3,
                'pengembalian' => 4,
                'selesai'      => 5,
                'dibatalkan'   => 6,
            ];

            usort($allRentals, function($a, $b) use ($statusOrder) {
                $orderA = $statusOrder[$a->status] ?? 99;
                $orderB = $statusOrder[$b->status] ?? 99;
                return $orderA - $orderB;
            });

            // Filter berdasarkan status pill yang dipilih
            if ($activeStatus !== 'semua') {
                $rentals = [];
                foreach ($allRentals as $r) {
                    if ($r->status === $activeStatus) {
                        $rentals[] = $r;
                    }
                }
            } else {
                $rentals = $allRentals;
            }
        @endphp

        {{-- ══ RENTAL LIST ══ --}}
        @forelse($rentals as $index => $rental)

        @php
            $status = strtolower(isset($rental->status) ? $rental->status : 'belum_bayar');

            $badgeClass = 'badge-default';
            $badgeLabel = ucfirst($status);
            if ($status === 'belum_bayar')  { $badgeClass = 'badge-belum_bayar';  $badgeLabel = 'Belum Bayar'; }
            if ($status === 'dikemas')      { $badgeClass = 'badge-dikemas';      $badgeLabel = 'Dikemas'; }
            if ($status === 'dikirim')      { $badgeClass = 'badge-dikirim';      $badgeLabel = 'Dikirim'; }
            if ($status === 'selesai')      { $badgeClass = 'badge-selesai';      $badgeLabel = 'Selesai'; }
            if ($status === 'dibatalkan')   { $badgeClass = 'badge-dibatalkan';   $badgeLabel = 'Dibatalkan'; }
            if ($status === 'pengembalian') { $badgeClass = 'badge-pengembalian'; $badgeLabel = 'Pengembalian'; }

            $stepIndex = 0;
            if ($status === 'dikemas')  { $stepIndex = 1; }
            if ($status === 'dikirim')  { $stepIndex = 2; }
            if ($status === 'selesai')  { $stepIndex = 3; }

            $showProgress = ($status === 'dikemas' || $status === 'dikirim' || $status === 'selesai');

            $items        = isset($rental->items) ? $rental->items : [];
            $itemCount    = count($items);
            $visibleItems = array_slice($items, 0, 1);
            $hiddenItems  = array_slice($items, 1);
            $hiddenCount  = count($hiddenItems);

            $totalQty = 0;
            foreach ($items as $itm) {
                $totalQty += isset($itm->quantity) ? (int)$itm->quantity : 1;
            }
        @endphp

        <div class="rental-card" style="animation-delay: {{ $index * 0.08 }}s">

            {{-- Header --}}
            <div class="card-header">
                <div class="seller-info">
                    <div class="seller-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        </svg>
                    </div>
                    <div class="seller-name">Camplore Official</div>
                </div>
                <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
            </div>

            {{-- Body --}}
            <div class="card-body">

                <div class="product-list">

                    {{-- Produk selalu tampil (1 pertama) --}}
                    @foreach($visibleItems as $item)
                    <div class="product-row">
                        <div class="product-thumb">
                            @if(!empty($item->image))
                                <img src="{{ $item->image }}" alt="{{ $item->name }}">
                            @else
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                          d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <circle cx="12" cy="13" r="3" stroke-width="1.2"/>
                                </svg>
                            @endif
                        </div>
                        <div class="product-info">
                            <div class="product-name-row">
                                <div class="product-name">{{ isset($item->name) ? $item->name : 'Produk' }}</div>
                                @if($status === 'pengembalian' && isset($item->overdue) && $item->overdue)
                                    <span class="badge badge-overdue" style="font-size:10px;padding:2px 9px;white-space:nowrap;flex-shrink:0;">Overdue</span>
                                @endif
                            </div>
                            <div class="product-meta">
                                Sewa {{ isset($item->duration) ? $item->duration : '-' }} hari
                                &bull; {{ \Carbon\Carbon::parse($item->start_date)->format('d M') }}
                                &ndash; {{ \Carbon\Carbon::parse($item->end_date)->format('d M') }}
                            </div>
                            <div class="product-price-row">
                                <span class="product-price">Rp {{ number_format(isset($item->price) ? $item->price : 0, 0, ',', '.') }}</span>
                                <span class="qty-tag">&times;{{ isset($item->quantity) ? $item->quantity : 1 }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    {{-- Produk tersembunyi (item ke-2 dst) --}}
                    @if($hiddenCount > 0)
                    <div id="hidden-items-{{ $rental->id }}" style="display:none;">
                        @foreach($hiddenItems as $item)
                        <div class="product-row">
                            <div class="product-thumb">
                                @if(!empty($item->image))
                                    <img src="{{ $item->image }}" alt="{{ $item->name }}">
                                @else
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                              d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <circle cx="12" cy="13" r="3" stroke-width="1.2"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="product-info">
                                <div class="product-name-row">
                                    <div class="product-name">{{ isset($item->name) ? $item->name : 'Produk' }}</div>
                                    @if($status === 'pengembalian' && isset($item->overdue) && $item->overdue)
                                        <span class="badge badge-overdue" style="font-size:10px;padding:2px 9px;white-space:nowrap;flex-shrink:0;">Overdue</span>
                                    @endif
                                </div>
                                <div class="product-meta">
                                    Sewa {{ isset($item->duration) ? $item->duration : '-' }} hari
                                    &bull; {{ \Carbon\Carbon::parse($item->start_date)->format('d M') }}
                                    &ndash; {{ \Carbon\Carbon::parse($item->end_date)->format('d M') }}
                                </div>
                                <div class="product-price-row">
                                    <span class="product-price">Rp {{ number_format(isset($item->price) ? $item->price : 0, 0, ',', '.') }}</span>
                                    <span class="qty-tag">&times;{{ isset($item->quantity) ? $item->quantity : 1 }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button class="show-more-btn"
                            id="toggle-btn-{{ $rental->id }}"
                            onclick="toggleItems({{ $rental->id }}, {{ $hiddenCount }})">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                        + {{ $hiddenCount }} produk lainnya
                    </button>
                    @endif

                </div>

                {{-- Timer (belum bayar) --}}
                @if($status === 'belum_bayar' && !empty($rental->payment_deadline))
                <div class="timer-bar">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="12" cy="12" r="10" stroke-width="1.8"/>
                        <path stroke-linecap="round" stroke-width="1.8" d="M12 6v6l4 2"/>
                    </svg>
                    <span class="timer-text">Bayar dalam</span>
                    <span class="timer-countdown"
                          data-deadline="{{ \Carbon\Carbon::parse($rental->payment_deadline)->timestamp }}">
                        --:--:--
                    </span>
                </div>
                @endif

                {{-- Return reminder note (selesai) --}}
                @if($status === 'selesai' && !empty($rental->return_date))
                @php
                    $returnDate   = \Carbon\Carbon::parse($rental->return_date);
                    $daysLeft     = (int) now()->startOfDay()->diffInDays($returnDate->startOfDay(), false);
                    $isUrgent     = $daysLeft <= 1;
                @endphp
                <div class="return-reminder" style="{{ $isUrgent ? 'background:#fef2f2;border-color:#fecaca;' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"
                         style="{{ $isUrgent ? 'color:#dc2626;' : '' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                    <div class="return-reminder-text" style="{{ $isUrgent ? 'color:#991b1b;' : '' }}">
                        Jangan lupa kembalikan barang sebelum
                        <span class="return-reminder-date" style="{{ $isUrgent ? 'color:#dc2626;' : '' }}">
                            {{ $returnDate->translatedFormat('d F Y') }}
                        </span>
                        @if($daysLeft > 0)
                            &mdash; {{ $daysLeft }} hari lagi.
                        @elseif($daysLeft === 0)
                            &mdash; <strong>Hari ini!</strong>
                        @else
                            &mdash; <strong>Sudah lewat batas!</strong>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Info keterlambatan & denda (pengembalian) --}}
                @if($status === 'pengembalian')
                <div class="return-info-grid">
                    <div class="return-info-box neutral">
                        <div class="return-info-label">Tanggal sewa</div>
                        <div class="return-info-value">
                            {{ isset($items[0]) ? \Carbon\Carbon::parse($items[0]->start_date)->format('d M Y') : '-' }}
                        </div>
                    </div>
                    <div class="return-info-box danger">
                        <div class="return-info-label red">Keterlambatan</div>
                        <div class="return-info-value red">
                            {{ isset($rental->overdue_days) ? $rental->overdue_days : 0 }} hari
                        </div>
                    </div>
                </div>
                <div class="denda-row">
                    <div>
                        <div class="denda-label">Total denda</div>
                        <div class="denda-value">Rp {{ number_format(isset($rental->late_fee) ? $rental->late_fee : 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="denda-actions">
                        <a href="#" class="btn btn-primary">Bayar</a>
                    </div>
                </div>
                @endif

                {{-- Order info --}}
                <div class="order-num">
                    No. pemesanan:
                    {{ isset($rental->order_number) ? $rental->order_number : 'CPL-' . str_pad($rental->id, 8, '0', STR_PAD_LEFT) }}
                    &bull; {{ $itemCount }} produk, {{ $totalQty }} item
                </div>

                {{-- Progress --}}
                @if($showProgress)
                <div class="prog-wrap">
                    <div class="prog-row">
                        <div class="prog-dot"></div>
                        <div class="prog-line {{ $stepIndex >= 1 ? '' : 'off' }}"></div>
                        <div class="prog-dot {{ $stepIndex >= 1 ? '' : 'off' }}"></div>
                        <div class="prog-line {{ $stepIndex >= 2 ? '' : 'off' }}"></div>
                        <div class="prog-dot {{ $stepIndex >= 2 ? '' : 'off' }}"></div>
                        <div class="prog-line {{ $stepIndex >= 3 ? '' : 'off' }}"></div>
                        <div class="prog-dot {{ $stepIndex >= 3 ? '' : 'off' }}"></div>
                    </div>
                    <div class="prog-labels">
                        <div class="prog-lbl on">Pesanan dibuat</div>
                        <div class="prog-lbl {{ $stepIndex >= 1 ? 'on' : '' }}">Dikemas</div>
                        <div class="prog-lbl {{ $stepIndex >= 2 ? 'on' : '' }}">Dikirim</div>
                        <div class="prog-lbl {{ $stepIndex >= 3 ? 'on' : '' }}">Diterima</div>
                    </div>
                </div>
                @endif

            </div>{{-- end card-body --}}

            {{-- Footer --}}
            <div class="card-footer">
                <div>
                    <div class="total-label">Total sewa:</div>
                    <div class="total-price">Rp {{ number_format(isset($rental->total_price) ? $rental->total_price : 0, 0, ',', '.') }}</div>
                    <div class="total-meta">{{ $itemCount }} produk &bull; {{ $totalQty }} item</div>
                </div>
                <div class="card-actions">

                    @if($status === 'belum_bayar')
                        <button class="btn btn-danger">Batalkan</button>
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

        </div>{{-- end .rental-card --}}

        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="empty-title">Belum Ada Riwayat Sewa</div>
            <a href="{{ url('/catalog') }}" class="empty-cta">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                </svg>
                Browse Gear Sekarang
            </a>
        </div>
        @endforelse

    </main>
</div>

<script>
    // Auto-hide flash
    setTimeout(function () {
        var el = document.getElementById('flash-msg');
        if (el) {
            el.style.transition = 'opacity 0.4s';
            el.style.opacity = '0';
            setTimeout(function () { el.remove(); }, 400);
        }
    }, 4000);

    // Countdown timers
    function updateCountdowns() {
        var els = document.querySelectorAll('.timer-countdown[data-deadline]');
        for (var i = 0; i < els.length; i++) {
            var el       = els[i];
            var deadline = parseInt(el.getAttribute('data-deadline')) * 1000;
            var diff     = Math.max(0, Math.floor((deadline - Date.now()) / 1000));
            if (diff <= 0) { el.textContent = '00:00:00'; continue; }
            var h = String(Math.floor(diff / 3600)).padStart(2, '0');
            var m = String(Math.floor((diff % 3600) / 60)).padStart(2, '0');
            var s = String(diff % 60).padStart(2, '0');
            el.textContent = h + ':' + m + ':' + s;
        }
    }
    updateCountdowns();
    setInterval(updateCountdowns, 1000);

    // Toggle hidden items
    function toggleItems(rentalId, hiddenCount) {
        var wrap = document.getElementById('hidden-items-' + rentalId);
        var btn  = document.getElementById('toggle-btn-' + rentalId);
        if (!wrap || !btn) return;

        var isOpen = wrap.style.display === 'block';

        if (isOpen) {
            wrap.style.display = 'none';
            btn.classList.remove('open');
            btn.innerHTML =
                '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="14" height="14">' +
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>' +
                '</svg> + ' + hiddenCount + ' produk lainnya';
        } else {
            wrap.style.display = 'block';
            btn.classList.add('open');
            btn.innerHTML =
                '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="14" height="14">' +
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>' +
                '</svg> Sembunyikan';
        }
    }
</script>
@endsection