@extends('layouts.pelanggan')

@section('title', 'Settings')

@push('styles')
<style>
    .input-field {
        transition: all 0.2s;
        border: 1px solid #E2E8F0;
    }

    .input-field:focus {
        border-color: #22543D;
        box-shadow: 0 0 0 3px rgba(34, 84, 61, 0.1);
        outline: none;
    }

    .anim {
        animation: fadeIn 0.5s ease-out forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

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
}" class="mmt-8 ml-84 min-h-screen bg-[#EEF3F0] px-9 pt-9 pb-16">

    {{-- Judul --}}
    <div class="mb-8 anim">
        <h1 class="text-3xl font-extrabold text-[#22543D] tracking-tight">Pengaturan Akun</h1>
        <p class="text-gray-500 mt-1">Kelola informasi data diri dan keamanan akun Anda.</p>
    </div>

    <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 overflow-hidden anim">
        <form action="{{ route('profil.update_profile') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf
            @method('PUT')

            {{-- Foto Profil --}}
            <div class="flex flex-col items-center pb-6 border-b border-gray-50">
                <div class="relative group">
                    <img :src="profilePreview 
                        ? profilePreview 
                        : 'https://ui-avatars.com/api/?name={{ urlencode($pelanggan->name) }}&background=22543D&color=fff&size=128'"
                        class="w-28 h-28 rounded-full object-cover border-4 border-[#EEF3F0] shadow-sm">

                    <label for="profile_picture" class="absolute bottom-0 right-0 bg-[#22543D] p-2 rounded-full text-white cursor-pointer hover:bg-[#ED64A6] transition shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </label>
                    <input type="file" id="profile_picture" name="profile_picture" class="hidden" @change="updatePreview($event, 'profile')">
                </div>
                <p class="text-[10px] font-bold text-gray-400 mt-3 uppercase tracking-widest">Foto Profil</p>
            </div>

            {{-- Form --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama --}}
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Nama Lengkap</label>
                    <input type="text" name="name"
                        value="{{ old('name', $pelanggan->name) }}"
                        class="input-field w-full px-4 py-3 rounded-xl text-sm font-medium text-gray-700">
                </div>

                {{-- Email --}}
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Alamat Email</label>
                    <input type="email" name="email"
                        value="{{ old('email', $pelanggan->email) }}"
                        class="input-field w-full px-4 py-3 rounded-xl text-sm font-medium text-gray-700">
                </div>

                {{-- Phone / NIK --}}
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Nomor Telepon</label>
                    <div class="flex gap-2">
                        <input type="text" name="nik"
                            value="{{ old('nik', $pelanggan->nik) }}"
                            class="input-field flex-1 px-4 py-3 rounded-xl text-sm font-medium text-gray-700">
                        <button type="button" @click="otpSent = true"
                            class="px-5 py-2 bg-[#22543D] text-white text-[11px] font-bold rounded-xl">
                            Verify
                        </button>
                    </div>
                </div>

                {{-- OTP Section (Conditional) --}}
                <div class="space-y-2"> 
                    <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Masukkan Kode OTP</label>
                    <div class="flex gap-2"> 
                        <input type="number" placeholder="656989" class="w-32 px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#22543D] outline-none font-bold text-center tracking-widest"> <button type="button" @click="isVerified = true" class="px-6 py-2 bg-[#ED64A6] text-white rounded-xl text-xs font-bold hover:bg-[#d55695] transition">Confirm</button> </div>
                    <p x-show="isVerified" class="text-xs text-emerald-600 font-bold flex items-center gap-2 italic"> ✓ Phone Number Successfully Verified! </p>
                </div>

                {{-- KTP --}}
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Dokumen (KTP)</label>
                    <label for="ktp"
                        class="flex items-center justify-center w-full px-4 py-3 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50">
                        <span class="text-xs text-gray-400 font-bold uppercase">Pilih File KTP</span>
                    </label>
                    <input type="file" id="ktp" name="ktp" class="hidden" @change="updatePreview($event, 'ktp')">
                </div>

            </div>

            {{-- Preview KTP --}}
            <div x-show="ktpPreview">
                <img :src="ktpPreview" class="h-32 w-56 object-cover rounded-2xl border shadow-sm">
            </div>

            {{-- Action --}}
            <div class="pt-6 flex justify-end gap-4 border-t">
                <button type="submit"
                    class="bg-[#22543D] hover:bg-[#ED64A6] text-white px-10 py-3 rounded-xl font-bold text-sm">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection