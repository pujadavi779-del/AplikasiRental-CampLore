<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CreateProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:150',
            'stok'             => 'required|integer|min:0|max:100',
            'kategori'         => 'required|string|max:50',
            'harga_per_hari'   => 'required|numeric|min:0|max:1000000',
            'deskripsi'         => 'required|string',
            'sorotan'           => 'required|string',
            'isi_paket'         => 'required|string',
            'id_tipe_kategori'  => 'nullable|exists:data_kategori,id_kategori',
            'id_merek_kategori' => 'nullable|exists:data_kategori,id_kategori',
            'gambar_barang'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'stok.max'            => 'Stok tidak boleh lebih dari 100.',
            'stok.required'       => 'Stok wajib diisi.',
            'stok.integer'        => 'Stok harus berupa angka.',
            'stok.min'            => 'Stok tidak boleh kurang dari 0.',
            'harga_per_hari.max'      => 'Harga per hari tidak boleh lebih dari Rp 1.000.000.',
            'harga_per_hari.required' => 'Harga per hari wajib diisi.',
            'harga_per_hari.numeric'  => 'Harga per hari harus berupa angka.',
            'harga_per_hari.min'      => 'Harga per hari tidak boleh kurang dari 0.',
        ]);

        $imagePath = null;
        if ($request->hasFile('gambar_barang')) {
            $imagePath = 'storage/' . $request->file('gambar_barang')->store('products', 'public');
        }

        Barang::create([
            'name'              => $request->name,
            'kategori'          => $request->kategori,
            'harga_per_hari'    => $request->harga_per_hari,
            'stok'              => $request->stok,
            'deskripsi'         => $request->deskripsi,
            'sorotan'           => $request->sorotan,
            'isi_paket'         => $request->isi_paket,
            'id_tipe_kategori'  => $request->id_tipe_kategori,
            'id_merek_kategori' => $request->id_merek_kategori,
            'gambar_barang'     => $imagePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan!');
    }
}