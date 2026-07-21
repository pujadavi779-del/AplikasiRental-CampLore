@php
$NavParent = 'Product Management';
$section = 'Tambah Produk';
@endphp

@extends('layouts.admin')

@section('title', 'Tambah Produk Baru - CampLore')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap');

    * {
        font-family: 'Inter', sans-serif;
    }

    .font-serif {
        font-family: 'Playfair Display', serif !important;
    }
</style>

<div class="max-w-full">
    <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

        {{-- Header Title --}}
        <div class="p-6 border-b border-[#eef4f0] flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-[#22543D] font-serif">Tambah Produk</h2>
                <p class="text-[11px] text-[#7c8b84] mt-1">Masukkan detail informasi alat rental baru</p>
            </div>
            <a href="{{ route('admin.products') }}" class="text-[#7c8b84] hover:text-[#22543D] text-xs font-bold flex items-center gap-2 transition-colors">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>

        {{-- Form Section --}}
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf

            @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                <ul class="text-sm text-red-600 space-y-1">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- Kiri: Input Text --}}
                <div class="space-y-5">
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">Nama Produk</label>
                        <input type="text" name="name" required
                            placeholder="Contoh: Sony Alpha A7 III"
                            class="w-full px-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D] outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">STOK</label>
                        <div class="relative">
                            <input type="number" name="stok" required
                                placeholder="0"
                                class="w-full pl-5 pr-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D] outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">Harga Rental / Hari</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-[#22543D] font-bold text-xs">IDR</span>
                            <input type="number" name="harga_per_hari" required
                                placeholder="0"
                                class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D] outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">Kategori Utama</label>
                        <select name="kategori" id="select_kategori" required
                            class="w-full px-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D] outline-none transition-all appearance-none">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Kamera">Kamera</option>
                            <option value="Camping">Camping</option>
                        </select>
                    </div>

                    {{-- TIPE --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">
                            Tipe
                        </label>
                        <select name="id_tipe_kategori" id="select_tipe" required
                            class="w-full px-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm">
                            <option value="">Pilih Tipe</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id_kategori }}" data-kategori="{{ $type->kategori_utama }}">
                                {{ $type->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- MEREK --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">Merek</label>
                        <select name="id_merek_kategori" id="select_merek" required
                            class="w-full px-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D] outline-none transition-all appearance-none">
                            <option value="">Pilih Merek</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id_kategori }}" data-kategori="{{ $brand->kategori_utama }}">
                                {{ $brand->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">Tentang Kamera ini</label>
                        <textarea name="deskripsi" required
                            placeholder="Tuliskan cerita dari barang ini, seperti kondisi fisik..."
                            class="w-full px-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D] outline-none transition-all"></textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">Sorotan</label>
                        <textarea name="sorotan" required
                            placeholder="Tuliskan kepentingan atau keunggulan alat secara singkat..."
                            class="w-full px-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D] outline-none transition-all"></textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">Isi Paket</label>
                        <textarea name="isi_paket" required
                            placeholder="Tuliskan isi dari paket barang ini include apa saja..."
                            class="w-full px-4 py-3 bg-gray-50 border border-[#eef4f0] rounded-xl text-sm focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D] outline-none transition-all"></textarea>
                    </div>
                </div>

                {{-- Kanan: Upload Gambar --}}
                <div class="flex flex-col">
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">Gambar Produk</label>
                    <div class="flex-1 border-2 border-dashed border-[#d7e6de] rounded-[24px] bg-gray-50 flex flex-col items-center justify-center p-6 relative hover:bg-emerald-50/30 transition-colors group">

                        {{-- Preview Container --}}
                        <div id="preview-container" class="hidden absolute inset-0 p-2">
                            <img id="image-preview" src="#" class="w-full h-full object-cover rounded-[20px]">
                            <button type="button" onclick="resetImage()" class="absolute top-4 right-4 bg-red-500 text-white p-1.5 rounded-full shadow-lg hover:bg-red-600">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <path d="M18 6L6 18M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div id="placeholder-info" class="text-center">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-sm border border-[#eef4f0] flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                <svg class="text-[#22543D]" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4m4-5l5-5 5 5m-5-5v12" />
                                </svg>
                            </div>
                            <p class="text-sm font-bold text-[#22543D]">Klik untuk Mengunggah</p>
                            <p class="text-[10px] text-[#7c8b84] mt-1 uppercase tracking-wider">PNG, JPG, JPEG (Max 2MB)</p>
                        </div>

                        <input type="file" name="gambar_barang" id="product_image" required class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" onchange="previewImage(this)">
                    </div>
                    @error('gambar_barang')
                    <p class="mt-2 text-[10px] text-red-500 font-bold">{{ $message }}</p>
                    @enderror

                </div>

            </div>

            {{-- Footer Form --}}
            <div class="mt-10 pt-6 border-t border-[#f1f8f4] flex justify-end">
                <button type="submit" class="bg-[#22543D] hover:bg-[#1B4332] text-white px-8 py-3 rounded-xl text-sm font-bold transition-all shadow-md flex items-center gap-2">
                    Simpan Produk Baru
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const container = document.getElementById('preview-container');
        const info = document.getElementById('placeholder-info');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
                info.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetImage() {
        const input = document.getElementById('product_image');
        const preview = document.getElementById('image-preview');
        const container = document.getElementById('preview-container');
        const info = document.getElementById('placeholder-info');

        input.value = '';
        preview.src = '#';
        container.classList.add('hidden');
        info.classList.remove('hidden');
    }

    // ── Filter Tipe & Merek berdasarkan Kategori Utama ──────────────────────
    // FIX: <option hidden> tidak konsisten disembunyikan oleh semua browser.
    // Solusinya: simpan semua opsi asli sekali di awal, lalu setiap kategori
    // berubah, REBUILD isi <select> hanya dengan opsi yang kategorinya cocok.

    let originalTipeOptions = [];
    let originalMerekOptions = [];

    function cloneOptions(select) {
        // Simpan semua <option> asli (termasuk placeholder "Pilih Tipe/Merek")
        return Array.from(select.querySelectorAll('option')).map(opt => opt.cloneNode(true));
    }

    function rebuildSelect(select, originalOptions, kategori) {
        const currentValue = select.value;
        select.innerHTML = '';

        originalOptions.forEach(opt => {
            // Placeholder (value kosong, tanpa data-kategori) selalu ditampilkan
            const isPlaceholder = !opt.dataset.kategori;
            const matches = isPlaceholder || opt.dataset.kategori === kategori;

            if (matches) {
                select.appendChild(opt.cloneNode(true));
            }
        });

        // Pertahankan pilihan sebelumnya jika masih valid untuk kategori baru
        const stillValid = Array.from(select.querySelectorAll('option')).some(o => o.value === currentValue);
        select.value = stillValid ? currentValue : '';
    }

    function filterByKategori() {
        const kategori = document.getElementById('select_kategori').value;
        const selectTipe = document.getElementById('select_tipe');
        const selectMerek = document.getElementById('select_merek');

        rebuildSelect(selectTipe, originalTipeOptions, kategori);
        rebuildSelect(selectMerek, originalMerekOptions, kategori);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Simpan opsi asli SEBELUM dimanipulasi
        originalTipeOptions = cloneOptions(document.getElementById('select_tipe'));
        originalMerekOptions = cloneOptions(document.getElementById('select_merek'));

        document.getElementById('select_kategori').addEventListener('change', filterByKategori);

        // Jika form sedang diisi ulang (misal validasi gagal & old() terisi),
        // langsung filter sesuai kategori yang sudah terpilih
        filterByKategori();
    });
</script>

@endsection