<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori_data;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    /**
     * Tampilkan halaman Kategori Produk.
     * Mengambil data tipe & merek dari tabel kategori_data,
     * serta menghitung produk per merek dari tabel products.
     */
    public function index()
    {
        // Tipe Kamera: jenis_atribut = 'Tipe', kategori_utama = 'Kamera'
        $tipeKamera = kategori_data::where('kategori_utama', 'Kamera')
            ->where('jenis_atribut', 'Tipe')
            ->orderBy('nama_kategori')
            ->get();

        // Merek Kamera: jenis_atribut = 'Merek', kategori_utama = 'Kamera'
        $merekKamera = kategori_data::where('kategori_utama', 'Kamera')
            ->where('jenis_atribut', 'Merek')
            ->where('aktif', true)
            ->orderBy('nama_kategori')
            ->get();

        // Tipe Camping
        $tipeCamping = kategori_data::where('kategori_utama', 'Camping')
            ->where('jenis_atribut', 'Tipe')
            ->orderBy('nama_kategori')
            ->get();

        // Merek Camping
        $merekCamping = kategori_data::where('kategori_utama', 'Camping')
            ->where('jenis_atribut', 'Merek')
            ->where('aktif', true)
            ->orderBy('nama_kategori')
            ->get();

        return view('pages.admin.kategori_produk', compact(
            'tipeKamera',
            'merekKamera',
            'tipeCamping',
            'merekCamping'
        ));
    }

    /**
     * Simpan Tipe baru (Tipe Kamera / Tipe Camping).
     */
    public function storeType(Request $request)
    {
        $request->validate([
            'nama_kategori'          => 'required|string|max:255',
            'kategori_utama' => 'required|in:Kamera,Camping',
        ]);

        // Cek duplikasi
        $exists = kategori_data::where('nama_kategori', $request->nama_kategori)
            ->where('kategori_utama', $request->kategori_utama)
            ->where('jenis_atribut', 'Tipe')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Tipe "' . $request->nama_kategori . '" sudah terdaftar di kategori ' . $request->kategori_utama . '.');
        }

        kategori_data::create([
            'nama_kategori'           => $request->nama_kategori,
            'kategori_utama'  => $request->kategori_utama,
            'jenis_atribut' => 'Tipe',
            'aktif'      => true,
        ]);

        return back()
        ->with('success', 'Tipe "' . $request->nama_kategori . '" berhasil ditambahkan.')
        ->with('last_tab', strtolower($request->kategori_utama))  // 'kamera' atau 'camping'
        ->with('jump_to_last', true);
    }

    /**
     * Simpan Merek baru beserta foto_logo (opsional).
     */
    public function storeBrand(Request $request)
    {
        $request->validate([
            'nama_kategori'          => 'required|string|max:255',
            'kategori_utama' => 'required|in:Kamera,Camping',
            'foto_logo'          => 'nullable|image|mimes:svg,png,jpg,jpeg|max:2048',
        ]);

        // Cek duplikasi
        $exists = kategori_data::where('nama_kategori', $request->nama_kategori)
            ->where('kategori_utama', $request->kategori_utama)
            ->where('jenis_atribut', 'Merek')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Merek "' . $request->nama_kategori . '" sudah terdaftar di kategori ' . $request->kategori_utama . '.');
        }

        $logoPath = null;
        if ($request->hasFile('foto_logo')) {
            $logoPath = $request->file('foto_logo')->store('brands', 'public');
        }

        kategori_data::create([
            'nama_kategori'           => $request->nama_kategori,
            'kategori_utama'  => $request->kategori_utama,
            'jenis_atribut' => 'Merek',
            'foto_logo'           => $logoPath,
            'aktif'      => $request->boolean('aktif', true),
        ]);

        return back()->with('success', 'Merek "' . $request->nama_kategori . '" berhasil ditambahkan.');
    }

    /**
     * Update Tipe.
     */
    public function updateType(Request $request, kategori_data $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori->update(['nama_kategori' => $request->nama_kategori]);

        return back()->with('success', 'Tipe berhasil diperbarui.');
    }

    /**
     * Update Merek (nama, foto_logo, status aktif).
     */
    public function updateBrand(Request $request, kategori_data $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'foto_logo' => 'nullable|image|mimes:svg,png,jpg,jpeg|max:2048',
        ]);

        $data = [
            'nama_kategori'      => $request->nama_kategori,
            'aktif' => $request->boolean('aktif', true),
        ];

        if ($request->hasFile('foto_logo')) {
            // Hapus foto_logo lama jika ada
            if ($kategori->foto_logo) {
                Storage::disk('public')->delete($kategori->foto_logo);
            }
            $data['foto_logo'] = $request->file('foto_logo')->store('brands', 'public');
        }

        $kategori->update($data);

        return back()->with('success', 'Merek berhasil diperbarui.');
    }

    /**
     * Hapus Tipe — hanya bisa jika tidak ada produk yang memakai tipe ini.
     */
    public function destroyType(kategori_data $kategori)
    {
        $productCount = Barang::where('id_tipe_kategori', $kategori->id)->count();

        if ($productCount > 0) {
            return back()->with('error', 'Tidak bisa menghapus tipe ini karena masih digunakan oleh ' . $productCount . ' produk.');
        }

        $kategori->delete();

        return back()->with('success', 'Tipe "' . $kategori->nama_kategori . '" berhasil dihapus.');
    }

    /**
     * Hapus Merek — hanya bisa jika tidak ada produk yang memakai merek ini.
     */
    public function destroyBrand(kategori_data $kategori)
    {
        $productCount = Barang::where('id_merek_kategori ', $kategori->id)->count();

        if ($productCount > 0) {
            return back()->with('error', 'Tidak bisa menghapus merek ini karena masih digunakan oleh ' . $productCount . ' produk.');
        }

        if ($kategori->foto_logo) {
            Storage::disk('public')->delete($kategori->foto_logo);
        }

        $kategori->delete();

        return back()->with('success', 'Merek "' . $kategori->nama_kategori . '" berhasil dihapus.');
    }

    /**
     * Ambil detail merek: daftar produk yang menggunakan merek ini.
     * Dipakai via AJAX untuk modal detail merek.
     */
    public function brandDetail(kategori_data $kategori)
    {
        $products = Barang::with(['typeCategory'])
            ->where('id_merek_kategori', $kategori->id)
            ->select('id', 'name', 'id_tipe_kategori', 'stok', 'harga_per_hari', 'kategori')
            ->get()
            ->map(function ($product) {
                return [
                    'id'         => $product->id,
                    'name'       => $product->name,
                    'tipe'       => $product->typeCategory?->nama_kategori ?? '-',
                    'stok'      => $product->stok,
                    'price'      => 'Rp ' . number_format($product->harga_per_hari, 0, ',', '.') . ' / hari',
                    'kategori'   => $product->kategori,
                ];
            });

        return response()->json([
            'merek'    => $kategori->nama_kategori,
            'foto_logo'     => $kategori->foto_logo ? asset($kategori->foto_logo) : null,
            'products' => $products,
        ]);
    }

    public function typeDetail(kategori_data $kategori)
    {
        $products = Barang::with(['brandCategory'])
            ->where('id_tipe_kategori', $kategori->id)
            ->select('id', 'name', 'id_merek_kategori', 'stok', 'harga_per_hari', 'kategori')
            ->get()
            ->map(function ($product) {
                return [
                    'id'         => $product->id,
                    'name'       => $product->name,
                    'merek'      => $product->brandCategory?->nama_kategori ?? '-',
                    'stok'      => $product->stok,
                    'price'      => 'Rp ' . number_format($product->harga_per_hari, 0, ',', '.') . ' / hari',
                    'kategori'   => $product->kategori,
                ];
            });

        return response()->json([
            'tipe'     => $kategori->nama_kategori,
            'products' => $products
        ]);
    }
}
