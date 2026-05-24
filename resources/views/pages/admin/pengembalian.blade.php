@extends('layouts.admin')

@section('title', 'Pengembalian - CampLore')

@section('content')

<div class="mb-6">
    @include('components.navbar_judul_LP', [
    'NavParent' => 'Manajemen Operasional',
    'section' => 'Pengembalian'
    ])
</div>

<div class="max-w-full">

    {{-- ══════════ STAT CARDS ══════════ --}}
    @php
    $col = collect($data_pengembalian);
    $totalAktif = $col->count();
    $perluKembali = $col->filter(fn($i) => !empty($i->tanggal_kembali) && \Carbon\Carbon::parse($i->tanggal_kembali)->isToday())->count();
    $perpanjangan = $col->filter(fn($i) => !empty($i->minta_perpanjangan))->count();
    $terlambat = $col->filter(fn($i) => !empty($i->tanggal_kembali) && \Carbon\Carbon::now()->startOfDay()->gt(\Carbon\Carbon::parse($i->tanggal_kembali)))->count();
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Sewa Aktif</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalAktif }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Perlu Kembali Hari Ini</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $perluKembali }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Permintaan Perpanjangan</p>
            <div class="flex items-center gap-2 mt-1">
                <p class="text-3xl font-bold text-gray-900">{{ $perpanjangan }}</p>
                @if($perpanjangan > 0)
                <span class="px-2 py-0.5 text-xs font-bold text-red-600 bg-red-50 rounded">URGENT</span>
                @endif
            </div>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Terlambat</p>
            <p class="text-3xl font-bold text-red-500 mt-1">{{ $terlambat }}</p>
        </div>
    </div>

    {{-- ══════════ KONTAINER UTAMA (HEADER, SEARCH & TABLE MENYATU) ══════════ --}}
    <div class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">

        <div class="p-6 pb-0">
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Pengembalian</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau dan kelola permintaan pengembalian serta perpanjangan sewa.</p>
        </div>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-6 bg-white">
            <div class="flex flex-wrap items-center gap-4 w-full md:w-auto">
                <div class="relative w-full sm:w-72">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                        </svg>
                    </div>
                    <input type="text" id="searchInput" placeholder="Cari nama atau produk..."
                        class="w-full pl-9 pr-4 py-2 text-sm bg-gray-50/50 border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-300 transition-all">
                </div>
            </div>

            <div class="flex items-center gap-2 self-end md:self-auto">
                <button type="button"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-100 transition-colors">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 6h18M7 12h10M11 18h2" />
                    </svg>
                    Filter
                </button>
                <button type="button"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-gray-900 border border-gray-900 rounded-xl hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 3v12" />
                    </svg>
                    Ekspor Data
                </button>
            </div>
        </div>

        {{-- Bagian Bawah: TABEL (Tanpa border luar ganda) --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-y border-gray-200">
                    <tr>
                        <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">Penyewa</th>
                        <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">ID Order</th>
                        <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">Tgl Pengembalian</th>
                        <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="tableBody">
                    @forelse($data_pengembalian as $item)
                    @php
                    $tglKembali = !empty($item->tanggal_kembali) ? \Carbon\Carbon::parse($item->tanggal_kembali) : null;
                    $today = \Carbon\Carbon::now()->startOfDay();
                    $isOverdue = $tglKembali && $today->timestamp > $tglKembali->timestamp;
                    $hariTerlambat = $isOverdue ? (int) floor(($today->timestamp - $tglKembali->timestamp) / 86400) : 0;
                    $totalDenda = $hariTerlambat * 50000;
                    $produkRelasi = $item->product ?? ($item->products[0] ?? null);
                    $kategori = $produkRelasi->kategori ?? '-';
                    $tipe = $produkRelasi->tipe ?? '-';
                    $merek = $produkRelasi->merek ?? $produkRelasi->brand ?? '-';
                    $tglFormatted = $tglKembali ? $tglKembali->format('d M Y') : '-';
                    $initial = strtoupper(substr($item->user->name ?? 'U', 0, 1));
                    $avatarBgs = ['bg-blue-100 text-blue-700','bg-pink-100 text-pink-700','bg-gray-100 text-gray-700','bg-green-100 text-green-700','bg-yellow-100 text-yellow-700'];
                    $avatarClass = $avatarBgs[$loop->index % count($avatarBgs)];
                    $products = collect($item->products ?? []);
                    $tglSewaFormatted = !empty($item->tanggal_sewa)
                    ? \Carbon\Carbon::parse($item->tanggal_sewa)->format('d M Y')
                    : (!empty($item->tgl_sewa) ? \Carbon\Carbon::parse($item->tgl_sewa)->format('d M Y') : '-');
                    $totalBiaya = $item->total_biaya ?? $item->total_harga ?? 0;
                    $depositVal = $item->deposit ?? $item->jaminan ?? 0;
                    $biayaLayanan = $item->biaya_layanan ?? $item->biaya_admin ?? 0;
                    $catatanInsp = $item->catatan_inspeksi ?? $item->catatan ?? '';
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors return-row">

                        {{-- Penyewa --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 {{ $avatarClass }}">
                                    {{ $initial }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 text-sm">{{ $item->user->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $item->user->email ?? $item->user->no_hp ?? '-' }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- ID Order --}}
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-gray-900">#{{ $item->id_pesanan }}</span>
                        </td>

                        {{-- Produk --}}
                        <td class="px-6 py-4">
                            @foreach($products->take(1) as $p)
                            <div class="text-sm font-semibold text-gray-900">{{ $p->name ?? $p['name'] ?? '-' }}</div>
                            @endforeach
                            @if($products->count() > 1)
                            <div class="text-xs text-gray-400 mt-0.5">+ {{ $products->count() - 1 }} item lainnya</div>
                            @endif
                        </td>

                        {{-- Tgl Pengembalian --}}
                        <td class="px-6 py-4">
                            @if($tglKembali)
                            <div class="text-sm font-semibold {{ $isOverdue ? 'text-red-500' : 'text-gray-700' }}">
                                {{ $tglFormatted }}
                            </div>
                            @if($isOverdue)
                            <div class="text-xs text-red-400 mt-0.5">Denda: Rp {{ number_format($totalDenda,0,',','.') }} ({{ $hariTerlambat }} hari)</div>
                            @endif
                            @if(!empty($item->minta_perpanjangan))
                            <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-bold text-yellow-800 bg-yellow-100 border border-yellow-200 rounded-full uppercase tracking-wider">Minta Perpanjangan</span>
                            @endif
                            @else
                            <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4">
                            @if($isOverdue)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold text-red-700 bg-red-50 border border-red-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Terlambat
                            </span>
                            @elseif(($item->status ?? '') === 'selesai')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold text-green-700 bg-green-50 border border-green-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Selesai
                            </span>
                            @ metals
                            @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>Disewa
                            </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            @if(!empty($item->minta_perpanjangan))
                            <button type="button"
                                onclick='bukaModalPerpanjang(
                                        @json($item->user->name),
                                        @json($item->id_pesanan),
                                        @json($item->durasi_awal ?? "3 Hari"),
                                        @json($item->tambahan_hari ?? 2),
                                        @json($item->biaya_per_hari ?? 200000),
                                        @json($tglFormatted)
                                    )'
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-gray-900 border border-gray-900 rounded-xl hover:bg-gray-800 transition-colors">
                                Perpanjang
                            </button>
                            @elseif($isOverdue)
                            <button type="button"
                                onclick='bukaModalDetail(
                                        @json($item->user->name),
                                        @json($item->user->email ?? $item->user->no_hp ?? "-"),
                                        @json($item->id_pesanan),
                                        @json($item->products),
                                        @json($merek),
                                        @json($kategori),
                                        @json($tipe),
                                        @json($tglFormatted),
                                        {{ $totalDenda }},
                                        {{ $hariTerlambat }},
                                        {{ $item->id }}
                                    )'
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                                Hubungi
                            </button>
                            @else
                            <button type="button"
                                onclick='bukaModalSelesai(
                                        @json($item->user->name),
                                        @json($item->user->email ?? $item->user->no_hp ?? "-"),
                                        @json($item->id_pesanan),
                                        @json($item->products),
                                        @json($tglFormatted),
                                        @json($tglSewaFormatted),
                                        {{ $totalBiaya }},
                                        {{ $depositVal }},
                                        {{ $biayaLayanan }},
                                        @json($catatanInsp)
                                    )'
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                                Detail
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-sm text-gray-400">Tidak ada data pengembalian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- TABLE FOOTER (PAGINATION) --}}
        <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-t border-gray-200">
            <p class="text-xs text-gray-400 font-medium">Menampilkan {{ $col->count() }} data pengembalian</p>
            <div class="flex items-center gap-1">
                <button class="w-8 h-8 flex items-center justify-center border border-gray-200 bg-white rounded-lg text-gray-400 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="w-8 h-8 flex items-center justify-center border border-gray-200 bg-white rounded-lg text-gray-400 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     MODAL: DETAIL PENGEMBALIAN (OVERDUE / HUBUNGI)
══════════════════════════════════════════════════════════ --}}
<div id="modalDetail" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-[99999] flex items-center justify-center bg-black/50 p-4">
    <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 sticky top-0 bg-white z-10">
            <div>
                <h3 class="text-sm font-bold text-gray-900">Detail Pengembalian</h3>
                <p class="text-xs text-gray-400 mt-0.5">Periksa detail sebelum konfirmasi</p>
            </div>
            <button onclick="tutupModalDetail()" type="button"
                class="w-7 h-7 flex items-center justify-center border border-gray-200 rounded-lg text-gray-500 hover:bg-gray-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Info Pemesan --}}
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Info Pemesan</p>
            <div class="flex items-center gap-3">
                <div id="mdAvatar" class="w-10 h-10 rounded-xl bg-green-100 text-green-700 flex items-center justify-center font-bold text-sm flex-shrink-0"></div>
                <div>
                    <div id="mdNama" class="text-sm font-bold text-gray-900"></div>
                    <div id="mdIdPesanan" class="text-xs text-gray-400 mt-0.5"></div>
                </div>
            </div>
        </div>

        {{-- Barang --}}
        <div class="px-6 py-4 border-b border-gray-100">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Barang Dipesan</p>
            <div id="mdBarangList" class="space-y-2"></div>
            <div class="flex items-center justify-between px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg mt-3">
                <span class="text-xs font-medium text-gray-500">Merek</span>
                <span id="mdMerek" class="text-xs font-bold text-gray-900"></span>
            </div>
        </div>

        {{-- Tanggal & Denda --}}
        <div class="px-6 py-4 border-b border-gray-100">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Tanggal & Denda</p>
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-green-50 border border-green-200 rounded-xl p-3.5 text-center">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1.5">Tgl Kembali</p>
                    <p id="mdTgl" class="text-sm font-bold text-green-700"></p>
                </div>
                <div id="mdDendaBox" class="bg-green-50 border border-green-200 rounded-xl p-3.5 text-center">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1.5">Denda</p>
                    <p id="mdDenda" class="text-sm font-bold text-green-600"></p>
                    <p id="mdDendaInfo" class="text-xs mt-1 text-green-400"></p>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex items-center gap-3 px-6 py-4 sticky bottom-0 bg-white border-t border-gray-100">
            <button onclick="tutupModalDetail()" type="button"
                class="flex-1 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50">
                Batal
            </button>
            <button onclick="konfirmasiKembali()" type="button"
                class="flex-[2] py-2.5 text-sm font-bold text-white bg-gray-900 rounded-xl hover:bg-gray-800">
                ✓ Konfirmasi Kembali
            </button>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     MODAL: PERPANJANG SEWA
