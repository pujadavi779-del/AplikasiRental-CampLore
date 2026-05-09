@extends('layouts.admin')

@section('title', 'Pengiriman - Camplore Admin')

@section('content')

<div class="mb-6">
    @include('components.navbar_judul_LP', [
        'NavParent' => 'Manajemen Operasional',
        'section' => 'Pengiriman'
    ])
</div>

<div class="max-w-full">
    <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

        {{-- HEADER --}}
        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#eef4f0]">
            <div>
                <h2 class="text-2xl font-bold text-[#22543D] leading-tight" style="font-family:'Playfair Display',Georgia,serif;">Data Pengiriman</h2>
                <p class="text-[11px] text-[#7c8b84] mt-0.5">Pantau dan kelola semua status logistik pengiriman barang.</p>
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
                <input type="text" id="searchInput" placeholder="Cari pemesan atau barang..."
                    class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl bg-gray-50 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D]">
            </div>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#f1f8f4] text-[10px] font-bold uppercase tracking-widest text-[#22543D] border-b border-[#eef4f0]">
                    <tr>
                        <th class="px-6 py-3">Pemesan</th>
                        <th class="px-6 py-3">Alamat</th>
                        <th class="px-6 py-3 text-center">Tgl Mulai</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#eef4f0]" id="tableBody">
                    @forelse($pengiriman as $item)
                    @php
                        $status = $item['status'] ?? 'dikirim';
                        $idPesanan = $item['id_pesanan'] ?? 'CMP-000';
                        $barangList = is_array($item['barang']) ? $item['barang'] : [['nama' => $item['barang'], 'kategori' => $item['kategori'] ?? 'Kamera']];
                    @endphp

                    <tr class="hover:bg-[#fcfdfb] transition-colors delivery-row">
                        {{-- Pemesan --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-[#22543D] flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($item['pemesan'], 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800 text-sm">{{ $item['pemesan'] }}</div>
                                    <div class="text-[10px] text-gray-400 mt-0.5">{{ $item['no_hp'] }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Alamat --}}
                        <td class="px-6 py-4">
                            <p class="text-[11px] text-gray-500 max-w-[180px] leading-relaxed">{{ $item['alamat'] }}</p>
                        </td>

                        {{-- Tgl Mulai --}}
                        <td class="px-6 py-4 text-center">
                        <div class="text-sm font-semibold text-gray-700">{{ $item['tanggal_mulai'] }}</div>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4 text-center">
                            @if($status === 'dikirim')
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase bg-pink-50 text-pink-600 border border-pink-200">Dikirim</span>
                            @elseif($status === 'proses')
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase bg-amber-50 text-amber-600 border border-amber-200">Sedang Diantar</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase bg-emerald-50 text-emerald-700 border border-emerald-200">Diterima</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4 text-center">
                            @php
                             $fotoTerima = $item['foto_terima'] ?? null;
                            @endphp
                                <button type="button"
                                    onclick='bukaDetail(
                                        @json($item["pemesan"]),
                                        @json($barangList),
                                        @json($item["tanggal_mulai"]),
                                        @json($idPesanan),
                                        @json($status),
                                        @json($fotoTerima)
                                    )'
                                    class="px-4 py-1.5 rounded-lg bg-[#22543D]/10 hover:bg-[#22543D]/20 text-[#22543D] text-[10px] font-bold uppercase border border-[#22543D]/20 transition-colors">
                                    Detail
                                </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-gray-400 text-sm">Belum ada data pengiriman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- FOOTER --}}
        <div class="px-6 py-4 bg-[#fcfdfb] border-t border-[#eef4f0]">
            <p class="text-[10px] font-bold text-[#22543D] uppercase tracking-widest">
                Menampilkan {{ count($pengiriman) }} data pengiriman
            </p>
        </div>

    </div>
</div>

{{-- ═══════════════════════ MODAL DETAIL ═══════════════════════ --}}
<div id="modalDetail" style="display:none; position:fixed; inset:0; z-index:99999; background:rgba(0,0,0,0.55); overflow-y:auto;" onclick="if(event.target===this)tutupDetail()">
    <div style="position:relative; margin:40px auto; background:white; border-radius:20px; width:90%; max-width:520px; overflow:hidden; box-shadow:0 25px 60px rgba(0,0,0,0.25); font-family:'Inter',sans-serif;">

        {{-- Header --}}
        <div style="display:flex; justify-content:space-between; align-items:flex-start; padding:18px 22px 14px; border-bottom:1px solid #eef4f0;">
            <div>
                <div style="font-weight:700; font-size:15px; color:#22543D;" id="detailNama"></div>
                <div style="font-size:11px; color:#9ca3af; margin-top:3px;" id="detailIdPesanan"></div>
            </div>
            
        </div>

        {{-- Info Barang --}}
        <div style="padding:16px 22px; border-bottom:1px solid #eef4f0; background:#f9fafb;">
            <div style="font-size:10px; color:#9ca3af; font-weight:700; text-transform:uppercase; letter-spacing:.07em; margin-bottom:10px;">Barang Dipesan</div>
            <div id="detailBarangList"></div>
        </div>

        {{-- Status & Aksi --}}
        <div style="padding:20px 22px;" id="detailStatusArea"></div>

        {{-- Footer --}}
        <div style="padding:12px 22px; border-top:1px solid #eef4f0; display:flex; justify-content:space-between; align-items:center;">
            <button onclick="unduhDetail()" style="background:none; border:none; cursor:pointer; font-size:12px; font-weight:600; color:#6b7280; display:flex; align-items:center; gap:6px; font-family:'Inter',sans-serif; padding:0;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Unduh detail
            </button>
            <button onclick="tutupDetail()" style="background:#22543D; color:white; border:none; border-radius:10px; padding:9px 22px; font-size:12px; font-weight:700; cursor:pointer; font-family:'Inter',sans-serif;">Tutup</button>
        </div>

    </div>
</div>

{{-- ═══════════════════════ MODAL KONFIRMASI ═══════════════════════ --}}
<div id="modalAksi" style="display:none; position:fixed; inset:0; z-index:999999; background:rgba(0,0,0,0.5);" onclick="if(event.target===this)tutupAksi()">
    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); background:white; border-radius:20px; padding:28px 24px; width:90%; max-width:380px; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,0.3); font-family:'Inter',sans-serif;">
        <div id="aksiIcon" style="width:56px; height:56px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:24px;"></div>
        <h3 id="aksiJudul" style="margin:0 0 8px; font-size:16px; font-weight:700; color:#22543D; font-family:'Playfair Display',Georgia,serif;"></h3>
        <p id="aksiSubjudul" style="margin:0 0 20px; font-size:12px; color:#9ca3af;"></p>

        {{-- Upload foto (hanya untuk aksi Terima) --}}
        <div id="uploadFotoWrap" style="display:none; margin-bottom:20px; text-align:left;">
            <label style="font-size:11px; font-weight:600; color:#374151; display:block; margin-bottom:8px;">📷 Foto Bukti Diterima <span style="color:#ef4444;">*</span></label>

            {{-- Drop Zone --}}
            <div id="dropZone"
                onclick="document.getElementById('fotoTerima').click()"
                style="border:2px dashed #d1d5db; border-radius:14px; padding:20px 16px; background:#f9fafb; cursor:pointer; text-align:center; transition:all .2s; position:relative;">
                <div id="dropZonePlaceholder">
                    <div style="font-size:26px; margin-bottom:6px;">🖼️</div>
                    <div style="font-size:12px; font-weight:600; color:#6b7280;">Klik untuk pilih foto</div>
                    <div style="font-size:10px; color:#9ca3af; margin-top:3px;">JPG, PNG, WEBP — maks. 5 MB</div>
                </div>
                <input type="file" id="fotoTerima" accept="image/*"
                    style="display:none;" onchange="previewFoto(this)">
            </div>

            {{-- Preview hasil foto --}}
            <div id="fotoPreviewWrap" style="display:none; margin-top:12px; border-radius:14px; overflow:hidden; border:1px solid #d1fae5; position:relative; background:#f0fdf4;">
                <img id="fotoPreviewImg" src="" alt="Preview"
                    style="width:100%; max-height:200px; object-fit:cover; display:block;">
                <div style="padding:10px 12px; display:flex; align-items:center; justify-content:space-between;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <div style="width:28px; height:28px; border-radius:8px; background:#22543D; display:flex; align-items:center; justify-content:center; font-size:13px; flex-shrink:0;">✅</div>
                        <div>
                            <div id="fotoNamaFile" style="font-size:11px; font-weight:700; color:#1f2937; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:200px;"></div>
                            <div id="fotoUkuranFile" style="font-size:10px; color:#9ca3af; margin-top:1px;"></div>
                        </div>
                    </div>
                    <button type="button" onclick="hapusFoto()"
                        style="background:#fee2e2; border:none; border-radius:8px; padding:5px 10px; font-size:10px; font-weight:700; color:#ef4444; cursor:pointer; white-space:nowrap;">
                        Hapus
                    </button>
                </div>
            </div>
        </div>

        <div style="display:flex; gap:12px;">
            <button onclick="tutupAksi()" style="flex:1; padding:10px; border:1px solid #e5e7eb; border-radius:12px; background:white; cursor:pointer; font-size:12px; font-weight:600; font-family:'Inter',sans-serif;">Batal</button>
            <button id="aksiBtn" style="flex:1; padding:10px; border:none; border-radius:12px; background:#22543D; color:white; cursor:pointer; font-size:12px; font-weight:700; font-family:'Inter',sans-serif;"></button>
        </div>
    </div>
