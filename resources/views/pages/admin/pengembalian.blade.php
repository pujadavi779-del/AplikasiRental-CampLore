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
    <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

        {{-- HEADER --}}
        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#eef4f0]">
            <div>
                <h2 class="text-2xl font-bold text-[#22543D] font-serif leading-tight">Pengembalian</h2>
                <p class="text-[11px] text-[#7c8b84] mt-0.5">Pantau status pengembalian barang dan denda pelanggan.</p>
            </div>
        </div>

        {{-- SEARCH --}}
        <div class="px-6 py-4 border-b border-[#eef4f0]">
            <div class="relative max-w-xs">
                <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                </div>
                <input type="text" id="searchInput" placeholder="Cari nama atau produk..."
                    class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl bg-gray-50 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D]">
            </div>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#f1f8f4] text-[10px] font-bold uppercase tracking-widest text-[#22543D] border-b border-[#eef4f0]">
                    <tr>
                        <th class="px-6 py-3">Pemesan</th>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">Merek</th>
                        <th class="px-6 py-3">Kategori & Tipe</th>
                        <th class="px-6 py-3 text-center">Tgl Kembali</th>
                        <th class="px-6 py-3 text-center">Denda</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#eef4f0]" id="tableBody">
                    @forelse($data_pengembalian as $item)
                    @php
                    $tglKembali    = $item->tanggal_kembali
                        ? \Carbon\Carbon::parse($item->tanggal_kembali)
                        : null;
                    $today         = \Carbon\Carbon::now()->startOfDay();
                    $isOverdue     = $tglKembali && $today->timestamp > $tglKembali->timestamp;
                    $hariTerlambat = $isOverdue ? (int) floor(($today->timestamp - $tglKembali->timestamp) / 86400) : 0;
                    $dendaPerHari  = 50000;
                    $totalDenda    = $hariTerlambat * $dendaPerHari;
                    $kategori      = $item->product->kategori ?? 'Kamera';
                    $tipe          = $item->product->tipe ?? '-';
                    $merek         = $item->product->merek ?? $item->product->brand ?? '-';
                    $tglFormatted  = $tglKembali ? $tglKembali->format('d M Y') : '-';
                    @endphp
                    <tr class="hover:bg-[#fcfdfb] transition-colors return-row">

                    

                        {{-- Pemesan --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#22543D]/10 flex items-center justify-center text-[#22543D] font-bold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800 text-sm">{{ $item->user->name }}</div>
                                    <div class="text-[10px] text-gray-400">{{ $item->user->no_hp ?? '-' }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Produk --}}
                        <td class="px-6 py-4">
                            @foreach($item->products as $prod)
                                <div class="font-semibold text-gray-800 text-sm">{{ $prod->name }}</div>
                            @endforeach
                            <div class="text-[10px] text-gray-400 mt-0.5">{{ $item->id_pesanan }}</div>
                        </td>

                        {{-- Merek --}}
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-gray-600">{{ $merek }}</span>
                        </td>

                        {{-- Kategori & Tipe --}}
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase w-fit
                                    {{ $kategori === 'Kamera' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700' }}">
                                    {{ $kategori }}
                                </span>
                                <span class="text-[10px] text-gray-400">{{ $tipe }}</span>
                            </div>
                        </td>

                        {{-- Tgl Kembali --}}
                        <td class="px-6 py-4 text-center">
                            @if($tglKembali)
                                <div class="text-sm font-semibold {{ $isOverdue ? 'text-red-600' : 'text-gray-700' }}">
                                    {{ $tglFormatted }}
                                </div>
                                @if($isOverdue)
                                    <div class="text-[10px] font-bold text-red-500 mt-0.5">{{ $hariTerlambat }} hari terlambat</div>
                                @endif
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>

                        {{-- Denda --}}
                        <td class="px-6 py-4 text-center">
                            @if($isOverdue)
                                <div class="font-bold text-red-600 text-sm">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
                                <div class="text-[10px] text-red-400 mt-0.5">{{ $hariTerlambat }}× Rp 50.000</div>
                            @else
                                <span class="text-gray-300 text-sm font-bold">—</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4 text-center">
                            @if($isOverdue)
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-red-100 text-red-600 border border-red-200">Overdue</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-amber-50 text-amber-600 border border-amber-200">Proses</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4 text-center">
                            <button type="button"
                                onclick='bukaModalKembali(
                                    @json($item->user->name),
                                    @json($item->products),
                                    @json($merek),
                                    @json($kategori),
                                    @json($tipe),
                                    @json($tglFormatted),
                                    {{ $totalDenda }},
                                    {{ $hariTerlambat }},
                                    {{ $item->id }},
                                    @json($item->id_pesanan)
                                )'
                                class="px-3 py-1.5 rounded-lg bg-[#22543D]/10 hover:bg-[#22543D]/20 text-[#22543D] text-[10px] font-bold uppercase border border-[#22543D]/20 transition-colors">
                                Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center text-gray-400 text-sm">Tidak ada barang yang sedang disewa</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="mKembaliTipePills" style="display:flex; flex-wrap:wrap; gap:6px;"></div>

        <div class="px-6 py-4 bg-[#fcfdfb] border-t border-[#eef4f0]">
            <p class="text-[10px] font-bold text-[#22543D] uppercase tracking-widest">
                Menampilkan {{ $data_pengembalian->count() }} data pengembalian
            </p>
        </div>

    </div>
</div>

{{-- ═══════════════════ MODAL DETAIL PENGEMBALIAN ═══════════════════ --}}
<div id="modalKembali" style="display:none; position:fixed; inset:0; z-index:99999; background:rgba(0,0,0,0.5); overflow-y:auto;" onclick="if(event.target===this)tutupModalKembali()">
    <div style="position:relative; margin:40px auto 40px; background:white; border-radius:20px; width:90%; max-width:520px; overflow:hidden; box-shadow:0 25px 60px rgba(0,0,0,0.3);">

        {{-- Header --}}
        <div style="display:flex; justify-content:space-between; align-items:center; padding:20px 24px; border-bottom:1px solid #eef4f0;">
            <div>
                <div style="font-weight:700; font-size:15px; color:#22543D;">Detail Pengembalian</div>
                <div style="font-size:11px; color:#9ca3af; margin-top:2px;" id="mKembaliSubjudul">Periksa detail sebelum konfirmasi</div>
            </div>
            <button onclick="tutupModalKembali()" style="border:none; background:#f3f4f6; border-radius:8px; width:28px; height:28px; cursor:pointer; font-size:14px;">✕</button>
        </div>

        {{-- Info Pemesan --}}
        <div style="padding:16px 24px; border-bottom:1px solid #eef4f0; background:#f9fafb;">
            <div style="font-size:10px; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:.08em; margin-bottom:10px;">Info Pemesan</div>
            <div style="display:flex; align-items:center; gap:12px;">
                <div id="mKembaliAvatar" style="width:38px; height:38px; border-radius:10px; background:#22543D; color:white; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px; flex-shrink:0;"></div>
                <div>
                    <div id="mKembaliNama" style="font-weight:700; font-size:14px; color:#1f2937;"></div>
                    <div id="mKembaliProdukInfo" style="font-size:11px; color:#6b7280; margin-top:2px;"></div>
                </div>
            </div>
        </div>

        {{-- Barang Dipesan --}}
        <div style="padding:16px 24px; border-bottom:1px solid #eef4f0;">
            <div style="font-size:10px; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:.08em; margin-bottom:10px;">Barang Dipesan</div>
            <div id="mKembaliBarangList"></div>
        </div>

        {{-- Barang: Kategori + Tipe --}}
        <div style="padding:16px 24px; border-bottom:1px solid #eef4f0;">
            

            {{-- Kategori row --}}
            <div style="margin-bottom:14px;">
                <div style="display:flex; gap:8px;">
                </div>
            </div>


            {{-- Merek --}}
            <div style="display:flex; align-items:center; gap:8px; padding:10px 14px; background:#f9fafb; border-radius:10px; border:1px solid #e5e7eb;">
                <span style="font-size:11px; font-weight:600; color:#6b7280;">Merek</span>
                <span style="font-size:12px; font-weight:700; color:#1f2937;" id="mKembaliMerek"></span>
            </div>
        </div>

        {{-- Tanggal & Denda --}}
        <div style="padding:16px 24px; border-bottom:1px solid #eef4f0;">
            <div style="font-size:10px; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:.08em; margin-bottom:12px;">Tanggal & Denda</div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                {{-- Tgl kembali --}}
                <div style="background:#f0fdf4; border-radius:12px; padding:14px; text-align:center; border:1px solid #bbf7d0;">
                    <div style="font-size:10px; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; margin-bottom:6px;">Tgl Kembali</div>
                    <div id="mKembaliTgl" style="font-size:14px; font-weight:700; color:#22543D;"></div>
                </div>
                {{-- Denda --}}
                <div id="mKembaliDendaBox" style="border-radius:12px; padding:14px; text-align:center; border:1px solid #e5e7eb;">
                    <div style="font-size:10px; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; margin-bottom:6px;">Denda</div>
                    <div id="mKembaliDenda" style="font-size:14px; font-weight:700;"></div>
                    <div id="mKembaliDendaInfo" style="font-size:10px; margin-top:4px;"></div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div style="padding:16px 24px; display:flex; gap:12px;">
            <button onclick="tutupModalKembali()" style="flex:1; padding:10px; border:1px solid #e5e7eb; border-radius:12px; background:white; cursor:pointer; font-size:12px; font-weight:600; color:#6b7280;">Batal</button>
            <button onclick="konfirmasiKembali()" style="flex:1; padding:10px; border:none; border-radius:12px; background:#22543D; color:white; cursor:pointer; font-size:12px; font-weight:700;">✓ Konfirmasi Kembali</button>
        </div>

    </div>
</div>

<script>
var tipeKamera  = ['DSLR', 'Mirrorless', 'Kamera Aksi', 'Kamera Instan (Polaroid)', 'Kamera Video'];
var tipeCamping = ['Tenda', 'Sleeping Bag', 'Matras', 'Carrier / Backpack', 'Kompor & Alat Masak', 'Lampu & Penerangan', 'Peralatan Hiking'];

var currentItemId = null;

function bukaModalKembali(nama, produk, merek, kategori, tipe, tglKembali, denda, hariTerlambat, itemId, idPesanan) {
    currentItemId = itemId;

    // Info pemesan
    document.getElementById('mKembaliAvatar').textContent    = nama.charAt(0).toUpperCase();
    document.getElementById('mKembaliNama').textContent      = nama;
    document.getElementById('mKembaliProdukInfo').textContent = produk + '  •  INV-' + itemId;
    document.getElementById('mKembaliMerek').textContent     = merek;
    document.getElementById('mKembaliProdukInfo').textContent = 'ID Pesanan: ' + idPesanan;
    
     // Render barang dipesan
        var barangHtml = '';
        produk.forEach(function(p) {
            barangHtml += '<div style="display:flex; align-items:center; justify-content:space-between; padding:10px 14px; background:#fff5f7; border-radius:10px; border:1px solid #fce7f3; margin-bottom:8px;">'
                + '<div style="display:flex; align-items:center; gap:10px;">'
                + '<span style="font-weight:700; font-size:13px; color:#1f2937;">' + p.name + '</span>'
                + '</div>'
                + '<div style="display:flex; gap:6px;">'
                + '<span style="padding:3px 10px; border-radius:999px; font-size:10px; font-weight:700; background:#fce7f3; color:#ED64A6;">' + p.kategori + '</span>'
                + '<span style="padding:3px 10px; border-radius:999px; font-size:10px; font-weight:700; background:#f3f4f6; color:#6b7280;">' + p.tipe + '</span>'
                + '</div>'
                + '</div>';
        });
        document.getElementById('mKembaliBarangList').innerHTML = barangHtml;

    // cukup ini aja
    var isKamera = kategori === 'Kamera';

    // ── Tipe pills ──────────────────────────────────
    var tipeList   = isKamera ? tipeKamera : tipeCamping;
    var activeBg   = isKamera ? '#eff6ff'  : '#ecfdf5';
    var activeTxt  = isKamera ? '#ED64A6'  : '#065f46';
    var activeBdr  = isKamera ? '#ED64A6'  : '#065f46';

    var html = '';
    tipeList.forEach(function(t) {
        var active = t === tipe;
        html += '<span style="padding:5px 12px; border-radius:999px; font-size:10px; font-weight:700; border:1.5px solid '
              + (active ? activeBdr : '#e5e7eb') + '; background:'
              + (active ? activeBg  : '#f9fafb') + '; color:'
              + (active ? activeTxt : '#9ca3af') + ';">'
              + t + '</span>';
    });
    

    // ── Tanggal ─────────────────────────────────────
    document.getElementById('mKembaliTgl').textContent = tglKembali;

    // ── Denda ───────────────────────────────────────
    var dendaBox  = document.getElementById('mKembaliDendaBox');
    var dendaEl   = document.getElementById('mKembaliDenda');
    var dendaInfo = document.getElementById('mKembaliDendaInfo');

    if (denda > 0) {
        dendaBox.style.background   = '#fef2f2';
        dendaBox.style.borderColor  = '#fecaca';
        dendaEl.style.color         = '#dc2626';
        dendaEl.textContent         = 'Rp ' + denda.toLocaleString('id-ID');
        dendaInfo.style.color       = '#f87171';
        dendaInfo.textContent       = hariTerlambat + ' hari × Rp 50.000';
    } else {
        dendaBox.style.background   = '#f0fdf4';
        dendaBox.style.borderColor  = '#bbf7d0';
        dendaEl.style.color         = '#16a34a';
        dendaEl.textContent         = 'Tidak Ada Denda';
        dendaInfo.style.color       = '#86efac';
        dendaInfo.textContent       = 'Tepat waktu ✓';
    }

    document.getElementById('modalKembali').style.display = 'block';
}

function tutupModalKembali() {
    document.getElementById('modalKembali').style.display = 'none';
}

function konfirmasiKembali() {
    // TODO: kirim ke server
    alert('Pengembalian berhasil dikonfirmasi!');
    tutupModalKembali();
}

// Search
document.getElementById('searchInput').addEventListener('input', function() {
    var q = this.value.toLowerCase();
    document.querySelectorAll('.return-row').forEach(function(row) {
        row.style.display = row.textContent.toLowerCase().indexOf(q) !== -1 ? '' : 'none';
    });
});
</script>

@endsection