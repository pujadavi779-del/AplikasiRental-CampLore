@extends('layouts.pelanggan')

@section('title', 'Change Password - Camplore')

@push('styles')
<style>
    .input-field { transition: all 0.2s; border: 1px solid #E2E8F0; }
    .input-field:focus { border-color: #22543D; box-shadow: 0 0 0 3px rgba(34, 84, 61, 0.1); outline: none; }
    
    .anim { opacity: 0; transform: translateY(20px); animation: fadeInUp 0.5s ease forwards; }
    @keyframes fadeInUp {
        to { opacity: 1; transform: translateY(0); }
    }
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

    {{-- Header --}}
    <div class="mb-8 anim" style="animation-delay: 0.1s">
        <h1 class="text-3xl font-extrabold text-[#22543D] tracking-tight">Ubah Kata Sandi Anda</h1>
        <p class="text-gray-500 mt-1">Gunakan password yang kuat untuk menjaga keamanan akun kamu.</p>
    </div>

    {{-- Card Form --}}
    <div class="max-w-2xl bg-white rounded-[24px] shadow-sm border border-gray-100 overflow-hidden anim" style="animation-delay: 0.2s">
        <form method="POST" action="{{ route('pages.pelanggan.change-password.update') }}" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            {{-- Kata Sandi Sebelumnya --}}
            <div class="space-y-2">
                <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Kata Sandi Sebelumnya</label>
                <div class="relative">
                    <input
                        type="password"
                        name="current_password"
                        id="current_password"
                        placeholder="••••••••"
                        class="input-field w-full px-4 py-3 pr-12 rounded-xl text-sm @error('current_password') border-red-400 @enderror"
                    >
                    <button type="button" onclick="togglePw('current_password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
                @error('current_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- New Password --}}
            <div class="space-y-2">
                <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Kata Sandi Baru</label>
                <div class="relative">
                    <input
                        type="password"
                        name="new_password"
                        id="new_password"
                        placeholder="••••••••"
                        class="input-field w-full px-4 py-3 pr-12 rounded-xl text-sm @error('new_password') border-red-400 @enderror"
                    >
                    <button type="button" onclick="togglePw('new_password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
                @error('new_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Kata Sandi Baru --}}
            <div class="space-y-2">
                <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Konfirmasi Kata Sandi Baru</label>
                <div class="relative">
                    <input
                        type="password"
                        name="new_password_confirmation"
                        id="new_password_confirmation"
                        placeholder="••••••••"
                        class="input-field w-full px-4 py-3 pr-12 rounded-xl text-sm"
                    >
                    <button type="button" onclick="togglePw('new_password_confirmation', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </button>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="pt-4 flex items-center justify-end gap-4">
                <a href="{{ url()->previous() }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">Batal</a>
                <button type="submit" class="bg-[#22543D] hover:bg-[#ED64A6] text-white px-8 py-3 rounded-xl font-bold text-sm transition shadow-lg shadow-emerald-900/10 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Update Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle Password Visibility
    function togglePw(id, btn) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

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