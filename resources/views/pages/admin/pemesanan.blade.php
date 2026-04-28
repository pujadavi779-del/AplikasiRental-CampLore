@extends('layouts.admin')

@section('title', 'Data Pemesanan Rental')

@section('content')

<div class="fixed top-5 right-6 z-40 left-[calc(272px+24px)] max-sm:left-6 animate-fade-up">
    @include('components.navbar_judul_LP', [
    'NavParent' => 'Manajemen Pesanan',
    'section' => 'Pemesanan'
    ])
</div>

<div class="max-w-full">
    <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#eef4f0]">
            <div>
                <h2 class="text-2xl font-bold text-[#22543D] font-serif leading-tight">Data Pemesanan Rental</h2>
                <p class="text-[11px] text-[#7c8b84] mt-0.5">Pantau dan kelola semua transaksi rental kamera & camping.</p>
            </div>
        </div>

        {{-- Filter --}}
        <div class="flex flex-col sm:flex-row gap-3 px-6 py-4 border-b border-[#eef4f0]">
            <div class="relative flex-1">
                <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                    </svg>
                </div>
                <input type="text" id="searchInput" placeholder="Cari nama pelanggan..." class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl bg-gray-50 outline-none">
            </div>
        </div>

        {{-- Tabel Data --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#f1f8f4] text-[10px] font-bold uppercase tracking-widest text-[#22543D] border-b border-[#eef4f0]">
                    <tr>
                        <th class="px-6 py-3 w-10"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 accent-[#22543D]"></th>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Pengguna</th>
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Total Harga</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="divide-y divide-[#eef4f0]">
                    @foreach($orders as $item)
                    <tr class="hover:bg-[#fcfdfb] transition-colors">
                        <td class="px-6 py-4"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 accent-[#22543D]"></td>
                        <td class="px-4 py-4"><span class="font-mono">ORD-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</span></td>
                        <td class="px-4 py-4">
                            <div class="font-semibold text-[#22543D]">{{ $item->user->name ?? 'User Hilang' }}</div>
                            <div class="text-[10px] text-gray-400">{{ $item->user->email ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-4 text-xs text-gray-500">{{ $item->product->name ?? 'Produk Hilang' }}</td>
                        <td class="px-4 py-4 font-bold text-[#22543D]">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                        <td class="px-4 py-4">
                            @php
                            $badge = [
                            'Aktif' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'Menunggu' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'Selesai' => 'bg-gray-50 text-gray-500 border-gray-200'
                            ][$item->status] ?? 'bg-red-50 text-red-600 border-red-200';
                            @endphp
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-full border {{ $badge }}">{{ $item->status }}</span>
                        </td>
                        <td class="px-4 py-4 text-xs text-gray-400">{{ $item->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center gap-1.5">
                                {{-- TOMBOL EDIT YANG SUDAH FIX --}}
                                <a href="{{ route('admin.orders.edit', $item->id) }}"
                                    class="text-xs text-blue-500 border border-blue-100 rounded-lg px-3 py-1.5 hover:bg-blue-50 transition-colors font-medium">
                                    Edit
                                </a>
                                <form action="{{ route('admin.orders.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 border border-red-100 rounded-lg px-3 py-1.5 hover:bg-red-50 transition-colors font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between px-6 py-4 bg-[#fcfdfb] border-t border-[#eef4f0]">
            <p class="text-[10px] font-bold text-[#22543D] uppercase tracking-widest">Total: {{ $orders->count() }} Pesanan</p>
        </div>
    </div>
</div>

{{-- Script Search Sederhana --}}
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableBody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>

@endsection