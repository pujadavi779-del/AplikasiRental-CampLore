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
        // 1. Validasi Input
        $request->validate([
            'name'          => 'required|string|max:255',
            'kategori'      => 'required|string',
            'harga_per_hari' => 'required|numeric',
            'stok'         => 'required|integer|min:0',
            'deskripsi'     => 'nullable|string',
            'sorotan'    => 'nullable|string',
            'isi_paket'     => 'nullable|string',
            'tipe_kategori_id'  => 'nullable|exists:categories,id',
            'merek_kategori_id' => 'nullable|exists:categories,id',
            'image'         => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 3. Simpan ke Database
        Barang::create([
            'name'              => $request->name,
            'kategori'          => $request->kategori,
            'harga_per_hari'     => $request->harga_per_hari,
            'stok'             => $request->stok,
            'deskripsi'         => $request->deskripsi,
            'sorotan'        => $request->sorotan,
            'isi_paket'         => $request->isi_paket,
            'tipe_kategori_id'  => $request->tipe_kategori_id,
            'merek_kategori_id' => $request->merek_kategori_id,
            'image'             => $imagePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan!');
    }
}
