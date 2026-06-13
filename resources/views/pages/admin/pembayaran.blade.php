@extends('layouts.admin')

@section('title', 'Transaksi Pembayaran - CampLore')

@php
    $NavParent = 'Manajemen Operasional';
    $section = 'Pengguna';
@endphp

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display&display=swap');
    .pay-wrap * { font-family: 'DM Sans', sans-serif; }
    .font-display { font-family: 'DM Serif Display', serif !important; }
    [x-cloak] { display: none !important; }

    .pay-wrap {
        --green:   #22543D;
        --green2:  #2D6A4F;
        --greenlt: #EEF4F0;
        --accent:  #ED64A6;
        --border:  #D7E6DE;
    }

    /* Row hover shimmer */
    .pay-row { transition: background .15s; }
    .pay-row:hover { background: #f7fbf8; }

    /* Status badge */
    .badge { display:inline-flex; align-items:center; gap:5px; padding:3px 10px;
             border-radius:8px; font-size:10px; font-weight:700; letter-spacing:.03em; }
    .badge::before { content:''; width:6px; height:6px; border-radius:50%; flex-shrink:0; }
    .badge-lunas    { background:#d1fae5; color:#065f46; border:1px solid #a7f3d0; }
    .badge-lunas::before    { background:#10b981; }
    .badge-proses   { background:#fef9c3; color:#854d0e; border:1px solid #fde68a; }
    .badge-proses::before   { background:#f59e0b; }
    .badge-batal    { background:#fee2e2; color:#b91c1c; border:1px solid #fca5a5; }
    .badge-batal::before    { background:#ef4444; }
    .badge-default  { background:#f3f4f6; color:#374151; border:1px solid #e5e7eb; }
    .badge-default::before  { background:#9ca3af; }

    /* Export button pulse */
    @keyframes pulse-green {
        0%,100% { box-shadow: 0 0 0 0 rgba(34,84,61,.3); }
        50%      { box-shadow: 0 0 0 6px rgba(34,84,61,0); }
    }
    .btn-export { animation: pulse-green 2.5s infinite; }

    /* Modal slide-up */
    .modal-card { transform-origin: bottom center; }
</style>

<div x-data="{ openDetail: false, selectedData: {} }" class="pay-wrap max-w-full">
    <div class="bg-white rounded-[24px] border border-[var(--border)] shadow-sm overflow-hidden">

        {{-- ── HEADER ─────────────────────────────────────── --}}
        <div class="px-6 pt-6 pb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[var(--greenlt)]">
            <div>
                <p class="text-[10px] font-bold tracking-widest text-[var(--accent)] uppercase mb-1">Manajemen Operasional</p>
                <h2 class="font-display text-2xl text-[var(--green)] leading-tight">Transaksi Pembayaran</h2>
                <p class="text-[11px] text-[#7c8b84] mt-0.5">Daftar semua transaksi yang telah melewati proses pembayaran.</p>
            </div>

            {{-- Export Button --}}
            <a href="{{ route('admin.pembayaran.export') }}"
               class="btn-export inline-flex items-center gap-2 px-5 py-2.5 bg-[var(--green)] hover:bg-[var(--green2)] text-white text-xs font-bold rounded-xl transition-all active:scale-95 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 10v6m0 0l-3-3m3 3l3-3M3 17v2a2 2 0 002 2h14a2 2 0 002-2v-2M16 6l-4-4-4 4"/>
                </svg>
                Export Excel
            </a>
        </div>

        {{-- ── SEARCH + STATS ──────────────────────────────── --}}
        <div class="px-6 py-4 border-b border-[var(--greenlt)] flex flex-col sm:flex-row sm:items-center gap-4">

            {{-- Search --}}
            <form method="GET" action="{{ route('admin.pembayaran') }}" class="flex-1">
                <div class="relative w-full sm:max-w-xs">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2"/>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari ID pesanan atau tanggal..."
                           class="w-full pl-10 pr-4 py-2 bg-[#f8faf9] border border-[var(--border)] rounded-xl text-xs
                                  focus:ring-1 focus:ring-[var(--accent)] focus:border-[var(--accent)] outline-none">
                </div>
            </form>

            {{-- Mini stats --}}
            <div class="flex gap-3 shrink-0">
                @php
                    $totalLunas  = $payments->getCollection()->where('status','selesai')->count();
                    $totalProses = $payments->getCollection()->where('status','dikemas')->count();
                    $totalBatal  = $payments->getCollection()->where('status','dibatalkan')->count();
                @endphp
                <div class="flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 border border-emerald-100 rounded-xl">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full"></span>
                    <span class="text-[10px] font-bold text-emerald-700">{{ $totalLunas }} Lunas</span>
                </div>
                <div class="flex items-center gap-1.5 px-3 py-1.5 bg-yellow-50 border border-yellow-100 rounded-xl">
                    <span class="w-2 h-2 bg-yellow-400 rounded-full"></span>
                    <span class="text-[10px] font-bold text-yellow-700">{{ $totalProses }} Proses</span>
                </div>
                <div class="flex items-center gap-1.5 px-3 py-1.5 bg-red-50 border border-red-100 rounded-xl">
                    <span class="w-2 h-2 bg-red-400 rounded-full"></span>
                    <span class="text-[10px] font-bold text-red-700">{{ $totalBatal }} Batal</span>
                </div>
            </div>
        </div>

        {{-- ── TABLE ───────────────────────────────────────── --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[900px]">
                <thead class="bg-[var(--greenlt)] text-[var(--green)] text-[10px] font-bold tracking-widest uppercase border-b border-[#dbeee4]">
                    <tr>
                        <th class="px-5 py-3.5">ID Pesanan</th>
                        <th class="px-5 py-3.5">Pelanggan</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                        <th class="px-5 py-3.5 text-right">Total Bayar</th>
                        <th class="px-5 py-3.5">Tanggal</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f0f7f3]">

                    @forelse($payments as $pesanan)
                    @php
                        $statusMap = [
                            'dikemas'    => ['label' => 'Proses',     'badge' => 'badge-proses',  'color' => 'orange'],
                            'selesai'    => ['label' => 'Lunas',      'badge' => 'badge-lunas',   'color' => 'emerald'],
                            'dibatalkan' => ['label' => 'Dibatalkan', 'badge' => 'badge-batal',   'color' => 'red'],
                        ];
                        $st = $statusMap[$pesanan->status] ?? ['label' => ucfirst($pesanan->status), 'badge' => 'badge-default', 'color' => 'gray'];

                        $allOrderItems = \App\Models\Pesanan::where('order_id', $pesanan->order_id)->get();
                        $totalBayar    = $allOrderItems->sum('total_harga')
                                       + $allOrderItems->first()->biaya_pengiriman
                                       + $allOrderItems->first()->biaya_layanan;

                        $namaUser = $pesanan->user->name ?? 'Pelanggan';
                        $parts    = explode(' ', $namaUser);
                        $inisial  = strtoupper(substr($parts[0],0,1).(isset($parts[1])?substr($parts[1],0,1):''));

                        $orderItems = $allOrderItems->map(fn($o) => [
                            'nama'     => $o->product->name     ?? 'Produk',
                            'kategori' => $o->product->Kategori_data ?? 'Lainnya',
                        ]);
                    @endphp

                    <tr class="pay-row">
                        {{-- ID --}}
                        <td class="px-5 py-3.5">
                            <span class="text-xs font-bold text-[var(--green)] font-mono tracking-tight">
                                {{ $pesanan->order_id }}
                            </span>
                        </td>

                        {{-- Pelanggan --}}
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-[var(--greenlt)] flex items-center justify-center
                                            text-[10px] font-bold text-[var(--green)] shrink-0">
                                    {{ $inisial }}
                                </div>
                                <span class="text-xs text-gray-700 font-medium truncate max-w-[120px]">{{ $namaUser }}</span>
                            </div>
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-3.5 text-center">
                            <span class="badge {{ $st['badge'] }}">{{ $st['label'] }}</span>
                        </td>

                        {{-- Total --}}
                        <td class="px-5 py-3.5 text-right">
                            <span class="text-xs font-black text-[var(--green)]">
                                Rp {{ number_format($totalBayar, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-5 py-3.5">
                            <div class="text-[11px] text-gray-500">
                                {{ $pesanan->created_at->format('d M Y') }}
                                <span class="text-gray-400 ml-1">{{ $pesanan->created_at->format('H:i') }}</span>
                            </div>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-5 py-3.5 text-center">
                            <button
                                @click="selectedData = {
                                    id:          '{{ $pesanan->order_id }}',
                                    nama:        '{{ addslashes($namaUser) }}',
                                    email:       '{{ $pesanan->user->email ?? '' }}',
                                    inisial:     '{{ $inisial }}',
                                    status:      '{{ $st['label'] }}',
                                    statusColor: '{{ $st['color'] }}',
                                    metode:      'QRIS / Transfer',
                                    total:       'Rp {{ number_format($totalBayar, 0, ',', '.') }}',
                                    mulai:       '{{ $pesanan->start_date ? \Carbon\Carbon::parse($pesanan->start_date)->format('d M Y') : '-' }}',
                                    selesai:     '{{ $pesanan->end_date   ? \Carbon\Carbon::parse($pesanan->end_date)->format('d M Y')   : '-' }}',
                                    noHp:        '{{ $pesanan->pelanggan_telepon   ?? '-' }}',
                                    alamat:      '{{ addslashes($pesanan->alamat_pelanggan ?? '-') }}',
                                    items:       {{ json_encode($orderItems->values()) }}
                                }; openDetail = true"
                                class="px-3.5 py-1.5 bg-[var(--green)] hover:bg-[var(--green2)] text-white
                                       text-[10px] font-bold rounded-lg transition-all active:scale-95 shadow-sm">
                                Detail
                            </button>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-2xl bg-[var(--greenlt)] flex items-center justify-center">
                                    <svg class="w-7 h-7 text-[var(--green)] opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-400">Belum ada transaksi pembayaran</p>
                                <p class="text-xs text-gray-300">Transaksi akan muncul setelah pelanggan melakukan pembayaran</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- ── PAGINATION ───────────────────────────────────── --}}
        <div class="px-6 py-4 bg-[#fcfdfb] border-t border-[var(--greenlt)]
                    flex flex-col sm:flex-row justify-between items-center gap-3
                    text-[10px] font-bold text-gray-400 uppercase">
            <span>Menampilkan {{ $payments->firstItem() ?? 0 }}–{{ $payments->lastItem() ?? 0 }} dari {{ $payments->total() }} transaksi</span>
            <div class="flex gap-1.5 items-center">
                @if($payments->onFirstPage())
                    <button disabled class="w-8 h-8 border rounded-lg text-gray-300 cursor-not-allowed text-sm">‹</button>
                @else
                    <a href="{{ $payments->previousPageUrl() }}"
                       class="w-8 h-8 border rounded-lg hover:bg-[var(--greenlt)] flex items-center justify-center text-sm transition-colors">‹</a>
                @endif

                @foreach($payments->getUrlRange(1, $payments->lastPage()) as $page => $url)
                    @if($page == $payments->currentPage())
                        <button class="w-8 h-8 bg-[var(--green)] text-white rounded-lg shadow text-xs">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}"
                           class="w-8 h-8 border rounded-lg hover:bg-[var(--greenlt)] flex items-center justify-center text-xs text-gray-600 transition-colors">{{ $page }}</a>
                    @endif
                @endforeach

                @if($payments->hasMorePages())
                    <a href="{{ $payments->nextPageUrl() }}"
                       class="w-8 h-8 border rounded-lg hover:bg-[var(--greenlt)] flex items-center justify-center text-sm transition-colors">›</a>
                @else
                    <button disabled class="w-8 h-8 border rounded-lg text-gray-300 cursor-not-allowed text-sm">›</button>
                @endif
            </div>
        </div>

    </div>{{-- /card --}}

    {{-- ── MODAL DETAIL ─────────────────────────────────── --}}
    <div x-show="openDetail"
         x-transition:enter="transition ease-out duration-250"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[999] flex items-end sm:items-center justify-center p-4 bg-black/30 backdrop-blur-sm"
         x-cloak>

        <div @click.away="openDetail = false"
             x-transition:enter="transition ease-out duration-250"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="modal-card bg-white w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden border border-gray-100">

            {{-- Modal Header --}}
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-[var(--greenlt)]">
                <div>
                    <h2 class="font-display text-base text-[var(--green)]">Detail Transaksi</h2>
                    <p class="text-[11px] text-gray-500 mt-0.5 font-mono" x-text="selectedData.id"></p>
                </div>
                <button @click="openDetail = false"
                        class="w-7 h-7 rounded-lg bg-white/60 hover:bg-white flex items-center justify-center text-gray-400 hover:text-gray-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="px-5 py-4 flex flex-col gap-4 max-h-[65vh] overflow-y-auto">

                {{-- Pelanggan --}}
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-[var(--greenlt)] flex items-center justify-center
                                text-sm font-bold text-[var(--green)] shrink-0"
                         x-text="selectedData.inisial"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800" x-text="selectedData.nama"></p>
                        <p class="text-[11px] text-gray-400 truncate" x-text="selectedData.email"></p>
                    </div>
                    <span class="badge shrink-0"
                          :class="{
                              'badge-lunas':  selectedData.statusColor === 'emerald',
                              'badge-proses': selectedData.statusColor === 'orange',
                              'badge-batal':  selectedData.statusColor === 'red',
                              'badge-default': !['emerald','orange','red'].includes(selectedData.statusColor)
                          }"
                          x-text="selectedData.status"></span>
                </div>

                {{-- Info Pembayaran --}}
                <div class="rounded-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-3 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                        Info Pembayaran
                    </div>
                    <table class="w-full text-sm">
                        <tr class="border-t border-gray-100">
                            <td class="px-3 py-2 text-gray-400 text-xs">Metode</td>
                            <td class="px-3 py-2 text-right text-gray-700 text-xs" x-text="selectedData.metode"></td>
                        </tr>
                        <tr class="border-t border-gray-100">
                            <td class="px-3 py-2 text-gray-400 text-xs">Total Bayar</td>
                            <td class="px-3 py-2 text-right font-bold text-[var(--green)] text-sm" x-text="selectedData.total"></td>
                        </tr>
                        <tr class="border-t border-gray-100">
                            <td class="px-3 py-2 text-gray-400 text-xs">No. HP</td>
                            <td class="px-3 py-2 text-right text-gray-700 text-xs" x-text="selectedData.noHp"></td>
                        </tr>
                        <tr class="border-t border-gray-100">
                            <td class="px-3 py-2 text-gray-400 text-xs align-top">Alamat</td>
                            <td class="px-3 py-2 text-right text-gray-600 text-xs" x-text="selectedData.alamat"></td>
                        </tr>
                    </table>
                </div>

                {{-- Unit Disewa --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Unit Disewa</span>
                        <span class="text-[10px] font-bold bg-[var(--greenlt)] text-[var(--green)] px-2 py-0.5 rounded-full"
                              x-text="(selectedData.items ? selectedData.items.length : 0) + ' item'"></span>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <template x-for="item in selectedData.items" :key="item.nama">
                            <div class="flex items-center justify-between px-3 py-2 border border-gray-100 rounded-xl hover:border-[var(--border)] transition-colors">
                                <span class="text-xs text-gray-700 font-medium" x-text="item.nama"></span>
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-[var(--greenlt)] text-[var(--green)] font-medium"
                                      x-text="item.kategori"></span>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Tanggal Sewa --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="p-3 bg-emerald-50 border border-emerald-100 rounded-xl">
                        <p class="text-[9px] font-bold text-emerald-500 uppercase tracking-wider mb-1">Mulai Sewa</p>
                        <p class="text-xs font-bold text-emerald-700" x-text="selectedData.mulai"></p>
                    </div>
                    <div class="p-3 bg-orange-50 border border-orange-100 rounded-xl">
                        <p class="text-[9px] font-bold text-orange-400 uppercase tracking-wider mb-1">Selesai Sewa</p>
                        <p class="text-xs font-bold text-orange-600" x-text="selectedData.selesai"></p>
                    </div>
                </div>

            </div>

            {{-- Modal Footer --}}
            <div class="px-5 py-3 border-t border-gray-100">
                <button @click="openDetail = false"
                        class="w-full py-2 text-xs text-gray-400 hover:text-gray-600 font-semibold rounded-xl
                               hover:bg-gray-50 transition-all">
                    Tutup
                </button>
            </div>

        </div>
    </div>

</div>
@endsection