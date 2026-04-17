@extends('layouts.list')

@section('title', 'Daftar Produk')

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Katalog Produk</h1>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-gray-200">
                    <th class="px-4 py-3 font-semibold text-gray-700 w-20">ID</th>
                    <th class="px-4 py-3 font-semibold text-gray-700">Nama Produk</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($data as $post)
                <tr class="hover:bg-blue-50 transition">
                    <td class="px-4 py-3 text-gray-600">{{ $post['id'] }}</td>
                    <td class="px-4 py-3 text-gray-800 font-medium">{{ $post['produk'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection