@extends('layouts.pelanggan')

@section('title', 'Settings')

@section('content')
<div x-data="{ 
    isVerified: false, 
    otpSent: false,
    profilePreview: null,
    ktpPreview: null,
    updatePreview(event, type) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                if (type === 'profile') this.profilePreview = e.target.result;
                if (type === 'ktp') this.ktpPreview = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
}" class="anim">

    {{-- Judul Halaman --}}
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-black text-gray-800 tracking-tight">Update Your Profile</h1>
        <p class="text-gray-400 font-medium mt-1">Kelola informasi data diri dan keamanan akun Anda.</p>
    </div>

    {{-- Container Putih Utama --}}
    <div class="bg-white p-8 md:p-12 rounded-[40px] shadow-sm border border-gray-50 max-w-4xl mx-auto">
        <form action="/settings" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Foto Profil --}}
            <div class="flex flex-col items-center mb-12">
                <div class="relative group">
                    <img :src="profilePreview ? profilePreview : 'https://ui-avatars.com/api/?name=Rizka+Nur&background=059669&color=fff&size=128'"
                        class="w-32 h-32 rounded-full object-cover border-4 border-pink-50 shadow-md">
                    <label for="profile_picture" class="absolute bottom-0 right-0 bg-pink-500 p-2.5 rounded-full text-white cursor-pointer hover:scale-110 transition shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </label>
                    <input type="file" id="profile_picture" name="profile_picture" class="hidden" @change="updatePreview($event, 'profile')">
                </div>
                <p class="text-[11px] font-bold text-gray-300 mt-4 uppercase tracking-widest italic">Klik ikon kamera untuk ganti foto profil</p>
            </div>

            <div class="grid grid-cols-1 gap-8">
                {{-- Full Name --}}
                <div class="relative">
                    <label class="absolute -top-2.5 left-6 bg-white px-2 text-[11px] font-bold text-green-600 uppercase tracking-[0.2em]">Full Name</label>
                    <input type="text" value="Rizka Nur" class="w-full px-8 py-4 bg-gray-50 border-none rounded-[25px] focus:ring-2 focus:ring-pink-500 outline-none text-gray-700 font-medium transition-all">
                </div>

                {{-- Email Address --}}
                <div class="relative">
                    <label class="absolute -top-2.5 left-6 z-10 bg-white px-2 text-[11px] font-bold text-green-600 uppercase tracking-[0.2em]">Email Address</label>
                    <div class="relative">
                        <input type="email" value="rizkaanurr@gmail.com" class="w-full px-8 py-4 bg-gray-50 border-none rounded-[25px] focus:ring-2 focus:ring-pink-500 outline-none text-gray-700 font-medium transition-all">
                        <div class="absolute right-6 top-4">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Phone Number & Verification --}}
                <div class="relative">
                    <label class="absolute -top-2.5 left-6 bg-white px-2 text-[11px] font-bold text-green-600 uppercase tracking-[0.2em]">Phone Number</label>
                    <div class="flex items-center bg-gray-50 rounded-[25px] overflow-hidden focus-within:ring-2 focus-within:ring-pink-500 transition-all">
                        <input type="text" value="089637001713" class="flex-1 px-8 py-4 bg-transparent outline-none font-medium">
                        <button type="button" @click="otpSent = true" class="mr-4 px-6 py-2 bg-[#1B4332] text-white text-[11px] font-bold rounded-full hover:bg-green-700 transition shadow-lg shadow-green-900/10">Verify</button>
                    </div>
                </div>

                {{-- OTP Section --}}
                <div x-show="otpSent" x-transition x-cloak class="bg-pink-50/50 p-8 rounded-[30px] border border-pink-100 space-y-5">
                    <label class="block text-[11px] font-bold text-pink-600 uppercase tracking-widest ml-2">Enter OTP Code</label>
                    <div class="flex gap-4">
                        <input type="text" placeholder="656989" class="w-40 px-6 py-3 bg-white border border-pink-100 rounded-2xl focus:ring-2 focus:ring-pink-500 outline-none font-bold text-center tracking-widest">
                        <button type="button" @click="isVerified = true" class="px-8 py-3 bg-pink-500 text-white rounded-2xl text-xs font-bold hover:bg-pink-600 transition shadow-lg shadow-pink-500/20">Confirm OTP</button>
                    </div>
                    <p x-show="isVerified" class="text-xs text-green-600 font-bold flex items-center gap-2">
                        <span class="bg-green-500 text-white text-[8px] w-4 h-4 flex items-center justify-center rounded-full">✓</span> Phone Number Successfully Verified!
                    </p>
                </div>

                {{-- Upload KTP --}}
                <div class="space-y-4">
                    <label class="block text-[11px] font-bold text-green-600 uppercase tracking-[0.2em] ml-6">Document (KTP)</label>
                    <div class="flex flex-wrap items-center gap-8 px-2">
                        <label for="ktp" class="flex flex-col items-center justify-center w-48 h-28 border-2 border-dashed border-pink-100 rounded-[30px] cursor-pointer hover:bg-pink-50 transition-all group">
                            <svg class="w-8 h-8 text-pink-200 group-hover:text-pink-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="text-[10px] text-pink-300 mt-2 font-bold uppercase tracking-tighter">Pilih Foto KTP</span>
                        </label>
                        <input type="file" id="ktp" name="ktp" class="hidden" @change="updatePreview($event, 'ktp')">

                        <div x-show="ktpPreview" x-cloak class="relative">
                            <img :src="ktpPreview" class="h-28 w-48 object-cover rounded-[30px] border border-pink-50 shadow-md">
                            <button @click="ktpPreview = null" type="button" class="absolute -top-3 -right-3 bg-red-500 text-white rounded-full p-1.5 shadow-xl hover:scale-110 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="pt-10 flex justify-center">
                    <button type="submit" class="bg-gradient-to-r from-[#1B4332] to-green-800 text-white px-16 py-4 rounded-[20px] font-bold text-sm shadow-xl shadow-green-900/20 hover:scale-[1.03] active:scale-95 transition-all flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                        Save All Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection