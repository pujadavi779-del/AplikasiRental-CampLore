<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage; // Tambahkan jika pakai upload file resmi

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
        $items = Product::where('category', 'Kamera')->get();
        return view('camera.index', compact('items'));
    }

    public function create()
    {
        // Ambil data kategori untuk dropdown di form tambah kamera
        $types = Category::where('main_category', 'Kamera')->where('attribute_type', 'Tipe')->get();
        $brands = Category::where('main_category', 'Kamera')->where('attribute_type', 'Merek')->get();
        
        return view('camera.create_camera', compact('types', 'brands'));
    }

    public function store(Request $request)
    {
        // Tambahkan proses upload gambar jika input berupa file
        $imagePath = $request->image;
        if ($request->hasFile('image')) {
            // Contoh menyimpan ke folder public/img_foto/camera
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img_foto/camera'), $filename);
            $imagePath = 'img_foto/camera/' . $filename;
        }

        Product::create([
            'name'              => $request->name,
            'type_category_id'  => $request->type_category_id,  // Hubungkan foreign key tipe
            'brand_category_id' => $request->brand_category_id, // Hubungkan foreign key merek
            'stock'             => $request->stock,
            'price_per_day'     => $request->price,
            'category'          => 'Kamera',
            'image'             => $imagePath,
            'deskripsi'         => $request->deskripsi,
            'highlights'        => $request->highlights,         // Hubungkan kolom highlights
            'isi_paket'         => $request->isi_paket,           // Hubungkan kolom isi_paket
        ]);

        return redirect()->route('camera.index');
    }

    public function edit($id)
    {
        $item = Product::findOrFail($id);
        $types = Category::where('main_category', 'Kamera')->where('attribute_type', 'Tipe')->get();
        $brands = Category::where('main_category', 'Kamera')->where('attribute_type', 'Merek')->get();
        
        return view('camera.edit_camera', compact('item', 'types', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $item = Product::findOrFail($id);

        $imagePath = $item->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada file baru yang diupload
            if ($item->image && file_exists(public_path($item->image))) {
                @unlink(public_path($item->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img_foto/camera'), $filename);
            $imagePath = 'img_foto/camera/' . $filename;
        }

        $item->update([
            'name'              => $request->name,
            'type_category_id'  => $request->type_category_id,  // Update foreign key tipe
            'brand_category_id' => $request->brand_category_id, // Update foreign key merek
            'stock'             => $request->stock,
            'price_per_day'     => $request->price,
            'image'             => $imagePath,
            'deskripsi'         => $request->deskripsi,
            'highlights'        => $request->highlights,         // Update kolom highlights
            'isi_paket'         => $request->isi_paket,           // Update kolom isi_paket
        ]);

        return redirect()->route('camera.index');
    }

    public function destroy($id)
    {
        $item = Product::findOrFail($id);
        
        // Opsional: Hapus file gambar dari local storage saat data dihapus
        if ($item->image && file_exists(public_path($item->image))) {
            @unlink(public_path($item->image));
        }

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

    // Ambil reviews dengan user
    $reviews = \App\Models\Review::with('user')
        ->where('product_id', $id)
        ->latest()
        ->get();

    $avgRating = $reviews->count() ? round($reviews->avg('rating'), 1) : 0;

    // Cek apakah user yang login boleh review
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
        'category'      => 'camera',
        'categoryLabel' => 'Kamera',
        'reviews'       => $reviews,
        'avgRating'     => $avgRating,
        'canReview'     => $canReview,
        'reviewOrder'   => $reviewOrder,
        'accordions'    => [
            ['title' => 'Tentang Kamera ini', 'deskripsi' => $item->deskripsi ?? 'Deskripsi tidak tersedia.', 'open' => true],
            ['title' => 'Sorotan',            'deskripsi' => $item->highlights ?? 'Spesifikasi unggulan tidak tersedia.', 'open' => false],
            ['title' => 'Isi Paket',          'deskripsi' => $item->isi_paket ?? 'Informasi isi paket tidak tersedia.', 'open' => false],
        ],
    ]);
}
}