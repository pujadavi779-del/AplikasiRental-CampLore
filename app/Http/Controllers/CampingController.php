<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camping;
use App\Models\Item;

class CampingController extends Controller
{
    // 🔹 TAMPIL DATA (INDEX)
    public function index()
    {
        $items = Camping::all();
        return view('admin.camping.camping_LP', compact('items'));
    }

    // 🔹 HALAMAN USER (LANDING)
    public function landing()
    {
        $items = Item::where('category', 'camping')->get();

        // 🔹 dummy brand (sementara)
        $campingBrands = collect([
            (object)['name' => 'Eiger', 'slug' => 'eiger', 'image' => null],
            (object)['name' => 'Consina', 'slug' => 'consina', 'image' => null],
            (object)['name' => 'Rei', 'slug' => 'rei', 'image' => null],
            (object)['name' => 'Naturehike', 'slug' => 'naturehike', 'image' => null],
            (object)['name' => 'Arei', 'slug' => 'arei', 'image' => null],
            (object)['name' => 'Avtech', 'slug' => 'avtech', 'image' => null],
        ]);

        return view('camping.camping_LP', compact('items', 'campingBrands'));
    }

    // 🔹 EDIT
    public function edit($id)
    {
        $item = Camping::findOrFail($id);
        return view('admin.camping.edit', compact('item'));
    }

    // 🔹 DELETE
    public function destroy($id)
    {
        $item = Camping::findOrFail($id);
        $item->delete();

        return redirect()->route('camping.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);

        $relatedItems = Item::where('id', '!=', $item->id)
            ->take(5)
            ->get();

        return view('camping.camping_categories.details_camping', compact('item', 'relatedItems'));
    }
}