</div>

<script>
// ── Helpers ───────────────────────────────────────────────
function svgKamera() {
    return '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#ED64A6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>';
}
function svgCamping() {
    return '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#065f46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18 L12 4 L21 18 Z"/><path d="M1 18 H23"/><path d="M10 18 L12 14 L14 18"/></svg>';
}

// ── MODAL DETAIL ──────────────────────────────────────────
var _currentStatus   = '';
var _currentNama     = '';
var _currentBarang   = [];
var _currentIdPesanan= '';
var _currentTanggal  = '';

function bukaDetail(nama, barangList, tanggal, idPesanan, status, fotoTerima) {
    _currentStatus    = status;
    _currentNama      = nama;
    _currentBarang    = barangList;
    _currentIdPesanan = idPesanan;
    _currentTanggal   = tanggal;

    document.getElementById('detailNama').textContent      = nama;
    document.getElementById('detailIdPesanan').textContent = 'ID Pesanan: ' + idPesanan + '  •  Mulai: ' + tanggal;

    var barangHtml = '';
    barangList.forEach(function(b) {
        var isKamera  = b.kategori === 'Kamera';
        var bgCard    = isKamera ? '#fff1f2' : '#f0fdf4';
        var borderCard= isKamera ? '#fecdd3' : '#bbf7d0';
        var bgBadgeK  = '#fce7f3'; var txtBadgeK = '#be185d';
        var bgBadgeC  = '#dcfce7'; var txtBadgeC = '#15803d';
        var bgTipe    = isKamera ? '#ffe4e6' : '#d1fae5';
        var txtTipe   = isKamera ? '#e11d48' : '#065f46';
        var svg       = isKamera ? svgKamera() : svgCamping();
        var bgIcon    = isKamera ? '#fce7f3' : '#d1fae5';

        barangHtml += '<div style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:' + bgCard + '; border:1px solid ' + borderCard + '; border-radius:12px; margin-bottom:8px;">';
        barangHtml += '<span style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border-radius:8px; background:' + bgIcon + '; flex-shrink:0;">' + svg + '</span>';
        barangHtml += '<div style="flex:1;">';
        barangHtml += '<div style="font-size:13px; font-weight:700; color:#1f2937;">' + b.nama + '</div>';
        barangHtml += '</div>';
        var bgBadge = isKamera ? bgBadgeK : bgBadgeC;
        var txtBadge= isKamera ? txtBadgeK : txtBadgeC;
        barangHtml += '<span style="font-size:10px; font-weight:700; padding:3px 8px; border-radius:99px; background:' + bgBadge + '; color:' + txtBadge + '; text-transform:uppercase; white-space:nowrap;">' + b.kategori + '</span>';
        if (b.tipe) {
            barangHtml += '<span style="font-size:10px; font-weight:600; padding:3px 8px; border-radius:99px; background:' + bgTipe + '; color:' + txtTipe + '; white-space:nowrap; margin-left:4px;">' + b.tipe + '</span>';
        }
        barangHtml += '</div>';
    });
    document.getElementById('detailBarangList').innerHTML = barangHtml;

    renderStatusArea(status, nama, fotoTerima);
    document.getElementById('modalDetail').style.display = 'block';
}

