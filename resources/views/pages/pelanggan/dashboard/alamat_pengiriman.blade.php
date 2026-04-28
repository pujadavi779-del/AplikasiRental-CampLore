@extends('layouts.pelanggan')

@section('title', 'Shipping Address')

@push('styles')
<style>
    .input-field { transition: all 0.2s; border: 1px solid #E2E8F0; }
    .input-field:focus { border-color: #22543D; box-shadow: 0 0 0 3px rgba(34, 84, 61, 0.1); outline: none; }
</style>
@endpush

@section('content')
<div class="px-9 pt-9 pb-16">
    
    {{-- Notifikasi --}}
    @if(session('success'))
    <div id="flash-msg" class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl anim">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-sm font-bold">{{ session('success') }}</span>
    </div>
    @endif

    <div class="mb-8 anim" style="animation-delay: 0.1s">
        <h1 class="text-3xl font-extrabold text-[#22543D] tracking-tight">Alamat pengiriman</h1>
        <p class="text-gray-500 mt-1">Lengkapi alamat agar pengiriman gear camping kamu lancar.</p>
    </div>

    <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 overflow-hidden anim" style="animation-delay: 0.2s">
        <form action="{{ route('shipping-address.update') }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Alamat Lengkap</label>
                <textarea name="full_address" rows="3" class="input-field w-full px-4 py-3 rounded-xl text-sm resize-none" placeholder="Nama Jalan, No. Rumah, RT/RW...">{{ old('full_address', $address->full_address ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Kota / Kabupaten</label>
                    <input type="text" name="city" value="{{ old('city', $address->city ?? '') }}" class="input-field w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Provinsi</label>
                    <input type="text" name="province" value="{{ old('province', $address->province ?? '') }}" class="input-field w-full px-4 py-3 rounded-xl text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Kode Pos</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}" class="input-field w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Kecamatan</label>
                    <input type="text" name="district" value="{{ old('district', $address->district ?? '') }}" class="input-field w-full px-4 py-3 rounded-xl text-sm">
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-4">
                <button type="button" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">Batal</button>
                <button type="submit" class="bg-[#22543D] hover:bg-[#ED64A6] text-white px-8 py-3 rounded-xl font-bold text-sm transition shadow-lg shadow-emerald-900/10">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto hide flash message
    setTimeout(() => {
        const msg = document.getElementById('flash-msg');
        if(msg) {
            msg.style.opacity = '0';
            msg.style.transition = '0.5s';
            setTimeout(() => msg.remove(), 500);
        }
    }, 3000);
</script>
@endpush