══════════════════════════════════════════════════════════ --}}
<div id="modalPerpanjang" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-[99999] flex items-center justify-center bg-black/50 p-4">
    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-bold text-gray-900">Perpanjang Sewa</h3>
            <button onclick="tutupModalPerpanjang()" type="button"
                class="w-7 h-7 flex items-center justify-center border border-gray-200 rounded-lg text-gray-500 hover:bg-gray-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- User --}}
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3">
                <div id="mpAvatar" class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm flex-shrink-0"></div>
                <div>
                    <div id="mpNama" class="text-sm font-semibold text-gray-900"></div>
                    <div class="text-xs text-gray-400">Meminta perpanjangan durasi</div>
                </div>
            </div>
        </div>

        {{-- Detail --}}
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Durasi Sewa Awal</p>
                    <p id="mpDurasi" class="text-sm font-semibold text-gray-900"></p>
                </div>
                <div class="text-right">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Tambahan</p>
                    <p id="mpTambahan" class="text-sm font-bold text-green-600"></p>
                </div>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-4">
                <div class="flex justify-between text-xs text-gray-500 mb-2">
                    <span>Biaya Sewa / Hari</span>
                    <span id="mpBiayaPerHari"></span>
                </div>
                <div class="flex justify-between text-sm font-bold text-gray-900 pt-3 border-t border-gray-200">
                    <span>Total Biaya Tambahan</span>
                    <span id="mpTotalBiaya"></span>
                </div>
            </div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Jadwal Pengembalian Baru</p>
            <div class="flex items-center gap-2 bg-green-50 border border-green-200 rounded-xl px-4 py-3">
                <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span id="mpJadwalBaru" class="text-sm font-semibold text-gray-900"></span>
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex items-center gap-3 px-6 py-4">
            <button onclick="tolakPerpanjangan()" type="button"
                class="flex-1 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50">
                Tolak
            </button>
            <button onclick="setujuiPerpanjangan()" type="button"
                class="flex-[2] py-2.5 text-sm font-bold text-white bg-gray-900 rounded-xl hover:bg-gray-800">
                Setujui Perpanjangan
            </button>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     MODAL: DETAIL SELESAI (RECEIPT)
