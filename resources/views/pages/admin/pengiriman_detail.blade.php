@extends('layouts.admin')
@section('title', 'Detail Pengiriman - Camplore Admin')
@php $NavParent = 'Manajemen Operasional'; $section = 'Pengiriman'; @endphp

@section('content')
@php
    $status    = $pengiriman['status'] ?? 'proses';
    $idPesanan = $pengiriman['id_pesanan'] ?? 'CMP-000';
    $pemesan   = $pengiriman['pemesan'] ?? '-';
    $noHp      = $pengiriman['no_hp'] ?? '-';
    $alamat    = $pengiriman['alamat'] ?? '-';
    $tglMulai  = $pengiriman['tanggal_mulai'] ?? '-';
    $tglSelesai= $pengiriman['tanggal_selesai'] ?? '-';
    $isPickup  = ($pengiriman['metode_pengiriman'] ?? 'delivery') === 'pickup';
    $fotoBukti = $pengiriman['foto_terima'] ?? null;
    $selesai   = in_array($status, ['pengembalian', 'selesai']);

    $barangList = is_array($pengiriman['barang'] ?? null)
        ? $pengiriman['barang']
        : [['nama' => $pengiriman['barang'] ?? '-', 'kategori' => $pengiriman['kategori'] ?? '-']];

    // Timeline steps
    $steps = $isPickup ? [
        ['label' => 'Menunggu Diambil',    'desc' => 'Barang siap diambil di toko.'],
        ['label' => 'Sudah Diambil',       'desc' => 'Pelanggan telah mengambil barang.'],
    ] : [
        ['label' => 'Menunggu Pengantaran','desc' => 'Barang siap diantar oleh kurir.'],
        ['label' => 'Sedang Diantar',      'desc' => 'Barang dalam perjalanan ke pelanggan.'],
        ['label' => 'Menunggu Pengembalian','desc' => 'Masa sewa selesai, menunggu barang dikembalikan.'],
    ];
    $orderMap   = $isPickup
        ? ['proses' => 0, 'pengembalian' => 1, 'selesai' => 1]
        : ['proses' => 0, 'jalan' => 1, 'pengembalian' => 2, 'selesai' => 2];
    $currentIdx = $orderMap[$status] ?? 0;

    // Label teks berdasarkan status & metode
    $statusLabel = match(true) {
        $selesai   => $isPickup ? 'Sudah Diambil'       : 'Menunggu Pengembalian',
        $status === 'jalan' => 'Sedang Diantar',
        default    => $isPickup ? 'Menunggu Diambil'    : 'Menunggu Pengantaran',
    };
    $statusDesc = match(true) {
        $selesai   => $isPickup ? 'Pelanggan telah mengambil barang dari toko.' : 'Barang sedang digunakan pelanggan, menunggu dikembalikan.',
        $status === 'jalan' => 'Kurir sedang dalam perjalanan menuju pelanggan.',
        default    => $isPickup ? 'Barang siap diambil oleh pelanggan di toko.' : 'Klik tombol di bawah saat kurir mulai berangkat.',
    };
    $badgeClass = $selesai ? 'bg-purple-50 text-purple-700 border-purple-200'
        : ($status === 'jalan' ? 'bg-blue-50 text-blue-700 border-blue-200'
        : 'bg-amber-50 text-amber-700 border-amber-200');

    // Butuh modal foto? (proses untuk pickup, jalan untuk delivery)
    $perluFoto = ($isPickup && $status === 'proses') || (!$isPickup && $status === 'jalan');
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-full">

