<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori_data;

class CampingController extends Controller
{
    // 🔹 TAMPIL DATA (ADMIN INDEX)
    public function index()
    {
        $items = Barang::where('kategori', 'Camping')->get();
        return view('admin.camping.camping_LP', compact('items'));
    }

   
    public function landing(Request $request)
    {
        $query = Barang::where('kategori', 'Camping');

        // FILTER TIPE
        if ($request->type) {
            $query->where('id_tipe_kategori', $request->type);
        }

        // FILTER MEREK
        if ($request->brand) {
            $query->where('id_merek_kategori', $request->brand);
        }

        $items = $query->get();

        $filterTipes = Kategori_data::where('kategori_utama', 'Camping')
            ->where('jenis_atribut', 'Tipe')
            ->where('aktif', 1)
            ->get();

        $filterMereks = Kategori_data::where('kategori_utama', 'Camping')
            ->where('jenis_atribut', 'Merek')
            ->where('aktif', 1)
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

        $types = Kategori_data::where('kategori_utama', 'Camping')
            ->where('jenis_atribut', 'Tipe')
            ->where('aktif', 1)
            ->get();

        $brands = Kategori_data::where('kategori_utama', 'Camping')
            ->where('jenis_atribut', 'Merek')
            ->where('aktif', 1)
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
        ->where('id_barang', '!=', $item->id_barang)
        ->take(5)
        ->get();

    $reviews = \App\Models\Review::with('pelanggan')
        ->where('product_id', $id)
        ->latest()
        ->get();

    $avgRating = $reviews->count() ? round($reviews->avg('bintang'), 1) : 0;

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
        $types = Kategori_data::where('kategori_utama', 'Camping')
            ->where('jenis_atribut', 'Tipe')
            ->where('aktif', 1)
            ->get();

        $brands = Kategori_data::where('kategori_utama', 'Camping')
            ->where('jenis_atribut', 'Merek')
            ->where('aktif', 1)
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
            'id_tipe_kategori' => 'required',
            'id_merek_kategori' => 'required',
            'harga_per_hari' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
            'sorotan' => 'required',
            'isi_paket' => 'required',
            'gambar_barang' => 'required|image',
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
            'name' => $request->name, // ← UPDATE
            'kategori' => $request->kategori,
            'id_tipe_kategori' => $request->id_tipe_kategori,
            'id_merek_kategori' => $request->id_merek_kategori,
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
            'id_tipe_kategori' => 'required',
            'id_merek_kategori' => 'required',
            'harga_per_hari' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
            'sorotan' => 'required',
            'isi_paket' => 'required',
            'gambar_barang' => 'nullable|image',
        ]);

        $data = [
            'name' => $request->name, // ← UPDATE
            'kategori' => $request->kategori,
            'id_tipe_kategori' => $request->id_tipe_kategori,
            'id_merek_kategori' => $request->id_merek_kategori,
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