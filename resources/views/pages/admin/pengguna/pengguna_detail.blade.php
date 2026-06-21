@php
    $NavParent = 'Manajemen Operasional';
    $section = 'Detail Pengguna';
@endphp
@extends('layouts.admin')

@section('title', 'Detail Verifikasi Pengguna')

@section('content')

<div class="flex gap-6 max-w-full">

    {{-- ══════════════ KOLOM KIRI ══════════════ --}}
    <div class="flex-1 flex flex-col gap-5">

        {{-- Card Info Pengguna --}}
        <div class="bg-white rounded-[22px] border border-[#d7e6de] shadow-sm p-6">
            <div class="flex items-start justify-between gap-4">

                {{-- Avatar + Info --}}
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-[#e8f0eb] flex items-center justify-center flex-shrink-0">
                        @if($customer->foto_profile)
                            <img src="{{ asset('storage/'.$customer->foto_profile) }}"
                                class="w-16 h-16 rounded-full object-cover">
                        @else
                            <svg class="w-8 h-8 text-[#22543D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-xl font-extrabold text-gray-900" style="font-family:'Playfair Display',Georgia,serif;">
                            {{ $customer->nama_lengkap?? $customer->nama }}
                        </h2>
                        <p class="text-sm text-gray-400 flex items-center gap-1 mt-0.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $customer->email }}
                        </p>
                    </div>
                </div>

                {{-- Status Badge --}}
                @php $status = $customer->ktp_status ?? 'pending'; @endphp
                <div class="flex-shrink-0">
                    @if($status === 'verified')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold border border-emerald-200">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Terverifikasi
                        </span>
                    @elseif($status === 'rejected')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-red-100 text-red-600 text-xs font-bold border border-red-200">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span> Ditolak
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-gray-100 text-gray-600 text-xs font-bold border border-gray-200">
                            <span class="w-2 h-2 rounded-full bg-gray-400"></span> Menunggu Verifikasi
                        </span>
                    @endif
                </div>
            </div>

            {{-- Info Grid --}}
            <div class="grid grid-cols-2 gap-4 mt-6">

                {{-- NIK --}}
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nomor Induk Kependudukan (NIK)</p>
                    <div class="flex items-center gap-2 px-4 py-3 bg-gray-50 rounded-xl border border-gray-200">
                        <span class="font-mono text-sm font-semibold text-gray-800 flex-1">{{ $customer->nik ?? '-' }}</span>
                        @if($customer->nik)
                        <button onclick="navigator.clipboard.writeText('{{ $customer->nik }}')"
                            class="text-gray-400 hover:text-[#22543D] transition" title="Salin NIK">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>

                {{-- Tanggal Registrasi --}}
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Tanggal Registrasi</p>
                    <div class="flex items-center gap-2 px-4 py-3 bg-gray-50 rounded-xl border border-gray-200">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-800">{{ $customer->created_at ? $customer->created_at->format('d F Y') : '-' }}</span>
                    </div>
                </div>

                {{-- No Telepon --}}
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nomor Telepon</p>
                    <div class="flex items-center gap-2 px-4 py-3 bg-gray-50 rounded-xl border border-gray-200">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-800">{{ $customer->no_tlp ?? '-' }}</span>
                    </div>
                </div>

                {{-- Alamat --}}
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Alamat</p>
                    <div class="flex items-start gap-2 px-4 py-3 bg-gray-50 rounded-xl border border-gray-200 min-h-[48px]">
                        <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-800 leading-relaxed">
                            @php
                                $sa = $customer->alamatPengiriman;
                                echo $sa
                                    ? implode(', ', array_filter([$sa->alamat_lengkap, $sa->kota, $sa->daerah, $sa->kode_pos]))
                                    : '-';
                            @endphp
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Foto KTP --}}
        <div class="bg-white rounded-[22px] border border-[#d7e6de] shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#eef4f0]">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#22543D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="2" y="5" width="20" height="14" rx="3" stroke-width="2"/>
                        <circle cx="8" cy="12" r="2" stroke-width="2"/>
                        <path d="M14 10h4M14 14h4" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span class="font-bold text-gray-800 text-sm">Foto KTP Terunggah</span>
                </div>
                @if($customer->foto_ktp)
                <div class="flex gap-2">
                    <a href="{{ asset('storage/'.$customer->foto_ktp) }}" target="_blank"
                        class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 transition" title="Perbesar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                        </svg>
                    </a>
                    <a href="{{ asset('storage/'.$customer->foto_ktp) }}" download
                        class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 transition" title="Unduh">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </a>
                </div>
                @endif
            </div>

            <div class="p-6 bg-gray-50">
                @if($customer->foto_ktp)
                    <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm bg-white">
                        <img src="{{ asset('storage/'.$customer->foto_ktp) }}"
                            alt="KTP {{ $customer->nama_lengkap }}"
                            class="w-full object-contain max-h-80">
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="2" y="5" width="20" height="14" rx="3" stroke-width="1.5"/>
                        </svg>
                        <p class="text-sm font-medium">Foto KTP belum diunggah</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- ══════════════ KOLOM KANAN ══════════════ --}}
    <div class="w-72 flex flex-col gap-5 flex-shrink-0">

        {{-- Panduan Verifikasi --}}
        <div class="bg-[#f1f8f4] rounded-[22px] border border-[#d1e8da] p-5">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-6 h-6 rounded-full bg-[#22543D]/10 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-[#22543D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-sm font-bold text-[#22543D]">Panduan Verifikasi</span>
            </div>
            <ul class="space-y-2 text-xs text-[#4a7c5f] leading-relaxed">
                <li>• Memastikan NIK yang diinput sesuai dengan foto KTP.</li>
                <li>• Menyetujui verifikasi ini akan secara otomatis mengaktifkan akun pengguna untuk melakukan transaksi.</li>
                <li>• Jika foto buram atau tidak sesuai, tolak dan minta pengguna mengunggah ulang.</li>
            </ul>
        </div>

        {{-- Kelola Status --}}
        <div class="bg-white rounded-[22px] border border-[#d7e6de] shadow-sm p-5">
            <h3 class="text-sm font-bold text-gray-800 mb-4">Kelola Status Verifikasi</h3>

            <form action="{{ route('admin.customers.update', $customer->id_pelanggan) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Catatan --}}
                <div class="mb-4">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1.5">
                        Catatan Verifikasi (Opsional)
                    </label>
                    <textarea name="ktp_note" rows="4"
                        placeholder="Contoh: NIK tidak sesuai dengan foto atau gambar kurang jelas..."
                        class="w-full px-3 py-2.5 text-xs text-gray-700 border border-gray-200 rounded-xl resize-none focus:outline-none focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D]">{{ $customer->ktp_note ?? '' }}</textarea>
                </div>

                {{-- Tombol Setujui --}}
                <button type="submit" name="ktp_status" value="verified"
                    class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-[#22543D] hover:bg-[#1a3d2e] text-white text-sm font-bold transition mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Setujui Verifikasi
                </button>

                {{-- Tombol Tolak --}}
                <button type="submit" name="ktp_status" value="rejected"
                    class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-white hover:bg-red-50 text-red-500 text-sm font-bold border-2 border-red-200 hover:border-red-400 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Tolak Pendaftaran
                </button>
            </form>

            {{-- Terakhir diubah --}}
            @if($customer->updated_at && $customer->ktp_status)
            <p class="text-[10px] text-gray-400 mt-4 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Terakhir diubah {{ $customer->updated_at->format('d/m/Y H:i') }}
            </p>
            @endif
        </div>

    </div>
</div>

@if(session('success'))
<div class="fixed bottom-6 right-6 bg-emerald-600 text-white px-5 py-3 rounded-2xl shadow-lg text-sm font-semibold z-50 flex items-center gap-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
    </svg>
    {{ session('success') }}
</div>
@endif

@endsection