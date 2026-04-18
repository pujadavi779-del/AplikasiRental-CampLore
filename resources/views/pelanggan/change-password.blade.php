@extends('layouts.app')

@section('title', 'Change Password - Camplore')

@push('styles')
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f5f5f0; }
    .sidebar { background: linear-gradient(170deg, #22543D 0%, #1B4332 60%, #163527 100%); }
    .nav-item { transition: all 0.2s ease; border-left: 3px solid transparent; }
    .nav-item:hover { background: rgba(255,255,255,0.08); border-left-color: #ED64A6; }
    .nav-item.active { background: rgba(237,100,166,0.15); border-left-color: #ED64A6; }
    .avatar-ring { background: linear-gradient(135deg, #ED64A6, #22543D); padding: 3px; border-radius: 9999px; display: inline-block; }
    .input-field { transition: border-color 0.18s, box-shadow 0.18s; }
    .input-field:focus { outline: none; border-color: #22543D; box-shadow: 0 0 0 3px rgba(34,84,61,0.10); }
</style>
@endpush

@section('content')
<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="sidebar w-[260px] min-h-screen fixed top-0 left-0 bottom-0 flex flex-col py-7 px-5 z-40 overflow-y-auto">

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
            <p class="text-white font-bold text-sm text-center">{{ auth()->user()->name ?? 'Pelanggan' }}</p>
            <p class="text-emerald-300 text-xs text-center mt-0.5 break-all px-2">{{ auth()->user()->email ?? '' }}</p>
            <span class="mt-2.5 bg-[#ED64A6]/20 text-[#ED64A6] text-[10px] font-bold px-3 py-1 rounded-full border border-[#ED64A6]/30">
                ⛺ Explorer Member
            </span>
        </div>

        <p class="text-[10px] font-bold text-emerald-400 tracking-widest uppercase px-3 mb-2">Menu</p>
        <nav class="space-y-0.5 flex-1">
            <a href="{{ route('dashboard') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Rent History
            </a>
            <a href="{{ route('change-password') }}" class="nav-item active flex items-center gap-3 px-3 py-2.5 rounded-xl text-white text-sm font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Change Password
            </a>
            <a href="#" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Settings
            </a>
            <a href="{{ route('shipping-address') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-100 hover:text-white text-sm font-semibold">
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
    <main class="ml-[260px] flex-1 min-h-screen p-10">
        <div class="max-w-2xl mx-auto">

            <h1 class="text-3xl font-extrabold text-gray-800 text-center mb-8">Change Your Password</h1>

            {{-- Success --}}
            @if(session('success'))
            <div id="flash-msg" class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 space-y-5">

                <form method="POST" action="{{ route('change-password.update') }}">
                    @csrf
                    @method('PUT')

                    {{-- Previous Password --}}
                    <div class="relative">
                        <input
                            type="password"
                            name="current_password"
                            id="current_password"
                            placeholder="Previous Password"
                            class="input-field w-full px-5 py-4 pr-12 border border-gray-200 rounded-xl text-sm @error('current_password') border-red-400 @enderror"
                        >
                        <button type="button" onclick="togglePw('current_password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div class="relative mt-4">
                        <input
                            type="password"
                            name="new_password"
                            id="new_password"
                            placeholder="New Password"
                            class="input-field w-full px-5 py-4 pr-12 border border-gray-200 rounded-xl text-sm @error('new_password') border-red-400 @enderror"
                        >
                        <button type="button" onclick="togglePw('new_password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                        @error('new_password')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm New Password --}}
                    <div class="relative mt-4">
                        <input
                            type="password"
                            name="new_password_confirmation"
                            id="new_password_confirmation"
                            placeholder="Confirm New Password"
                            class="input-field w-full px-5 py-4 pr-12 border border-gray-200 rounded-xl text-sm"
                        >
                        <button type="button" onclick="togglePw('new_password_confirmation', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </button>
                    </div>

                    {{-- Submit --}}
                    <div class="mt-8 flex justify-center">
                        <button type="submit" class="flex items-center gap-2 px-10 py-3.5 bg-[#22543D] hover:bg-[#ED64A6] text-white rounded-full text-sm font-bold transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
    function togglePw(id, btn) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

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