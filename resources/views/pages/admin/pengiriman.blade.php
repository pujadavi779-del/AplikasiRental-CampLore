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

    {{-- ═══════════════ STAT CARDS ═══════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        {{-- Total Request --}}
        <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Total Rental</p>
                <p class="text-3xl font-bold text-gray-900 leading-tight">{{ $stats['total'] ?? 128 }}</p>
                <p class="text-[11px] text-emerald-500 font-semibold mt-0.5">↑ +5% hari ini</p>
            </div>
        </div>

        {{-- Sedang Diantar --}}
        <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Sedang Diantar</p>
                <p class="text-3xl font-bold text-gray-900 leading-tight">{{ $stats['diantar'] ?? 7 }}</p>
                <p class="text-[11px] text-gray-400 font-semibold mt-0.5">⊙ Proses antar mandiri</p>
            </div>
        </div>

        {{-- Selesai Hari Ini --}}
        <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Selesai Hari Ini</p>
                <p class="text-3xl font-bold text-gray-900 leading-tight">{{ $stats['selesai'] ?? 12 }}</p>
                <p class="text-[11px] text-gray-400 font-semibold mt-0.5">⊙ Tuntas ke lokasi tujuan</p>
            </div>
        </div>
    </div>

    {{-- ═══════════════ TABLE CARD ═══════════════ --}}
    <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-sm overflow-hidden">

        {{-- HEADER --}}
        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#f3f4f6]">
            <h2 class="text-lg font-bold text-gray-900">Daftar Pengantaran Aktif</h2>
            <div class="flex items-center gap-2">
                <button class="flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M7 8h10M11 12h2M9 16h6" />
                    </svg>
                    Filter
                </button>
                <button class="flex items-center gap-1.5 px-4 py-2 text-sm font-bold text-white bg-gray-900 rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Request Baru
                </button>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-[#f3f4f6]">
                    <tr class="text-[11px] font-bold uppercase tracking-widest text-gray-400">
                        <th class="px-6 py-3">ID Rental</th>
                        <th class="px-6 py-3">Tujuan Lokasi</th>
                        <th class="px-6 py-3">Penerima</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f3f4f6]" id="tableBody">
                    @forelse($pengiriman as $item)
                    @php
                    $status = $item['status'] ?? 'dikirim';
                    $idPesanan = $item['id_pesanan'] ?? 'CMP-000';
                    $barangList = is_array($item['barang']) ? $item['barang'] : [['nama' => $item['barang'], 'kategori' => $item['kategori'] ?? 'Kamera']];
                    $fotoTerima = $item['foto_terima'] ?? null;
                    $alamat = $item['alamat'] ?? '-';
                    $subAlamat = $item['sub_alamat'] ?? '';
                    @endphp

                    <tr class="hover:bg-gray-50 transition-colors delivery-row">

                        {{-- ID Request --}}
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-900 text-sm">#{{ $idPesanan }}</span>
                        </td>

                        {{-- Tujuan Lokasi --}}
                        <td class="px-6 py-4">
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div>
                                    <div class="font-semibold text-gray-800 text-sm">{{ $alamat }}</div>
                                    @if($subAlamat)
                                    <div class="text-[11px] text-gray-400 mt-0.5">{{ $subAlamat }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Penerima --}}
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-700 font-medium">{{ $item['pemesan'] }}</span>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4">
                            @if($status === 'dikirim')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400 inline-block"></span>Menunggu Pengantaran
                            </span>
                            @elseif($status === 'proses')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 inline-block"></span>Sedang Diantar
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-500">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                Selesai
                            </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            @if($status === 'tiba')
                            <button type="button"
                                onclick='bukaDetail(
                                        @json($item["pemesan"]),
                                        @json($barangList),
                                        @json($item["tanggal_mulai"]),
                                        @json($idPesanan),
                                        @json($status),
                                        @json($fotoTerima)
                                    )'
                                class="text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">
                                Detail
                            </button>
                            @else
                            {{-- Aksi --}}
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.pengiriman.detail', $item['id_pesanan']) }}"
                                class="text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">
                                {{ $status === 'tiba' ? 'Detail' : 'Lacak' }}
                            </a>
                        </td>
                        @endif
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

        {{-- FOOTER / PAGINATION --}}
        <div class="px-6 py-4 bg-white border-t border-[#f3f4f6] flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-[11px] text-gray-400">
                Menampilkan status terkini CampLore
            </p>
            <div class="flex items-center gap-1">
                <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-900 text-white text-xs font-bold">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50 transition-colors text-xs font-semibold">2</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>

