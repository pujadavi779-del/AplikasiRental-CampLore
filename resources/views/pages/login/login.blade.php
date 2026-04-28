<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAMPLORE – Masuk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body class="font-['Jost',sans-serif] bg-white text-[#1a1a18] h-full">

{{-- NAVBAR --}}
<nav class="fixed top-0 left-0 right-0 h-[58px] flex items-center justify-center border-b border-[#e2e2de] bg-white z-[100]">
    <a href="/">
        <img src="{{ asset('images/Black_Summer_Camp_Adventure_Logo-removebg-preview.png') }}" alt="Camplore Logo" class="h-[200px] w-auto block">
    </a>
</nav>

{{-- PAGE --}}
<div class="min-h-screen flex items-center justify-center px-5 pt-[90px] pb-[60px]">
    <div class="w-full max-w-[380px]">

        <h1 class="font-['Cormorant_Garamond',serif] text-[26px] font-semibold tracking-[3px] uppercase text-[#22543D] text-center mb-8">Masuk</h1>

        {{-- Success alert --}}
        @if(session('success'))
            <div class="px-3.5 py-2.5 rounded text-xs bg-[#f0fff4] border border-[#c6f6d5] text-[#276749] mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error alert --}}
        @if($errors->any())
            <div class="px-3.5 py-2.5 rounded text-xs bg-[#fff5f5] border border-[#fed7d7] text-[#c53030] mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/login" method="POST">
            @csrf

            {{-- Username --}}
            <div class="mb-3">
                <input type="text" name="username" id="username"
                    placeholder="Username"
                    value="{{ old('username') }}"
                    autocomplete="username"
                    class="w-full px-4 py-3 border border-[#e2e2de] rounded-[3px] text-sm font-light text-[#1a1a18] bg-[#f7f7f5] outline-none transition focus:border-[#38856a] focus:bg-white placeholder-[#bebeba] tracking-[0.3px]">
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <div class="relative">
                    <input type="password" name="password" id="password"
                        placeholder="Kata sandi"
                        autocomplete="current-password"
                        class="w-full px-4 py-3 pr-10 border border-[#e2e2de] rounded-[3px] text-sm font-light text-[#1a1a18] bg-[#f7f7f5] outline-none transition focus:border-[#38856a] focus:bg-white placeholder-[#bebeba]">
                    <button type="button" onclick="togglePw('password', this)"
                        class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent border-none cursor-pointer text-[#ccc] hover:text-[#2d6b50] transition p-0">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit"
                class="w-full py-3.5 mt-1.5 bg-[#22543D] text-white border-none rounded-[3px] text-xs font-medium tracking-[3px] uppercase cursor-pointer hover:bg-[#2d6b50] transition">
                Masuk
            </button>
        </form>

        {{-- Lupa password --}}
        <div class="text-center mt-4">
            <a href="#" class="text-xs font-light text-[#999990] underline underline-offset-[3px] hover:text-[#22543D] transition">
                Lupa kata sandi?
            </a>
        </div>

        {{-- Divider --}}
        <div class="flex items-center gap-3.5 my-6">
            <div class="flex-1 h-px bg-[#e2e2de]"></div>
            <span class="text-[11px] text-[#d0d0cc] tracking-[1.5px] uppercase">atau</span>
            <div class="flex-1 h-px bg-[#e2e2de]"></div>
        </div>

        <p class="text-center text-xs font-light text-[#999990] mb-2.5 tracking-[0.2px]">Belum punya akun?</p>
        <a href="/registrasi"
            class="block w-full py-3 bg-transparent border-[1.5px] border-[#ED64A6] rounded-[3px] text-xs font-medium tracking-[3px] uppercase text-[#ED64A6] text-center no-underline hover:bg-[#ED64A6] hover:text-white transition">
            Daftar Sekarang
        </a>

    </div>
</div>

{{-- Footer bar --}}
<div class="fixed bottom-0 left-0 right-0 h-[3px] bg-gradient-to-r from-[#22543D] from-[65%] to-[#ED64A6]"></div>

<script>
function togglePw(id, btn) {
    const el = document.getElementById(id);
    const show = el.type === 'password';
    el.type = show ? 'text' : 'password';
    btn.innerHTML = show
        ? `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
        : `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
}
</script>

</body>
</html>