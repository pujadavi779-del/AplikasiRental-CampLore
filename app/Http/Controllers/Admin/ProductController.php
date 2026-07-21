<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create()
    {
        $types = Kategori_data::where('jenis_atribut', 'Tipe')
            ->where('aktif', 1)
            ->get();

        $brands = Kategori_data::where('jenis_atribut', 'Merek')
            ->where('aktif', 1)
            ->get();

        return view('pages.admin.products.create', compact('types', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:50|regex:/^[a-zA-Z0-9\s\.\-]+$/',
            'stok'             => 'required|integer|min:0|max:100',
            'kategori'         => 'required|string|max:50',
            'harga_per_hari'   => 'required|numeric|min:0|max:1000000',
            'deskripsi'         => 'required|string',
            'sorotan'           => 'required|string',
            'isi_paket'         => 'required|string',
            'id_tipe_kategori'  => 'nullable|exists:data_kategori,id_kategori',
            'id_merek_kategori' => 'nullable|exists:data_kategori,id_kategori',
            'gambar_barang'     => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.min'      => 'Nama produk minimal 3 karakter.',
            'name.max'      => 'Nama produk tidak boleh lebih dari 50 karakter.',
            'name.regex'    => 'Nama produk hanya boleh berisi huruf, angka, spasi, titik, dan tanda hubung.',
            'stok.max'            => 'Stok tidak boleh lebih dari 100.',
            'stok.required'       => 'Stok wajib diisi.',
            'stok.integer'        => 'Stok harus berupa angka.',
            'stok.min'            => 'Stok tidak boleh kurang dari 0.',
            'harga_per_hari.max'      => 'Harga per hari tidak boleh lebih dari Rp 1.000.000.',
            'harga_per_hari.required' => 'Harga per hari wajib diisi.',
            'harga_per_hari.numeric'  => 'Harga per hari harus berupa angka.',
            'harga_per_hari.min'      => 'Harga per hari tidak boleh kurang dari 0.',
            'gambar_barang.required' => 'Gambar produk wajib diunggah.',
            'gambar_barang.image'    => 'File harus berupa gambar.',
            'gambar_barang.mimes'    => 'Format gambar harus JPG, JPEG, atau PNG.',
            'gambar_barang.max'      => 'Ukuran gambar maksimal 2MB.',
        ]);

        $imagePath = null;

        if ($request->hasFile('gambar_barang')) {
            $imageName = time() . '.' . $request->gambar_barang->extension();

            if ($request->kategori == 'Kamera') {
                $dir = public_path('img_foto/camera');
                if (!File::isDirectory($dir)) {
                    File::makeDirectory($dir, 0755, true);
                }
                $request->gambar_barang->move($dir, $imageName);
                $imagePath = 'img_foto/camera/' . $imageName;
            } elseif ($request->kategori == 'Camping') {
                $dir = public_path('img_foto/camping');
                if (!File::isDirectory($dir)) {
                    File::makeDirectory($dir, 0755, true);
                }
                $request->gambar_barang->move($dir, $imageName);
                $imagePath = 'img_foto/camping/' . $imageName;
            }
        }

        Barang::create([
            'name'              => $request->name,
            'stok'              => $request->stok,
            'kategori'          => $request->kategori,
            'harga_per_hari'    => $request->harga_per_hari,
            'deskripsi'         => $request->deskripsi,
            'sorotan'           => $request->sorotan,
            'isi_paket'         => $request->isi_paket,
            'id_tipe_kategori'  => $request->id_tipe_kategori,
            'id_merek_kategori' => $request->id_merek_kategori,
            'gambar_barang'     => $imagePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id_barang) // ← UPDATE parameter name
    {
        $product = Barang::findOrFail($id_barang);

        $types = Kategori_data::where('jenis_atribut', 'Tipe')
            ->where('aktif', 1)
            ->get();

        $brands = Kategori_data::where('jenis_atribut', 'Merek')
            ->where('aktif', 1)
            ->get();

        return view('pages.admin.products.edit', compact('product', 'types', 'brands'));
    }

    public function update(Request $request, $id_barang) // ← UPDATE parameter name
    {
        $product = Barang::findOrFail($id_barang);

        $request->validate([
            'name'             => 'required|string|min:3|max:50|regex:/^[a-zA-Z0-9\s\.\-]+$/',
            'stok'             => 'required|integer|min:0|max:100',
            'kategori'         => 'required|string|max:50',
            'harga_per_hari'   => 'required|numeric|min:0|max:1000000',
            'deskripsi'         => 'required|string',
            'sorotan'           => 'nullable|string',
            'isi_paket'         => 'nullable|string',
            'id_tipe_kategori'  => 'nullable|exists:data_kategori,id_kategori',
            'id_merek_kategori' => 'nullable|exists:data_kategori,id_kategori',
            'gambar_barang'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.min'      => 'Nama produk minimal 3 karakter.',
            'name.max'      => 'Nama produk tidak boleh lebih dari 50 karakter.',
            'name.regex'    => 'Nama produk hanya boleh berisi huruf, angka, spasi, titik, dan tanda hubung.',
            'stok.max'            => 'Stok tidak boleh lebih dari 100.',
            'stok.required'       => 'Stok wajib diisi.',
            'stok.integer'        => 'Stok harus berupa angka.',
            'stok.min'            => 'Stok tidak boleh kurang dari 0.',
            'harga_per_hari.max'      => 'Harga per hari tidak boleh lebih dari Rp 1.000.000.',
            'harga_per_hari.required' => 'Harga per hari wajib diisi.',
            'harga_per_hari.numeric'  => 'Harga per hari harus berupa angka.',
            'harga_per_hari.min'      => 'Harga per hari tidak boleh kurang dari 0.',
        ]);

        $data = [
            'name'              => $request->name, // ← UPDATE
            'stok'              => $request->stok,
            'kategori'          => $request->kategori,
            'harga_per_hari'    => $request->harga_per_hari,
            'deskripsi'         => $request->deskripsi,
            'sorotan'           => $request->sorotan,
            'isi_paket'         => $request->isi_paket,
            'id_tipe_kategori'  => $request->id_tipe_kategori,
            'id_merek_kategori' => $request->id_merek_kategori,
        ];

        if ($request->hasFile('gambar_barang')) {
            if ($product->gambar_barang && file_exists(public_path($product->gambar_barang))) {
                unlink(public_path($product->gambar_barang));
            }

            $imageName = time() . '.' . $request->gambar_barang->extension();

            if ($request->kategori == 'Kamera') {
                $request->gambar_barang->move(public_path('img_foto/camera'), $imageName);
                $data['gambar_barang'] = 'img_foto/camera/' . $imageName;
            } elseif ($request->kategori == 'Camping') {
                $request->gambar_barang->move(public_path('img_foto/camping'), $imageName);
                $data['gambar_barang'] = 'img_foto/camping/' . $imageName;
            }
        }

        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id_barang)
    {
        $product = Barang::findOrFail($id_barang);

        $activeOrderCount = DB::table('pesanan_detail')
            ->join('pesanan', 'pesanan_detail.pesanan_id', '=', 'pesanan.id_pesanan')
            ->where('pesanan_detail.product_id', $id_barang)
            ->whereNotIn('pesanan.status', ['selesai', 'dibatalkan'])
            ->count();

        if ($activeOrderCount > 0) {
            return back()->with('error', 'Tidak bisa menghapus produk "' . $product->name . '" karena masih ada ' . $activeOrderCount . ' pesanan aktif.');
        }

        $product->delete();

        return back()->with('success', 'Produk "' . $product->name . '" berhasil dihapus.');
    }
}
