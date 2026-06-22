@php
    $NavParent = 'Manajemen Rental';
    $section = 'Mengubah Produk';
@endphp

@extends('layouts.admin')

@section('title', 'Edit Produk - CampLore')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght=400;500;600;700&family=Playfair+Display:wght=400;500;600;700&display=swap');

    * {
        font-family: 'Inter', sans-serif;
    }

    .font-serif {
        font-family: 'Playfair Display', serif !important;
    }
</style>



<div class="max-w-full">

    {{-- Error bag --}}
    @if($errors->any())
    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs font-bold">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="p-6 border-b border-[#eef4f0] flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-[#22543D] font-serif">Mengubah Produk</h2>
                <p class="text-[11px] text-[#7c8b84] mt-1">Perbarui informasi alat rental</p>
            </div>
            <a href="{{ route('admin.products') }}"
                class="text-[#7c8b84] hover:text-[#22543D] text-xs font-bold flex items-center gap-2 transition-colors">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>

        {{-- ===== FORM UTAMA ===== --}}
        <form id="form-edit"
            action="{{ route('admin.products.update', $product->id_barang) }}"
            method="POST"
            enctype="multipart/form-data"
            class="p-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- ===== KIRI: Input Fields ===== --}}
                <div class="space-y-5">

                    {{-- Nama Produk --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">
                            Nama Produk
                        </label>
                        <input type="text" name="name"
                            value="{{ old('name', $product->name) }}"
                            required
                            placeholder="Contoh: Sony Alpha A7 III"
                            class="w-full px-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm
                                     focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D] outline-none transition-all
                                     @error('name') border-red-400 @enderror">
                        @error('name')
                        <p class="mt-1 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stok --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">
                            Stok
                        </label>
                        <input type="number" name="stok" required min="0"
                            value="{{ old('stok', $product->stok) }}"
                            class="w-full px-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm">
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">
                            Kategori
                        </label>
                        <select name="kategori" required
                            class="w-full px-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm
                                       focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D] outline-none
                                       transition-all appearance-none
                                       @error('Kategori_data') border-red-400 @enderror">
                            
                            @foreach(['Kamera','Camping'] as $cat)
                            <option value="{{ $cat }}"
                                {{ old('kategori', $product->kategori) === $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                            @endforeach
                        </select>
                        @error('Kategori_data')
                        <p class="mt-1 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- TIPE --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">
                            Tipe
                        </label>

                        <select name="id_tipe_kategori" required
                            class="w-full px-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm">

                            @foreach($types as $type)
                            <option value="{{ $type->id_kategori }}"
                                {{ old('id_tipe_kategori', $product->id_tipe_kategori) == $type->id_kategori ? 'selected' : '' }}>
                                {{ $type->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- MEREK --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">
                            Merek
                        </label>

                        <select name="id_merek_kategori" required
                            class="w-full px-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm">
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id_kategori }}"
                                {{ old('id_merek_kategori', $product->id_merek_kategori) == $brand->id_kategori ? 'selected' : '' }}>
                                {{ $brand->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Harga Rental / Hari --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">
                            Harga Rental / Hari
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center
                                         text-[#22543D] font-bold text-xs pointer-events-none">IDR</span>
                            <input type="number" name="harga_per_hari" min="0"
                                value="{{ old('harga_per_hari', intval($product->harga_per_hari)) }}"
                                required
                                placeholder="0"
                                class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm
                                          focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D] outline-none transition-all
                                          @error('harga_per_hari') border-red-400 @enderror">
                        </div>
                        @error('harga_per_hari')
                        <p class="mt-1 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tentang Kamera / Deskripsi --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">Tentang Kamera ini</label>
                        <textarea name="deskripsi" required
                            placeholder="Tuliskan cerita dari barang ini, seperti kondisi fisik..."
                            class="w-full px-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D] outline-none transition-all">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                        @error('deskripsi')
                        <p class="mt-1 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Sorotan --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">Sorotan</label>
                        <textarea name="sorotan" required
                            placeholder="Tuliskan kepentingan atau keunggulan alat secara singkat..."
                            class="w-full px-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D] outline-none transition-all">{{ old('sorotan', $product->sorotan) }}</textarea>
                        @error('sorotan')
                        <p class="mt-1 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Isi Paket --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">Isi Paket</label>
                        <textarea name="isi_paket" required
                            placeholder="Tuliskan isi dari paket barang ini include apa saja..."
                            class="w-full px-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D] outline-none transition-all">{{ old('isi_paket', $product->isi_paket) }}</textarea>
                        @error('isi_paket')
                        <p class="mt-1 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- ===== KANAN: Upload Gambar ===== --}}
                <div class="flex flex-col">
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">
                        Gambar Produk
                    </label>

                    <div class="flex-1 border-2 border-dashed border-[#d7e6de] rounded-[24px] bg-gray-50
                                flex flex-col items-center justify-center p-6 relative
                                hover:bg-emerald-50/30 transition-colors group min-h-[280px]">

                        {{-- Preview gambar baru --}}
                        <div id="preview-container" class="hidden absolute inset-0 p-2">
                            <img id="gambar_barang-preview" src="#"
                                class="w-full h-full object-cover rounded-[20px]">
                            <button type="button" onclick="resetImage()"
                                class="absolute top-4 right-4 bg-red-500 text-white p-1.5 rounded-full shadow-lg hover:bg-red-600">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="3">
                                    <path d="M18 6L6 18M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {{-- Gambar existing --}}
                        <div id="existing-container"
                            class="{{ $product->gambar_barang ? '' : 'hidden' }} absolute inset-0 p-2">
                            <img id="existing-gambar_barang"
                                src="{{ Str::startsWith($product->gambar_barang, 'http') 
    ? $product->gambar_barang 
    : asset($product->gambar_barang) }}"
                                onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'"
                                class="w-full h-full object-cover rounded-[20px]">
                            <div class="absolute inset-0 flex items-end p-4 rounded-[20px]
                                         bg-gradient-to-t from-black/40 to-transparent">
                                <span class="text-white text-[10px] font-bold uppercase tracking-widest">
                                    Gambar Saat Ini — Klik area untuk ganti
                                </span>
                            </div>
                        </div>

                        {{-- Placeholder --}}
                        <div id="placeholder-info"
                            class="{{ $product->gambar_barang ? 'hidden' : '' }} text-center z-10 pointer-events-none">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-sm border border-[#eef4f0]
                                        flex items-center justify-center mx-auto mb-4
                                        group-hover:scale-110 transition-transform">
                                <svg class="text-[#22543D]" width="28" height="28" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4m4-5l5-5 5 5m-5-5v12" />
                                </svg>
                            </div>
                            <p class="text-sm font-bold text-[#22543D]">Klik untuk Upload</p>
                            <p class="text-[10px] text-[#7c8b84] mt-1 uppercase tracking-wider">
                                PNG, JPG, JPEG (Max 2MB)
                            </p>
                        </div>

                        <input type="file" name="gambar_barang" id="product_image"
                            class="absolute inset-0 opacity-0 cursor-pointer z-20"
                            accept="gambar_barang/*"
                            onchange="previewImage(this)">
                    </div>

                    @error('gambar_barang')
                    <p class="mt-2 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                    @enderror

                    <p class="mt-3 text-[10px] text-[#7c8b84] font-medium">
                        Kosongkan jika tidak ingin mengganti gambar.
                    </p>
                </div>

            </div>

        </form>
        {{-- ===== AKHIR FORM UTAMA ===== --}}

        {{-- Footer: Hapus & Simpan --}}
        <div class="px-8 pb-8 pt-6 border-t border-[#f1f8f4] flex items-center justify-between">

            {{-- Form Hapus --}}
            <form action="{{ route('admin.products.destroy', $product->id_barang) }}"
                method="POST"
                onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="text-red-400 hover:bg-red-50 px-5 py-2.5 rounded-xl text-xs font-bold
                               flex items-center gap-2 border border-transparent hover:border-red-100 transition-all">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="3">
                        <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                    </svg>
                    Hapus Produk
                </button>
            </form>

            {{-- Tombol Simpan --}}
            <button type="submit" form="form-edit"
                class="bg-[#22543D] hover:bg-[#1B4332] text-white px-8 py-3 rounded-xl text-sm
                           font-bold transition-all shadow-md flex items-center gap-2">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="3">
                    <path d="M20 6L9 17l-5-5" />
                </svg>
                Simpan Perubahan
            </button>

        </div>

    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('gambar_barang-preview');
        const container = document.getElementById('preview-container');
        const existing = document.getElementById('existing-container');
        const info = document.getElementById('placeholder-info');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
                existing.classList.add('hidden');
                info.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetImage() {
        const input = document.getElementById('product_image');
        const preview = document.getElementById('gambar_barang-preview');
        const container = document.getElementById('preview-container');
        const existing = document.getElementById('existing-container');

        input.value = '';
        preview.src = '#';
        container.classList.add('hidden');
        existing.classList.remove('hidden');
    }
</script>

@endsection