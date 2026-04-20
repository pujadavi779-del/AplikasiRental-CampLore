@extends('layouts.pelanggan')

@section('title', 'Ubah Password')

@section('content')
<div class="anim">
    {{-- Judul Halaman --}}
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-black text-gray-800 tracking-tight">Change Your Password</h1>
        <p class="text-gray-400 font-medium mt-1">Gunakan password yang kuat untuk menjaga keamanan akun Anda.</p>
    </div>

    {{-- Container Putih Utama --}}
    <div class="bg-white rounded-[40px] shadow-sm border border-gray-50 p-10 md:p-16 max-w-3xl mx-auto flex flex-col items-center">

        <form action="#" method="POST" class="w-full space-y-6">
            @csrf

            {{-- Previous Password --}}
            <div class="relative group">
                <label class="absolute -top-2.5 left-6 bg-white px-2 text-[11px] font-bold text-green-600 uppercase tracking-[0.2em]">Previous Password</label>
                <input type="password" placeholder="Masukkan password lama"
                    class="w-full py-4 px-8 bg-gray-50 border-none rounded-[25px] outline-none focus:ring-2 focus:ring-green-600 transition-all font-medium text-gray-700">
                <span class="absolute right-6 top-4 text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
            </div>

            {{-- New Password --}}
            <div class="relative group">
                <label class="absolute -top-2.5 left-6 bg-white px-2 text-[11px] font-bold text-pink-600 uppercase tracking-[0.2em]">New Password</label>
                <input type="password" placeholder="Masukkan password baru"
                    class="w-full py-4 px-8 bg-gray-50 border-none rounded-[25px] outline-none focus:ring-2 focus:ring-pink-500 transition-all font-medium text-gray-700">
                <span class="absolute right-6 top-4 text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </span>
            </div>

            {{-- Confirm Password --}}
            <div class="relative group">
                <label class="absolute -top-2.5 left-6 bg-white px-2 text-[11px] font-bold text-pink-600 uppercase tracking-[0.2em]">Confirm New Password</label>
                <input type="password" placeholder="Ulangi password baru"
                    class="w-full py-4 px-8 bg-gray-50 border-none rounded-[25px] outline-none focus:ring-2 focus:ring-pink-500 transition-all font-medium text-gray-700">
                <span class="absolute right-6 top-4 text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </span>
            </div>

            {{-- Button Submit --}}
            <div class="flex justify-center pt-8">
                <button type="submit" class="flex items-center gap-3 px-12 py-4 bg-[#1B4332] hover:bg-green-800 text-white rounded-[20px] font-bold text-sm shadow-xl shadow-green-900/20 transition-all active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Update Password
                </button>
            </div>
        </form>

    </div>
</div>
@endsection