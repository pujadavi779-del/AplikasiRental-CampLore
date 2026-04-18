@extends('layouts.app')

@section('title', 'Shipping Address - Camplore')

@push('styles')
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #EEF3F0; }
    .sidebar { background: linear-gradient(170deg, #22543D 0%, #1B4332 60%, #163527 100%); }
    .nav-item { transition: all 0.2s ease; border-left: 3px solid transparent; }
    .nav-item:hover { background: rgba(255,255,255,0.08); border-left-color: #ED64A6; }
    .nav-item.active { background: rgba(237,100,166,0.15); border-left-color: #ED64A6; }
    .input-field { transition: border-color 0.18s, box-shadow 0.18s; }
    .input-field:focus { outline: none; border-color: #22543D; box-shadow: 0 0 0 3px rgba(34,84,61,0.10); }
    @keyframes fadeSlide { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
    .anim { animation: fadeSlide 0.4s ease forwards; }
    .anim-d1 { animation-delay:0.05s; opacity:0; }
    .anim-d2 { animation-delay:0.12s; opacity:0; }
</style>
@endpush

@section('content')
<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="sidebar w-[240px] min-h-screen fixed top-0 left-0 bottom-0 flex flex-col py-7 px-4 z-40 overflow-y-auto">

        <a href="{{ url('/') }}" class="flex items-center gap-2.5 mb-8">
            <div class="w-8 h-8 bg-white rounded-xl flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#22543D]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                </svg>
            </div>
            <span class="text-white font-extrabold text-lg tracking-tight">Camp<span class="text-[#ED64A6]">lore</span></span>
        </a>

        <div class="flex flex-col items-center mb-7">
            <div class="avatar-ring mb-3">
                <div class="w-[72px] h-[72px] rounded-full bg-[#163527] overflow-hidden flex items-center justify-center text-white text-2xl font-extrabold">
                    @if(auth()->check() && auth()->user()->photo)
                        <img src="{{ asset('storage/'.auth()->user()->photo) }}" class="w-full h-full object-cover" alt="foto">
                    @else
                        {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'U' }}
                    @endif
                </div>
            </div>
            <p class="text-white font-bold text-sm text-center">{{ auth()->check() ? auth()->user()->name : 'Pelanggan' }}</p>
            <p class="text-emerald-300 text-xs text-center mt-0.5 break-all px-2">{{ auth()->check() ? auth()->user()->email : '' }}</p>
            <span class="mt-2.5 bg-[#ED64A6]/20 text-[#ED64A6] text-[10px] font-bold px-3 py-1 rounded-full border border-[#ED64A6]/30">
                ⛺ Explorer Member
            </span>
        </div>

        <p class="text-[10px] font-bold text-emerald-400 tracking-widest uppercase px-3 mb-2">Menu</p>
        <nav class="space-y-0.5 flex-1">
            <a href="{{ route('dashboard_pelanggan') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Rent History
            </a>
            <a href="{{ route('change-password') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Change Password
            </a>
            <a href="#" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Settings
            </a>
            <a href="{{ route('shipping-address') }}" class="nav-item active flex items-center gap-3 px-3 py-2.5 rounded-xl text-white text-sm font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Shipping Address
            </a>
        </nav>

        <div class="border-t border-white/10 pt-4 mt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-300 hover:text-white hover:bg-white/10 transition text-sm font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN --}}
    <main class="ml-[240px] flex-1 min-h-screen p-8">

        @if(session('success'))
        <div id="flash-msg" class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-2xl text-sm font-semibold anim">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
            <button onclick="document.getElementById('flash-msg').remove()" class="ml-auto text-emerald-400 hover:text-emerald-700 text-base leading-none">✕</button>
        </div>
        @endif

        <div class="mb-7 anim anim-d1">
            <h1 class="text-2xl font-extrabold text-[#22543D] tracking-tight">Shipping Address</h1>
            <p class="text-gray-400 text-sm mt-1">Kelola alamat pengiriman gear kamu.</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden max-w-3xl anim anim-d2">
            <div class="px-8 py-5 border-b border-gray-100 flex items-center gap-3">
                <div class="w-9 h-9 bg-[#22543D]/10 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#22543D]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h2 class="font-extrabold text-gray-800 text-base">Update Shipping Address</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Isi data alamat pengiriman kamu dengan lengkap</p>
                </div>
            </div>

            <form method="POST" action="{{ route('shipping-address.update') }}" class="px-8 py-7 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Full Address <span class="text-red-500">*</span></label>
                    <textarea name="full_address" rows="3" placeholder="Masukkan alamat lengkap kamu..."
                        class="input-field w-full px-4 py-3 border border-gray-200 rounded-xl text-sm resize-none @error('full_address') border-red-400 @enderror">{{ old('full_address', $address->full_address ?? '') }}</textarea>
                    @error('full_address')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">City <span class="text-red-500">*</span></label>
                        <input type="text" name="city" value="{{ old('city', $address->city ?? '') }}" placeholder="Contoh: Batam"
                            class="input-field w-full px-4 py-3 border border-gray-200 rounded-xl text-sm @error('city') border-red-400 @enderror">
                        @error('city')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Province <span class="text-red-500">*</span></label>
                        <input type="text" name="province" value="{{ old('province', $address->province ?? '') }}" placeholder="Contoh: Kepulauan Riau"
                            class="input-field w-full px-4 py-3 border border-gray-200 rounded-xl text-sm @error('province') border-red-400 @enderror">
                        @error('province')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Postal Code <span class="text-red-500">*</span></label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}" placeholder="Contoh: 29438"
                            class="input-field w-full px-4 py-3 border border-gray-200 rounded-xl text-sm @error('postal_code') border-red-400 @enderror">
                        @error('postal_code')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">District <span class="text-red-500">*</span></label>
                        <input type="text" name="district" value="{{ old('district', $address->district ?? '') }}" placeholder="Contoh: Batu Aji"
                            class="input-field w-full px-4 py-3 border border-gray-200 rounded-xl text-sm @error('district') border-red-400 @enderror">
                        @error('district')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Catatan Pengiriman <span class="text-gray-400 font-normal">(Optional)</span></label>
                    <input type="text" name="notes" value="{{ old('notes', $address->notes ?? '') }}" placeholder="Contoh: Titip ke satpam jika tidak ada di rumah"
                        class="input-field w-full px-4 py-3 border border-gray-200 rounded-xl text-sm">
                </div>

                <div class="border-t border-gray-100 pt-2"></div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('dashboard') }}" class="px-6 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 transition">Batal</a>
                    <button type="submit" class="flex items-center gap-2 px-8 py-2.5 bg-[#22543D] hover:bg-[#ED64A6] text-white rounded-xl text-sm font-bold transition shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                        Save Address
                    </button>
                </div>
            </form>
        </div>

        <div class="max-w-3xl mt-4">
            <div class="bg-emerald-50 border border-emerald-100 rounded-2xl px-6 py-4 flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#22543D] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-emerald-800 text-xs font-medium leading-relaxed">
                    Alamat ini akan digunakan sebagai <span class="font-bold">alamat pengiriman default</span> saat kamu menyewa gear. Pastikan alamat sudah benar sebelum menyimpan.
                </p>
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
    setTimeout(() => {
        const el = document.getElementById('flash-msg');
        if (el) {
            el.style.transition = 'opacity 0.4s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 400);
        }
    }, 4000);
</script>
@endpush