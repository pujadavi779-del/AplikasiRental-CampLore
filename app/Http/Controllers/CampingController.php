<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class CampingController extends Controller
{
    public function index()
    {
        $items = Item::where('category', 'camping')->get();
        return view('admin.items.camping', compact('items'));
    }

    public function create()
    {
        return view('admin.items.create');
    }

    public function store(Request $request)
    {
        Item::create([
            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price,
            'category' => 'camping'
        ]);

        return redirect()->route('camping.index');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('admin.items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $item->update([
            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price,
        ]);

        return redirect()->route('camping.index');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('camping.index');
    }
}
