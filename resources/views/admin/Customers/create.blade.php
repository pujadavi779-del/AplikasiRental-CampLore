@extends('layouts.admin')

@section('title', 'Tambah Customer - Camplore')
@section('page-title', 'Customer')

@section('breadcrumb')
    <span class="text-gray-300">/</span>
    <a href="{{ route('admin.customers.index') }}" class="hover:text-[#22543D]">Customer</a>
    <span class="text-gray-300">/</span>
    <span class="text-[#22543D] font-semibold">Tambah Customer</span>
@endsection

@section('content')

<div class="max-w-4xl">

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- Form header --}}
        <div class="px-8 py-5 border-b border-gray-100 flex items-center gap-3">
            <div class="w-9 h-9 bg-[#22543D]/10 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#22543D]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <div>
                <h2 class="font-extrabold text-gray-800">Tambah Customer</h2>
                <p class="text-xs text-gray-400 mt-0.5">Isi semua data customer dengan lengkap</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.customers.store') }}" enctype="multipart/form-data" class="px-8 py-7">
            @csrf

            {{-- Foto + NIK --}}
            <div class="flex gap-8 items-start mb-7">

                {{-- Foto preview --}}
                <div class="flex flex-col items-center gap-3 flex-shrink-0">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">
                        Photo <span class="text-gray-400 font-normal">(Optional)</span>
                    </label>
                    <div class="relative">
                        <div id="photoPreview"
                             class="w-24 h-24 rounded-2xl bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden cursor-pointer hover:border-[#22543D] transition">
                            <div id="photoPlaceholder" class="flex flex-col items-center gap-1 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-[10px]">NO IMAGE</span>
                            </div>
                            <img id="photoImg" class="w-full h-full object-cover hidden">
                        </div>
                    </div>
                    <label for="photo" class="cursor-pointer text-xs font-semibold text-[#22543D] hover:text-[#ED64A6] transition flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        Pilih Foto
                    </label>
                    <input type="file" id="photo" name="photo" accept="image/*" class="hidden">
                </div>

                {{-- NIK --}}
                <div class="flex-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        NIK <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nik" value="{{ old('nik') }}" placeholder="Masukkan NIK"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#22543D] focus:ring-2 focus:ring-[#22543D]/10 @error('nik') border-red-400 @enderror">
                    @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Nama + No HP --}}
            <div class="grid grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap customer"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#22543D] focus:ring-2 focus:ring-[#22543D]/10 @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        No HP <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#22543D] focus:ring-2 focus:ring-[#22543D]/10 @error('phone') border-red-400 @enderror">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Alamat + Jenis Customer --}}
            <div class="grid grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Alamat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Alamat lengkap"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#22543D] focus:ring-2 focus:ring-[#22543D]/10 @error('address') border-red-400 @enderror">
                    @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Jenis Customer <span class="text-red-500">*</span>
                    </label>
                    <select name="customer_type"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#22543D] focus:ring-2 focus:ring-[#22543D]/10 bg-white @error('customer_type') border-red-400 @enderror">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Pribadi"    {{ old('customer_type') === 'Pribadi'    ? 'selected' : '' }}>Pribadi</option>
                        <option value="Perusahaan" {{ old('customer_type') === 'Perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                        <option value="Organisasi" {{ old('customer_type') === 'Organisasi' ? 'selected' : '' }}>Organisasi</option>
                    </select>
                    @error('customer_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Jenis Kelamin + Apakah Member + Diskon --}}
            <div class="grid grid-cols-3 gap-5 mb-5">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Jenis Kelamin <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-5 mt-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="gender" value="L" {{ old('gender','L') === 'L' ? 'checked' : '' }}
                                class="accent-[#22543D] w-4 h-4">
                            <span class="text-sm font-semibold text-gray-700">Laki-laki</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="gender" value="P" {{ old('gender') === 'P' ? 'checked' : '' }}
                                class="accent-[#22543D] w-4 h-4">
                            <span class="text-sm font-semibold text-gray-700">Perempuan</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Apakah Member? <span class="text-red-500">*</span>
                    </label>
                    <select name="is_member"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#22543D] focus:ring-2 focus:ring-[#22543D]/10 bg-white">
                        <option value="1" {{ old('is_member','1') === '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('is_member') === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Persentase Diskon (%) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="discount" value="{{ old('discount', 0) }}" min="0" max="100"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#22543D] focus:ring-2 focus:ring-[#22543D]/10">
                </div>
            </div>

            {{-- Dokumen + Upload + Surat + Status --}}
            <div class="grid grid-cols-4 gap-5 mb-8">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Dokumen Pendukung <span class="text-red-500">*</span>
                    </label>
                    <select name="document_type"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#22543D] bg-white">
                        <option value="KTP">KTP</option>
                        <option value="SIM">SIM</option>
                        <option value="Paspor">Paspor</option>
                        <option value="Lainnya" {{ old('document_type') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Upload Dokumen <span class="text-red-500">*</span>
                    </label>
                    <label class="flex items-center gap-2 w-full px-4 py-3 border border-gray-200 rounded-xl cursor-pointer hover:border-[#22543D] transition text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        <span id="docLabel">Pilih File</span>
                        <input type="file" name="document" id="docInput" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                    </label>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Surat Perjanjian <span class="text-gray-400 font-normal">(Optional)</span>
                    </label>
                    <label class="flex items-center gap-2 w-full px-4 py-3 border border-gray-200 rounded-xl cursor-pointer hover:border-[#22543D] transition text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span id="suratLabel">Pilih File</span>
                        <input type="file" name="agreement" id="suratInput" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                    </label>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-3 mt-3">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="status" value="aktif" id="statusToggle" class="sr-only peer" {{ old('status','aktif') === 'aktif' ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-[#22543D]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#22543D]"></div>
                        </label>
                        <span class="text-sm font-semibold text-gray-600" id="statusLabel">Aktif</span>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-100 mb-6"></div>

            {{-- Buttons --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.customers.index') }}"
                   class="px-6 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                    class="flex items-center gap-2 px-8 py-2.5 bg-[#22543D] hover:bg-[#ED64A6] text-white rounded-xl text-sm font-bold transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Photo preview
    document.getElementById('photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (ev) => {
            document.getElementById('photoImg').src = ev.target.result;
            document.getElementById('photoImg').classList.remove('hidden');
            document.getElementById('photoPlaceholder').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });

    // File name labels
    document.getElementById('docInput').addEventListener('change', function() {
        document.getElementById('docLabel').textContent = this.files[0]?.name || 'Pilih File';
    });
    document.getElementById('suratInput').addEventListener('change', function() {
        document.getElementById('suratLabel').textContent = this.files[0]?.name || 'Pilih File';
    });

    // Status toggle label
    document.getElementById('statusToggle').addEventListener('change', function() {
        document.getElementById('statusLabel').textContent = this.checked ? 'Aktif' : 'Nonaktif';
    });
</script>
@endpush