function renderStatusArea(status, nama, fotoTerima) {
    var area  = document.getElementById('detailStatusArea');
    var order = { 'dikirim': 0, 'proses': 1, 'tiba': 2 };
    var steps = [
        { key:'dikirim', icon:'📦', label:'Dikirim',            desc:'Barang sedang dalam perjalanan menuju pelanggan.' },
        { key:'tiba',    icon:'✅', label:'Diterima Pelanggan', desc:'Barang telah diterima oleh pelanggan.' },
    ];
    var currentIdx = order[status] ?? 0;

    var html = '<div style="margin-bottom:20px;">';
    html += '<div style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:.07em; margin-bottom:14px;">Status Pengiriman</div>';

    steps.forEach(function(s, i) {
        var isDone    = i <= currentIdx;
        var isCurrent = i === currentIdx;
        var dotBg     = isDone ? '#22543D' : '#d1d5db';
        var lblColor  = isCurrent ? '#22543D' : (isDone ? '#374151' : '#9ca3af');
        var fontW     = isCurrent ? '700' : '600';

        html += '<div style="display:flex; gap:14px;">';
        html += '<div style="display:flex; flex-direction:column; align-items:center; width:22px; flex-shrink:0;">';
        html += '<div style="width:16px; height:16px; border-radius:50%; background:' + dotBg + '; display:flex; align-items:center; justify-content:center; margin-top:2px;">';
        if (isDone) html += '<div style="width:6px; height:6px; border-radius:50%; background:white;"></div>';
        html += '</div>';
        if (i < steps.length - 1) html += '<div style="width:2px; flex:1; background:#e5e7eb; margin:4px 0;"></div>';
        html += '</div>';
        html += '<div style="padding-bottom:16px; flex:1;">';
        html += '<div style="font-size:13px; font-weight:' + fontW + '; color:' + lblColor + ';">' + s.icon + ' ' + s.label + '</div>';
        html += '<div style="font-size:11px; color:#9ca3af; margin-top:3px; line-height:1.5;">' + s.desc + '</div>';

        if (s.key === 'tiba' && fotoTerima) {
            html += '<div style="margin-top:8px;">';
            html += '<a href="' + fotoTerima + '" target="_blank" style="display:inline-flex; align-items:center; gap:5px; font-size:11px; font-weight:600; color:#22543D; text-decoration:none; background:#d1fae5; padding:5px 10px; border-radius:8px;">';
            html += '🖼️ Lihat Foto Bukti Diterima';
            html += '</a>';
            html += '</div>';
        }

        html += '</div>';
        html += '</div>';
    });

    html += '</div>';

    html += '<div style="display:flex; gap:10px; flex-wrap:wrap;">';
    if (status !== 'tiba') {
        html += '<button onclick="bukaKonfirmasi(\'tiba\', \'' + nama + '\')" '
              + 'style="flex:1; min-width:120px; padding:10px; border-radius:12px; border:1px solid #6ee7b7; background:#d1fae5; color:#065f46; font-size:12px; font-weight:700; cursor:pointer; font-family:\'Inter\',sans-serif;">'
              + '✅ Pelanggan Sudah Terima</button>';
    }
    if (status === 'tiba') {
        html += '<div style="width:100%; padding:10px 14px; border-radius:12px; background:#d1fae5; color:#065f46; font-size:12px; font-weight:700; text-align:center;">'
              + '✅ Barang sudah diterima pelanggan</div>';
    }
    html += '</div>';
    area.innerHTML = html;
}

