<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori_data;
use App\Models\Keterlambatan;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        $tipeKamera = Kategori_data::where('kategori_utama', 'Kamera')
            ->where('jenis_atribut', 'Tipe')
            ->with('keterlambatan')
            ->orderBy('nama_kategori')
            ->get();

        $merekKamera = Kategori_data::where('kategori_utama', 'Kamera')
            ->where('jenis_atribut', 'Merek')
            ->orderBy('aktif', 'desc')
            ->orderBy('nama_kategori')
            ->get();

        $tipeCamping = Kategori_data::where('kategori_utama', 'Camping')
            ->where('jenis_atribut', 'Tipe')
            ->with('keterlambatan')
            ->orderBy('nama_kategori')
            ->get();

        $merekCamping = Kategori_data::where('kategori_utama', 'Camping')
            ->where('jenis_atribut', 'Merek')
            ->orderBy('aktif', 'desc')
            ->orderBy('nama_kategori')
            ->get();

        return view('pages.admin.kategori_produk', compact(
            'tipeKamera',
            'merekKamera',
            'tipeCamping',
            'merekCamping'
        ));
    }

    public function storeType(Request $request)
    {
        $request->validate([
            'nama_kategori'  => 'required|string|max:255',
            'kategori_utama' => 'required|in:Kamera,Camping',
            'denda_per_hari' => 'required|numeric|min:0',
        ]);

        $exists = Kategori_data::where('nama_kategori', $request->nama_kategori)
            ->where('kategori_utama', $request->kategori_utama)
            ->where('jenis_atribut', 'Tipe')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Tipe "' . $request->nama_kategori . '" sudah terdaftar.');
        }

        $tipe = Kategori_data::create([
            'nama_kategori'  => $request->nama_kategori,
            'kategori_utama' => $request->kategori_utama,
            'jenis_atribut'  => 'Tipe',
            'aktif'          => true,
        ]);

        Keterlambatan::create([
            'id_tipe_kategori' => $tipe->id_kategori,
            'denda_per_hari'   => $request->denda_per_hari,
        ]);

        return back()
            ->with('success', 'Tipe "' . $request->nama_kategori . '" berhasil ditambahkan.')
            ->with('last_tab', strtolower($request->kategori_utama))
            ->with('jump_to_last', true);
    }

    public function updateType(Request $request, Kategori_data $kategori)
    {
        $request->validate([
            'nama_kategori'  => 'required|string|max:255',
            'denda_per_hari' => 'required|numeric|min:0',
        ]);

        $kategori->update(['nama_kategori' => $request->nama_kategori]);

        // update atau buat baru kalau belum ada
        Keterlambatan::updateOrCreate(
            ['id_tipe_kategori' => $kategori->id_kategori],
            ['denda_per_hari'   => $request->denda_per_hari]
        );

        return back()->with('success', 'Tipe berhasil diperbarui.');
    }

    public function storeBrand(Request $request)
    {
        $request->validate([
            'nama_kategori'  => 'required|string|max:255',
            'kategori_utama' => 'required|in:Kamera,Camping',
            'foto_logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $exists = Kategori_data::where('nama_kategori', $request->nama_kategori)
            ->where('kategori_utama', $request->kategori_utama)
            ->where('jenis_atribut', 'Merek')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Merek "' . $request->nama_kategori . '" sudah terdaftar.');
        }

        $logoPath = null;
        if ($request->hasFile('foto_logo')) {
            $folder = $request->kategori_utama === 'Kamera' ? 'logo_camera' : 'logo_camping';
            $file = $request->file('foto_logo');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-]/', '', $request->nama_kategori) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/' . $folder), $filename);
            $logoPath = 'images/' . $folder . '/' . $filename;
        }

        Kategori_data::create([
            'nama_kategori'  => $request->nama_kategori,
            'kategori_utama' => $request->kategori_utama,
            'jenis_atribut'  => 'Merek',
            'foto_logo'      => $logoPath,
            'aktif'          => $request->boolean('aktif', false),
        ]);

        return back()->with('success', 'Merek "' . $request->nama_kategori . '" berhasil ditambahkan.');
    }

    public function updateBrand(Request $request, Kategori_data $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'foto_logo'     => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $data = [
            'nama_kategori' => $request->nama_kategori,
            'aktif'         => $request->boolean('aktif', false),
        ];

        if ($request->hasFile('foto_logo')) {
            if ($kategori->foto_logo && file_exists(public_path($kategori->foto_logo))) {
                unlink(public_path($kategori->foto_logo));
            }

            $folder = $kategori->kategori_utama === 'Kamera' ? 'logo_camera' : 'logo_camping';
            $file = $request->file('foto_logo');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-]/', '', $request->nama_kategori) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/' . $folder), $filename);
            $data['foto_logo'] = 'images/' . $folder . '/' . $filename;
        }

        $kategori->update($data);
        return back()->with('success', 'Merek berhasil diperbarui.');
    }

    public function destroyType(Kategori_data $kategori)
    {
        $productCount = Barang::where('id_tipe_kategori', $kategori->id_kategori)->count();
        if ($productCount > 0) {
            return back()->with('error', 'Tidak bisa menghapus tipe ini karena masih digunakan oleh ' . $productCount . ' produk.');
        }
        $kategori->delete();
        return back()->with('success', 'Tipe "' . $kategori->nama_kategori . '" berhasil dihapus.');
    }

    public function destroyBrand(Kategori_data $kategori)
    {
        $productCount = Barang::where('id_merek_kategori', $kategori->id_kategori)->count();
        if ($productCount > 0) {
            return back()->with('error', 'Tidak bisa menghapus merek ini karena masih digunakan oleh ' . $productCount . ' produk.');
        }
        if ($kategori->foto_logo && file_exists(public_path($kategori->foto_logo))) {
            unlink(public_path($kategori->foto_logo));
        }
        $kategori->delete();
        return back()->with('success', 'Merek "' . $kategori->nama_kategori . '" berhasil dihapus.');
    }

    public function toggleBrand(Kategori_data $kategori)
    {
        $kategori->update(['aktif' => !$kategori->aktif]);
        $status = $kategori->aktif ? 'diaktifkan' : 'dinonaktifkan';
        return back()
            ->with('success', 'Merek "' . $kategori->nama_kategori . '" berhasil ' . $status . '.')
            ->with('last_tab', strtolower($kategori->kategori_utama));
    }

    public function brandDetail(Kategori_data $kategori)
    {
        $products = Barang::where('id_merek_kategori', $kategori->id_kategori)
            ->select('id_barang', 'name', 'id_tipe_kategori', 'stok', 'harga_per_hari', 'kategori')
            ->get()
            ->map(function ($product) {
                $tipe = Kategori_data::where('id_kategori', $product->id_tipe_kategori)->first();

                $lajuSewa = DB::table('pesanan')
                    ->join('pesanan_detail', 'pesanan.id_pesanan', '=', 'pesanan_detail.pesanan_id')
                    ->where('pesanan_detail.product_id', $product->id_barang)
                    ->whereIn('pesanan.status', ['selesai', 'dikemas', 'dikirim', 'pengembalian'])
                    ->distinct()
                    ->count('pesanan.id_pesanan');

                return [
                    'id'        => $product->id_barang,
                    'name'      => $product->name,
                    'tipe'      => $tipe->nama_kategori ?? '-',
                    'stok'      => $product->stok,
                    'price'     => $product->harga_per_hari,
                    'kategori'  => $product->kategori,
                    'laju_sewa' => $lajuSewa . 'x disewa',
                ];
            });

        return response()->json([
            'merek'     => $kategori->nama_kategori,
            'foto_logo' => $kategori->foto_logo ? asset($kategori->foto_logo) : null,
            'aktif'     => $kategori->aktif,
            'products'  => $products,
        ]);
    }

    public function typeDetail(Kategori_data $kategori)
    {
        $products = Barang::with(['brandCategory'])
            ->where('id_tipe_kategori', $kategori->id_kategori)
            ->select('id_barang', 'name', 'id_merek_kategori', 'stok', 'harga_per_hari', 'kategori')
            ->get()
            ->map(function ($product) {
                return [
                    'id'       => $product->id_barang,
                    'name'     => $product->name,
                    'merek'    => $product->brandCategory?->nama_kategori ?? '-',
                    'stok'     => $product->stok,
                    'price'    => 'Rp ' . number_format($product->harga_per_hari, 0, ',', '.') . ' / hari',
                    'kategori' => $product->kategori,
                ];
            });

        return response()->json([
            'tipe'     => $kategori->nama_kategori,
            'products' => $products,
        ]);
    }

    public function getMerekDetail($merekId)
    {
        // ✅ PASTIKAN query ini filter berdasarkan merek YANG BENAR
        $products = Product::where('merek_id', $merekId)
            ->where('kategori_utama', function ($query) use ($merekId) {
                // Ambil kategori_utama dari tabel kategori merek
                $merek = Kategori::where('id_kategori', $merekId)->first();
                return $merek ? $merek->kategori_utama : 'Kamera';
            })
            ->with(['tipeKategori', 'rentalCount']) // pastikan relasi benar
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->nama_produk,
                    'tipe' => $product->tipeKategori->nama_kategori ?? '-',
                    'stok' => $product->stok_tersedia ?? 0,
                    'price' => $product->harga_sewa ?? 0,
                    'laju_sewa' => ($product->rentalCount ?? 0) . 'x disewa', // ✅ FIX: format laju_sewa
                    'foto' => $product->foto_utama ? asset($product->foto_utama) : null,
                ];
            });

        return response()->json([
            'products' => $products
        ]);
    }
}
