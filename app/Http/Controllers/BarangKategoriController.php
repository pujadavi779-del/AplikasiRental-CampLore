<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori_data;

class BarangKategoriController extends Controller
{
    private function config(string $kategoriUtama): array
    {
        return match ($kategoriUtama) {
            'Kamera' => [
                'slug'       => 'camera',
                'title'      => 'Kamera',
                'emptyIcon'  => '📷',
                'aboutLabel' => 'Tentang Kamera ini',
            ],
            'Camping' => [
                'slug'       => 'camping',
                'title'      => 'Camping',
                'emptyIcon'  => '🏕️',
                'aboutLabel' => 'Tentang Alat ini',
            ],
            default => abort(404),
        };
    }

    public function landing(Request $request, string $kategoriUtama)
    {
        $cfg = $this->config($kategoriUtama);

        $query = Barang::where('kategori', $kategoriUtama);

        if ($request->type)  $query->where('id_tipe_kategori', $request->type);
        if ($request->brand) $query->where('id_merek_kategori', $request->brand);

        $items = $query->get();

        $filterTipes = Kategori_data::where('kategori_utama', $kategoriUtama)
            ->where('jenis_atribut', 'Tipe')->where('aktif', 1)->get();

        $filterMereks = Kategori_data::where('kategori_utama', $kategoriUtama)
            ->where('jenis_atribut', 'Merek')->where('aktif', 1)->get();

        return view('pages.landing.kategori.kategori_LP', [
            'items'        => $items,
            'filterTipes'  => $filterTipes,
            'filterMereks' => $filterMereks,
            'kategori'     => $cfg['slug'],
            'title'        => $cfg['title'],
            'emptyIcon'    => $cfg['emptyIcon'],
        ]);
    }

    public function show($id, string $kategoriUtama)
    {
        $cfg = $this->config($kategoriUtama);
        $item = Barang::findOrFail($id);

        $relatedItems = Barang::where('kategori', $kategoriUtama)
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
            $reviewOrder = \App\Models\Pesanan::where('user_id', auth()->id())
                ->where('status', 'selesai')
                ->whereHas('details', fn($q) => $q->where('product_id', $id))
                ->first();

            $alreadyReviewed = \App\Models\Review::where('user_id', auth()->id())
                ->where('product_id', $id)
                ->exists();

            $canReview = $reviewOrder && !$alreadyReviewed;
        }

        return view('pages.landing.kategori.details_LP', [
            'item'          => $item,
            'relatedItems'  => $relatedItems,
            'kategori'      => $cfg['slug'],
            'categoryLabel' => $cfg['title'],
            'reviews'       => $reviews,
            'avgRating'     => $avgRating,
            'canReview'     => $canReview,
            'reviewOrder'   => $reviewOrder,
            'accordions'    => [
                ['title' => $cfg['aboutLabel'], 'deskripsi' => $item->deskripsi ?? 'Deskripsi tidak tersedia.', 'open' => true],
                ['title' => 'Sorotan',          'deskripsi' => $item->sorotan ?? 'Spesifikasi unggulan tidak tersedia.', 'open' => false],
                ['title' => 'Isi Paket',        'deskripsi' => $item->isi_paket ?? 'Informasi isi paket tidak tersedia.', 'open' => false],
            ],
        ]);
    }
}