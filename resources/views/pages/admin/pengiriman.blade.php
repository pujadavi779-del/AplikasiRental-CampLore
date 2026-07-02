@extends('layouts.admin')

@section('title', 'Pengiriman - Camplore Admin')

@php
 $NavParent = 'Manajemen Operasional';
 $section = 'Pengiriman';
 
 // Urutkan data: pengembalian di bawah, lainnya di atas
 $pengirimanSorted = collect($pengiriman)->sortBy(function($item) {
     $status = $item['status'] ?? '';
     // Pengembalian paling bawah (nilai 1), lainnya di atas (nilai 0)
     return $status === 'pengembalian' ? 1 : 0;
 })->values()->all();
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
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Total Permintaan</p>
                <p class="text-3xl font-bold text-gray-900 leading-tight">{{ $stats['total'] ?? 0 }}</p>
                @php
                    $totalKemarin = $stats['total_kemarin'] ?? 0;
                    $totalHariIni = $stats['total'] ?? 0;
                    
                    if ($totalKemarin > 0) {
                        $persenPerubahan = round((($totalHariIni - $totalKemarin) / $totalKemarin) * 100, 1);
                    } elseif ($totalHariIni > 0) {
                        $persenPerubahan = 100;
                    } else {
                        $persenPerubahan = 0;
                    }
                @endphp
                <p class="text-[11px] font-semibold mt-0.5 {{ $persenPerubahan > 0 ? 'text-emerald-500' : ($persenPerubahan < 0 ? 'text-red-500' : 'text-gray-400') }}">
                    @if($persenPerubahan > 0)
                        ↑ +{{ $persenPerubahan }}% hari ini
                    @elseif($persenPerubahan < 0)
                        ↓ {{ $persenPerubahan }}% hari ini
                    @else
                        — Tidak ada perubahan hari ini
                    @endif
                </p>
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
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Total Ambil di Toko</p>
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
                    @foreach(['semua' => 'Semua', 'delivery' => 'Perlu Diantar', 'pickup' => 'Ambil di Toko'] as $val => $label)
                    <a href="{{ request()->fullUrlWithQuery(['metode' => $val, 'status' => $status]) }}"
                        class="px-4 py-1.5 rounded-md text-xs font-bold transition-all duration-200
                  {{ $metode === $val ? 'bg-gray-900 text-white' : 'text-gray-500 hover:text-gray-700' }}">
                        {{ $label }}
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="flex items-center gap-2">

                {{-- FILTER DROPDOWN --}}
                <details class="relative">
                    <summary class="flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer list-none transition-colors
                    {{ $status !== 'semua' ? 'border-blue-300 text-blue-600' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M7 8h10M11 12h2M9 16h6" />
                        </svg>
                        Filter {{ $status !== 'semua' ? '·' : '' }}
                    </summary>

                    <div class="absolute right-0 mt-1.5 w-52 bg-white border border-gray-200 rounded-xl shadow-lg z-50 overflow-hidden">
                        <p class="px-3 pt-2.5 pb-1 text-[10px] font-bold uppercase tracking-widest text-gray-400">Status</p>
                        <div class="border-t border-gray-100 py-1">
                            @foreach([
                            'semua' => ['label' => 'Semua status', 'dot' => 'gray'],
                            'dikemas' => ['label' => 'Menunggu', 'dot' => 'amber'],
                            'jalan' => ['label' => 'Sedang Diantar', 'dot' => 'blue'],
                            'pengembalian' => ['label' => 'Pengembalian', 'dot' => 'emerald'],
                            ] as $val => $opt)
                            <a href="{{ request()->fullUrlWithQuery(['status' => $val, 'metode' => $metode]) }}"
                                class="flex items-center gap-2.5 px-3.5 py-2 text-[13px] transition-colors
                          {{ $status === $val ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <span class="w-2 h-2 rounded-full bg-{{ $opt['dot'] }}-400 flex-shrink-0"></span>
                                {{ $opt['label'] }}
                                @if($status === $val)
                                <svg class="w-3.5 h-3.5 ml-auto" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                @endif
                            </a>
                            @endforeach
                        </div>
                    </div>
                </details>
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

                    @forelse($pengirimanSorted as $item)
                    @php
                    $statusItem = $item['status'] ?? 'proses';
                    $idPesanan = $item['id_pesanan'] ?? '-';
                    $alamat = $item['alamat'] ?? '-';
                    $metodeItem = $item['metode_pengiriman'] ?? 'delivery';
                    $isPickup = $metodeItem === 'pickup';
                    @endphp

                    <tr class="hover:bg-gray-50 transition-colors delivery-row {{ $statusItem === 'pengembalian' ? 'opacity-70' : '' }}"
                        data-metode="{{ $metodeItem }}">

                        {{-- ID --}}
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-900 text-sm">#{{ $idPesanan }}</span>
                        </td>

                        {{-- Metode --}}
                        <td class="px-6 py-4">
                            @if($isPickup)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                AMBIL DI TOKO
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                KURIR
                            </span>
                            @endif
                        </td>

                        {{-- Alamat --}}
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
                            <span class="text-sm text-gray-500">{{ $item['no_tlp'] ?? '-' }}</span>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4">
                            @if($statusItem === 'pengembalian')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block"></span>
                                Pengembalian
                            </span>
                            @elseif($statusItem === 'dikemas' || $statusItem === 'proses')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700">
                                <span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span>
                                Menunggu
                            </span>
                            @elseif($statusItem === 'jalan' || $statusItem === 'dikirim')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-600">
                                <span class="w-2 h-2 rounded-full bg-blue-400 inline-block animate-pulse"></span>
                                Sedang Diantar
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-500">
                                <span class="w-2 h-2 rounded-full bg-gray-400 inline-block"></span>
                                {{ ucfirst($statusItem) }}
                            </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.pengiriman.detail', $idPesanan) }}"
                                class="text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">
                                {{ $statusItem === 'pengembalian' ? 'Detail' : 'Lacak' }}
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

@endsection