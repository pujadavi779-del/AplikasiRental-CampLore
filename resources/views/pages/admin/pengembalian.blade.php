@extends('layouts.admin')

@section('title', 'Manajemen Pengembalian - CampLore')

@section('content')

<div class="fixed top-5 right-6 z-40 left-[calc(272px+24px)] max-sm:left-6">
    @include('components.navbar_judul_LP', [
    'NavParent' => 'Manajemen Operasional',
    'section' => 'Pengembalian'
    ])
</div>

<div class="max-w-full ">
    <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">
        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#eef4f0]">
            <div>
                <h2 class="text-2xl font-bold text-[#22543D] font-serif leading-tight">
                    Pengembalian
                </h2>
                <p class="text-[11px] text-[#7c8b84] mt-0.5">
                    Pantau status pengembalian barang dan denda pelanggan.
                </p>
            </div>
        </div>

        {{-- TABLE CONTAINER --}}
        <div class="p-5 bg-[#fcfdfb]">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" />
                    </svg>
                </span>
                <input type="text" placeholder="Cari nama pelanggan atau produk..."
                    class="w-full bg-white border border-[#d7e6de] text-sm py-2.5 pl-11 pr-4 rounded-xl outline-none focus:ring-2 focus:ring-[#22543D]/10 focus:border-[#22543D] transition-all shadow-sm">
            </div>
        </div>

        <div class="overflow-x-auto">
            {{-- table-fixed digunakan agar lebar kolom konsisten --}}
            <table class="w-full text-left table-fixed min-w-[1000px]">
                <thead class="bg-[#f1f8f4] text-[#22543D] uppercase text-[10px] font-bold tracking-widest">
                    <tr class="border-b border-[#e4f0ea]">
                        {{-- Border kanan ditambahkan dengan border-r --}}
                        <th class="px-6 py-4 border-r border-[#e4f0ea] w-[15%]">Pemesan</th>
                        <th class="px-4 py-4 text-center border-r border-[#e4f0ea] w-[12%]">No HP</th>
                        <th class="px-4 py-4 border-r border-[#e4f0ea] w-[25%]">Alamat</th>
                        <th class="px-4 py-4 border-r border-[#e4f0ea] w-[15%]">Produk</th>
                        <th class="px-4 py-4 text-center border-r border-[#e4f0ea] w-[10%]">Tgl Kembali</th>
                        <th class="px-4 py-4 text-center border-r border-[#e4f0ea] w-[10%]">Denda</th>
                        <th class="px-6 py-4 text-center w-[13%]">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#eef4f0]">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 border-r border-[#eef4f0] whitespace-normal break-words">
                            <div class="text-sm font-bold text-[#22543D]">Andi Pratama</div>
                            <div class="text-[10px] text-gray-400 uppercase">INV-2026001</div>
                        </td>
                        <td class="px-4 py-4 text-center border-r border-[#eef4f0]">
                            <span class="text-[11px] font-mono text-gray-600">0812-3456-7890</span>
                        </td>
                        {{-- Class whitespace-normal dan break-words membuat teks turun ke bawah --}}
                        <td class="px-4 py-4 border-r border-[#eef4f0] whitespace-normal break-words">
                            <div class="text-[11px] text-gray-600 leading-relaxed">
                                Jl. Sungai Langkai No. 19, Sagulung, Kota Batam, Kepulauan Riau, ID 29439
                            </div>
                        </td>
                        <td class="px-4 py-4 border-r border-[#eef4f0] whitespace-normal break-words">
                            <div class="text-xs font-medium text-[#22543D]">Canon EOS R6 + Tripod Takara</div>
                        </td>
                        <td class="px-4 py-4 text-center border-r border-[#eef4f0] text-xs text-gray-600 uppercase">
                            18 Apr 2026
                        </td>
                        <td class="px-4 py-4 text-center border-r border-[#eef4f0]">
                            <span class="text-xs font-bold text-red-500 tracking-tight">IDR 0.00</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button onclick="openModal('Tandai Sudah Dikembalikan', 'Canon EOS R6')"
                                class="inline-flex items-center justify-center w-full px-2 py-2 bg-[#f1f8f4] hover:bg-[#22543D] hover:text-white border border-[#d7e6de] text-[#22543D] rounded-lg text-[9px] font-black transition-all active:scale-95 shadow-sm uppercase">
                                Tandai Kembali
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination / Footer --}}
        <div class="p-5 bg-[#fcfdfb] border-t border-[#eef4f0] flex items-center justify-between">
            <p class="text-[10px] font-bold text-[#22543D] uppercase tracking-widest">
                Menampilkan {{ count($pengiriman ?? []) }} data pengiriman
            </p>
            <div class="flex gap-1.5">
                <button class="w-9 h-9 flex items-center justify-center border border-gray-100 rounded-xl text-gray-400 hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7" stroke-width="2" />
                    </svg>
                </button>
                <button class="w-9 h-9 flex items-center justify-center bg-[#22543D] text-white font-bold text-xs rounded-xl shadow-lg shadow-[#22543D]/20">1</button>
                <button class="w-9 h-9 flex items-center justify-center border border-gray-100 rounded-xl text-gray-400 hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7" stroke-width="2" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>

{{-- MODAL POPUP --}}
<div id="statusModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#1a2e23]/40 backdrop-blur-sm transition-all duration-300 opacity-0">
    <div class="bg-[#f4f5ed] w-[90%] max-w-sm rounded-[28px] p-8 shadow-2xl border border-[#c8c9b4] text-center relative transform scale-95 transition-all duration-300" id="modalCard">
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 bg-[#22543D] rounded-full flex items-center justify-center border-4 border-[#dff0c0] shadow-sm">
                <svg class="w-8 h-8 text-[#dff0c0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7" stroke-width="3" />
                </svg>
            </div>
        </div>

        <h3 class="text-lg font-bold text-[#22543D] mb-1" id="modalUser">Konfirmasi</h3>

        <p class="text-[11px] text-gray-500 leading-relaxed mb-6 px-4">
            Pastikan unit <span class="font-bold text-[#ED64A6]" id="modalProduct"></span>
            telah diperiksa dan diterima kembali oleh tim CampLore.
        </p>

        <div class="flex gap-3">
            <button onclick="closeModal()"
                class="flex-1 px-4 py-3 bg-gray-100 text-gray-500 text-[10px] font-bold rounded-2xl hover:bg-gray-200 transition-colors">
                BATAL
            </button>

            <button onclick="confirmAction()"
                class="flex-1 px-4 py-3 bg-[#22543D] text-white text-[10px] font-bold rounded-2xl hover:bg-[#1B4332] transition-all shadow-md">
                KONFIRMASI
            </button>
        </div>
    </div>
</div>
</div>

<script>
    function openModal(name, product) {
        const modal = document.getElementById('statusModal');
        const card = document.getElementById('modalCard');

        // isi data
        document.getElementById('modalUser').innerText = name;
        document.getElementById('modalProduct').innerText = product;

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(() => {
            modal.classList.add('opacity-100');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('statusModal');
        const card = document.getElementById('modalCard');

        modal.classList.remove('opacity-100');
        card.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }

    function confirmAction() {
        alert('Status Berhasil Diperbarui!');
        closeModal();
    }

    // klik luar modal
    window.onclick = function(event) {
        const modal = document.getElementById('statusModal');
        if (event.target === modal) {
            closeModal();
        }
    }
</script>

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
</style>

@endsection