function unduhDetail() {
    var statusLabel = _currentStatus === 'tiba' ? 'Diterima Pelanggan'
                    : _currentStatus === 'proses' ? 'Sedang Diantar'
                    : 'Dikirim';

    var barangLines = '';
    _currentBarang.forEach(function(b) {
        barangLines += '  - ' + b.nama + ' [' + b.kategori + (b.tipe ? ' / ' + b.tipe : '') + ']\n';
    });

    var isi = '================================\n'
            + '     DETAIL PENGIRIMAN\n'
            + '================================\n\n'
            + 'Pemesan      : ' + _currentNama + '\n'
            + 'ID Pesanan   : ' + _currentIdPesanan + '\n'
            + 'Tgl Mulai    : ' + _currentTanggal + '\n\n'
            + 'Barang Dipesan:\n' + barangLines + '\n'
            + 'Status       : ' + statusLabel + '\n'
            + 'Dicetak pada : ' + new Date().toLocaleString('id-ID') + '\n\n'
            + '================================\n';

    var blob = new Blob([isi], { type: 'text/plain' });
    var url  = URL.createObjectURL(blob);
    var a    = document.createElement('a');
    a.href     = url;
    a.download = 'detail-pengiriman-' + _currentNama.replace(/\s+/g, '-').toLowerCase() + '.txt';
    a.click();
    URL.revokeObjectURL(url);
}

