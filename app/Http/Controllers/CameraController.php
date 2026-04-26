<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // 1. Ganti dari Item ke Product

class CameraController extends Controller
{
    public function landing()
    {
        // 2. Ambil dari Product, kategori 'Kamera' (sesuai isi database tadi)
        $items = Product::where('category', 'Kamera')->get();

        $ipCategories = collect([
            (object)['name' => 'Canon',    'slug' => 'canon',    'image' => null],
            (object)['name' => 'Sony',     'slug' => 'sony',     'image' => null],
            (object)['name' => 'Nikon',    'slug' => 'nikon',    'image' => null],
            (object)['name' => 'Fujifilm', 'slug' => 'fujifilm', 'image' => null],
            (object)['name' => 'GoPro',    'slug' => 'gopro',    'image' => null],
            (object)['name' => 'Sigma',    'slug' => 'sigma',    'image' => null],
            (object)['name' => 'Leica',    'slug' => 'leica',    'image' => null],
            (object)['name' => 'DJI',      'slug' => 'dji',      'image' => null],
        ]);

        return view('pages.landing.kategori.camera_LP', compact('items', 'ipCategories'));
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
            'body' => $request->body,
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
            'body' => $request->body,
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

        return view('pages.landing.kategori.details_camera', compact('item', 'relatedItems'));
    }
}