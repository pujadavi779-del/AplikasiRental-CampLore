<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori_data;
use Illuminate\Support\Facades\Storage; // Tambahkan jika pakai upload file resmi

class CameraController extends Controller
{
    public function landing(Request $request)
    {
        $query = Barang::where('kategori', 'Kamera');

        // FILTER TIPE
        if ($request->type) {
            $query->where('id_tipe_kategori', $request->type);
        }

        // FILTER MEREK
        if ($request->brand) {
            $query->where('id_merek_kategori', $request->brand);
        }

        $items = $query->get();

        $filterTipes = Kategori_data::where('kategori_utama', 'Kamera')
            ->where('jenis_atribut', 'Tipe')
            ->where('aktif', 1)
            ->get();

        $filterMereks = Kategori_data::where('kategori_utama', 'Kamera')
            ->where('jenis_atribut', 'Merek')
            ->where('aktif', 1)
            ->get();

        return view('pages.landing.kategori.kategori_LP', [
            'items'        => $items,
            'filterTipes'  => $filterTipes,
            'filterMereks' => $filterMereks,
            'kategori'     => 'camera',
            'title'        => 'Kamera',
            'emptyIcon'    => '📷',
        ]);
    }

    public function index()
    {
        $items = Barang::where('kategori', 'Kamera')->get();
        return view('camera.index', compact('items'));
    }

    public function create()
    {
        // Ambil data kategori untuk dropdown di form tambah kamera
        $types = Kategori_data::where('kategori_utama', 'Kamera')->where('jenis_atribut', 'Tipe')->get();
        $brands = Kategori_data::where('kategori_utama', 'Kamera')->where('jenis_atribut', 'Merek')->get();
        
        return view('camera.create_camera', compact('types', 'brands'));
    }

    public function store(Request $request)
    {
        // Tambahkan proses upload gambar jika input berupa file
        $imagePath = $request->gambar_barang;
        if ($request->hasFile('gambar_barang')) {
            // Contoh menyimpan ke folder public/img_foto/camera
            $file = $request->file('gambar_barang');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img_foto/camera'), $filename);
            $imagePath = 'img_foto/camera/' . $filename;
        }

        Barang::create([
            'name'              => $request->name,
            'id_tipe_kategori'  => $request->id_tipe_kategori,  // Hubungkan foreign key tipe
            'id_merek_kategori' => $request->id_merek_kategori, // Hubungkan foreign key merek
            'stok'             => $request->stok,
            'harga_per_hari'     => $request->price,
            'kategori'          => 'Kamera',
            'gambar_barang'             => $imagePath,
            'deskripsi'         => $request->deskripsi,
            'sorotan'        => $request->sorotan,         // Hubungkan kolom sorotan
            'isi_paket'         => $request->isi_paket,           // Hubungkan kolom isi_paket
        ]);

        return redirect()->route('camera.index');
    }

    public function edit($id)
    {
        $item = Barang::findOrFail($id);
        $types = Kategori_data::where('kategori_utama', 'Kamera')->where('jenis_atribut', 'Tipe')->get();
        $brands = Kategori_data::where('kategori_utama', 'Kamera')->where('jenis_atribut', 'Merek')->get();
        
        return view('camera.edit_camera', compact('item', 'types', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $item = Barang::findOrFail($id);

        $imagePath = $item->gambar_barang;
        if ($request->hasFile('gambar_barang')) {
            // Hapus gambar lama jika ada file baru yang diupload
            if ($item->gambar_barang && file_exists(public_path($item->gambar_barang))) {
                @unlink(public_path($item->gambar_barang));
            }
            $file = $request->file('gambar_barang');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img_foto/camera'), $filename);
            $imagePath = 'img_foto/camera/' . $filename;
        }

        $item->update([
            'name'              => $request->name,
            'id_tipe_kategori'  => $request->id_tipe_kategori,  // Update foreign key tipe
            'id_merek_kategori' => $request->id_merek_kategori, // Update foreign key merek
            'stok'             => $request->stok,
            'harga_per_hari'     => $request->price,
            'gambar_barang'             => $imagePath,
            'deskripsi'         => $request->deskripsi,
            'sorotan'        => $request->sorotan,         // Update kolom sorotan
            'isi_paket'         => $request->isi_paket,           // Update kolom isi_paket
        ]);

        return redirect()->route('camera.index');
    }

    public function destroy($id)
    {
        $item = Barang::findOrFail($id);
        
        // Opsional: Hapus file gambar dari local storage saat data dihapus
        if ($item->gambar_barang && file_exists(public_path($item->gambar_barang))) {
            @unlink(public_path($item->gambar_barang));
        }

        $item->delete();
        return redirect()->route('camera.index');
    }

    public function show($id)
{
    $item = Barang::findOrFail($id);

    $relatedItems = Barang::where('kategori', 'Kamera')
        ->where('id', '!=', $item->id)
        ->take(5)
        ->get();

    // Ambil reviews dengan pelanggan
    $reviews = \App\Models\Review::with('pelanggan')
        ->where('product_id', $id)
        ->latest()
        ->get();

    $avgRating = $reviews->count() ? round($reviews->avg('bintang'), 1) : 0;

    // Cek apakah pelanggan yang login boleh review
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
        'kategori'      => 'camera',
        'categoryLabel' => 'Kamera',
        'reviews'       => $reviews,
        'avgRating'     => $avgRating,
        'canReview'     => $canReview,
        'reviewOrder'   => $reviewOrder,
        'accordions'    => [
            ['title' => 'Tentang Kamera ini', 'deskripsi' => $item->deskripsi ?? 'Deskripsi tidak tersedia.', 'open' => true],
            ['title' => 'Sorotan',            'deskripsi' => $item->sorotan ?? 'Spesifikasi unggulan tidak tersedia.', 'open' => false],
            ['title' => 'Isi Paket',          'deskripsi' => $item->isi_paket ?? 'Informasi isi paket tidak tersedia.', 'open' => false],
        ],
    ]);
}
}