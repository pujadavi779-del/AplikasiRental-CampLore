<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CampingController extends Controller
{
    // 🔹 TAMPIL DATA (ADMIN INDEX)
    public function index()
    {
        $items = Product::where('category', 'Camping')->get();
        return view('admin.camping.camping_LP', compact('items'));
    }

    // 🔹 HALAMAN USER (LANDING)
    public function landing()
    {
        $items = Product::where('category', 'Camping')->get();

        $filterTipes = Category::where('main_category', 'Camping')
            ->where('attribute_type', 'Tipe')
            ->where('is_active', 1)
            ->get();

        $filterMereks = Category::where('main_category', 'Camping')
            ->where('attribute_type', 'Merek')
            ->where('is_active', 1)
            ->get();

        return view('pages.landing.kategori.kategori_LP', [
            'items'        => $items,
            'filterTipes'  => $filterTipes,
            'filterMereks' => $filterMereks,
            'category'     => 'camping',
            'title'        => 'Camping',
            'emptyIcon'    => '🏕️',
        ]);
    }   // ← cuma 1 kurung, tutup method

    // 🔹 EDIT
    public function edit($id)
    {
        $item = Product::findOrFail($id);
        return view('admin.camping.edit', compact('item'));
    }

    // 🔹 DELETE
    public function destroy($id)
    {
        $item = Product::findOrFail($id);
        $item->delete();

        return redirect()->route('camping.index')
            ->with('success', 'Data berhasil dihapus');
    }

    // 🔹 DETAIL PRODUK (SHOW)
    public function show($id)
    {
        $item = Product::findOrFail($id);

        $relatedItems = Product::where('category', 'Camping')
            ->where('id', '!=', $item->id)
            ->take(5)
            ->get();

        return view('pages.landing.kategori.details_LP', [
            'item'          => $item,
            'relatedItems'  => $relatedItems,
            'category'      => 'camping',
            'categoryLabel' => 'Camping',
        ]);
    }
}   // ← ini tutup class