function tutupDetail() {
    document.getElementById('modalDetail').style.display = 'none';
}

// ── MODAL KONFIRMASI AKSI ─────────────────────────────────
var aksiTipe = '';

function bukaKonfirmasi(tipe, nama) {
    aksiTipe = tipe;

    document.getElementById('aksiIcon').style.background = '#d1fae5';
    document.getElementById('aksiIcon').textContent = '✅';
    document.getElementById('aksiJudul').textContent = 'Konfirmasi Diterima';
    document.getElementById('aksiSubjudul').textContent = 'Upload foto bukti barang pesanan "' + nama + '" diterima pelanggan.';
    document.getElementById('aksiBtn').textContent = 'Simpan & Konfirmasi';
    document.getElementById('aksiBtn').style.background = '#22543D';
    document.getElementById('uploadFotoWrap').style.display = 'block';

    document.getElementById('modalAksi').style.display = 'block';
}

function previewFoto(input) {
    if (!input.files || !input.files[0]) return;
    var file = input.files[0];

    // Validasi ukuran maks 5 MB
    if (file.size > 5 * 1024 * 1024) {
        alert('Ukuran foto maksimal 5 MB.');
        input.value = '';
        return;
    }

    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('fotoPreviewImg').src = e.target.result;
        document.getElementById('fotoNamaFile').textContent  = file.name;
        document.getElementById('fotoUkuranFile').textContent = (file.size / 1024).toFixed(1) + ' KB';
        document.getElementById('dropZone').style.display        = 'none';
        document.getElementById('fotoPreviewWrap').style.display = 'block';
    };
    reader.readAsDataURL(file);
}

function hapusFoto() {
    document.getElementById('fotoTerima').value = '';
    document.getElementById('fotoPreviewImg').src = '';
    document.getElementById('fotoPreviewWrap').style.display = 'none';
    document.getElementById('dropZone').style.display        = 'block';
}

function tutupAksi() {
    document.getElementById('modalAksi').style.display = 'none';
    hapusFoto();
}

document.getElementById('aksiBtn').addEventListener('click', function() {
    if (aksiTipe === 'tiba') {
        var foto = document.getElementById('fotoTerima').files[0];
        if (!foto) {
            alert('Mohon upload foto bukti diterima terlebih dahulu.');
            return;
        }
    }
    // TODO: kirim ke server via fetch/form submit
    alert('Status berhasil diperbarui!');
    tutupAksi();
    tutupDetail();
});

// ── SEARCH ────────────────────────────────────────────────
document.getElementById('searchInput').addEventListener('input', function() {
    var q = this.value.toLowerCase();
    document.querySelectorAll('.delivery-row').forEach(function(row) {
        row.style.display = row.textContent.toLowerCase().indexOf(q) !== -1 ? '' : 'none';
    });
});
</script>

@endsection