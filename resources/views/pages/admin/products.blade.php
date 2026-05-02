@extends('layouts.admin')

@section('title', 'Manajemen Produk - CampLore')

@section('content')

<div class="mb-6">
    @include('components.navbar_judul_LP', [
    'NavParent' => 'Manajemen Rental',
    'section' => 'Produk'
    ])
</div>

<div class="max-w-full">
    @if(session('success'))
    <div class="mb-4 p-4 bg-emerald-100 border border-emerald-200 text-[#22543D] rounded-xl text-xs font-bold">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#eef4f0]">
            <div>
                <h2 class="text-2xl font-bold text-[#22543D] font-serif">Produk</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-[11px] text-[#7c8b84]">Kelola inventaris kamera dan alat camping</span>
                    <span class="bg-emerald-100 text-[#22543D] text-[10px] font-bold px-2 py-0.5 rounded-full border border-emerald-200">
                        Tersedia ({{ $products->total() }})
                    </span>
                </div>
            </div>
            <a href="{{ route('admin.products.create') }}" class="bg-[#22543D] hover:bg-[#1B4332] text-white px-5 py-2.5 rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-2">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Tambah Produk
            </a>
        </div>

        {{-- TABLE CONTAINER --}}

        {{-- SEARCH & FILTER BAR --}}
        <div class="p-6 border-b border-[#f1f8f4] flex flex-col md:flex-row gap-4 items-center justify-between">
            <form method="GET" action="{{ route('admin.products') }}" class="relative w-full md:w-80 flex">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search product..."
                    class="w-full pl-4 pr-4 py-2 bg-gray-50 border rounded-xl text-xs">

                <button type="submit" class="ml-2 px-3 bg-[#22543D] text-white rounded-xl text-xs">
                    Cari
                </button>
            </form>

            <div class="flex gap-2">

                {{-- ALL --}}
                <a href="{{ route('admin.products') }}"
                    class="px-4 py-2 text-xs rounded-lg font-bold 
        {{ !request('category') ? 'bg-[#22543D] text-white' : 'bg-gray-100' }}">
                    All
                </a>

                {{-- KAMERA --}}
                <a href="{{ route('admin.products', ['category' => 'Kamera']) }}"
                    class="px-4 py-2 text-xs rounded-lg font-bold 
        {{ request('category') == 'Kamera' ? 'bg-[#22543D] text-white' : 'bg-gray-100' }}">
                    Kamera
                </a>

                {{-- CAMPING --}}
                <a href="{{ route('admin.products', ['category' => 'Camping']) }}"
                    class="px-4 py-2 text-xs rounded-lg font-bold 
        {{ request('category') == 'Camping' ? 'bg-[#22543D] text-white' : 'bg-gray-100' }}">
                    Camping
                </a>

            </div>
        </div>

        {{-- TABLE SECTION --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-[#fcfdfb] border-b border-[#f1f8f4]">
                        <th class="px-6 py-4 w-10"><input type="checkbox" class="accent-[#22543D] rounded"></th>
                        <th class="px-4 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Gambar</th>
                        <th class="px-4 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Produk</th>
                        <th class="px-4 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Kategori</th>
                        <th class="px-4 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Harga/Perhari</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f1f8f4]">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4"><input type="checkbox" class="accent-[#22543D] rounded"></td>
                        <td class="px-4 py-4">
                            <div class="w-12 h-12 rounded-xl bg-gray-100 border border-[#d7e6de] overflow-hidden shadow-sm">
                                <img src="{{ asset('storage/' . $product->image) }}"
                                    onerror="this.src='https://via.placeholder.com/100?text=No+Image'">
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm font-bold text-[#22543D]">{{ $product->name }}</div>
                            <div class="text-[10px] {{ $product->stock > 0 ? 'text-emerald-500' : 'text-red-400' }} font-bold">
                                ● {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
                            </div>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="px-3 py-1 bg-[#f1f8f4] text-[#22543D] text-[10px] font-bold rounded-lg border border-[#d7e6de]">
                                {{ $product->category }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-xs font-bold text-[#22543D]">IDR {{ number_format($product->price_per_day, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                    class="text-[#ED64A6] hover:bg-[#ED64A6]/10 px-3 py-1.5 rounded-lg transition-colors
                                    font-bold text-[11px] flex items-center gap-1 border border-transparent hover:border-[#ED64A6]/20">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                    Edit
                                </a>
                                <button class="text-red-400 hover:bg-red-50 px-3 py-1.5 rounded-lg transition-colors font-bold text-[11px] flex items-center gap-1 border border-transparent hover:border-red-100">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-12 h-12 mb-3 opacity-20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M20 13V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7m16 0v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5m16 0h-2.586a1 1 0 0 0-.707.293l-2.414 2.414a1 1 0 0 1-.707.293h-3.172a1 1 0 0 1-.707-.293l-2.414-2.414A1 1 0 0 0 6.586 13H4" />
                                </svg>
                                <p class="text-sm font-medium italic">Belum ada produk yang ditambahkan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION FOOTER --}}
        <div class="px-6 py-4 bg-[#fcfdfb] border-t border-[#f1f8f4] flex justify-between items-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">
            <span>Showing {{ $products->count() }} Products</span>
            <div class="px-6 py-4 bg-[#fcfdfb] border-t flex justify-between items-center text-xs">
                <span>Total {{ $products->total() }} produk</span>

                <div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
</style>

@endsection