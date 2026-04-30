@extends('layouts.admin')

@section('title', 'Pengguna - Camplore Admin')

@section('content')

<div class="fixed top-5 right-6 z-40 left-[calc(272px+24px)] max-sm:left-6 animate-fade-up">
    @include('components.navbar_judul_LP', [
        'NavParent' => 'Manajemen Operasional',
        'section' => 'Pengguna'
    ])
</div>

<div class="max-w-full">
    <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#eef4f0]">
            <div>
                <h2 class="text-2xl font-bold text-[#22543D] font-serif leading-tight">Data Pengguna</h2>
                <p class="text-[11px] text-[#7c8b84] mt-0.5">Kelola semua data customer yang terdaftar</p>
            </div>
            <a href="{{ route('admin.customers.create') }}"
               class="inline-flex items-center gap-2 bg-[#22543D] hover:bg-[#1B4332] text-white text-xs font-bold px-5 py-2.5 rounded-xl transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                Tambah Customer
            </a>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 px-6 py-4 border-b border-[#eef4f0]">
            <div class="relative flex-1 max-w-xs">
                <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                </div>
                <input type="text" id="searchInput" placeholder="Cari customer..."
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
                        <th class="px-6 py-3">NIK</th>
                        <th class="px-6 py-3">No HP</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#eef4f0]" id="tableBody">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-[#fcfdfb] transition-colors customer-row">
                        <td class="px-6 py-4 text-gray-400 font-medium">{{ $loop->iteration }}</td>
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
                        <td class="px-6 py-4 text-gray-500">{{ $customer->nik ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $customer->phone ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            @php $status = $customer->status ?? 'aktif'; @endphp
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide
                                {{ $status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-500' }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 transition-colors" title="Edit">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </a>
                                <button type="button" onclick="alert('Fitur aktif setelah koneksi database')"
                                    class="p-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-500 transition-colors" title="Hapus">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/>
                                    </svg>
                                </button>
                            </div>
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

{{-- MODAL --}}
<div id="modalSewa" style="display:none; position:fixed; inset:0; z-index:99999; background:rgba(0,0,0,0.5);" onclick="if(event.target===this)tutupModal()">
    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); background:white; border-radius:16px; padding:24px; width:90%; max-width:480px; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3 id="modalJudul" style="margin:0; font-size:16px; font-weight:700; color:#22543D;"></h3>
        </div>
        <div id="modalIsi"></div>
        <div style="margin-top:16px; text-align:right;">
            <button onclick="tutupModal()" style="background:#22543D; color:white; border:none; border-radius:10px; padding:8px 20px; cursor:pointer; font-size:13px;">Tutup</button>
        </div>
    </div>
</div>

{{-- SCRIPT LANGSUNG, TANPA @push --}}
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

document.getElementById('searchInput').addEventListener('input', function() {
    var q = this.value.toLowerCase();
    document.querySelectorAll('.customer-row').forEach(function(row) {
        row.style.display = row.textContent.toLowerCase().indexOf(q) !== -1 ? '' : 'none';
    });
});
</script>

@endsection