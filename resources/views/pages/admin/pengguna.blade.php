@extends('layouts.admin')

@section('title', 'Pengguna - Camplore Admin')

@section('content')

<div class="mb-6">
    @include('components.navbar_judul_LP', [
        'NavParent' => 'Manajemen Operasional',
        'section' => 'Pengguna'
    ])
</div>

<div class="max-w-full">
    <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#eef4f0]">
            <div>
                <h2 class="text-2xl font-bold text-[#22543D] leading-tight" style="font-family:'Playfair Display',Georgia,serif;">Data Pengguna</h2>
                <p class="text-[11px] text-[#7c8b84] mt-0.5">Kelola semua data customer yang terdaftar</p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 px-6 py-4 border-b border-[#eef4f0]">
            <div class="relative flex-1 max-w-xs">
                <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                </div>
                <input type="text" id="searchInput" placeholder="Cari Nama Pengguna..."
                    class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl bg-gray-50 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D]">
            </div>
            <span class="text-[11px] font-bold text-[#22543D] uppercase tracking-widest flex items-center">
                Total: {{ $customers->count() }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#f1f8f4] text-[10px] font-bold uppercase tracking-widest text-[#22543D] border-b border-[#eef4f0]">
                    <tr>
                        <th class="px-6 py-3 w-10">No</th>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Alamat</th>
                        <th class="px-6 py-3">NIK</th>
                        <th class="px-6 py-3">No HP</th>
                        <th class="px-6 py-3 text-center">KTP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#eef4f0]" id="tableBody">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-[#fcfdfb] transition-colors customer-row">
                        <td class="px-6 py-4 text-gray-400 font-medium">{{ $loop->iteration }}</td>

                        {{-- Nama --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#22543D]/10 flex items-center justify-center text-[#22543D] font-bold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                                <button type="button"
                                    onclick="bukaModal({{ $customer->id }}, '{{ addslashes($customer->name) }}')"
                                    class="font-semibold text-[#22543D] hover:underline text-left cursor-pointer bg-transparent border-0 p-0">
                                    {{ $customer->name }}
                                </button>
                            </div>
                        </td>

                        {{-- Alamat --}}
                        <td class="px-6 py-4">
                            <p class="text-[11px] text-gray-500 max-w-[180px] leading-relaxed">
                        @php
                            $sa = $customer->shippingAddress;
                            $alamat = $sa
                                ? implode(', ', array_filter([
                                    $sa->full_address,
                                    $sa->city,
                                    $sa->district,
                                    $sa->postal_code,
                                ]))
                                : '-';
                        @endphp
                        {{ $alamat }}</p>
                        </td>

                        {{-- NIK --}}
                        <td class="px-6 py-4 text-gray-500">{{ $customer->nik ?? '-' }}</td>

                        {{-- No HP --}}
                        <td class="px-6 py-4 text-gray-500">{{ $customer->phone ?? '-' }}</td>

                        {{-- KTP --}}
                        <td class="px-6 py-4 text-center">
                            @if(!empty($customer->document))
                                @php
                                    // Untuk dummy data pakai placeholder KTP, untuk data real pakai Storage::url
                                    $ktpUrl = str_starts_with($customer->document, 'dummy/')
                                        ? 'https://placehold.co/640x400/22543D/ffffff?text=KTP+' . urlencode($customer->name)
                                        : Storage::url($customer->document);
                                @endphp
                                <button type="button"
                                    onclick="bukaKTP('{{ addslashes($customer->name) }}', '{{ $ktpUrl }}')"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#22543D]/10 hover:bg-[#22543D]/20 text-[#22543D] text-[10px] font-bold uppercase border border-[#22543D]/20 transition-colors">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="5" width="20" height="14" rx="3"/>
                                        <circle cx="8" cy="12" r="2"/>
                                        <path d="M14 10h4M14 14h4"/>
                                    </svg>
                                    Lihat KTP
                                </button>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gray-100 text-gray-400 text-[10px] font-bold uppercase border border-gray-200">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="5" width="20" height="14" rx="3"/>
                                        <circle cx="8" cy="12" r="2"/>
                                        <path d="M14 10h4M14 14h4"/>
                                    </svg>
                                    Belum Ada
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-400">Belum ada data customer</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($customers) && method_exists($customers, 'hasPages') && $customers->hasPages())
        <div class="px-6 py-4 bg-[#fcfdfb] border-t border-[#eef4f0]">
            {{ $customers->links() }}
        </div>
        @endif

    </div>
</div>

{{-- ═══════════════════════ MODAL RIWAYAT SEWA ═══════════════════════ --}}
<div id="modalSewa" style="display:none; position:fixed; inset:0; z-index:99999; background:rgba(0,0,0,0.5);" onclick="if(event.target===this)tutupModal()">
    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); background:white; border-radius:16px; padding:24px; width:90%; max-width:480px; box-shadow:0 20px 60px rgba(0,0,0,0.3); font-family:'Inter',sans-serif;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3 id="modalJudul" style="margin:0; font-size:16px; font-weight:700; color:#22543D; font-family:'Playfair Display',Georgia,serif;"></h3>
        </div>
        <div id="modalIsi"></div>
        <div style="margin-top:16px; text-align:right;">
            <button onclick="tutupModal()" style="background:#22543D; color:white; border:none; border-radius:10px; padding:8px 20px; cursor:pointer; font-size:13px; font-family:'Inter',sans-serif;">Tutup</button>
        </div>
    </div>
</div>

{{-- ═══════════════════════ MODAL KTP ═══════════════════════ --}}
<div id="modalKTP" style="display:none; position:fixed; inset:0; z-index:999999; background:rgba(0,0,0,0.7); overflow-y:auto;" onclick="if(event.target===this)tutupKTP()">
    <div style="position:relative; margin:40px auto; background:white; border-radius:20px; width:90%; max-width:540px; overflow:hidden; box-shadow:0 25px 60px rgba(0,0,0,0.35); font-family:'Inter',sans-serif;">

        {{-- Header --}}
        <div style="display:flex; justify-content:space-between; align-items:center; padding:16px 20px; border-bottom:1px solid #eef4f0;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:34px; height:34px; border-radius:10px; background:#22543D; display:flex; align-items:center; justify-content:center;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="14" rx="3"/>
                        <circle cx="8" cy="12" r="2"/>
                        <path d="M14 10h4M14 14h4"/>
                    </svg>
                </div>
                <div>
                    <div style="font-weight:700; font-size:14px; color:#22543D;">Foto KTP</div>
                    <div id="ktpNama" style="font-size:11px; color:#9ca3af; margin-top:1px;"></div>
                </div>
            </div>
            <button onclick="tutupKTP()" style="background:#f3f4f6; border:none; border-radius:50%; width:30px; height:30px; font-size:16px; cursor:pointer; color:#6b7280; display:flex; align-items:center; justify-content:center; line-height:1;">×</button>
        </div>

        {{-- Foto KTP --}}
        <div style="padding:20px; background:#f9fafb;">
            <div style="border-radius:14px; overflow:hidden; border:1px solid #e5e7eb; background:white; box-shadow:0 4px 12px rgba(0,0,0,0.06);">
                <img id="ktpImg" src="" alt="Foto KTP"
                    style="width:100%; display:block; object-fit:contain; max-height:340px; background:#f3f4f6;">
            </div>

            {{-- Info strip --}}
            <div style="margin-top:12px; padding:10px 14px; background:#d1fae5; border-radius:12px; display:flex; align-items:center; gap:8px; border:1px solid #6ee7b7;">
                <span style="font-size:16px;">🪪</span>
                <div>
                    <div id="ktpNamaStrip" style="font-size:12px; font-weight:700; color:#065f46;"></div>
                    <div style="font-size:10px; color:#059669; margin-top:1px;">Kartu Tanda Penduduk — Data terverifikasi</div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div style="padding:12px 20px; border-top:1px solid #eef4f0; display:flex; justify-content:space-between; align-items:center;">
            <a id="ktpDownloadLink" href="#" download
                style="display:inline-flex; align-items:center; gap:6px; font-size:11px; font-weight:600; color:#6b7280; text-decoration:none;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Unduh KTP
            </a>
            <button onclick="tutupKTP()" style="background:#22543D; color:white; border:none; border-radius:10px; padding:9px 22px; font-size:12px; font-weight:700; cursor:pointer; font-family:'Inter',sans-serif;">Tutup</button>
        </div>
    </div>
</div>

<script>
var rentalData = {
    1: [
        { product: 'Tenda Dome 4P', brand: 'Consina', tipe: 'Tenda' },
        { product: 'Sleeping Bag Ultra', brand: 'Eiger', tipe: 'Sleeping Bag' },
        { product: 'Canon EOS 200D', brand: 'Canon', tipe: 'DSLR' },
    ],
    2: [
        { product: 'Carrier 60L', brand: 'Deuter', tipe: 'Carrier / Backpack' },
        { product: 'Sony Alpha A6000', brand: 'Sony', tipe: 'Mirrorless' },
    ],
    3: [],
    4: [
        { product: 'Matras Gunung Pro', brand: 'Karrimor', tipe: 'Matras' },
        { product: 'GoPro Hero 11', brand: 'GoPro', tipe: 'Kamera Aksi' },
    ]
};

function bukaModal(id, nama) {
    var list = rentalData[id] || [];
    document.getElementById('modalJudul').textContent = nama + ' — ' + list.length + 'x Sewa';
    var html = '';
    if (list.length === 0) {
        html = '<p style="text-align:center;color:#9ca3af;padding:20px 0;">Belum ada riwayat sewa</p>';
    } else {
        for (var i = 0; i < list.length; i++) {
            html += '<div style="display:flex;justify-content:space-between;align-items:center;padding:10px 12px;border-radius:10px;border:1px solid #eef4f0;margin-bottom:8px;">'
                  + '<div><div style="font-weight:600;font-size:13px;color:#1f2937;">' + list[i].product + '</div>'
                  + '<div style="font-size:11px;color:#9ca3af;">' + list[i].brand + '</div></div>'
                  + '<span style="background:#d1fae5;color:#065f46;padding:3px 10px;border-radius:999px;font-size:10px;font-weight:700;text-transform:uppercase;">' + list[i].tipe + '</span>'
                  + '</div>';
        }
    }
    document.getElementById('modalIsi').innerHTML = html;
    document.getElementById('modalSewa').style.display = 'block';
}

function tutupModal() {
    document.getElementById('modalSewa').style.display = 'none';
}

// ── MODAL KTP ─────────────────────────────────────────────
function bukaKTP(nama, urlFoto) {
    document.getElementById('ktpNama').textContent      = nama;
    document.getElementById('ktpNamaStrip').textContent = nama;
    document.getElementById('ktpImg').src               = urlFoto;
    document.getElementById('ktpDownloadLink').href     = urlFoto;
    document.getElementById('modalKTP').style.display   = 'block';
}

function tutupKTP() {
    document.getElementById('modalKTP').style.display = 'none';
    document.getElementById('ktpImg').src = '';
}

// ── SEARCH ────────────────────────────────────────────────
document.getElementById('searchInput').addEventListener('input', function() {
    var q = this.value.toLowerCase();
    document.querySelectorAll('.customer-row').forEach(function(row) {
        row.style.display = row.textContent.toLowerCase().indexOf(q) !== -1 ? '' : 'none';
    });
});
</script>

@endsection