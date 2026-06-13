@extends('layouts.admin')

@section('title', 'Pengiriman - Camplore Admin')

@php
    $NavParent = 'Manajemen Operasional';
    $section = 'Pengiriman';
@endphp

@section('content')

<div class="max-w-full">

    {{-- ═══════════════ STAT CARDS ═══════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Total Request</p>
                <p class="text-3xl font-bold text-gray-900 leading-tight">{{ $stats['total'] ?? 0 }}</p>
                <p class="text-[11px] text-emerald-500 font-semibold mt-0.5">↑ +5% hari ini</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Sedang Diantar</p>
                <p class="text-3xl font-bold text-gray-900 leading-tight">{{ $stats['diantar'] ?? 0 }}</p>
                <p class="text-[11px] text-gray-400 font-semibold mt-0.5">⊙ Proses antar</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Total Pickup</p>
                <p class="text-3xl font-bold text-gray-900 leading-tight">{{ $stats['pickup'] ?? 0 }}</p>
                <p class="text-[11px] text-gray-400 font-semibold mt-0.5">⊙ Siap diambil hari ini</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Selesai Hari Ini</p>
                <p class="text-3xl font-bold text-gray-900 leading-tight">{{ $stats['selesai'] ?? 0 }}</p>
                <p class="text-[11px] text-gray-400 font-semibold mt-0.5">⊙ Tuntas dikirim/diambil</p>
            </div>
        </div>
    </div>

    {{-- ═══════════════ TABLE CARD ═══════════════ --}}
    <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-sm overflow-hidden">

        {{-- HEADER + TABS --}}
        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#f3f4f6]">
            <div class="flex items-center gap-3 flex-wrap">
                <h2 class="text-lg font-bold text-gray-900">Daftar Pengantaran Aktif</h2>
                <div class="flex items-center bg-gray-100 rounded-lg p-1 gap-1">
                    <button id="tab-semua"   onclick="switchTab('semua')"   class="tab-btn active-tab px-4 py-1.5 rounded-md text-xs font-bold transition-all duration-200">Semua</button>
                    <button id="tab-dikirim" onclick="switchTab('dikirim')" class="tab-btn inactive-tab px-4 py-1.5 rounded-md text-xs font-bold transition-all duration-200">Perlu Diantar</button>
                    <button id="tab-pickup"  onclick="switchTab('pickup')"  class="tab-btn inactive-tab px-4 py-1.5 rounded-md text-xs font-bold transition-all duration-200">Ambil di Toko</button>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button class="flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M7 8h10M11 12h2M9 16h6" />
                    </svg>
                    Filter
                </button>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-[#f3f4f6]">
                    <tr class="text-[11px] font-bold uppercase tracking-widest text-gray-400">
                        <th class="px-6 py-3">ID Pesanan</th>
                        <th class="px-6 py-3">Metode</th>
                        <th class="px-6 py-3 col-alamat">Tujuan Lokasi</th>
                        <th class="px-6 py-3">Penerima</th>
                        <th class="px-6 py-3">No. HP</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f3f4f6]">

                    @forelse($pengiriman as $item)
                    @php
                        $status        = $item['status'] ?? 'proses';
                        $idPesanan     = $item['id_pesanan'] ?? '-';
                        $alamat        = $item['alamat'] ?? '-';
                        $metode        = $item['metode_pengiriman'] ?? 'delivery';
                        $isPickup      = $metode === 'pickup';
                    @endphp

                    <tr class="hover:bg-gray-50 transition-colors delivery-row"
                        data-metode="{{ $metode }}">

                        {{-- ID --}}
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-900 text-sm">#{{ $idPesanan }}</span>
                        </td>

                        {{-- Metode --}}
                        <td class="px-6 py-4">
                            @if($isPickup)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    PICKUP
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                    KURIR
                                </span>
                            @endif
                        </td>

                        {{-- Alamat (hanya relevan untuk delivery) --}}
                        <td class="px-6 py-4 col-alamat">
                            @if($isPickup)
                                <span class="text-gray-400 text-xs italic">Ambil di toko</span>
                            @else
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="font-semibold text-gray-800 text-sm">{{ $alamat }}</span>
                                </div>
                            @endif
                        </td>

                        {{-- Penerima --}}
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-700 font-medium">{{ $item['pemesan'] ?? '-' }}</span>
                        </td>

                        {{-- No HP --}}
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-500">{{ $item['no_hp'] ?? '-' }}</span>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4">
                            @if($status === 'proses')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span>
                                    {{ $isPickup ? 'Menunggu Diambil' : 'Menunggu Pengantaran' }}
                                </span>
                            @elseif($status === 'dikirim')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 inline-block animate-pulse"></span>Sedang Diantar
                                </span>
                            @elseif($status === 'tiba')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ $isPickup ? 'Sudah Diambil' : 'Selesai' }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-500">
                                    {{ ucfirst($status) }}
                                </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.pengiriman.detail', $idPesanan) }}"
                                class="text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">
                                {{ in_array($status, ['tiba', 'pengembalian']) ? 'Detail' : 'Lacak' }}
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12" />
                                </svg>
                                <p class="text-gray-400 text-sm font-medium">Belum ada data pengiriman.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- FOOTER --}}
        <div class="px-6 py-4 bg-white border-t border-[#f3f4f6] flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-[11px] text-gray-400" id="row-count">Menampilkan semua data</p>
            <div class="flex items-center gap-1">
                <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-900 text-white text-xs font-bold">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>

<style>
    .active-tab   { background: #111827; color: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.15); }
    .inactive-tab { background: transparent; color: #6b7280; }
    .inactive-tab:hover { color: #374151; }
</style>

<script>
function switchTab(tab) {
    // Update tombol
    ['semua', 'dikirim', 'pickup'].forEach(function(t) {
        var btn = document.getElementById('tab-' + t);
        btn.className = 'tab-btn ' + (t === tab ? 'active-tab' : 'inactive-tab') + ' px-4 py-1.5 rounded-md text-xs font-bold transition-all duration-200';
    });

    // Filter baris
    var rows = document.querySelectorAll('.delivery-row');
    var visible = 0;
    rows.forEach(function(row) {
        var metode = row.getAttribute('data-metode');
        var show = tab === 'semua'
            || (tab === 'dikirim' && metode === 'delivery')
            || (tab === 'pickup'  && metode === 'pickup');
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    // Update counter
    var label = tab === 'semua'   ? 'Menampilkan semua data'
              : tab === 'dikirim' ? 'Menampilkan: Perlu Diantar (' + visible + ')'
              : 'Menampilkan: Ambil di Toko (' + visible + ')';
    document.getElementById('row-count').textContent = label;
}
</script>

@endsection