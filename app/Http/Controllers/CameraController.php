<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class CameraController extends Controller
{
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
}
