@extends('layouts.admin')

@section('title', 'Data Pemesanan Rental')

@section('content')

<div class="mb-6">
    @include('components.navbar_judul_LP', [
        'NavParent' => 'Manajemen Pesanan',
        'section' => 'Pemesanan'
    ])
</div>

<div class="max-w-full">
    <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="p-6 border-b border-[#eef4f0]">
            <h2 class="text-2xl font-bold text-[#22543D] font-serif">Data Pemesanan Rental</h2>
            <p class="text-[11px] text-[#7c8b84] mt-1">
                Pantau dan kelola semua transaksi rental kamera & camping.
            </p>
        </div>

        {{-- Search --}}
        <div class="px-6 py-4 border-b border-[#eef4f0]">
            <input id="searchInput" type="text" placeholder="Cari nama pelanggan..."
                class="w-full sm:w-72 px-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-xl outline-none">
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-[#f1f8f4] text-[10px] uppercase font-bold tracking-widest text-[#22543D] border-b">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-4 py-3">Pengguna</th>
                        <th class="px-4 py-3">Total Harga</th>
                        <th class="px-4 py-3">Tanggal Sewa</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tableBody" class="divide-y divide-[#eef4f0]">

                    {{-- ORDER 1 (1 PRODUK) --}}
                    <tr>
                        <td class="px-6 py-4 font-mono">CMP-001</td>
                        <td class="px-4 py-4">
                            <div class="font-semibold text-[#22543D]">Andi Pratama</div>
                            <div class="text-[10px] text-gray-400">andi@gmail.com</div>
                        </td>
                        <td class="px-4 py-4 font-bold">Rp 1.500.000</td>
                        <td class="px-4 py-4 text-xs text-gray-500">12 Apr 2026 – 14 Apr 2026</td>
                        <td class="px-4 py-4 text-center">
                            <button onclick="openDetail('detail1')" class="px-4 py-1.5 text-xs text-blue-500 border border-blue-100 rounded-lg hover:bg-blue-50">
                                Detail
                            </button>
                        </td>
                    </tr>

                    {{-- ORDER 2 (MULTI PRODUK) --}}
                    <tr>
                        <td class="px-6 py-4 font-mono">CMP-002</td>
                        <td class="px-4 py-4">
                            <div class="font-semibold text-[#22543D]">Budi Santoso</div>
                            <div class="text-[10px] text-gray-400">budi@mail.com</div>
                        </td>
                        <td class="px-4 py-4 font-bold">Rp 2.250.000</td>
                        <td class="px-4 py-4 text-xs text-gray-500">13 Apr 2026 – 16 Apr 2026</td>
                        <td class="px-4 py-4 text-center">
                            <button onclick="openDetail('detail2')" class="px-4 py-1.5 text-xs text-blue-500 border border-blue-100 rounded-lg hover:bg-blue-50">
                                Detail
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- ================= MODAL DETAIL ================= --}}

{{-- DETAIL 1 --}}
<div id="detail1" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-2xl p-6">
        <h3 class="font-bold text-lg text-[#22543D] mb-3">Detail Pemesanan</h3>

        <p class="text-sm font-semibold mb-1">Produk:</p>
        <ul class="text-sm text-gray-600 list-disc pl-5 mb-3">
            <li>Canon EOS R6 (1 Unit)</li>
        </ul>

        <p class="text-sm mb-2">
            <strong>Tanggal Sewa:</strong><br>
            12 Apr 2026 – 14 Apr 2026
        </p>

        <div class="flex justify-end gap-2 mt-4">
            <button class="px-4 py-2 text-sm border border-red-200 text-red-500 rounded-lg hover:bg-red-50">
                Tolak
            </button>
            <button class="px-4 py-2 text-sm border border-blue-200 text-blue-500 rounded-lg hover:bg-blue-50">
                Terima
            </button>
            <button onclick="closeDetail('detail1')" class="px-4 py-2 text-sm bg-gray-100 rounded-lg">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- DETAIL 2 --}}
<div id="detail2" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-2xl p-6">
        <h3 class="font-bold text-lg text-[#22543D] mb-3">Detail Pemesanan</h3>

        <p class="text-sm font-semibold mb-1">Produk:</p>
        <ul class="text-sm text-gray-600 list-disc pl-5 mb-3">
            <li>Tenda Camping Dome (1 Unit)</li>
            <li>Kompor Portable (1 Unit)</li>
        </ul>

        <p class="text-sm mb-2">
            <strong>Tanggal Sewa:</strong><br>
            13 Apr 2026 – 16 Apr 2026
        </p>

        <div class="flex justify-end gap-2 mt-4">
            <button class="px-4 py-2 text-sm border border-red-200 text-red-500 rounded-lg hover:bg-red-50">
                Tolak
            </button>
            <button class="px-4 py-2 text-sm border border-blue-200 text-blue-500 rounded-lg hover:bg-blue-50">
                Terima
            </button>
            <button onclick="closeDetail('detail2')" class="px-4 py-2 text-sm bg-gray-100 rounded-lg">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    function openDetail(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeDetail(id) {
        document.getElementById(id).classList.add('hidden');
    }

    document.getElementById('searchInput').addEventListener('keyup', function () {
        let value = this.value.toLowerCase();
        document.querySelectorAll('#tableBody tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });
</script>

@endsection