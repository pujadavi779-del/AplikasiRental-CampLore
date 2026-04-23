@extends('layouts.pelanggan')

@section('title', 'Change Password - Camplore')


@section('content')
<div class="min-h-screen flex">

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

                <form method="POST" action="{{ route('pages.pelanggan.change-password.update') }}">
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