<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
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
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string',
            'harga_per_hari' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'sorotan' => 'required|string',
            'isi_paket' => 'required|string',
            'tipe_kategori_id' => 'nullable|exists:categories,id',
            'merek_kategori_id' => 'nullable|exists:categories,id',
            'gambar_barang' => 'nullable|gambar_barang|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('gambar_barang')) {

            $imageName = time() . '.' . $request->gambar_barang->extension();

            // FOTO KAMERA
            if ($request->kategori == 'Kamera') {

                $request->gambar_barang->move(
                    public_path('img_foto/camera'),
                    $imageName
                );

                $imagePath = 'img_foto/camera/' . $imageName;
            }

            // FOTO CAMPING
            elseif ($request->kategori == 'Camping') {

                $request->gambar_barang->move(
                    public_path('img_foto/camping'),
                    $imageName
                );

                $imagePath = 'img_foto/camping/' . $imageName;
            }
        }

        Barang::create([
            'name' => $request->name,
            'stok' => $request->stok,
            'kategori' => $request->kategori,
            'harga_per_hari' => $request->harga_per_hari,
            'deskripsi' => $request->deskripsi,
            'sorotan' => $request->sorotan,
            'isi_paket' => $request->isi_paket,
            'tipe_kategori_id' => $request->tipe_kategori_id,
            'merek_kategori_id' => $request->merek_kategori_id,
            'gambar_barang' => $imagePath,
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
        $product = Barang::findOrFail($id);

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
        $product = Barang::findOrFail($id);

        $request->validate([
            'name'               => 'required|string|max:255',
            'stok'              => 'required|numeric|min:0',
            'kategori'           => 'required|string',
            'harga_per_hari'      => 'required|numeric|min:0',

            'deskripsi'          => 'required|string',
            'sorotan'         => 'nullable|string',
            'isi_paket'          => 'nullable|string',

            'tipe_kategori_id'   => 'nullable|exists:categories,id',
            'merek_kategori_id'  => 'nullable|exists:categories,id',

            'gambar_barang'              => 'nullable|gambar_barang|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name'               => $request->name,
            'stok'              => $request->stok,
            'kategori'           => $request->kategori,
            'harga_per_hari'      => $request->harga_per_hari,

            'deskripsi'          => $request->deskripsi,
            'sorotan'         => $request->sorotan,
            'isi_paket'          => $request->isi_paket,

            'tipe_kategori_id'   => $request->tipe_kategori_id,
            'merek_kategori_id'  => $request->merek_kategori_id,
        ];

        if ($request->hasFile('gambar_barang')) {

            // HAPUS FOTO LAMA
            if ($product->gambar_barang && file_exists(public_path($product->gambar_barang))) {
                unlink(public_path($product->gambar_barang));
            }

            $imageName = time() . '.' . $request->gambar_barang->extension();

            // FOTO KAMERA
            if ($request->kategori == 'Kamera') {

                $request->gambar_barang->move(
                    public_path('img_foto/camera'),
                    $imageName
                );

                $data['gambar_barang'] = 'img_foto/camera/' . $imageName;
            }

            // FOTO CAMPING
            elseif ($request->kategori == 'Camping') {

                $request->gambar_barang->move(
                    public_path('img_foto/camping'),
                    $imageName
                );

                $data['gambar_barang'] = 'img_foto/camping/' . $imageName;
            }
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
        $product = Barang::findOrFail($id);

        if ($product->gambar_barang && file_exists(public_path($product->gambar_barang))) {
            unlink(public_path($product->gambar_barang));
        }

        $product->delete();

        return redirect()
            ->route('admin.products')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
