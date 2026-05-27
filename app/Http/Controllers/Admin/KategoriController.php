<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    /**
     * Tampilkan halaman Kategori Produk.
     * Mengambil data tipe & merek dari tabel categories,
     * serta menghitung produk per merek dari tabel products.
     */
    public function index()
    {
        // Tipe Kamera: attribute_type = 'Tipe', main_category = 'Kamera'
        $tipeKamera = Category::where('main_category', 'Kamera')
            ->where('attribute_type', 'Tipe')
            ->orderBy('name')
            ->get();

        // Merek Kamera: attribute_type = 'Merek', main_category = 'Kamera'
        $merekKamera = Category::where('main_category', 'Kamera')
            ->where('attribute_type', 'Merek')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        // Tipe Camping
        $tipeCamping = Category::where('main_category', 'Camping')
            ->where('attribute_type', 'Tipe')
            ->orderBy('name')
            ->get();

        // Merek Camping
        $merekCamping = Category::where('main_category', 'Camping')
            ->where('attribute_type', 'Merek')
            ->where('is_active', true)
            ->orderBy('name')
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
            'name'          => 'required|string|max:255',
            'main_category' => 'required|in:Kamera,Camping',
        ]);

        // Cek duplikasi
        $exists = Category::where('name', $request->name)
            ->where('main_category', $request->main_category)
            ->where('attribute_type', 'Tipe')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Tipe "' . $request->name . '" sudah terdaftar di kategori ' . $request->main_category . '.');
        }

        Category::create([
            'name'           => $request->name,
            'main_category'  => $request->main_category,
            'attribute_type' => 'Tipe',
            'is_active'      => true,
        ]);

        return back()
        ->with('success', 'Tipe "' . $request->name . '" berhasil ditambahkan.')
        ->with('last_tab', strtolower($request->main_category))  // 'kamera' atau 'camping'
        ->with('jump_to_last', true);
    }

    /**
     * Simpan Merek baru beserta logo (opsional).
     */
    public function storeBrand(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'main_category' => 'required|in:Kamera,Camping',
            'logo'          => 'nullable|image|mimes:svg,png,jpg,jpeg|max:2048',
        ]);

        // Cek duplikasi
        $exists = Category::where('name', $request->name)
            ->where('main_category', $request->main_category)
            ->where('attribute_type', 'Merek')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Merek "' . $request->name . '" sudah terdaftar di kategori ' . $request->main_category . '.');
        }

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('brands', 'public');
        }

        Category::create([
            'name'           => $request->name,
            'main_category'  => $request->main_category,
            'attribute_type' => 'Merek',
            'logo'           => $logoPath,
            'is_active'      => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Merek "' . $request->name . '" berhasil ditambahkan.');
    }

    /**
     * Update Tipe.
     */
    public function updateType(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update(['name' => $request->name]);

        return back()->with('success', 'Tipe berhasil diperbarui.');
    }

    /**
     * Update Merek (nama, logo, status aktif).
     */
    public function updateBrand(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:svg,png,jpg,jpeg|max:2048',
        ]);

        $data = [
            'name'      => $request->name,
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($category->logo) {
                Storage::disk('public')->delete($category->logo);
            }
            $data['logo'] = $request->file('logo')->store('brands', 'public');
        }

        $category->update($data);

        return back()->with('success', 'Merek berhasil diperbarui.');
    }

    /**
     * Hapus Tipe — hanya bisa jika tidak ada produk yang memakai tipe ini.
     */
    public function destroyType(Category $category)
    {
        $productCount = Product::where('type_category_id', $category->id)->count();

        if ($productCount > 0) {
            return back()->with('error', 'Tidak bisa menghapus tipe ini karena masih digunakan oleh ' . $productCount . ' produk.');
        }

        $category->delete();

        return back()->with('success', 'Tipe "' . $category->name . '" berhasil dihapus.');
    }

    /**
     * Hapus Merek — hanya bisa jika tidak ada produk yang memakai merek ini.
     */
    public function destroyBrand(Category $category)
    {
        $productCount = Product::where('brand_category_id', $category->id)->count();

        if ($productCount > 0) {
            return back()->with('error', 'Tidak bisa menghapus merek ini karena masih digunakan oleh ' . $productCount . ' produk.');
        }

        if ($category->logo) {
            Storage::disk('public')->delete($category->logo);
        }

        $category->delete();

        return back()->with('success', 'Merek "' . $category->name . '" berhasil dihapus.');
    }

    /**
     * Ambil detail merek: daftar produk yang menggunakan merek ini.
     * Dipakai via AJAX untuk modal detail merek.
     */
    public function brandDetail(Category $category)
    {
        $products = Product::with(['typeCategory'])
            ->where('brand_category_id', $category->id)
            ->select('id', 'name', 'type_category_id', 'stock', 'price_per_day', 'category')
            ->get()
            ->map(function ($product) {
                return [
                    'id'         => $product->id,
                    'name'       => $product->name,
                    'tipe'       => $product->typeCategory?->name ?? '-',
                    'stock'      => $product->stock,
                    'price'      => 'Rp ' . number_format($product->price_per_day, 0, ',', '.') . ' / hari',
                    'category'   => $product->category,
                ];
            });

        return response()->json([
            'merek'    => $category->name,
            'logo'     => $category->logo ? asset($category->logo) : null,
            'products' => $products,
        ]);
    }

    public function typeDetail(Category $category)
    {
        $products = Product::with(['brandCategory'])
            ->where('type_category_id', $category->id)
            ->select('id', 'name', 'brand_category_id', 'stock', 'price_per_day', 'category')
            ->get()
            ->map(function ($product) {
                return [
                    'id'         => $product->id,
                    'name'       => $product->name,
                    'merek'      => $product->brandCategory?->name ?? '-',
                    'stock'      => $product->stock,
                    'price'      => 'Rp ' . number_format($product->price_per_day, 0, ',', '.') . ' / hari',
                    'category'   => $product->category,
                ];
            });

        return response()->json([
            'tipe'     => $category->name,
            'products' => $products
        ]);
    }
}