══════════════════════════════════════════════════════════ --}}
<div id="modalSelesai" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-[99999] flex items-center justify-center bg-black/50 p-4">
    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">

        {{-- Header --}}
        <div class="flex items-start justify-between px-6 py-4 border-b border-gray-100">
            <div>
                <p id="msIdTransaksi" class="text-xs text-gray-400 mb-2"></p>
                <div class="flex items-center gap-3">
                    <div id="msAvatar" class="w-9 h-9 rounded-full bg-gray-100 text-gray-700 flex items-center justify-center font-bold text-sm flex-shrink-0"></div>
                    <div>
                        <div id="msNama" class="text-sm font-semibold text-gray-900"></div>
                        <div id="msKontak" class="text-xs text-gray-400"></div>
                    </div>
                </div>
            </div>
            <div class="flex items-start gap-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold text-green-700 bg-green-100 border border-green-200">Selesai</span>
                <button onclick="tutupModalSelesai()" type="button"
                    class="w-7 h-7 flex items-center justify-center border border-gray-200 rounded-lg text-gray-500 hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Produk --}}
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-4 bg-gray-50 border border-gray-200 rounded-xl p-3 mb-4">
                <div class="w-14 h-14 rounded-xl bg-gray-900 text-white flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zM16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" />
                    </svg>
                </div>
                <div>
                    <div id="msProductName" class="text-sm font-semibold text-gray-900"></div>
                    <div class="flex gap-5 mt-1.5">
                        <div>
                            <div class="text-xs text-gray-400 uppercase tracking-wide">Tanggal Sewa</div>
                            <div id="msTglSewa" class="text-xs font-semibold text-gray-700 mt-0.5"></div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400 uppercase tracking-wide">Tanggal Kembali</div>
                            <div id="msTglKembali" class="text-xs font-semibold text-gray-700 mt-0.5"></div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Ringkasan Pembayaran</p>
            <div class="space-y-1.5">
                <div class="flex justify-between text-xs text-gray-500">
                    <span id="msBiayaSewa">Biaya Sewa</span>
                    <span id="msBiayaSewaVal"></span>
                </div>
                <div class="flex justify-between text-xs text-gray-500">
                    <span>Jaminan Kerusakan (Deposit)</span>
                    <span id="msDeposit"></span>
                </div>
                <div class="flex justify-between text-xs text-gray-500">
                    <span>Biaya Layanan</span>
                    <span id="msBiayaLayanan"></span>
                </div>
            </div>
            <div class="flex items-baseline justify-between pt-3 mt-3 border-t border-gray-100">
                <div>
                    <p class="text-sm font-bold text-gray-900">Total Akhir</p>
                    <p class="text-xs text-green-600 font-semibold">&#9679; Lunas</p>
                </div>
                <p id="msTotalAkhir" class="text-lg font-bold text-gray-900"></p>
            </div>
        </div>

        {{-- Catatan Inspeksi --}}
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-2 text-xs font-semibold text-gray-700 mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Catatan Inspeksi Pengembalian
                </div>
                <p id="msCatatanInspeksi" class="text-xs text-gray-500 italic leading-relaxed"></p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex items-center gap-3 px-6 py-4">
            <button onclick="cetakInvoice()" type="button"
                class="flex-1 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50">
                🖨 Cetak Invoice
            </button>
            <button onclick="tutupModalSelesai()" type="button"
                class="flex-[2] py-2.5 text-sm font-bold text-white bg-gray-900 rounded-xl hover:bg-gray-800">
                Selesai & Tutup
            </button>
        </div>
    </div>
