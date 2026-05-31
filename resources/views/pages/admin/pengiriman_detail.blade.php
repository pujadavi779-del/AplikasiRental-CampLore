@extends('layouts.admin')

@section('title', 'Detail Pengiriman - Camplore Admin')

@php
    $NavParent = 'Manajemen Operasional';
    $section = 'Pengguna';
@endphp
@section('content')



@php
    $status     = $pengiriman['status'] ?? 'proses';
    $idPesanan = $pengiriman['id_pesanan'] ?? 'CMP-000';
    $pemesan   = $pengiriman['pemesan'] ?? '-';
    $noHp      = $pengiriman['no_hp'] ?? '-';
    $alamat    = $pengiriman['alamat'] ?? '-';
    $tglMulai  = $pengiriman['tanggal_mulai'] ?? '-';
    $tglSelesai= $pengiriman['tanggal_selesai'] ?? '-';
    $fotoTerima= $pengiriman['foto_terima'] ?? null;
    $barangList= is_array($pengiriman['barang'] ?? null) ? $pengiriman['barang'] : [['nama' => $pengiriman['barang'] ?? '-', 'kategori' => $pengiriman['kategori'] ?? '-']];

    // Urutan tetap 3: Menunggu Pengantaran -> Sedang Diantar -> Sampai di Tujuan
    $steps = [
        ['key' => 'proses',  'label' => 'Menunggu Pengantaran',  'desc' => 'Barang siap diantar oleh kurir.'],
        ['key' => 'jalan',   'label' => 'Sedang Diantar',        'desc' => 'Barang dalam perjalanan ke tujuan.'],
        ['key' => 'tiba',    'label' => 'Sampai di Tujuan',      'desc' => 'Barang telah diterima oleh pelanggan.'],
    ];

    $orderMap = ['proses' => 0, 'jalan' => 1, 'tiba' => 2];
    $currentIdx = $orderMap[$status] ?? 0;
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-full">

    {{-- ══ KIRI: Status Kendaraan + Info ══ --}}
    <div class="lg:col-span-2 flex flex-col gap-5">

        {{-- Card: Status Aksi Driver --}}
        <div class="bg-white rounded-[24px] border border-[#d7e6de] shadow-sm overflow-hidden">
            <div class="p-5 flex items-start justify-between gap-3 border-b border-[#eef4f0]">
                <div>
                    <div class="text-[10px] font-bold uppercase tracking-widest text-[#7c8b84] mb-1">Status Kendaraan</div>
                    @if($status === 'tiba')
                        <h2 class="text-xl font-bold text-[#22543D]" style="font-family:'Playfair Display',Georgia,serif;">Pengiriman Selesai</h2>
                        <p class="text-xs text-[#7c8b84] mt-1">Barang telah diterima oleh pelanggan.</p>
                    @elseif($status === 'jalan')
                        <h2 class="text-xl font-bold text-[#22543D]" style="font-family:'Playfair Display',Georgia,serif;">Sedang Diantar</h2>
                        <p class="text-xs text-[#7c8b84] mt-1">Kurir sedang dalam perjalanan menuju pelanggan.</p>
                    @else
                        <h2 class="text-xl font-bold text-[#22543D]" style="font-family:'Playfair Display',Georgia,serif;">Mulai Pengantaran</h2>
                        <p class="text-xs text-[#7c8b84] mt-1">Update status pengiriman secara manual untuk mensinkronkan sistem.</p>
                    @endif
                </div>
                <span class="px-3 py-1.5 rounded-full text-[10px] font-bold uppercase whitespace-nowrap
                    @if($status === 'tiba') bg-emerald-50 text-emerald-700 border border-emerald-200
                    @elseif($status === 'jalan') bg-blue-50 text-blue-700 border border-blue-200
                    @else bg-amber-50 text-amber-700 border border-amber-200
                    @endif">
                    {{ $status === 'tiba' ? 'Diterima' : ($status === 'jalan' ? 'Sedang Diantar' : 'Menunggu Pengantaran') }}
                </span>
            </div>

            {{-- Action Buttons --}}
            <div class="p-5 flex flex-col gap-3">
                @if($status === 'proses')
                    {{-- Status awal: Menunggu Pengantaran, tombolnya langsung mengubah ke 'jalan' --}}
                    <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-amber-50 border border-amber-200">
                        <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-sm text-amber-800">Menunggu Pengantaran</div>
                            <div class="text-[11px] text-amber-600">Kurir siap berangkat dari Hub Logistik</div>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('admin.pengiriman.update-status', $idPesanan) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="jalan">
                        <button type="submit"
                            class="w-full flex items-center justify-between gap-4 bg-[#22543D] hover:bg-[#1a4230] text-white rounded-2xl px-5 py-4 transition-colors group">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <div class="font-bold text-sm">Kurir Berangkat</div>
                                    <div class="text-[11px] text-white/70">Klik saat kurir mulai mengantar barang</div>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-white/50 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </form>

                @elseif($status === 'jalan')
                    <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-blue-50 border border-blue-200">
                        <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-sm text-blue-800">Sedang Diantar</div>
                            <div class="text-[11px] text-blue-600">Kurir dalam perjalanan menuju tujuan</div>
                        </div>
                    </div>
                    {{-- Konfirmasi diterima dengan upload foto --}}
                    <button type="button" onclick="bukaKonfirmasiTiba()"
                        class="w-full flex items-center justify-between gap-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl px-5 py-4 transition-colors group">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="text-left">
                                <div class="font-bold text-sm">Konfirmasi Diterima</div>
                                <div class="text-[11px] text-white/70">Upload foto bukti penerimaan barang</div>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-white/50 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                @else
                    <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-emerald-50 border border-emerald-200">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-sm text-emerald-800">Barang Sudah Diterima</div>
                            <div class="text-[11px] text-emerald-600">Pengiriman telah selesai</div>
                        </div>
                    </div>
                    @if($fotoTerima)
                    <a href="{{ $fotoTerima }}" target="_blank"
                        class="flex items-center gap-3 px-5 py-3 rounded-2xl border border-[#d7e6de] bg-[#f0fdf4] hover:bg-[#d1fae5] transition-colors">
                        <svg class="w-5 h-5 text-[#22543D]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-semibold text-[#22543D]">Lihat Foto Bukti Diterima</span>
                    </a>
                    @endif
                @endif
            </div>
        </div>

        {{-- Card: Tujuan & Barang --}}
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white rounded-[20px] border border-[#d7e6de] shadow-sm p-4">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-[#22543D]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[#7c8b84]">Tujuan</span>
                </div>
                <div class="text-sm font-bold text-gray-800">{{ $pemesan }}</div>
                <div class="text-[11px] text-gray-500 mt-1 leading-relaxed">{{ $alamat }}</div>
            </div>

            <div class="bg-white rounded-[20px] border border-[#d7e6de] shadow-sm p-4">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-[#22543D]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[#7c8b84]">Item</span>
                </div>
                @foreach($barangList as $b)
                <div class="text-sm font-bold text-gray-800">{{ $b['nama'] }}</div>
                @if(isset($b['jumlah']))
                <div class="text-[11px] text-gray-500 mt-0.5">{{ $b['jumlah'] }}x {{ $b['kategori'] ?? '' }}</div>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    {{-- ══ KANAN: Timeline + Info Penerima ══ --}}
    <div class="flex flex-col gap-5">

        {{-- Status Timeline --}}
        <div class="bg-white rounded-[24px] border border-[#d7e6de] shadow-sm p-5">
            <div class="text-[10px] font-bold uppercase tracking-widest text-[#7c8b84] mb-4">Status Timeline</div>

            <div class="flex flex-col gap-0">
                @foreach($steps as $i => $step)
                @php
                    $done    = $i <= $currentIdx;
                    $current = $i === $currentIdx;
                @endphp
                <div class="flex gap-3">
                    {{-- dot + line --}}
                    <div class="flex flex-col items-center w-7 flex-shrink-0">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center mt-0.5
                            {{ $done ? 'bg-[#22543D]' : 'bg-gray-100 border border-gray-200' }}">
                            @if($done)
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                            @endif
                        </div>
                        @if($i < count($steps) - 1)
                            <div class="w-0.5 flex-1 my-1 {{ $done ? 'bg-[#22543D]/30' : 'bg-gray-100' }}"></div>
                        @endif
                    </div>
                    {{-- text --}}
                    <div class="pb-4 flex-1 pt-0.5">
                        <div class="text-sm font-{{ $current ? 'bold' : 'semibold' }} {{ $done ? 'text-gray-800' : 'text-gray-400' }}">
                            {{ $step['label'] }}
                        </div>
                        <div class="text-[11px] {{ $done ? 'text-gray-500' : 'text-gray-300' }} mt-0.5 leading-relaxed">
                            {{ $step['desc'] }}
                        </div>
                        @if($current && $status !== 'tiba')
                        <div class="mt-1 text-[10px] text-[#22543D] font-bold">● Status saat ini</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Info Penerima --}}
        <div class="bg-white rounded-[24px] border border-[#d7e6de] shadow-sm p-5">
            <div class="text-[10px] font-bold uppercase tracking-widest text-[#7c8b84] mb-4">Informasi Penerima</div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-[#22543D] flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr($pemesan, 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-sm text-gray-800">{{ $pemesan }}</div>
                    <div class="text-[11px] text-gray-500">Penerima</div>
                </div>
            </div>
            <div class="flex flex-col gap-3">
                <div class="flex justify-between items-start">
                    <span class="text-[11px] text-gray-500">Kontak</span>
                    <span class="text-[11px] font-semibold text-gray-700">{{ $noHp }}</span>
                </div>
                <div class="flex justify-between items-start">
                    <span class="text-[11px] text-gray-500">Waktu Sewa</span>
                    <span class="text-[11px] font-semibold text-gray-700">{{ $tglMulai }} – {{ $tglSelesai }}</span>
                </div>
                <div class="flex justify-between items-start">
                    <span class="text-[11px] text-gray-500">ID Pesanan</span>
                    <span class="text-[11px] font-semibold text-[#22543D]">{{ $idPesanan }}</span>
                </div>
            </div>
            <a href="tel:{{ $noHp }}"
                class="mt-4 w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-[#d7e6de] text-sm font-semibold text-[#22543D] hover:bg-[#f0fdf4] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 7V5z"/>
                </svg>
                Hubungi Penerima
            </a>
        </div>
    </div>
</div>

{{-- ══ MODAL KONFIRMASI TERIMA ══ --}}
<div id="modalKonfTiba" style="display:none; position:fixed; inset:0; z-index:99999; background:rgba(0,0,0,0.55); overflow-y:auto;" onclick="if(event.target===this)tutupKonfirmasiTiba()">
    <div style="position:relative; margin:60px auto; background:white; border-radius:24px; width:90%; max-width:420px; overflow:hidden; box-shadow:0 25px 60px rgba(0,0,0,0.25); font-family:'Inter',sans-serif;">

        <div style="padding:20px 22px 16px; border-bottom:1px solid #eef4f0;">
            <div style="font-weight:700; font-size:16px; color:#22543D; font-family:'Playfair Display',Georgia,serif;">Konfirmasi Diterima</div>
            <div style="font-size:12px; color:#9ca3af; margin-top:4px;">Upload foto bukti barang telah diterima oleh pelanggan.</div>
        </div>

        <div style="padding:20px 22px;">
            <label style="font-size:11px; font-weight:600; color:#374151; display:block; margin-bottom:10px;">Foto Bukti Diterima <span style="color:#ef4444;">*</span></label>

            <div id="dropZoneTiba" onclick="document.getElementById('fotoTerimaTiba').click()"
                style="border:2px dashed #d1d5db; border-radius:16px; padding:24px 16px; background:#f9fafb; cursor:pointer; text-align:center; transition:all .2s;">
                <div style="font-size:28px; margin-bottom:6px;">🖼️</div>
                <div style="font-size:13px; font-weight:600; color:#6b7280;">Klik untuk pilih foto</div>
                <div style="font-size:11px; color:#9ca3af; margin-top:3px;">JPG, PNG, WEBP — maks. 5 MB</div>
                <input type="file" id="fotoTerimaTiba" accept="image/*" style="display:none;" onchange="previewFotoTiba(this)">
            </div>

            <div id="previewWrapTiba" style="display:none; margin-top:12px; border-radius:14px; overflow:hidden; border:1px solid #d1fae5;">
                <img id="previewImgTiba" src="" alt="Preview" style="width:100%; max-height:200px; object-fit:cover; display:block;">
                <div style="padding:10px 12px; display:flex; align-items:center; justify-content:space-between; background:#f0fdf4;">
                    <div style="font-size:11px; font-weight:700; color:#1f2937;" id="namaFileTiba">-</div>
                    <button type="button" onclick="hapusFotoTiba()" style="background:#fee2e2; border:none; border-radius:8px; padding:5px 10px; font-size:10px; font-weight:700; color:#ef4444; cursor:pointer;">Hapus</button>
                </div>
            </div>
        </div>

        <div style="padding:12px 22px; border-top:1px solid #eef4f0; display:flex; gap:10px;">
            <button onclick="tutupKonfirmasiTiba()" style="flex:1; padding:11px; border:1px solid #e5e7eb; border-radius:12px; background:white; cursor:pointer; font-size:12px; font-weight:600; font-family:'Inter',sans-serif;">Batal</button>
            <button onclick="submitTiba()" style="flex:1; padding:11px; border:none; border-radius:12px; background:#22543D; color:white; cursor:pointer; font-size:12px; font-weight:700; font-family:'Inter',sans-serif;">Simpan & Konfirmasi</button>
        </div>
    </div>
</div>

<script>
function bukaKonfirmasiTiba() {
    document.getElementById('modalKonfTiba').style.display = 'block';
}
function tutupKonfirmasiTiba() {
    document.getElementById('modalKonfTiba').style.display = 'none';
    hapusFotoTiba();
}
function previewFotoTiba(input) {
    if (!input.files || !input.files[0]) return;
    var file = input.files[0];
    if (file.size > 5 * 1024 * 1024) { alert('Ukuran foto maksimal 5 MB.'); input.value = ''; return; }
    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('previewImgTiba').src = e.target.result;
        document.getElementById('namaFileTiba').textContent = file.name;
        document.getElementById('dropZoneTiba').style.display = 'none';
        document.getElementById('previewWrapTiba').style.display = 'block';
    };
    reader.readAsDataURL(file);
}
function hapusFotoTiba() {
    document.getElementById('fotoTerimaTiba').value = '';
    document.getElementById('previewImgTiba').src = '';
    document.getElementById('previewWrapTiba').style.display = 'none';
    document.getElementById('dropZoneTiba').style.display = 'block';
}
function submitTiba() {
    var foto = document.getElementById('fotoTerimaTiba').files[0];
    if (!foto) { alert('Mohon upload foto bukti terlebih dahulu.'); return; }

    var formData = new FormData();
    formData.append('status', 'tiba');
    formData.append('foto_terima', foto);
    formData.append('_method', 'PATCH');
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

    fetch('{{ route("admin.pengiriman.update-status", $idPesanan) }}', {
        method: 'POST',
        deskripsi: formData
    }).then(function(res) {
        if (res.ok) { window.location.reload(); }
        else { alert('Gagal menyimpan. Coba lagi.'); }
    }).catch(function() { alert('Terjadi kesalahan jaringan.'); });
}
function cetakSuratJalan() {
    window.print();
}
</script>

@endsection