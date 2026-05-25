<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CameraController extends Controller
{
    public function landing(Request $request)
    {
        $query = Product::where('category', 'Kamera');

        // FILTER TIPE
        if ($request->type) {
            $query->where('type_category_id', $request->type);
        }

        // FILTER MEREK
        if ($request->brand) {
            $query->where('brand_category_id', $request->brand);
        }

        $items = $query->get();

        $filterTipes = Category::where('main_category', 'Kamera')
            ->where('attribute_type', 'Tipe')
            ->where('is_active', 1)
            ->get();

        $filterMereks = Category::where('main_category', 'Kamera')
            ->where('attribute_type', 'Merek')
            ->where('is_active', 1)
            ->get();

        return view('pages.landing.kategori.kategori_LP', [
            'items'        => $items,
            'filterTipes'  => $filterTipes,
            'filterMereks' => $filterMereks,
            'category'     => 'camera',
            'title'        => 'Kamera',
            'emptyIcon'    => '📷',
        ]);
    }

    public function index()
    {
        // Ganti ke Product
        $items = Product::where('category', 'Kamera')->get();
        return view('camera.index', compact('items'));
    }

    public function create()
    {
        return view('camera.create_camera');
    }

    public function store(Request $request)
    {
        Product::create([
            'name' => $request->name,
            'stock' => $request->stock,
            'price_per_day' => $request->price,
            'category' => 'Kamera',
            'image'         => $request->image,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('camera.index');
    }

    public function edit($id)
    {
        $item = Product::findOrFail($id);
        return view('camera.edit_camera', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Product::findOrFail($id);

        // Update sesuai nama kolom di tabel products
        $item->update([
            'name' => $request->name,
            'stock' => $request->stock,
            'price_per_day' => $request->price,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('camera.index');
    }

    public function destroy($id)
    {
        $item = Product::findOrFail($id);
        $item->delete();

        return redirect()->route('camera.index');
    }

    public function show($id)
    {
        $item = Product::findOrFail($id);

        $relatedItems = Product::where('category', 'Kamera')
            ->where('id', '!=', $item->id)
            ->take(5)
            ->get();

        return view('pages.landing.kategori.details_LP', [
            'item'          => $item,
            'relatedItems'  => $relatedItems,
            'category'      => 'camera',
            'categoryLabel' => 'Kamera',
            'accordions'    => [
                ['title' => 'Tentang Kamera ini', 'deskripsi' => $item->deskripsi ?? 'Deskripsi tidak tersedia.', 'open' => true],
                ['title' => 'Sorotan',            'deskripsi' => 'Spesifikasi unggulan untuk ' . $item->name . '.', 'open' => false],
                ['title' => 'Isi Paket',          'deskripsi' => $item->stock > 0 ? 'Tersedia — ' . $item->stock . ' unit siap disewa.' : 'Stok sedang kosong.', 'open' => false],
            ],
        ]);
    }
}