</div>

<script>
    // ── Search ──────────────────────────────────────────────────
    document.getElementById('searchInput').addEventListener('input', function() {
        var q = this.value.toLowerCase();
        document.querySelectorAll('.return-row').forEach(function(row) {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });

    // ── Helpers ─────────────────────────────────────────────────
    var currentItemId = null;

    function formatRp(val) {
        return 'Rp ' + Number(val).toLocaleString('id-ID');
    }

    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    // Close on backdrop click
    ['modalDetail', 'modalPerpanjang', 'modalSelesai'].forEach(function(id) {
        document.getElementById(id).addEventListener('click', function(e) {
            if (e.target === this) closeModal(id);
        });
    });

    // ── MODAL DETAIL (OVERDUE) ───────────────────────────────────
    function bukaModalDetail(nama, kontak, idPesanan, produk, merek, kategori, tipe, tglKembali, denda, hariTerlambat, itemId) {
        currentItemId = itemId;
        document.getElementById('mdAvatar').textContent = nama.charAt(0).toUpperCase();
        document.getElementById('mdNama').textContent = nama;
        document.getElementById('mdIdPesanan').textContent = 'ID Pesanan: ' + idPesanan;
        document.getElementById('mdMerek').textContent = merek;
        document.getElementById('mdTgl').textContent = tglKembali;

        var html = '';
        if (Array.isArray(produk)) {
            produk.forEach(function(p) {
                html += '<div class="flex items-center justify-between px-3 py-2.5 bg-pink-50 border border-pink-200 rounded-xl">' +
                    '<span class="text-sm font-semibold text-gray-900">' + (p.name || p.nama || '-') + '</span>' +
                    '<div class="flex gap-1.5">' +
                    '<span class="px-2 py-0.5 text-xs font-bold bg-pink-100 text-pink-700 rounded-full">' + (p.kategori || kategori) + '</span>' +
                    '<span class="px-2 py-0.5 text-xs font-bold bg-gray-100 text-gray-500 rounded-full">' + (p.tipe || tipe) + '</span>' +
                    '</div></div>';
            });
        } else {
            html = '<div class="px-3 py-2.5 bg-pink-50 border border-pink-200 rounded-xl text-sm font-semibold text-gray-900">' + produk + '</div>';
        }
        document.getElementById('mdBarangList').innerHTML = html;

        var box = document.getElementById('mdDendaBox');
        var val = document.getElementById('mdDenda');
        var info = document.getElementById('mdDendaInfo');
        if (denda > 0) {
            box.className = 'bg-red-50 border border-red-200 rounded-xl p-3.5 text-center';
            val.className = 'text-sm font-bold text-red-600';
            val.textContent = formatRp(denda);
            info.className = 'text-xs mt-1 text-red-400';
            info.textContent = hariTerlambat + ' hari × Rp 50.000';
        } else {
            box.className = 'bg-green-50 border border-green-200 rounded-xl p-3.5 text-center';
            val.className = 'text-sm font-bold text-green-600';
            val.textContent = 'Tidak Ada Denda';
            info.className = 'text-xs mt-1 text-green-400';
            info.textContent = 'Tepat waktu ✓';
        }
        openModal('modalDetail');
    }

    function tutupModalDetail() {
        closeModal('modalDetail');
    }

    function konfirmasiKembali() {
        if (!currentItemId) return;
        fetch('/admin/pengembalian/' + currentItemId + '/konfirmasi', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(function(res) {
                return res.json();
            })
            .then(function(data) {
                tutupModalDetail();
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Terjadi kesalahan.');
                }
            })
            .catch(function() {
                alert('Gagal menghubungi server.');
            });
    }

    // ── MODAL PERPANJANG ─────────────────────────────────────────
    function bukaModalPerpanjang(nama, idPesanan, durasiAwal, tambahanHari, biayaPerHari, tglKembali) {
        document.getElementById('mpAvatar').textContent = nama.charAt(0).toUpperCase();
        document.getElementById('mpNama').textContent = nama;
        document.getElementById('mpDurasi').textContent = durasiAwal;
        document.getElementById('mpTambahan').textContent = '+ ' + tambahanHari + ' Hari';
        document.getElementById('mpBiayaPerHari').textContent = formatRp(biayaPerHari);
        document.getElementById('mpTotalBiaya').textContent = formatRp(tambahanHari * biayaPerHari);
        document.getElementById('mpJadwalBaru').textContent = tglKembali + ' — 10:00 WIB';
        openModal('modalPerpanjang');
    }

    function tutupModalPerpanjang() {
        closeModal('modalPerpanjang');
    }

    function setujuiPerpanjangan() {
        alert('Perpanjangan disetujui!');
        tutupModalPerpanjang();
    }

    function tolakPerpanjangan() {
        tutupModalPerpanjang();
    }

    // ── MODAL SELESAI (RECEIPT) ──────────────────────────────────
    function bukaModalSelesai(nama, kontak, idPesanan, produk, tglKembali, tglSewa, totalBiaya, deposit, biayaLayanan, catatanInspeksi) {
        document.getElementById('msAvatar').textContent = nama.charAt(0).toUpperCase();
        document.getElementById('msNama').textContent = nama;
        document.getElementById('msKontak').textContent = kontak;
        document.getElementById('msIdTransaksi').textContent = 'ID Transaksi: #RTN-' + idPesanan;

        var produkNama = Array.isArray(produk) ? (produk[0] ? (produk[0].name || produk[0].nama || '-') : '-') : produk;
        document.getElementById('msProductName').textContent = produkNama;
        document.getElementById('msTglSewa').textContent = tglSewa;
        document.getElementById('msTglKembali').textContent = tglKembali;

        var biayaSewa = totalBiaya - deposit - biayaLayanan;
        document.getElementById('msBiayaSewaVal').textContent = formatRp(biayaSewa);
        document.getElementById('msDeposit').textContent = formatRp(deposit);
        document.getElementById('msBiayaLayanan').textContent = formatRp(biayaLayanan);
        document.getElementById('msTotalAkhir').textContent = formatRp(totalBiaya);
        document.getElementById('msCatatanInspeksi').textContent = catatanInspeksi ? '"' + catatanInspeksi + '"' : '"Tidak ada catatan inspeksi."';

        openModal('modalSelesai');
    }

    function tutupModalSelesai() {
        closeModal('modalSelesai');
    }

    function cetakInvoice() {
        window.print();
    }
</script>

@endsection