{{-- ══ KIRI ══ --}}
<div class="lg:col-span-2 flex flex-col gap-5">

    {{-- Card: Status --}}
    <div class="bg-white rounded-[24px] border border-[#d7e6de] shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="p-5 flex items-start justify-between gap-3 border-b border-[#eef4f0]">
            <div>
                <div class="text-[10px] font-bold uppercase tracking-widest text-[#7c8b84] mb-1">
                    {{ $isPickup ? 'Status Pickup' : 'Status Pengiriman' }}
                </div>
                <h2 class="text-xl font-bold text-[#22543D]" style="font-family:'Playfair Display',Georgia,serif;">
                    {{ $statusLabel }}
                </h2>
                <p class="text-xs text-[#7c8b84] mt-1">{{ $statusDesc }}</p>
            </div>
            <span class="px-3 py-1.5 rounded-full text-[10px] font-bold uppercase border whitespace-nowrap {{ $badgeClass }}">
                {{ $statusLabel }}
            </span>
        </div>

        {{-- Body: info banner + action button --}}
        <div class="p-5 flex flex-col gap-3">

            {{-- Info banner sesuai status --}}
            @if($selesai)
                {{-- Selesai / pengembalian --}}
                <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-purple-50 border border-purple-200">
                    <div class="w-9 h-9 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $isPickup ? 'M5 13l4 4L19 7' : 'M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6' }}" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-sm text-purple-800">{{ $isPickup ? 'Barang Sudah Diambil' : 'Menunggu Pengembalian' }}</div>
                        <div class="text-[11px] text-purple-600">{{ $isPickup ? 'Menunggu pelanggan mengembalikan barang' : 'Masa sewa selesai — barang harus dikembalikan ke toko' }}</div>
                    </div>
                </div>

            @elseif($status === 'jalan')
                {{-- Kurir sedang jalan --}}
                <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-blue-50 border border-blue-200">
                    <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600 animate-pulse" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-sm text-blue-800">Sedang Diantar</div>
                        <div class="text-[11px] text-blue-600">Kurir dalam perjalanan menuju pelanggan</div>
                    </div>
                </div>

            @else
                {{-- Menunggu (proses) --}}
                <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-amber-50 border border-amber-200">
                    <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $isPickup ? 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z' : 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' }}" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-sm text-amber-800">{{ $isPickup ? 'Menunggu Diambil' : 'Menunggu Pengantaran' }}</div>
                        <div class="text-[11px] text-amber-600">{{ $isPickup ? 'Barang sudah siap di toko, menunggu pelanggan datang' : 'Kurir siap berangkat dari toko' }}</div>
                    </div>
                </div>

                {{-- Tombol aksi tanpa foto (kurir berangkat) --}}
                @if(!$isPickup)
                <form method="POST" action="{{ route('admin.pengiriman.update-status', $idPesanan) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="jalan">
                    <button type="submit"
                        class="w-full flex items-center justify-between gap-4 bg-[#22543D] hover:bg-[#1a4230] text-white rounded-2xl px-5 py-4 transition-colors group">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <div class="text-left">
                                <div class="font-bold text-sm">Kurir Berangkat</div>
                                <div class="text-[11px] text-white/70">Klik saat kurir mulai mengantar barang</div>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-white/50 group-hover:text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </form>
                @endif
            @endif

            {{-- Tombol buka modal foto (pickup: saat proses | kurir: saat jalan) --}}
            @if($perluFoto)
            <button type="button" onclick="document.getElementById('modalFotoBukti').classList.remove('hidden')"
                class="w-full flex items-center justify-between gap-4 bg-[#22543D] hover:bg-[#1a4230] text-white rounded-2xl px-5 py-4 transition-colors group">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $isPickup ? 'M5 13l4 4L19 7' : 'M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6' }}" />
                        </svg>
                    </div>
                    <div class="text-left">
                        <div class="font-bold text-sm">{{ $isPickup ? 'Verifikasi Sudah Diambil' : 'Tandai Selesai Diantar' }}</div>
                        <div class="text-[11px] text-white/70">Upload foto bukti sebagai konfirmasi</div>
                    </div>
                </div>
                <svg class="w-5 h-5 text-white/50 group-hover:text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            @endif

        </div>
    </div>

    {{-- Card: Tujuan & Barang --}}
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white rounded-[20px] border border-[#d7e6de] shadow-sm p-4">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 text-[#22543D]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    @if($isPickup)
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    @else
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    @endif
                </svg>
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#7c8b84]">{{ $isPickup ? 'Metode' : 'Tujuan' }}</span>
            </div>
            @if($isPickup)
            <div class="text-sm font-bold text-gray-800">Ambil di Toko</div>
            <div class="text-[11px] text-gray-500 mt-1">Pelanggan datang langsung ke toko Camplore</div>
            @else
            <div class="text-sm font-bold text-gray-800">{{ $pemesan }}</div>
            <div class="text-[11px] text-gray-500 mt-1 leading-relaxed">{{ $alamat }}</div>
            @endif
        </div>

        <div class="bg-white rounded-[20px] border border-[#d7e6de] shadow-sm p-4">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 text-[#22543D]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
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

    {{-- Card: Foto Bukti (muncul saat status pengembalian/selesai) --}}
    @if($selesai)
    <div class="bg-white rounded-[24px] border border-[#d7e6de] shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-[#eef4f0]">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-[#22543D]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#7c8b84]">
                    {{ $isPickup ? 'Foto Bukti Pengambilan' : 'Foto Bukti Pengiriman' }}
                </span>
            </div>
            @if($fotoBukti)
            <div class="flex gap-2">
                <button onclick="document.getElementById('modalZoomFoto').classList.remove('hidden')"
                    class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                </button>
                <a href="{{ $fotoBukti }}" download
                    class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </a>
            </div>
            @endif
        </div>
        <div class="p-4">
            @if($fotoBukti)
            <div class="rounded-[18px] overflow-hidden border border-[#eef4f0]">
                <img src="{{ $fotoBukti }}" alt="Bukti"
                    class="w-full object-cover max-h-72 cursor-pointer hover:opacity-95 transition-opacity"
                    onclick="document.getElementById('modalZoomFoto').classList.remove('hidden')">
            </div>
            @else
            <div class="rounded-[18px] border-2 border-dashed border-[#d7e6de] bg-[#f8fdf9] flex flex-col items-center justify-center py-10 gap-3">
                <div class="w-14 h-14 rounded-2xl bg-gray-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="text-center">
                    <div class="text-sm font-semibold text-gray-400">Belum ada foto bukti</div>
                    <div class="text-[11px] text-gray-300 mt-0.5">Foto akan muncul setelah dikonfirmasi</div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

</div>

{{-- ══ KANAN ══ --}}
<div class="flex flex-col gap-5">

    {{-- Timeline --}}
    <div class="bg-white rounded-[24px] border border-[#d7e6de] shadow-sm p-5">
        <div class="text-[10px] font-bold uppercase tracking-widest text-[#7c8b84] mb-4">Status Timeline</div>
        <div class="flex flex-col gap-0">
            @foreach($steps as $i => $step)
            @php $done = $i <= $currentIdx; $current = $i === $currentIdx; @endphp
            <div class="flex gap-3">
                <div class="flex flex-col items-center w-7 flex-shrink-0">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center mt-0.5 {{ $done ? 'bg-[#22543D]' : 'bg-gray-100 border border-gray-200' }}">
                        @if($done)
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        @else
                        <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                        @endif
                    </div>
                    @if($i < count($steps) - 1)
                    <div class="w-0.5 flex-1 my-1 {{ $done ? 'bg-[#22543D]/30' : 'bg-gray-100' }}"></div>
                    @endif
                </div>
                <div class="pb-4 flex-1 pt-0.5">
                    <div class="text-sm {{ $done ? 'text-gray-800' : 'text-gray-400' }} {{ $current ? 'font-bold' : 'font-semibold' }}">
                        {{ $step['label'] }}
                    </div>
                    <div class="text-[11px] {{ $done ? 'text-gray-500' : 'text-gray-300' }} mt-0.5 leading-relaxed">
                        {{ $step['desc'] }}
                    </div>
                    @if($current && !$selesai)
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
                <div class="text-[11px] text-gray-500">{{ $isPickup ? 'Pickup' : 'Penerima' }}</div>
            </div>
        </div>
        <div class="flex flex-col gap-3">
            <div class="flex justify-between items-start">
                <span class="text-[11px] text-gray-500">Kontak</span>
                <span class="text-[11px] font-semibold text-gray-700">{{ $noHp }}</span>
            </div>
            @if(!$isPickup)
            <div class="flex justify-between items-start">
                <span class="text-[11px] text-gray-500">Alamat</span>
                <span class="text-[11px] font-semibold text-gray-700 text-right max-w-[60%]">{{ $alamat }}</span>
            </div>
            @endif
            <div class="flex justify-between items-start">
                <span class="text-[11px] text-gray-500">Waktu Sewa</span>
                <span class="text-[11px] font-semibold text-gray-700">{{ $tglMulai }} – {{ $tglSelesai }}</span>
            </div>
            <div class="flex justify-between items-start">
                <span class="text-[11px] text-gray-500">ID Pesanan</span>
                <span class="text-[11px] font-semibold text-[#22543D]">{{ $idPesanan }}</span>
            </div>
            <div class="flex justify-between items-start">
                <span class="text-[11px] text-gray-500">Metode</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold {{ $isPickup ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-600' }}">
                    {{ $isPickup ? 'PICKUP' : 'KURIR' }}
                </span>
            </div>
        </div>
        <a href="tel:{{ $noHp }}"
            class="mt-4 w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-[#d7e6de] text-sm font-semibold text-[#22543D] hover:bg-[#f0fdf4] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 7V5z" />
            </svg>
            Hubungi Penerima
        </a>
    </div>

</div>
</div>

{{-- ══ MODAL FOTO BUKTI (dipakai pickup & kurir) ══ --}}
@if($perluFoto)
<div id="modalFotoBukti" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
    onclick="if(event.target===this) tutupModal()">
    <div class="bg-white rounded-[24px] shadow-2xl w-full max-w-lg overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-[#eef4f0]">
            <div>
                <h3 class="font-bold text-base text-gray-800" style="font-family:'Playfair Display',Georgia,serif;">
                    {{ $isPickup ? 'Bukti Foto Pengambilan' : 'Bukti Foto Pengiriman' }}
                </h3>
                <p class="text-[11px] text-gray-400 mt-0.5">
                    {{ $isPickup ? 'Upload foto konfirmasi barang sudah diambil pelanggan' : 'Upload foto konfirmasi barang sudah diterima pelanggan' }}
                </p>
            </div>
            <button onclick="tutupModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.pengiriman.update-status', $idPesanan) }}" enctype="multipart/form-data">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="pengembalian">

            <div class="px-6 py-5 flex flex-col gap-5">
                {{-- Drop zone --}}
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-widest text-[#7c8b84] mb-2 block">Foto Bukti</label>
                    <div id="dropZone"
                        class="relative border-2 border-dashed border-[#d7e6de] rounded-[20px] bg-[#f8fdf9] hover:border-[#22543D] hover:bg-[#f0fdf4] transition-colors cursor-pointer overflow-hidden"
                        onclick="document.getElementById('inputFoto').click()"
                        ondragover="event.preventDefault(); this.classList.add('border-[#22543D]','bg-[#f0fdf4]')"
                        ondragleave="this.classList.remove('border-[#22543D]','bg-[#f0fdf4]')"
                        ondrop="handleDrop(event)">
                        <div id="dropPlaceholder" class="flex flex-col items-center justify-center py-10 gap-3">
                            <div class="w-14 h-14 rounded-2xl bg-[#22543D]/10 flex items-center justify-center">
                                <svg class="w-7 h-7 text-[#22543D]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                </svg>
                            </div>
                            <div class="text-center">
                                <div class="text-sm font-semibold text-[#22543D]">Klik atau seret foto ke sini</div>
                                <div class="text-[11px] text-gray-400 mt-0.5">JPG, PNG, WEBP · Maks. 5MB</div>
                            </div>
                        </div>
                        <div id="previewFoto" class="hidden">
                            <img id="imgPreview" src="" alt="Preview" class="w-full object-cover max-h-64 rounded-[18px]">
                        </div>
                    </div>
                    <input type="file" id="inputFoto" name="foto_terima" accept="image/*" class="hidden" onchange="previewGambar(this)">
                </div>

                {{-- Panduan --}}
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-amber-700 mb-2">Panduan Foto</div>
                    <ul class="flex flex-col gap-1.5 text-[11px] text-amber-800">
                        <li class="flex gap-2"><span class="text-amber-500 mt-0.5">•</span>Pastikan barang terlihat jelas di tangan pelanggan.</li>
                        <li class="flex gap-2"><span class="text-amber-500 mt-0.5">•</span>{{ $isPickup ? 'Foto diambil saat pelanggan mengambil barang di toko.' : 'Foto diambil di lokasi pengiriman, bukan di toko.' }}</li>
                        <li class="flex gap-2"><span class="text-amber-500 mt-0.5">•</span>Jika foto buram, upload ulang sebelum konfirmasi.</li>
                    </ul>
                </div>
            </div>

            <div class="px-6 pb-5 flex gap-3">
                <button type="button" onclick="tutupModal()"
                    class="flex-1 py-3 rounded-2xl border border-[#d7e6de] text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" id="btnKonfirmasi" disabled
                    class="flex-1 py-3 rounded-2xl bg-[#22543D] text-white text-sm font-bold disabled:opacity-40 disabled:cursor-not-allowed hover:bg-[#1a4230] transition-colors">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $isPickup ? 'Konfirmasi Diambil' : 'Konfirmasi Diterima' }}
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Modal Zoom Foto --}}
@if($fotoBukti && $selesai)
<div id="modalZoomFoto" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm px-4"
    onclick="this.classList.add('hidden')">
    <div class="relative max-w-3xl w-full" onclick="event.stopPropagation()">
        <button onclick="document.getElementById('modalZoomFoto').classList.add('hidden')"
            class="absolute -top-4 -right-4 w-9 h-9 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center z-10">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <img src="{{ $fotoBukti }}" class="w-full rounded-[20px] shadow-2xl object-contain max-h-[80vh]">
    </div>
</div>
@endif

<script>
function tutupModal() {
    document.getElementById('modalFotoBukti').classList.add('hidden');
    document.getElementById('previewFoto').classList.add('hidden');
    document.getElementById('dropPlaceholder').classList.remove('hidden');
    document.getElementById('inputFoto').value = '';
    document.getElementById('btnKonfirmasi').disabled = true;
}
function previewGambar(input) {
    if (!input.files || !input.files[0]) return;
    if (input.files[0].size > 5 * 1024 * 1024) { alert('Maksimal 5MB.'); input.value = ''; return; }
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('imgPreview').src = e.target.result;
        document.getElementById('dropPlaceholder').classList.add('hidden');
        document.getElementById('previewFoto').classList.remove('hidden');
        document.getElementById('btnKonfirmasi').disabled = false;
    };
    reader.readAsDataURL(input.files[0]);
}
function handleDrop(e) {
    e.preventDefault();
    document.getElementById('dropZone').classList.remove('border-[#22543D]','bg-[#f0fdf4]');
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const dt = new DataTransfer(); dt.items.add(file);
        const input = document.getElementById('inputFoto');
        input.files = dt.files;
        previewGambar(input);
    }
}
</script>

@endsection