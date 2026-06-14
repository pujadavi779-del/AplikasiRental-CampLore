@extends('layouts.admin')

@section('title', 'Manajemen Produk - CampLore')

@php
$NavParent = 'Manajemen Rental';
$section = 'Produk';
@endphp
@section('content')


<div class="max-w-full">
    {{-- Toast Success --}}
    @if(session('success'))
    <div id="toast-success" class="fixed top-6 right-6 z-50 flex items-center w-full max-w-sm p-4 text-gray-700 bg-white rounded-xl shadow-lg border border-emerald-200" role="alert">
        <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-emerald-600 bg-emerald-100 rounded-lg">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
            </svg>
        </div>
        <div class="ms-3 text-sm font-semibold">{{ session('success') }}</div>
        <button type="button" onclick="this.closest('#toast-success').remove()"
            class="ms-auto flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    {{-- Toast Error --}}
    @if(session('error'))
    <div id="toast-error" class="fixed top-6 right-6 z-50 flex items-center w-full max-w-sm p-4 text-gray-700 bg-white rounded-xl shadow-lg border border-red-200" role="alert">
        <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
        <div class="ms-3 text-sm font-semibold">{{ session('error') }}</div>
        <button type="button" onclick="this.closest('#toast-error').remove()"
            class="ms-auto flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif



    <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

        {{-- HEADER SECTION --}}
        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#eef4f0]">
            <div>
                <h2 class="text-2xl font-bold text-[#22543D]" style="font-family:'Playfair Display',Georgia,serif;">Produk</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-[11px] text-[#7c8b84]">Kelola inventaris kamera dan alat camping</span>
                    <span class="bg-emerald-100 text-[#22543D] text-[10px] font-bold px-2 py-0.5 rounded-full border border-emerald-200">
                        Tersedia ({{ \App\Models\Barang::where('stok', '>', 0)->count() }})
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

        {{-- SEARCH & FILTER BAR --}}
        <div class="p-6 border-b border-[#f1f8f4] flex flex-col md:flex-row gap-4 items-center justify-between">
            <form method="GET" action="{{ route('admin.products') }}" class="relative w-full md:w-80 flex">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari Nama Produk..."
                    class="w-full pl-4 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-[#22543D]">

                <button type="submit" class="ml-2 px-4 bg-[#22543D] hover:bg-[#1B4332] text-white rounded-xl text-xs font-bold transition-colors">
                    Cari
                </button>
            </form>

            <div class="flex gap-2">
                {{-- ALL --}}
                <a href="{{ route('admin.products') }}"
                    class="px-4 py-2 text-xs rounded-lg font-bold transition-colors
                    {{ !request('Kategori') ? 'bg-[#22543D] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Semua
                </a>

                {{-- KAMERA --}}
                <a href="{{ route('admin.products', ['Kategori' => 'Kamera']) }}"
                    class="px-4 py-2 text-xs rounded-lg font-bold transition-colors
                    {{ request('Kategori') == 'Kamera' ? 'bg-[#22543D] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Kamera
                </a>

                {{-- CAMPING --}}
                <a href="{{ route('admin.products', ['Kategori' => 'Camping']) }}"
                    class="px-4 py-2 text-xs rounded-lg font-bold transition-colors
                    {{ request('Kategori') == 'Camping' ? 'bg-[#22543D] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Camping
                </a>
            </div>
        </div>

        {{-- TABLE SECTION --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#fcfdfb] border-b border-[#f1f8f4]">
                        {{-- Judul kolom digabung dan menggunakan colspan="2" agar sejajar sempurna dengan isi di bawahnya --}}
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest" colspan="2">Gambar & Nama Produk</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Kategori</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Harga/Perhari</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f1f8f4]">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50/80 transition-colors">

                        {{-- GAMBAR DAN NAMA PRODUK --}}
                        <td class="px-6 py-4 vertical-align-middle" colspan="2">
                            <div class="flex items-center gap-4">
                                {{-- Kotak Gambar --}}
                                <div class="w-12 h-12 rounded-xl bg-gray-100 border border-[#d7e6de] overflow-hidden shadow-sm flex items-center justify-center flex-shrink-0">
                                    <img src="{{ Str::startsWith($product->gambar_barang, 'http') ? $product->gambar_barang : asset($product->gambar_barang) }}"
                                        onerror="this.src='https://via.placeholder.com/100?text=No+Image'"
                                        class="w-full h-full object-cover">
                                </div>
                                {{-- Teks Nama & Stok --}}
                                <div>
                                    <div class="text-sm font-bold text-[#22543D] mb-0.5">{{ $product->name }}</div>
                                    <div class="text-[10px] font-bold flex items-center gap-1">
                                        @if($product->stok > 0)
                                        <span class="text-emerald-500 text-[8px]">●</span>
                                        <span class="text-emerald-500">Tersedia: {{ $product->stok }} Unit</span>
                                        @else
                                        <span class="text-red-400 text-[8px]">●</span>
                                        <span class="text-red-400">Habis</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- KATEGORI --}}
                        <td class="px-6 py-4 text-center vertical-align-middle">
                            <span class="px-3 py-1 bg-[#f1f8f4] text-[#22543D] text-[10px] font-bold rounded-lg border border-[#d7e6de] inline-block min-w-[70px]">
                                {{ $product->kategori }}
                            </span>
                        </td>

                        {{-- HARGA --}}
                        <td class="px-6 py-4 vertical-align-middle">
                            <div class="text-xs font-bold text-[#22543D]">IDR {{ number_format($product->harga_per_hari, 2) }}</div>
                        </td>

                        {{-- TINDAKAN --}}
                        <td class="px-6 py-4 text-right vertical-align-middle">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                    class="text-[#ED64A6] hover:bg-[#ED64A6]/5 px-2 py-1 rounded-lg transition-colors font-bold text-[11px] flex items-center gap-1">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                    Ubah
                                </a>

                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:bg-red-50/50 px-2 py-1 rounded-lg transition-colors font-bold text-[11px] flex items-center gap-1">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                            <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
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
        <div class="px-6 py-4 bg-[#fcfdfb] border-t border-[#f1f8f4] flex justify-between items-center">
            {{-- Info Total Produk (Sisi Kiri) --}}
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                Menampilkan {{ $products->count() }} dari {{ $products->total() }} Produk
            </span>

            {{-- Navigasi Halaman Bergaya Kustom (Sisi Kanan) --}}
            <div class="flex items-center gap-4">
                {{-- Info Halaman Ke- Berapa --}}
                <span class="text-xs font-semibold text-gray-400 selection:bg-transparent">
                    Halaman <span class="text-gray-900">{{ $products->currentPage() }}</span> dari <span class="text-gray-900">{{ $products->lastPage() }}</span>
                </span>

                {{-- Tombol-Tombol Angka --}}
                <div class="inline-flex gap-1">
                    {{-- Tombol Previous (<) --}}
                    @if ($products->onFirstPage())
                    <button disabled class="px-2.5 py-1.5 border border-gray-200 rounded-lg text-xs font-bold opacity-40 cursor-not-allowed text-gray-400 shadow-sm">
                        &lt;
                    </button>
                    @else
                    <a href="{{ $products->previousPageUrl() }}" class="px-2.5 py-1.5 border border-gray-200 rounded-lg text-xs font-bold transition-colors shadow-sm hover:bg-gray-50 text-gray-700">
                        &lt;
                    </a>
                    @endif

                    {{-- Render Angka Halaman Secara Dinamis --}}
                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @if ($page == $products->currentPage())
                    {{-- Halaman Aktif (Menggunakan warna hijau khas CampLore) --}}
                    <span class="px-3 py-1.5 bg-[#22543D] text-white border border-[#22543D] rounded-lg text-xs font-bold shadow-sm inline-block">
                        {{ $page }}
                    </span>
                    @else
                    {{-- Halaman Biasa --}}
                    <a href="{{ $url }}" class="px-3 py-1.5 border border-gray-200 rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50 transition-all inline-block">
                        {{ $page }}
                    </a>
                    @endif
                    @endforeach

                    {{-- Tombol Next (>) --}}
                    @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="px-2.5 py-1.5 border border-gray-200 rounded-lg text-xs font-bold transition-colors shadow-sm hover:bg-gray-50 text-gray-700">
                        &gt;
                    </a>
                    @else
                    <button disabled class="px-2.5 py-1.5 border border-gray-200 rounded-lg text-xs font-bold opacity-40 cursor-not-allowed text-gray-400 shadow-sm">
                        &gt;
                    </button>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .vertical-align-middle {
        vertical-align: middle !important;
    }
</style>

    {{-- Auto hide toast setelah 3 detik --}}
    <script>
        setTimeout(() => {
            document.getElementById('toast-success')?.remove();
            document.getElementById('toast-error')?.remove();
        }, 3000);
    </script>

@endsection