{{-- ═══════════════════════ MODAL DETAIL ═══════════════════════ --}}
<div id="modalDetail" style="display:none; position:fixed; inset:0; z-index:99999; background:rgba(0,0,0,0.55); overflow-y:auto;" onclick="if(event.target===this)tutupDetail()">
    <div style="position:relative; margin:40px auto; background:white; border-radius:20px; width:90%; max-width:520px; overflow:hidden; box-shadow:0 25px 60px rgba(0,0,0,0.25); font-family:'Inter',sans-serif;">

        {{-- Header --}}
        <div style="display:flex; justify-content:space-between; align-items:flex-start; padding:18px 22px 14px; border-bottom:1px solid #f3f4f6;">
            <div>
                <div style="font-weight:700; font-size:15px; color:#111827;" id="detailNama"></div>
                <div style="font-size:11px; color:#9ca3af; margin-top:3px;" id="detailIdPesanan"></div>
            </div>
        </div>

        {{-- Info Barang --}}
        <div style="padding:16px 22px; border-bottom:1px solid #f3f4f6; background:#f9fafb;">
            <div style="font-size:10px; color:#9ca3af; font-weight:700; text-transform:uppercase; letter-spacing:.07em; margin-bottom:10px;">Barang Dipesan</div>
            <div id="detailBarangList"></div>
        </div>

        {{-- Status & Aksi --}}
        <div style="padding:20px 22px;" id="detailStatusArea"></div>

        {{-- Footer --}}
        <div style="padding:12px 22px; border-top:1px solid #f3f4f6; display:flex; justify-content:flex-end;">
            <button onclick="tutupDetail()" style="background:#111827; color:white; border:none; border-radius:10px; padding:9px 22px; font-size:12px; font-weight:700; cursor:pointer; font-family:'Inter',sans-serif;">Tutup</button>
        </div>

    </div>
</div>

{{-- ═══════════════════════ MODAL KONFIRMASI ═══════════════════════ --}}
<div id="modalAksi" style="display:none; position:fixed; inset:0; z-index:999999; background:rgba(0,0,0,0.5);" onclick="if(event.target===this)tutupAksi()">
    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); background:white; border-radius:20px; padding:28px 24px; width:90%; max-width:380px; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,0.3); font-family:'Inter',sans-serif;">
        <div id="aksiIcon" style="width:56px; height:56px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:24px;"></div>
        <h3 id="aksiJudul" style="margin:0 0 8px; font-size:16px; font-weight:700; color:#111827;"></h3>
        <p id="aksiSubjudul" style="margin:0 0 20px; font-size:12px; color:#9ca3af;"></p>

        <div id="uploadFotoWrap" style="display:none; margin-bottom:20px; text-align:left;">
            <label style="font-size:11px; font-weight:600; color:#374151; display:block; margin-bottom:8px;">📷 Foto Bukti Diterima <span style="color:#ef4444;">*</span></label>
            <div id="dropZone"
                onclick="document.getElementById('fotoTerima').click()"
                style="border:2px dashed #d1d5db; border-radius:14px; padding:20px 16px; background:#f9fafb; cursor:pointer; text-align:center; transition:all .2s;">
                <div id="dropZonePlaceholder">
                    <div style="font-size:26px; margin-bottom:6px;">🖼️</div>
                    <div style="font-size:12px; font-weight:600; color:#6b7280;">Klik untuk pilih foto</div>
                    <div style="font-size:10px; color:#9ca3af; margin-top:3px;">JPG, PNG, WEBP — maks. 5 MB</div>
                </div>
                <input type="file" id="fotoTerima" accept="image/*" style="display:none;" onchange="previewFoto(this)">
            </div>
            <div id="fotoPreviewWrap" style="display:none; margin-top:12px; border-radius:14px; overflow:hidden; border:1px solid #d1fae5; position:relative; background:#f0fdf4;">
                <img id="fotoPreviewImg" src="" alt="Preview" style="width:100%; max-height:200px; object-fit:cover; display:block;">
                <div style="padding:10px 12px; display:flex; align-items:center; justify-content:space-between;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <div style="width:28px; height:28px; border-radius:8px; background:#111827; display:flex; align-items:center; justify-content:center; font-size:13px; flex-shrink:0;">✅</div>
                        <div>
                            <div id="fotoNamaFile" style="font-size:11px; font-weight:700; color:#1f2937; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:200px;"></div>
                            <div id="fotoUkuranFile" style="font-size:10px; color:#9ca3af; margin-top:1px;"></div>
                        </div>
                    </div>
                    <button type="button" onclick="hapusFoto()" style="background:#fee2e2; border:none; border-radius:8px; padding:5px 10px; font-size:10px; font-weight:700; color:#ef4444; cursor:pointer;">Hapus</button>
                </div>
            </div>
        </div>

        <div style="display:flex; gap:12px;">
            <button onclick="tutupAksi()" style="flex:1; padding:10px; border:1px solid #e5e7eb; border-radius:12px; background:white; cursor:pointer; font-size:12px; font-weight:600; font-family:'Inter',sans-serif;">Batal</button>
            <button id="aksiBtn" style="flex:1; padding:10px; border:none; border-radius:12px; background:#111827; color:white; cursor:pointer; font-size:12px; font-weight:700; font-family:'Inter',sans-serif;"></button>
        </div>
    </div>
