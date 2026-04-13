<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class CameraController extends Controller
{
    public function landing()
    {
        $items = Item::where('category', 'camera')->get();

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

        return view('camera.camera_LP', compact('items', 'ipCategories'));
    }
    public function index()
    {
        $items = Item::where('category', 'camera')->get();
        return view('camera.index', compact('items'));
    }

    public function create()
    {
        return view('camera.create_camera');
    }

    public function store(Request $request)
    {
        Item::create([
            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price,
            'category' => 'camera'
        ]);

        return redirect()->route('camera.index');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('camera.edit_camera', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $item->update([
            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price,
        ]);

        return redirect()->route('camera.index');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('camera.index');
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);

        $relatedItems = Item::where('id', '!=', $item->id)
            ->take(5)
            ->get();

        return view('camera.camera_categories.details_camera', compact('item', 'relatedItems'));
    }
}
