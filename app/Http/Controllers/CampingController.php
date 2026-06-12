<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Category;

class CampingController extends Controller
{
    // 🔹 TAMPIL DATA (ADMIN INDEX)
    public function index()
    {
        $items = Barang::where('kategori', 'Camping')->get();
        return view('admin.camping.camping_LP', compact('items'));
    }

    // 🔹 HALAMAN USER (LANDING)
    public function landing(Request $request)
    {
        $query = Barang::where('kategori', 'Camping');

        // FILTER TIPE
        if ($request->type) {
            $query->where('tipe_kategori_id', $request->type);
        }

        // FILTER MEREK
        if ($request->brand) {
            $query->where('merek_kategori_id', $request->brand);
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
            'kategori'     => 'camping',
            'title'        => 'Camping',
            'emptyIcon'    => '🏕️',
        ]);
    }

    // 🔹 EDIT
    public function edit($id)
    {
        $product = Barang::findOrFail($id);

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
        $item = Barang::findOrFail($id);
        
        // Opsional: Hapus file gambar dari public folder saat data dihapus
        if ($item->gambar_barang && file_exists(public_path($item->gambar_barang))) {
            @unlink(public_path($item->gambar_barang));
        }

        $item->delete();

        return redirect()->route('camping.index')
            ->with('success', 'Data berhasil dihapus');
    }

    // 🔹 DETAIL PRODUK (SHOW)
    public function show($id)
{
    $item = Barang::findOrFail($id);

    $relatedItems = Barang::where('kategori', 'Camping')
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
        $reviewOrder = \App\Models\Pemesanan::where('user_id', auth()->id())
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
        'kategori'      => 'camping',
        'categoryLabel' => 'Camping',
        'reviews'       => $reviews,
        'avgRating'     => $avgRating,
        'canReview'     => $canReview,
        'reviewOrder'   => $reviewOrder,
        'accordions'    => [
            ['title' => 'Tentang Alat ini', 'deskripsi' => $item->deskripsi ?? 'Deskripsi tidak tersedia.', 'open' => true],
            ['title' => 'Sorotan',          'deskripsi' => $item->sorotan ?? 'Spesifikasi unggulan tidak tersedia.', 'open' => false],
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
            'kategori' => 'required',
            'tipe_kategori_id' => 'required',
            'merek_kategori_id' => 'required',
            'harga_per_hari' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
            'sorotan' => 'required',
            'isi_paket' => 'required',
            'gambar_barang' => 'required|gambar_barang',
        ]);

        $imagePath = null;

        if ($request->hasFile('gambar_barang')) {
            // Disesuaikan agar strukturnya sama seperti img_foto/camping/ di database kamu
            $file = $request->file('gambar_barang');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img_foto/camping'), $filename);
            $imagePath = 'img_foto/camping/' . $filename;
        }

        Barang::create([
            'name' => $request->name,
            'kategori' => $request->kategori,
            'tipe_kategori_id' => $request->tipe_kategori_id,
            'merek_kategori_id' => $request->merek_kategori_id,
            'harga_per_hari' => $request->harga_per_hari,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'sorotan' => $request->sorotan,
            'isi_paket' => $request->isi_paket,
            'gambar_barang' => $imagePath,
        ]);

        return redirect()->route('camping.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    // 🔹 UPDATE
    public function update(Request $request, $id)
    {
        $product = Barang::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'kategori' => 'required',
            'tipe_kategori_id' => 'required',
            'merek_kategori_id' => 'required',
            'harga_per_hari' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
            'sorotan' => 'required',
            'isi_paket' => 'required',
            'gambar_barang' => 'nullable|gambar_barang',
        ]);

        $data = [
            'name' => $request->name,
            'kategori' => $request->kategori,
            'tipe_kategori_id' => $request->tipe_kategori_id,
            'merek_kategori_id' => $request->merek_kategori_id,
            'harga_per_hari' => $request->harga_per_hari,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'sorotan' => $request->sorotan,
            'isi_paket' => $request->isi_paket,
        ];

        if ($request->hasFile('gambar_barang')) {
            // Hapus gambar lama jika ada file baru yang masuk
            if ($product->gambar_barang && file_exists(public_path($product->gambar_barang))) {
                @unlink(public_path($product->gambar_barang));
            }
            
            $file = $request->file('gambar_barang');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img_foto/camping'), $filename);
            $data['gambar_barang'] = 'img_foto/camping/' . $filename;
        }

        $product->update($data);

        return redirect()->route('camping.index')
            ->with('success', 'Produk berhasil diupdate');
    }
}