</div>

<script>
    function svgKamera() {
        return '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#ED64A6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>';
    }

    function svgCamping() {
        return '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#065f46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18 L12 4 L21 18 Z"/><path d="M1 18 H23"/><path d="M10 18 L12 14 L14 18"/></svg>';
    }

    var _currentStatus = '',
        _currentNama = '',
        _currentBarang = [],
        _currentIdPesanan = '',
        _currentTanggal = '';

    function bukaDetail(nama, barangList, tanggal, idPesanan, status, fotoTerima) {
        _currentStatus = status;
        _currentNama = nama;
        _currentBarang = barangList;
        _currentIdPesanan = idPesanan;
        _currentTanggal = tanggal;
        document.getElementById('detailNama').textContent = nama;
        document.getElementById('detailIdPesanan').textContent = 'ID Pesanan: #' + idPesanan + '  •  Mulai: ' + tanggal;
        var barangHtml = '';
        barangList.forEach(function(b) {
            var isKamera = b.kategori === 'Kamera';
            var bgCard = isKamera ? '#fff1f2' : '#f0fdf4';
            var borderCard = isKamera ? '#fecdd3' : '#bbf7d0';
            var svg = isKamera ? svgKamera() : svgCamping();
            var bgIcon = isKamera ? '#fce7f3' : '#d1fae5';
            var bgBadge = isKamera ? '#fce7f3' : '#dcfce7';
            var txtBadge = isKamera ? '#be185d' : '#15803d';
            barangHtml += '<div style="display:flex; align-items:center; gap:10px; padding:10px 12px; background:' + bgCard + '; border:1px solid ' + borderCard + '; border-radius:12px; margin-bottom:8px;">';
            barangHtml += '<span style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border-radius:8px; background:' + bgIcon + '; flex-shrink:0;">' + svg + '</span>';
            barangHtml += '<div style="flex:1;"><div style="font-size:13px; font-weight:700; color:#1f2937;">' + b.nama + '</div></div>';
            barangHtml += '<span style="font-size:10px; font-weight:700; padding:3px 8px; border-radius:99px; background:' + bgBadge + '; color:' + txtBadge + '; text-transform:uppercase; white-space:nowrap;">' + b.kategori + '</span>';
            if (b.tipe) barangHtml += '<span style="font-size:10px; font-weight:600; padding:3px 8px; border-radius:99px; background:#e5e7eb; color:#374151; white-space:nowrap; margin-left:4px;">' + b.tipe + '</span>';
            barangHtml += '</div>';
        });
        document.getElementById('detailBarangList').innerHTML = barangHtml;
        renderStatusArea(status, nama, fotoTerima);
        document.getElementById('modalDetail').style.display = 'block';
    }

    function renderStatusArea(status, nama, fotoTerima) {
        var area = document.getElementById('detailStatusArea');
        var order = {
            'dikirim': 0,
            'proses': 1,
            'tiba': 2
        };
        var steps = [{
                key: 'dikirim',
                icon: '📦',
                label: 'Dikirim',
                desc: 'Barang sedang dalam perjalanan menuju pelanggan.'
            },
            {
                key: 'tiba',
                icon: '✅',
                label: 'Diterima Pelanggan',
                desc: 'Barang telah diterima oleh pelanggan.'
            },
        ];
        var currentIdx = order[status] ?? 0;
        var html = '<div style="margin-bottom:20px;">';
        html += '<div style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:.07em; margin-bottom:14px;">Status Pengiriman</div>';
        steps.forEach(function(s, i) {
            var isDone = i <= currentIdx,
                isCurrent = i === currentIdx;
            var dotBg = isDone ? '#111827' : '#d1d5db';
            var lblColor = isCurrent ? '#111827' : (isDone ? '#374151' : '#9ca3af');
            html += '<div style="display:flex; gap:14px;">';
            html += '<div style="display:flex; flex-direction:column; align-items:center; width:22px; flex-shrink:0;">';
            html += '<div style="width:16px; height:16px; border-radius:50%; background:' + dotBg + '; display:flex; align-items:center; justify-content:center; margin-top:2px;">';
            if (isDone) html += '<div style="width:6px; height:6px; border-radius:50%; background:white;"></div>';
            html += '</div>';
            if (i < steps.length - 1) html += '<div style="width:2px; flex:1; background:#e5e7eb; margin:4px 0;"></div>';
            html += '</div>';
            html += '<div style="padding-bottom:16px; flex:1;">';
            html += '<div style="font-size:13px; font-weight:' + (isCurrent ? '700' : '600') + '; color:' + lblColor + ';">' + s.icon + ' ' + s.label + '</div>';
            html += '<div style="font-size:11px; color:#9ca3af; margin-top:3px; line-height:1.5;">' + s.desc + '</div>';
            if (s.key === 'tiba' && fotoTerima) {
                html += '<div style="margin-top:8px;"><a href="' + fotoTerima + '" target="_blank" style="display:inline-flex; align-items:center; gap:5px; font-size:11px; font-weight:600; color:#374151; text-decoration:none; background:#f3f4f6; padding:5px 10px; border-radius:8px;">🖼️ Lihat Foto Bukti Diterima</a></div>';
            }
            html += '</div></div>';
        });
        html += '</div>';
        html += '<div style="display:flex; gap:10px; flex-wrap:wrap;">';
        if (status !== 'tiba') {
            html += '<button onclick="bukaKonfirmasi(\'tiba\', \'' + nama + '\')" style="flex:1; min-width:120px; padding:10px; border-radius:12px; border:1px solid #d1d5db; background:#f9fafb; color:#374151; font-size:12px; font-weight:700; cursor:pointer; font-family:\'Inter\',sans-serif;">✅ Pelanggan Sudah Terima</button>';
        }
        if (status === 'tiba') {
            html += '<div style="width:100%; padding:10px 14px; border-radius:12px; background:#f0fdf4; color:#065f46; font-size:12px; font-weight:700; text-align:center;">✅ Barang sudah diterima pelanggan</div>';
        }
        html += '</div>';
        area.innerHTML = html;
    }

    function tutupDetail() {
        document.getElementById('modalDetail').style.display = 'none';
    }

    var aksiTipe = '';

    function bukaKonfirmasi(tipe, nama) {
        aksiTipe = tipe;
        document.getElementById('aksiIcon').style.background = '#f3f4f6';
        document.getElementById('aksiIcon').textContent = '✅';
        document.getElementById('aksiJudul').textContent = 'Konfirmasi Diterima';
        document.getElementById('aksiSubjudul').textContent = 'Upload foto bukti barang pesanan "' + nama + '" diterima pelanggan.';
        document.getElementById('aksiBtn').textContent = 'Simpan & Konfirmasi';
        document.getElementById('aksiBtn').style.background = '#111827';
        document.getElementById('uploadFotoWrap').style.display = 'block';
        document.getElementById('modalAksi').style.display = 'block';
    }

    function previewFoto(input) {
        if (!input.files || !input.files[0]) return;
        var file = input.files[0];
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran foto maksimal 5 MB.');
            input.value = '';
            return;
        }
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('fotoPreviewImg').src = e.target.result;
            document.getElementById('fotoNamaFile').textContent = file.name;
            document.getElementById('fotoUkuranFile').textContent = (file.size / 1024).toFixed(1) + ' KB';
            document.getElementById('dropZone').style.display = 'none';
            document.getElementById('fotoPreviewWrap').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    function hapusFoto() {
        document.getElementById('fotoTerima').value = '';
        document.getElementById('fotoPreviewImg').src = '';
        document.getElementById('fotoPreviewWrap').style.display = 'none';
        document.getElementById('dropZone').style.display = 'block';
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
        alert('Status berhasil diperbarui!');
        tutupAksi();
        tutupDetail();
    });

    document.getElementById('searchInput') && document.getElementById('searchInput').addEventListener('input', function() {
        var q = this.value.toLowerCase();
        document.querySelectorAll('.delivery-row').forEach(function(row) {
            row.style.display = row.textContent.toLowerCase().indexOf(q) !== -1 ? '' : 'none';
        });
    });
</script>

@endsection