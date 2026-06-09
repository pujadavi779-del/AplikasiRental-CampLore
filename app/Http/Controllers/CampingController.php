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
    public function landing(Request $request)
    {
        $query = Product::where('category', 'Camping');

        // FILTER TIPE
        if ($request->type) {
            $query->where('type_category_id', $request->type);
        }

        // FILTER MEREK
        if ($request->brand) {
            $query->where('brand_category_id', $request->brand);
        }

        $items = $query->get();

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
    }

    // 🔹 EDIT
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $types = Category::where('main_category', 'Camping')
            ->where('attribute_type', 'Tipe')
            ->where('is_active', 1)
            ->get();

        $brands = Category::where('main_category', 'Camping')
            ->where('attribute_type', 'Merek')
            ->where('is_active', 1)
            ->get();

        return view('pages.admin.products.edit', compact(
            'product',
            'types',
            'brands'
        ));
    }

    // 🔹 DELETE
    public function destroy($id)
    {
        $item = Product::findOrFail($id);
        
        // Opsional: Hapus file gambar dari public folder saat data dihapus
        if ($item->image && file_exists(public_path($item->image))) {
            @unlink(public_path($item->image));
        }

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

    $reviews = \App\Models\Review::with('user')
        ->where('product_id', $id)
        ->latest()
        ->get();

    $avgRating = $reviews->count() ? round($reviews->avg('rating'), 1) : 0;

    $canReview = false;
    $reviewOrder = null;
    if (auth()->check()) {
        $reviewOrder = \App\Models\Order::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->where('status', 'selesai')
            ->first();
        $alreadyReviewed = \App\Models\Review::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->exists();
        $canReview = $reviewOrder && !$alreadyReviewed;
    }

    return view('pages.landing.kategori.details_LP', [
        'item'          => $item,
        'relatedItems'  => $relatedItems,
        'category'      => 'camping',
        'categoryLabel' => 'Camping',
        'reviews'       => $reviews,
        'avgRating'     => $avgRating,
        'canReview'     => $canReview,
        'reviewOrder'   => $reviewOrder,
        'accordions'    => [
            ['title' => 'Tentang Alat ini', 'deskripsi' => $item->deskripsi ?? 'Deskripsi tidak tersedia.', 'open' => true],
            ['title' => 'Sorotan',          'deskripsi' => $item->highlights ?? 'Spesifikasi unggulan tidak tersedia.', 'open' => false],
            ['title' => 'Isi Paket',        'deskripsi' => $item->isi_paket ?? 'Informasi isi paket tidak tersedia.', 'open' => false],
        ],
    ]);
}

    public function create()
    {
        $types = Category::where('main_category', 'Camping')
            ->where('attribute_type', 'Tipe')
            ->where('is_active', 1)
            ->get();

        $brands = Category::where('main_category', 'Camping')
            ->where('attribute_type', 'Merek')
            ->where('is_active', 1)
            ->get();

        return view('pages.admin.products.create', compact(
            'types',
            'brands'
        ));
    }

    // 🔹 STORE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'type_category_id' => 'required',
            'brand_category_id' => 'required',
            'price_per_day' => 'required',
            'stock' => 'required',
            'deskripsi' => 'required',
            'highlights' => 'required',
            'isi_paket' => 'required',
            'image' => 'required|image',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            // Disesuaikan agar strukturnya sama seperti img_foto/camping/ di database kamu
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img_foto/camping'), $filename);
            $imagePath = 'img_foto/camping/' . $filename;
        }

        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'type_category_id' => $request->type_category_id,
            'brand_category_id' => $request->brand_category_id,
            'price_per_day' => $request->price_per_day,
            'stock' => $request->stock,
            'deskripsi' => $request->deskripsi,
            'highlights' => $request->highlights,
            'isi_paket' => $request->isi_paket,
            'image' => $imagePath,
        ]);

        return redirect()->route('camping.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    // 🔹 UPDATE
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'type_category_id' => 'required',
            'brand_category_id' => 'required',
            'price_per_day' => 'required',
            'stock' => 'required',
            'deskripsi' => 'required',
            'highlights' => 'required',
            'isi_paket' => 'required',
            'image' => 'nullable|image',
        ]);

        $data = [
            'name' => $request->name,
            'category' => $request->category,
            'type_category_id' => $request->type_category_id,
            'brand_category_id' => $request->brand_category_id,
            'price_per_day' => $request->price_per_day,
            'stock' => $request->stock,
            'deskripsi' => $request->deskripsi,
            'highlights' => $request->highlights,
            'isi_paket' => $request->isi_paket,
        ];

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada file baru yang masuk
            if ($product->image && file_exists(public_path($product->image))) {
                @unlink(public_path($product->image));
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img_foto/camping'), $filename);
            $data['image'] = 'img_foto/camping/' . $filename;
        }

        $product->update($data);

        return redirect()->route('camping.index')
            ->with('success', 'Produk berhasil diupdate');
    }
}