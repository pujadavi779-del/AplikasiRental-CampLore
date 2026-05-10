@extends('layouts.pelanggan')

@section('title', 'Sewa Saya - Camplore')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp .4s ease both; }
    .prog-line-on  { flex:1; height:3px; background:#1a5c3a; }
    .prog-line-off { flex:1; height:3px; background:#e5e7eb; }
    .show-more-btn svg { transition: transform .25s; }
    .show-more-btn.open svg { transform: rotate(180deg); }
    /* Tailwind doesn't ship tabular-nums, add it */
    .tabular { font-variant-numeric: tabular-nums; }
</style>
@endpush

@section('content')
<div class="bg-[#f5f6f4] min-h-screen" style="font-family:'Inter',sans-serif;">
<div class="max-w-[1100px] mx-auto px-4 py-8 flex gap-6">

    {{-- ══ MAIN ══ --}}
    <main class="flex-1 min-w-0">

        {{-- Flash --}}
        @if(session('success'))
        <div id="flash-msg"
             class="flex items-center gap-2.5 bg-[#f0fdf4] border border-[#bbf7d0] text-[#166534] px-4 py-3 rounded-2xl text-[13px] font-semibold mb-[18px]">
            <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
            <button class="ml-auto bg-transparent border-0 cursor-pointer text-[#166534] text-[15px] leading-none"
                    onclick="document.getElementById('flash-msg').remove()">&#x2715;</button>
        </div>
        @endif

        {{-- Page Title --}}
        <div class="text-3xl font-extrabold text-[#22543D] tracking-tight" style="font-family: 'Playfair Display', serif;">Sewa Saya</div>
        <div class="text-[13px] text-[#6b7280] mt-1">Tinjau semua transaksi penyewaan Anda berdasarkan statusnya.</div>

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
        <div class="flex flex-wrap gap-2 mt-[18px] mb-[22px]">
            @foreach($filters as $f)
            <a href="?status={{ $f['value'] }}"
               class="inline-flex items-center gap-1.5 px-4 py-[7px] rounded-full border-[1.5px] text-xs font-bold no-underline transition-all duration-200
                      {{ $activeStatus === $f['value']
                         ? 'bg-[#1a5c3a] border-[#1a5c3a] text-white'
                         : 'bg-white border-[#e5e7eb] text-[#6b7280] hover:border-[#1a5c3a] hover:text-[#1a5c3a]' }}">
                <span class="w-1.5 h-1.5 rounded-full inline-block"
                      style="background:currentColor;opacity:0.65;"></span>
                {{ $f['label'] }}
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

            $statusOrder = ['belum_bayar'=>1,'dikemas'=>2,'dikirim'=>3,'pengembalian'=>4,'selesai'=>5,'dibatalkan'=>6];
            usort($allRentals, fn($a,$b) => ($statusOrder[$a->status]??99) - ($statusOrder[$b->status]??99));

            $rentals = $activeStatus !== 'semua'
                ? array_values(array_filter($allRentals, fn($r) => $r->status === $activeStatus))
                : $allRentals;
        @endphp

        {{-- ══ RENTAL LIST ══ --}}
        @forelse($rentals as $index => $rental)

        @php
            $status = strtolower($rental->status ?? 'belum_bayar');

            $badgeClass = 'bg-[#f3f4f6] text-[#6b7280] border border-[#e5e7eb]';
            $badgeLabel = ucfirst($status);
            if ($status === 'belum_bayar')  { $badgeClass = 'bg-[#fff7ed] text-[#c2410c] border border-[#fed7aa]'; $badgeLabel = 'Belum Bayar'; }
            if ($status === 'dikemas')      { $badgeClass = 'bg-[#f0fdf4] text-[#15803d] border border-[#bbf7d0]'; $badgeLabel = 'Dikemas'; }
            if ($status === 'dikirim')      { $badgeClass = 'bg-[#eff6ff] text-[#1d4ed8] border border-[#bfdbfe]'; $badgeLabel = 'Dikirim'; }
            if ($status === 'selesai')      { $badgeClass = 'bg-[#f0fdf4] text-[#166534] border border-[#86efac]'; $badgeLabel = 'Selesai'; }
            if ($status === 'dibatalkan')   { $badgeClass = 'bg-[#fef2f2] text-[#991b1b] border border-[#fecaca]'; $badgeLabel = 'Dibatalkan'; }
            if ($status === 'pengembalian') { $badgeClass = 'bg-[#faf5ff] text-[#7e22ce] border border-[#e9d5ff]'; $badgeLabel = 'Pengembalian'; }

            $stepIndex = 0;
            if ($status === 'dikemas') $stepIndex = 1;
            if ($status === 'dikirim') $stepIndex = 2;
            if ($status === 'selesai') $stepIndex = 3;
            $showProgress = in_array($status, ['dikemas','dikirim','selesai']);

            $items        = $rental->items ?? [];
            $itemCount    = count($items);
            $visibleItems = array_slice($items, 0, 1);
            $hiddenItems  = array_slice($items, 1);
            $hiddenCount  = count($hiddenItems);
            $totalQty     = array_sum(array_map(fn($i) => (int)($i->quantity ?? 1), $items));
        @endphp

        {{-- Card --}}
        <div class="bg-white rounded-[18px] border-[1.5px] border-[#e5e7eb] mb-3.5 overflow-hidden
                    transition-all duration-[250ms] hover:shadow-[0_8px_32px_rgba(26,92,58,0.12)] hover:-translate-y-0.5
                    fade-up"
             style="animation-delay: {{ $index * 0.08 }}s">

            {{-- Card Header --}}
            <div class="flex items-center justify-between px-4 py-3 pb-[10px] border-b border-[#e5e7eb]">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 bg-[#eef5f0] rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#1a5c3a]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        </svg>
                    </div>
                    <span class="text-[13px] font-bold text-[#1a1a1a]">Camplore Official</span>
                </div>
                <span class="px-3 py-1 rounded-full text-[11px] font-bold {{ $badgeClass }}">{{ $badgeLabel }}</span>
            </div>

            {{-- Card Body --}}
            <div class="px-4 py-3.5">

                {{-- Product list --}}
                <div class="flex flex-col">

                    {{-- Visible items (first only) --}}
                    @foreach($visibleItems as $item)
                    <div class="flex gap-3.5 items-start py-2.5 first:pt-0 last:border-0 last:pb-0 border-b border-[#e5e7eb]">
                        {{-- Thumb --}}
                        <div class="w-[68px] h-[68px] rounded-xl border-[1.5px] border-[#e5e7eb] overflow-hidden
                                    flex-shrink-0 bg-[#eef5f0] flex items-center justify-center">
                            @if(!empty($item->image))
                                <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-[26px] h-[26px] text-[#1a5c3a] opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                          d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <circle cx="12" cy="13" r="3" stroke-width="1.2"/>
                                </svg>
                            @endif
                        </div>
                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <div class="text-sm font-extrabold text-[#1a1a1a] truncate">{{ $item->name ?? 'Produk' }}</div>
                                @if($status === 'pengembalian' && ($item->overdue ?? false))
                                    <span class="flex-shrink-0 px-[9px] py-0.5 rounded-full text-[10px] font-bold bg-[#fef2f2] text-[#dc2626] border border-[#fecaca]">Overdue</span>
                                @endif
                            </div>
                            <div class="text-xs text-[#6b7280] mt-0.5">
                                Sewa {{ $item->duration ?? '-' }} hari
                                &bull; {{ \Carbon\Carbon::parse($item->start_date)->format('d M') }}
                                &ndash; {{ \Carbon\Carbon::parse($item->end_date)->format('d M') }}
                            </div>
                            <div class="flex items-center gap-2 mt-[5px]">
                                <span class="text-sm font-extrabold text-[#1a5c3a]">Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}</span>
                                <span class="inline-flex items-center bg-[#eef5f0] text-[#1a5c3a] rounded-[6px] px-2 py-0.5 text-[11px] font-bold">
                                    &times;{{ $item->quantity ?? 1 }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    {{-- Hidden items --}}
                    @if($hiddenCount > 0)
                    <div id="hidden-items-{{ $rental->id }}" style="display:none;">
                        @foreach($hiddenItems as $item)
                        <div class="flex gap-3.5 items-start py-2.5 border-b border-[#e5e7eb] last:border-0">
                            <div class="w-[68px] h-[68px] rounded-xl border-[1.5px] border-[#e5e7eb] overflow-hidden
                                        flex-shrink-0 bg-[#eef5f0] flex items-center justify-center">
                                @if(!empty($item->image))
                                    <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-[26px] h-[26px] text-[#1a5c3a] opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                              d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <circle cx="12" cy="13" r="3" stroke-width="1.2"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <div class="text-sm font-extrabold text-[#1a1a1a] truncate">{{ $item->name ?? 'Produk' }}</div>
                                    @if($status === 'pengembalian' && ($item->overdue ?? false))
                                        <span class="flex-shrink-0 px-[9px] py-0.5 rounded-full text-[10px] font-bold bg-[#fef2f2] text-[#dc2626] border border-[#fecaca]">Overdue</span>
                                    @endif
                                </div>
                                <div class="text-xs text-[#6b7280] mt-0.5">
                                    Sewa {{ $item->duration ?? '-' }} hari
                                    &bull; {{ \Carbon\Carbon::parse($item->start_date)->format('d M') }}
                                    &ndash; {{ \Carbon\Carbon::parse($item->end_date)->format('d M') }}
                                </div>
                                <div class="flex items-center gap-2 mt-[5px]">
                                    <span class="text-sm font-extrabold text-[#1a5c3a]">Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}</span>
                                    <span class="inline-flex items-center bg-[#eef5f0] text-[#1a5c3a] rounded-[6px] px-2 py-0.5 text-[11px] font-bold">
                                        &times;{{ $item->quantity ?? 1 }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Toggle button --}}
                    <button class="show-more-btn flex items-center gap-1.5 w-full pt-[9px] pb-0.5
                                   bg-transparent border-0 cursor-pointer text-xs font-bold text-[#1a5c3a]
                                   text-left transition-opacity duration-200 hover:opacity-75"
                            id="toggle-btn-{{ $rental->id }}"
                            onclick="toggleItems({{ $rental->id }}, {{ $hiddenCount }})">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                        + {{ $hiddenCount }} produk lainnya
                    </button>
                    @endif

                </div>{{-- end product-list --}}

                {{-- Timer (belum_bayar) --}}
                @if($status === 'belum_bayar' && !empty($rental->payment_deadline))
                <div class="mt-3 bg-[#fff7ed] rounded-[10px] px-3.5 py-[9px] flex items-center gap-2 border border-[#fed7aa]">
                    <svg class="w-[15px] h-[15px] text-[#c2410c] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="12" cy="12" r="10" stroke-width="1.8"/>
                        <path stroke-linecap="round" stroke-width="1.8" d="M12 6v6l4 2"/>
                    </svg>
                    <span class="text-xs font-bold text-[#c2410c]">Bayar dalam</span>
                    <span class="ml-auto text-sm font-extrabold text-[#c2410c] tabular timer-countdown"
                          data-deadline="{{ \Carbon\Carbon::parse($rental->payment_deadline)->timestamp }}">
                        --:--:--
                    </span>
                </div>
                @endif

                {{-- Return reminder (selesai) --}}
                @if($status === 'selesai' && !empty($rental->return_date))
                @php
                    $returnDate = \Carbon\Carbon::parse($rental->return_date);
                    $daysLeft   = (int) now()->startOfDay()->diffInDays($returnDate->startOfDay(), false);
                    $isUrgent   = $daysLeft <= 1;
                @endphp
                <div class="mt-3 rounded-[10px] px-3.5 py-[10px] flex items-start gap-2.5
                            {{ $isUrgent ? 'bg-[#fef2f2] border border-[#fecaca]' : 'bg-[#fffbeb] border border-[#fde68a]' }}">
                    <svg class="w-[15px] h-[15px] flex-shrink-0 mt-px {{ $isUrgent ? 'text-[#dc2626]' : 'text-[#b45309]' }}"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                    <div class="text-xs font-semibold leading-relaxed {{ $isUrgent ? 'text-[#991b1b]' : 'text-[#92400e]' }}">
                        Jangan lupa kembalikan barang sebelum
                        <span class="text-[13px] font-extrabold {{ $isUrgent ? 'text-[#dc2626]' : 'text-[#b45309]' }}">
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

                {{-- Pengembalian info --}}
                @if($status === 'pengembalian')
                <div class="grid grid-cols-2 gap-2.5 mt-3.5">
                    <div class="bg-[#f5f6f4] border border-[#e5e7eb] rounded-xl px-3.5 py-3">
                        <div class="text-[11px] font-semibold text-[#6b7280] mb-1">Tanggal sewa</div>
                        <div class="text-[15px] font-extrabold text-[#1a1a1a]">
                            {{ isset($items[0]) ? \Carbon\Carbon::parse($items[0]->start_date)->format('d M Y') : '-' }}
                        </div>
                    </div>
                    <div class="bg-[#fef2f2] border border-[#fecaca] rounded-xl px-3.5 py-3">
                        <div class="text-[11px] font-semibold text-[#dc2626] mb-1">Keterlambatan</div>
                        <div class="text-[15px] font-extrabold text-[#dc2626]">
                            {{ $rental->overdue_days ?? 0 }} hari
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-2.5 px-3.5 py-3
                            bg-[#f5f6f4] rounded-xl border border-[#e5e7eb]">
                    <div>
                        <div class="text-xs text-[#6b7280] font-medium mb-0.5">Total denda</div>
                        <div class="text-base font-black text-[#dc2626]">Rp {{ number_format($rental->late_fee ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="flex gap-2 items-center">
                        <a href="#" class="px-[18px] py-[9px] rounded-[10px] text-xs font-bold bg-[#1a5c3a] text-white
                                           hover:bg-[#2d7a52] transition-colors duration-200 no-underline inline-flex items-center gap-1.5">
                            Bayar
                        </a>
                    </div>
                </div>
                @endif

                {{-- Order info --}}
                <div class="text-[11px] text-[#9ca3af] mt-2.5">
                    No. pemesanan:
                    {{ $rental->order_number ?? 'CPL-' . str_pad($rental->id, 8, '0', STR_PAD_LEFT) }}
                    &bull; {{ $itemCount }} produk, {{ $totalQty }} item
                </div>

                {{-- Progress bar --}}
                @if($showProgress)
                <div class="mt-3.5">
                    {{-- Dots + lines --}}
                    <div class="flex items-center">
                        <div class="w-[13px] h-[13px] rounded-full bg-[#1a5c3a] flex-shrink-0"></div>
                        <div class="{{ $stepIndex >= 1 ? 'prog-line-on' : 'prog-line-off' }}"></div>
                        <div class="w-[13px] h-[13px] rounded-full flex-shrink-0 {{ $stepIndex >= 1 ? 'bg-[#1a5c3a]' : 'bg-[#e5e7eb]' }}"></div>
                        <div class="{{ $stepIndex >= 2 ? 'prog-line-on' : 'prog-line-off' }}"></div>
                        <div class="w-[13px] h-[13px] rounded-full flex-shrink-0 {{ $stepIndex >= 2 ? 'bg-[#1a5c3a]' : 'bg-[#e5e7eb]' }}"></div>
                        <div class="{{ $stepIndex >= 3 ? 'prog-line-on' : 'prog-line-off' }}"></div>
                        <div class="w-[13px] h-[13px] rounded-full flex-shrink-0 {{ $stepIndex >= 3 ? 'bg-[#1a5c3a]' : 'bg-[#e5e7eb]' }}"></div>
                    </div>
                    {{-- Labels --}}
                    <div class="flex mt-1.5">
                        <div class="flex-1 text-center text-[10px] font-bold text-[#1a5c3a]">Pesanan dibuat</div>
                        <div class="flex-1 text-center text-[10px] {{ $stepIndex >= 1 ? 'font-bold text-[#1a5c3a]' : 'font-semibold text-[#9ca3af]' }}">Dikemas</div>
                        <div class="flex-1 text-center text-[10px] {{ $stepIndex >= 2 ? 'font-bold text-[#1a5c3a]' : 'font-semibold text-[#9ca3af]' }}">Dikirim</div>
                        <div class="flex-1 text-center text-[10px] {{ $stepIndex >= 3 ? 'font-bold text-[#1a5c3a]' : 'font-semibold text-[#9ca3af]' }}">Diterima</div>
                    </div>
                </div>
                @endif

            </div>{{-- end card-body --}}

            {{-- Card Footer --}}
            <div class="border-t border-[#e5e7eb] px-4 py-3 flex items-center justify-between gap-3">
                <div>
                    <div class="text-xs text-[#6b7280] font-medium">Total sewa:</div>
                    <div class="text-[17px] font-black text-[#1a1a1a] mt-px">
                        Rp {{ number_format($rental->total_price ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="text-[11px] text-[#9ca3af] mt-0.5">{{ $itemCount }} produk &bull; {{ $totalQty }} item</div>
                </div>
                <div class="flex gap-2 items-center flex-wrap justify-end">

                    @if($status === 'belum_bayar')
                        <button class="px-[18px] py-[9px] rounded-[10px] text-xs font-bold cursor-pointer transition-all duration-200
                                       bg-white border-[1.5px] border-[#fecaca] text-[#dc2626] hover:bg-[#fef2f2]">
                            Batalkan
                        </button>
                        <a href="#" class="px-[18px] py-[9px] rounded-[10px] text-xs font-bold no-underline inline-flex items-center gap-1.5
                                           bg-[#1a5c3a] text-white hover:bg-[#2d7a52] transition-colors duration-200">
                            Bayar Sekarang
                        </a>
                    @endif

                    @if($status === 'dikirim')
                        <a href="#" class="px-[18px] py-[9px] rounded-[10px] text-xs font-bold no-underline inline-flex items-center gap-1.5
                                           bg-white border-[1.5px] border-[#e5e7eb] text-[#1a1a1a]
                                           hover:border-[#1a5c3a] hover:text-[#1a5c3a] transition-all duration-200">
                            Hubungi Penjual
                        </a>
                    @endif

                    @if($status === 'selesai')
                        <a href="#" class="px-[18px] py-[9px] rounded-[10px] text-xs font-bold no-underline inline-flex items-center gap-1.5
                                           bg-[#e8567a] text-white hover:bg-[#d4466a] transition-colors duration-200">
                            Sewa Lagi
                        </a>
                    @endif

                </div>
            </div>

        </div>{{-- end rental-card --}}

        @empty
        {{-- Empty state --}}
        <div class="bg-white rounded-[18px] border-[1.5px] border-[#e5e7eb] px-8 py-16 text-center">
            <div class="w-[88px] h-[88px] bg-[#eef5f0] rounded-[22px] flex items-center justify-center mx-auto mb-5">
                <svg class="w-10 h-10 text-[#1a5c3a] opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="text-xl font-black text-[#1a5c3a] mb-2" style="font-family:'Playfair Display',Georgia,serif;">
                Belum Ada Riwayat Sewa
            </div>
            <a href="{{ url('/catalog') }}"
               class="inline-flex items-center gap-2 bg-[#1a5c3a] text-white px-7 py-3 rounded-full
                      font-bold text-[13px] no-underline mt-1
                      shadow-[0_4px_14px_rgba(26,92,58,0.25)] hover:bg-[#e8567a]
                      hover:shadow-[0_4px_14px_rgba(232,86,122,0.3)] transition-all duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                </svg>
                Browse Gear Sekarang
            </a>
        </div>
        @endforelse

    </main>
</div>
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