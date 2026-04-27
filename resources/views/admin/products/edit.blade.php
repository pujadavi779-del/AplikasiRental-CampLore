@extends('layouts.admin')

@section('title', 'Edit Produk - CampLore')

@section('content')

{{-- Navbar Header --}}
<div class="fixed top-5 right-6 z-40 left-[calc(272px+24px)] max-sm:left-6">
    @include('components.navbar_judul_LP', [
    'NavParent' => 'Product Management',
    'section' => 'Edit Produk'
    ])
</div>

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
                <h2 class="text-2xl font-bold text-[#22543D] font-serif">Edit Produk</h2>
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
            action="{{ route('admin.products.update', $product->id) }}"
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

                    {{-- Status Barang --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">
                            Status Barang
                        </label>
                        <div class="flex gap-3">

                            {{-- Tersedia --}}
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="stock" value="1"
                                    class="sr-only peer"
                                    {{ old('stock', $product->stock) >= 1 ? 'checked' : '' }}>
                                <div class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2
                                            border-[#eef4f0] bg-gray-50 text-sm font-bold text-gray-400
                                            peer-checked:border-emerald-500 peer-checked:bg-emerald-50
                                            peer-checked:text-emerald-700 transition-all">
                                    <span class="w-2 h-2 rounded-full bg-current"></span>
                                    Tersedia
                                </div>
                            </label>

                            {{-- Habis --}}
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="stock" value="0"
                                    class="sr-only peer"
                                    {{ old('stock', $product->stock) == 0 ? 'checked' : '' }}>
                                <div class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2
                                            border-[#eef4f0] bg-gray-50 text-sm font-bold text-gray-400
                                            peer-checked:border-red-400 peer-checked:bg-red-50
                                            peer-checked:text-red-500 transition-all">
                                    <span class="w-2 h-2 rounded-full bg-current"></span>
                                    Habis
                                </div>
                            </label>

                        </div>
                        @error('stock')
                        <p class="mt-1 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">
                            Kategori
                        </label>
                        <select name="category" required
                            class="w-full px-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm
                                       focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D] outline-none
                                       transition-all appearance-none
                                       @error('category') border-red-400 @enderror">
                            <option value="" disabled>Pilih Kategori</option>
                            @foreach(['Kamera','Camping','Lensa','Aksesoris'] as $cat)
                            <option value="{{ $cat }}"
                                {{ old('category', $product->category) === $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                            @endforeach
                        </select>
                        @error('category')
                        <p class="mt-1 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Harga Rental / Hari --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">
                            Harga Rental / Hari
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center
                                         text-[#22543D] font-bold text-xs pointer-events-none">IDR</span>
                            <input type="number" name="price_per_day" min="0"
                                value="{{ old('price_per_day', $product->price_per_day) }}"
                                required
                                placeholder="0"
                                class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm
                                          focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D] outline-none transition-all
                                          @error('price_per_day') border-red-400 @enderror">
                        </div>
                        @error('price_per_day')
                        <p class="mt-1 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">
                            Deskripsi Produk
                        </label>
                        <textarea name="body" rows="5" required
                            placeholder="Tuliskan spesifikasi, kondisi, dan kelengkapan alat..."
                            class="w-full px-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm
                                         focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D] outline-none
                                         transition-all resize-none
                                         @error('body') border-red-400 @enderror">{{ old('body', $product->body) }}</textarea>
                        @error('body')
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
                            <img id="image-preview" src="#"
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
                            class="{{ $product->image ? '' : 'hidden' }} absolute inset-0 p-2">
                            <img id="existing-image"
                                src="{{ $product->image ? asset('storage/' . $product->image) : '#' }}"
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
                            class="{{ $product->image ? 'hidden' : '' }} text-center z-10 pointer-events-none">
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

                        <input type="file" name="image" id="product_image"
                            class="absolute inset-0 opacity-0 cursor-pointer z-20"
                            accept="image/*"
                            onchange="previewImage(this)">
                    </div>

                    @error('image')
                    <p class="mt-2 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                    @enderror

                    <p class="mt-3 text-[10px] text-[#7c8b84] font-medium">
                        Kosongkan jika tidak ingin mengganti gambar.
                    </p>
                </div>

            </div>

        </form>
        {{-- ===== AKHIR FORM UTAMA ===== --}}

        {{-- Footer: Hapus & Simpan — DI LUAR form utama --}}
        <div class="px-8 pb-8 pt-6 border-t border-[#f1f8f4] flex items-center justify-between">

            {{-- Form Hapus (terpisah dari form edit) --}}
            <form action="{{ route('admin.products.destroy', $product->id) }}"
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

            {{-- Tombol Simpan — terhubung ke form-edit via atribut form= --}}
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
        const preview = document.getElementById('image-preview');
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
        const preview = document.getElementById('image-preview');
        const container = document.getElementById('preview-container');
        const existing = document.getElementById('existing-container');

        input.value = '';
        preview.src = '#';
        container.classList.add('hidden');
        existing.classList.remove('hidden');
    }
</script>

@endsection