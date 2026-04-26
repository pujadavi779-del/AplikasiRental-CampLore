<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Pastikan ini terpanggil

class CampingController extends Controller
{
    // 🔹 TAMPIL DATA (ADMIN INDEX)
    public function index()
    {
        // Mengambil dari model Product
        $items = Product::where('category', 'Camping')->get();
        return view('admin.camping.camping_LP', compact('items'));
    }

    // 🔹 HALAMAN USER (LANDING)
    public function landing()
    {
        // Ganti Item ke Product
        $items = Product::where('category', 'Camping')->get();

        // 🔹 dummy brand (tetap dipertahankan)
        $campingBrands = collect([
            (object)['name' => 'Eiger', 'slug' => 'eiger', 'image' => null],
            (object)['name' => 'Consina', 'slug' => 'consina', 'image' => null],
            (object)['name' => 'Rei', 'slug' => 'rei', 'image' => null],
            (object)['name' => 'Naturehike', 'slug' => 'naturehike', 'image' => null],
            (object)['name' => 'Arei', 'slug' => 'arei', 'image' => null],
            (object)['name' => 'Avtech', 'slug' => 'avtech', 'image' => null],
        ]);

        return view('pages.landing.kategori.camping_LP', compact('items', 'campingBrands'));
    }

    // 🔹 EDIT
    public function edit($id)
    {
        // Ganti model ke Product
        $item = Product::findOrFail($id);
        return view('admin.camping.edit', compact('item'));
    }

    // 🔹 DELETE
    public function destroy($id)
    {
        // Ganti model ke Product
        $item = Product::findOrFail($id);
        $item->delete();

        return redirect()->route('camping.index')
            ->with('success', 'Data berhasil dihapus');
    }

    // 🔹 DETAIL PRODUK (SHOW)
    public function show($id)
    {
        // Ganti model ke Product
        $item = Product::findOrFail($id);

        // Ambil produk terkait sesama kategori Camping di tabel products
        $relatedItems = Product::where('category', 'Camping')
            ->where('id', '!=', $item->id)
            ->take(5)
            ->get();

        return view('pages.landing.kategori.details_camping', compact('item', 'relatedItems'));
    }
}