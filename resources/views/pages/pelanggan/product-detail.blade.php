@extends('layouts.dashboard_pelanggan')
@section('title', $product['name'].' - Camplore')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800;900&display=swap');

    section, section * {
        font-family: 'Inter', sans-serif;
    }

    section h1 {
        font-family: 'Playfair Display', serif;
    }
</style>

<section class="py-16 max-w-5xl mx-auto px-4">
    <a href="javascript:history.back()" class="text-sm text-gray-400 hover:text-[#22543D] transition">← Kembali</a>

    <div class="mt-6 bg-white rounded-3xl shadow-sm border border-pink-100 overflow-hidden grid md:grid-cols-2 gap-0">

        {{-- Foto --}}
        <div class="aspect-square overflow-hidden">
            <img src="{{ $product['img'] }}" class="w-full h-full object-cover">
        </div>

        {{-- Detail --}}
        <div class="p-8 flex flex-col justify-between">
            <div>
                <span class="text-xs font-bold text-[#22543D] bg-emerald-100 px-3 py-1 rounded-full">{{ $product['category'] }