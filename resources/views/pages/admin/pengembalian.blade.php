@extends('layouts.admin')

@section('title', 'Pengembalian - CampLore')

@php
$NavParent = 'Manajemen Operasional';
$section = 'Pengembalian';
@endphp

@section('content')

<div class="max-w-full">

    {{-- ══════════ STAT CARDS (REAL-TIME) ══════════ --}}
    @php
    use Carbon\Carbon;
    $hariIni = Carbon::now()->startOfDay();
    $col = collect($data_pengembalian);

    $totalAktif = $col->count();

    // Belum jatuh tempo: tanggal_kembali > hari ini
    $sedangDisewa = $col->filter(function($i) use ($hariIni) {
    if (empty($i->tanggal_kembali)) return false;
    return Carbon::parse($i->tanggal_kembali)->startOfDay()->gt($hariIni);
    })->count();

    // Jatuh tempo hari ini: tanggal_kembali == hari ini
    $menungguPengembalian = $col->filter(function($i) use ($hariIni) {
    if (empty($i->tanggal_kembali)) return false;
    return Carbon::parse($i->tanggal_kembali)->startOfDay()->equalTo($hariIni);
    })->count();

    // Lewat jatuh tempo: tanggal_kembali < hari ini
        $terlambat=$col->filter(function($i) use ($hariIni) {
        if (empty($i->tanggal_kembali)) return false;
        return $hariIni->gt(Carbon::parse($i->tanggal_kembali)->startOfDay());
        })->count();
        @endphp

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Pengembalian</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalAktif }}</p>
                <p class="text-xs text-gray-400 mt-1">Belum dikonfirmasi admin</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Sedang Disewa</p>
                <p class="text-3xl font-bold text-blue-500 mt-1">{{ $sedangDisewa }}</p>
                <p class="text-xs text-gray-400 mt-1">Belum jatuh tempo</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Menunggu Pengembalian</p>
                <p class="text-3xl font-bold text-orange-500 mt-1">{{ $menungguPengembalian }}</p>
                <p class="text-xs text-gray-400 mt-1">Batas kembali hari ini</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Terlambat</p>
                <p class="text-3xl font-bold text-red-500 mt-1">{{ $terlambat }}</p>
                <p class="text-xs text-gray-400 mt-1">Melewati batas waktu</p>
            </div>
        </div>

        {{-- ══════════ TABLE CARD ══════════ --}}
        <div class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">

            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-800">Daftar Pengembalian</h1>
                    <p class="text-sm text-gray-400 mt-0.5">Konfirmasi barang yang sudah dikembalikan pelanggan.</p>
                </div>
                <div class="relative w-full md:w-64">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                    </svg>
                    <input type="text" id="searchInput" placeholder="Cari nama atau produk..."
                        class="w-full pl-9 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">Penyewa</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">ID Order</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">Batas Kembali</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="tableBody">
                        @forelse($data_pengembalian as $item)
                        @php
                        $tglKembali = !empty($item->tanggal_kembali) ? Carbon::parse($item->tanggal_kembali)->startOfDay() : null;

                        // Tiga kondisi status berdasarkan tanggal batas kembali
                        $isBelumJatuhTempo = $tglKembali ? $tglKembali->gt($hariIni) : false;
                        $isJatuhTempoHariIni = $tglKembali ? $tglKembali->equalTo($hariIni) : false;
                        $isOverdue = $tglKembali
                        ? $hariIni->gt($tglKembali->copy()->addDay())
                        : false;

                        // Tombol konfirmasi hanya tampil kalau sudah jatuh tempo (hari ini atau lewat)
                        $bisaKonfirmasi = $isJatuhTempoHariIni || $isOverdue;

                        $hariTerlambat = $isOverdue
                        ? $hariIni->diffInDays($tglKembali) - 1
                        : 0;

                        $totalDenda = $hariTerlambat * 10000;

                        $tglFormatted = $tglKembali ? $tglKembali->format('d M Y') : '-';
                        $products = collect($item->products ?? []);

                        // VALIDASI EXTRA: Memastikan nama_lengkap ditarik dengan benar dari objek atau array relasi
                        $namaUser = '-';
                        if (isset($item->pelanggan)) {
                        $namaUser = is_array($item->pelanggan)
                        ? ($item->pelanggan['nama_lengkap'] ?? $item->pelanggan['name'] ?? '-')
                        : ($item->pelanggan->nama_lengkap ?? $item->pelanggan->name ?? '-');
                        }

                        // Jika relasi langsung null, kita coba fallback mencari alternatif properti di model utama (misal ada duplikasi kolom)
                        if($namaUser == '-') {
                        $namaUser = $item->nama_lengkap ?? $item->nama_pelanggan ?? '-';
                        }

                        $initial = strtoupper(substr(($namaUser && $namaUser != '-') ? $namaUser : 'U', 0, 1));

                        $avatarBgs = ['bg-blue-100 text-blue-700','bg-pink-100 text-pink-700','bg-emerald-100 text-emerald-700','bg-violet-100 text-violet-700','bg-amber-100 text-amber-700'];
                        $avatarClass = $avatarBgs[$loop->index % count($avatarBgs)];

                        $emailUser = is_array($item->pelanggan ?? null)
                        ? ($item->pelanggan['email'] ?? '-')
                        : ($item->pelanggan->email ?? $item->email ?? '-');
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors return-row">

                            {{-- Penyewa --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <div class="font-semibold text-gray-900 text-sm">{{ $namaUser }}</div>
                                        <div class="text-xs text-gray-400">{{ $emailUser }}</div>
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
                                <div class="text-sm font-semibold text-gray-900">{{ $p->name ?? '-' }}</div>
                                @endforeach
                                @if($products->count() > 1)
                                <div class="text-xs text-gray-400 mt-0.5">+ {{ $products->count() - 1 }} item lainnya</div>
                                @endif
                            </td>

                            {{-- Batas Kembali --}}
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold {{ $isOverdue ? 'text-red-500' : 'text-gray-700' }}">
                                    {{ $tglFormatted }}
                                </div>
                                @if($isOverdue)
                                <div class="text-xs text-red-400 mt-0.5">Telat {{ $hariTerlambat }} hari</div>
                                @elseif($isJatuhTempoHariIni)
                                <div class="text-xs text-orange-400 mt-0.5">Hari ini</div>
                                @else
                                <div class="text-xs text-gray-400 mt-0.5">Belum jatuh tempo</div>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @if($isOverdue)
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                    Terlambat
                                </span>
                                @elseif($isJatuhTempoHariIni)
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-orange-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                    Menunggu Pengembalian
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                                    Sedang Disewa
                                </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4">
                                @if($bisaKonfirmasi)
                                <button type="button"
                                    onclick="bukaModalKonfirmasi(
                                '{{ addslashes($namaUser) }}',
                                '{{ $emailUser }}',
                                '{{ $item->id_pesanan }}',
                                {{ json_encode($products->values()->all()) }},
                                '{{ $tglFormatted }}',
                                {{ $isOverdue ? 'true' : 'false' }},
                                {{ (int)$hariTerlambat }},
                                {{ (int)$totalDenda }}
                                )"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold rounded-xl transition-colors
                            {{ $isOverdue ? 'text-white bg-red-500 hover:bg-red-600' : 'text-white bg-[#22543D] hover:bg-[#1a4230]' }}">
                                    @if($isOverdue)
                                    ⚠ Konfirmasi + Denda
                                    @else
                                    ✓ Konfirmasi Kembali
                                    @endif
                                </button>
                                @else
                                <span class="text-xs text-gray-400 italic">Belum bisa dikonfirmasi</span>
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-sm text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p>Tidak ada data pengembalian.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-t border-gray-200">
                <p class="text-xs text-gray-400">Menampilkan {{ $col->count() }} data pengembalian</p>
            </div>
        </div>
</div>

{{-- ══════════ MODAL KONFIRMASI KEMBALI ══════════ --}}
<div id="modalKonfirmasi" class="hidden fixed inset-0 z-[99999] flex items-center justify-center bg-black/50 p-4">
    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div>
                <h3 class="text-sm font-bold text-gray-900">Konfirmasi Pengembalian</h3>
                <p class="text-xs text-gray-400 mt-0.5">Pastikan barang sudah diterima di toko sebelum konfirmasi.</p>
            </div>
            <button onclick="tutupModal()" class="w-7 h-7 flex items-center justify-center border border-gray-200 rounded-lg text-gray-500 hover:bg-gray-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Info Penyewa --}}
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div id="mkAvatar" class="w-10 h-10 rounded-xl bg-[#22543D] text-white flex items-center justify-center font-bold text-sm flex-shrink-0"></div>
                <div>
                    <div id="mkNama" class="text-sm font-bold text-gray-900"></div>
                    <div id="mkKontak" class="text-xs text-gray-400 mt-0.5"></div>
                    <div id="mkIdPesanan" class="text-xs text-gray-400"></div>
                </div>
            </div>
        </div>

        {{-- Produk --}}
        <div class="px-6 py-4 border-b border-gray-100">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Produk yang Dikembalikan</p>
            <div id="mkProdukList" class="space-y-2"></div>
        </div>

        {{-- Status Denda --}}
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-3.5 text-center">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Batas Kembali</p>
                    <p id="mkTglKembali" class="text-sm font-bold text-gray-800"></p>
                </div>
                <div id="mkDendaBox" class="rounded-xl p-3.5 text-center">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Status Denda</p>
                    <p id="mkDendaVal" class="text-sm font-bold"></p>
                    <p id="mkDendaInfo" class="text-xs mt-0.5"></p>
                </div>
            </div>
        </div>

        {{-- Checklist --}}
        <div class="px-6 py-4 border-b border-gray-100">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Checklist Sebelum Konfirmasi</p>
            <div class="space-y-2.5">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" class="w-4 h-4 accent-[#22543D]" id="check1">
                    <span class="text-sm text-gray-700">Barang sudah diterima di toko</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" class="w-4 h-4 accent-[#22543D]" id="check2">
                    <span class="text-sm text-gray-700">Kondisi barang sudah dicek</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer" id="checkDendaWrap" style="display:none">
                    <input type="checkbox" class="w-4 h-4 accent-red-500" id="check3">
                    <span class="text-sm text-red-600 font-semibold">Denda sudah dibayar / dicatat</span>
                </label>
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex items-center gap-3 px-6 py-4">
            <button onclick="tutupModal()"
                class="flex-1 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50">
                Batal
            </button>
            <button onclick="konfirmasiKembali()" id="btnKonfirmasi"
                class="flex-[2] py-2.5 text-sm font-bold text-white bg-[#22543D] rounded-xl hover:bg-[#1a4230] transition-colors">
                ✓ Konfirmasi Barang Kembali
            </button>
        </div>
    </div>
</div>

<script>
    var currentOrderId = null;
    var isOverdueModal = false;

    // Fitur Pencarian
    document.getElementById('searchInput').addEventListener('input', function() {
        var q = this.value.toLowerCase();
        document.querySelectorAll('.return-row').forEach(function(row) {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });

    function bukaModalKonfirmasi(nama, kontak, idPesanan, produk, tglKembali, isOverdue, hariTerlambat, totalDenda) {
        currentOrderId = idPesanan;
        isOverdueModal = isOverdue;

        document.getElementById('check1').checked = false;
        document.getElementById('check2').checked = false;
        document.getElementById('check3').checked = false;

        document.getElementById('mkAvatar').textContent = nama.charAt(0).toUpperCase();
        document.getElementById('mkNama').textContent = nama;
        document.getElementById('mkKontak').textContent = kontak;
        document.getElementById('mkIdPesanan').textContent = 'ID: ' + idPesanan;
        document.getElementById('mkTglKembali').textContent = tglKembali;

        var html = '';
        if (Array.isArray(produk) && produk.length > 0) {
            produk.forEach(function(p) {
                html += '<div class="flex items-center justify-between px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl">' +
                    '<span class="text-sm font-semibold text-gray-900">' + (p.name || '-') + '</span>' +
                    '<span class="text-xs text-gray-400">' + (p.kategori || '') + '</span>' +
                    '</div>';
            });
        } else {
            html = '<div class="text-sm text-gray-400 italic">Tidak ada data produk.</div>';
        }
        document.getElementById('mkProdukList').innerHTML = html;

        var box = document.getElementById('mkDendaBox');
        var val = document.getElementById('mkDendaVal');
        var info = document.getElementById('mkDendaInfo');
        var checkDendaWrap = document.getElementById('checkDendaWrap');

        if (isOverdue) {
            box.className = 'bg-red-50 border border-red-200 rounded-xl p-3.5 text-center';
            val.className = 'text-sm font-bold text-red-600';
            val.textContent = 'Rp ' + Number(totalDenda).toLocaleString('id-ID');
            info.className = 'text-xs mt-0.5 text-red-400';
            info.textContent = hariTerlambat + ' hari · Terlambat';
            checkDendaWrap.style.display = 'flex';

            document.getElementById('btnKonfirmasi').className = 'flex-[2] py-2.5 text-sm font-bold text-white bg-red-500 rounded-xl hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors';
            document.getElementById('btnKonfirmasi').textContent = '⚠ Konfirmasi + Catat Denda';
        } else {
            box.className = 'bg-green-50 border border-green-200 rounded-xl p-3.5 text-center';
            val.className = 'text-sm font-bold text-green-600';
            val.textContent = 'Tidak Ada Denda';
            info.className = 'text-xs mt-0.5 text-green-400';
            info.textContent = 'Tepat waktu ✓';
            checkDendaWrap.style.display = 'none';

            document.getElementById('btnKonfirmasi').className = 'flex-[2] py-2.5 text-sm font-bold text-white bg-[#22543D] rounded-xl hover:bg-[#1a4230] disabled:opacity-50 disabled:cursor-not-allowed transition-colors';
            document.getElementById('btnKonfirmasi').textContent = '✓ Konfirmasi Barang Kembali';
        }

        document.getElementById('modalKonfirmasi').classList.remove('hidden');
    }

    function tutupModal() {
        document.getElementById('modalKonfirmasi').classList.add('hidden');
        currentOrderId = null;
    }

    function konfirmasiKembali() {
        if (!currentOrderId) return;

        var check1 = document.getElementById('check1').checked;
        var check2 = document.getElementById('check2').checked;
        var check3 = document.getElementById('check3').checked;

        if (!check1 || !check2) {
            alert('Mohon centang semua checklist terlebih dahulu.');
            return;
        }
        if (isOverdueModal && !check3) {
            alert('Mohon konfirmasi bahwa denda sudah dibayar/dicatat.');
            return;
        }

        var btn = document.getElementById('btnKonfirmasi');
        btn.disabled = true;
        btn.textContent = 'Memproses...';

        fetch('/admin/pengembalian/' + currentOrderId + '/konfirmasi', {
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
                tutupModal();
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Terjadi kesalahan.');
                    btn.disabled = false;
                }
            })
            .catch(function() {
                alert('Gagal menghubungi server.');
                btn.disabled = false;
            });
    }
</script>

@endsection