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
            'name' => 'required|string|max:255',
            'category' => 'required',
            'price_per_day' => 'required|numeric',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Handle Upload Gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            // Path ini akan menghasilkan: storage/app/public/products/namafile.jpg
        }

        // 3. Simpan ke Database
        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'price_per_day' => $request->price_per_day,
            'description' => $request->description,
            'image' => $imagePath, // Simpan path-nya saja
            'stock' => 1, // Default stok tersedia
        ]);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan!');
    }
}
