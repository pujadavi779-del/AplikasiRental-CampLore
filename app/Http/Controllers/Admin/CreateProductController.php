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
            'name'              => 'required|string|max:255',
            'Kategori_data'     => 'required|string',
            'harga_per_hari'    => 'required|numeric',
            'stok'              => 'required|integer|min:0',
            'deskripsi'         => 'nullable|string',
            'sorotan'           => 'nullable|string',
            'isi_paket'         => 'nullable|string',
            'id_tipe_kategori'  => 'nullable|exists:data_kategori,id_kategori', // ← UPDATE
            'id_merek_kategori' => 'nullable|exists:data_kategori,id_kategori', // ← UPDATE
            'image'             => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = 'storage/' . $request->file('image')->store('products', 'public');
        }

        Barang::create([
            'name'              => $request->name, // ← UPDATE
            'kategori'          => $request->Kategori_data,
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
