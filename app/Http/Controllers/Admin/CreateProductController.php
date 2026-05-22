<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CreateProductController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name'          => 'required|string|max:255',
            'category'      => 'required|string',
            'price_per_day' => 'required|numeric',
            'stock'         => 'required|integer|min:0',
            'deskripsi'     => 'nullable|string',
            'highlights'    => 'nullable|string',
            'isi_paket'     => 'nullable|string',
            'type_category_id'  => 'nullable|exists:categories,id',
            'brand_category_id' => 'nullable|exists:categories,id',
            'image'         => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 3. Simpan ke Database
        Product::create([
            'name'              => $request->name,
            'category'          => $request->category,
            'price_per_day'     => $request->price_per_day,
            'stock'             => $request->stock,
            'deskripsi'         => $request->deskripsi,
            'highlights'        => $request->highlights,
            'isi_paket'         => $request->isi_paket,
            'type_category_id'  => $request->type_category_id,
            'brand_category_id' => $request->brand_category_id,
            'image'             => $imagePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan!');
    }
}
