<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori_data;
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
            ->orderBy('nama_kategori')
            ->get();

        $merekKamera = Kategori_data::where('kategori_utama', 'Kamera')
            ->where('jenis_atribut', 'Merek')
            ->orderBy('aktif', 'desc')
            ->orderBy('nama_kategori')
            ->get();

        $tipeCamping = Kategori_data::where('kategori_utama', 'Camping')
            ->where('jenis_atribut', 'Tipe')
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
        ]);

        $exists = Kategori_data::where('nama_kategori', $request->nama_kategori)
            ->where('kategori_utama', $request->kategori_utama)
            ->where('jenis_atribut', 'Tipe')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Tipe "' . $request->nama_kategori . '" sudah terdaftar.');
        }

        Kategori_data::create([
            'nama_kategori'  => $request->nama_kategori,
            'kategori_utama' => $request->kategori_utama,
            'jenis_atribut'  => 'Tipe',
            'aktif'          => true,
        ]);

        return back()
            ->with('success', 'Tipe "' . $request->nama_kategori . '" berhasil ditambahkan.')
            ->with('last_tab', strtolower($request->kategori_utama))
            ->with('jump_to_last', true);
    }

    public function storeBrand(Request $request)
    {
        $request->validate([
            'nama_kategori'  => 'required|string|max:255',
            'kategori_utama' => 'required|in:Kamera,Camping',
            'foto_logo'      => 'nullable|image|mimes:svg,png,jpg,jpeg|max:2048',
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
            $logoPath = $request->file('foto_logo')->store('brands', 'public');
        }

        Kategori_data::create([
            'nama_kategori'  => $request->nama_kategori,
            'kategori_utama' => $request->kategori_utama,
            'jenis_atribut'  => 'Merek',
            'foto_logo'      => $logoPath,
            'aktif'          => $request->boolean('aktif', true),
        ]);

        return back()->with('success', 'Merek "' . $request->nama_kategori . '" berhasil ditambahkan.');
    }

    public function updateType(Request $request, Kategori_data $kategori)
    {
        $request->validate(['nama_kategori' => 'required|string|max:255']);
        $kategori->update(['nama_kategori' => $request->nama_kategori]);
        return back()->with('success', 'Tipe berhasil diperbarui.');
    }

    public function updateBrand(Request $request, Kategori_data $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'foto_logo'     => 'nullable|image|mimes:svg,png,jpg,jpeg|max:2048',
        ]);

        $data = [
            'nama_kategori' => $request->nama_kategori,
            'aktif'         => $request->boolean('aktif', true),
        ];

        if ($request->hasFile('foto_logo')) {
            if ($kategori->foto_logo) {
                Storage::disk('public')->delete($kategori->foto_logo);
            }
            $data['foto_logo'] = $request->file('foto_logo')->store('brands', 'public');
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
        if ($kategori->foto_logo) {
            Storage::disk('public')->delete($kategori->foto_logo);
        }
        $kategori->delete();
        return back()->with('success', 'Merek "' . $kategori->nama_kategori . '" berhasil dihapus.');
    }

    public function toggleBrand(Kategori_data $kategori)
    {
        $kategori->update(['aktif' => !$kategori->aktif]);
        $status = $kategori->aktif ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', 'Merek "' . $kategori->nama_kategori . '" berhasil ' . $status . '.');
    }

    public function brandDetail(Kategori_data $kategori)
    {
        $products = Barang::with(['typeCategory'])
            ->where('id_merek_kategori', $kategori->id_kategori)
            ->select('id', 'name', 'id_tipe_kategori', 'stok', 'harga_per_hari', 'kategori')
            ->get()
            ->map(function ($product) {
                $lajuSewa = DB::table('pesanan')
                    ->where('product_id', $product->id)
                    ->whereIn('status', ['selesai', 'dikemas', 'dikirim', 'pengembalian'])
                    ->count();

                return [
                    'id'        => $product->id,
                    'name'      => $product->name,
                    'tipe'      => $product->typeCategory?->nama_kategori ?? '-',
                    'stok'      => $product->stok,
                    'price'     => $product->harga_per_hari,
                    'kategori'  => $product->kategori,
                    'laju_sewa' => $lajuSewa . 'x disewa',
                ];
            });

        return response()->json([
            'merek'     => $kategori->nama_kategori,
            'foto_logo' => $kategori->foto_logo
                ? (str_starts_with($kategori->foto_logo, 'brands/')
                    ? asset('storage/' . $kategori->foto_logo)
                    : asset($kategori->foto_logo))
                : null,
            'aktif'     => $kategori->aktif,
            'products'  => $products,
        ]);
    }

    public function typeDetail(Kategori_data $kategori)
    {
        $products = Barang::with(['brandCategory'])
            ->where('id_tipe_kategori', $kategori->id_kategori)
            ->select('id', 'name', 'id_merek_kategori', 'stok', 'harga_per_hari', 'kategori')
            ->get()
            ->map(function ($product) {
                return [
                    'id'       => $product->id,
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
}
