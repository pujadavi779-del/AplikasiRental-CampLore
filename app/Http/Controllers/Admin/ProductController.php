<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CREATE PAGE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $types = Category::where('attribute_type', 'Tipe')
            ->where('is_active', 1)
            ->get();

        $brands = Category::where('attribute_type', 'Merek')
            ->where('is_active', 1)
            ->get();

        return view('pages.admin.products.create', compact('types', 'brands'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE PRODUCT
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'highlights' => 'required|string',
            'isi_paket' => 'required|string',
            'type_category_id' => 'nullable|exists:categories,id',
            'brand_category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'stock' => $request->stock,
            'category' => $request->category,
            'price_per_day' => $request->price_per_day,
            'deskripsi' => $request->deskripsi,
            'highlights' => $request->highlights,
            'isi_paket' => $request->isi_paket,
            'type_category_id' => $request->type_category_id,
            'brand_category_id' => $request->brand_category_id,
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('admin.products')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT PAGE
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $types = Category::where('attribute_type', 'Tipe')
            ->where('is_active', 1)
            ->get();

        $brands = Category::where('attribute_type', 'Merek')
            ->where('is_active', 1)
            ->get();

        return view('pages.admin.products.edit', compact(
            'product',
            'types',
            'brands'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PRODUCT
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'               => 'required|string|max:255',
            'stock'              => 'required|numeric|min:0',
            'category'           => 'required|string',
            'price_per_day'      => 'required|numeric|min:0',

            'deskripsi'          => 'required|string',
            'highlights'         => 'nullable|string',
            'isi_paket'          => 'nullable|string',

            'type_category_id'   => 'nullable|exists:categories,id',
            'brand_category_id'  => 'nullable|exists:categories,id',

            'image'              => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name'               => $request->name,
            'stock'              => $request->stock,
            'category'           => $request->category,
            'price_per_day'      => $request->price_per_day,

            'deskripsi'          => $request->deskripsi,
            'highlights'         => $request->highlights,
            'isi_paket'          => $request->isi_paket,

            'type_category_id'   => $request->type_category_id,
            'brand_category_id'  => $request->brand_category_id,
        ];

        if ($request->hasFile('image')) {

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request
                ->file('image')
                ->store('products', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('admin.products')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE PRODUCT
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
