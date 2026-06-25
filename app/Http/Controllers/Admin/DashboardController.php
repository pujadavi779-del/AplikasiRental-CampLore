<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── STAT CARDS ───────────────────────────────────────────
        $totalRentalAktif = Pesanan::whereIn('status', ['proses', 'pengiriman', 'jalan', 'dikembalikan'])->count();

        $totalKamera  = Barang::where('kategori', 'Kamera')->count();
        $totalCamping = Barang::where('kategori', 'Camping')->count();

        // FIX: Join melewati pesanan_detail
        $kameraDipinjam = DB::table('pesanan')
            ->join('pesanan_detail', 'pesanan.id_pesanan', '=', 'pesanan_detail.pesanan_id')
            ->join('barang', 'pesanan_detail.product_id', '=', 'barang.id_barang')
            ->whereIn('pesanan.status', ['proses', 'pengiriman', 'jalan', 'dikembalikan'])
            ->where('barang.kategori', 'Kamera')
            ->whereNull('barang.deleted_at')
            ->count();

        $campingDipinjam = DB::table('pesanan')
            ->join('pesanan_detail', 'pesanan.id_pesanan', '=', 'pesanan_detail.pesanan_id')
            ->join('barang', 'pesanan_detail.product_id', '=', 'barang.id_barang')
            ->whereIn('pesanan.status', ['proses', 'pengiriman', 'jalan', 'dikembalikan'])
            ->where('barang.kategori', 'Camping')
            ->whereNull('barang.deleted_at')
            ->count();

        $kameraTersedia  = $totalKamera  - $kameraDipinjam;
        $campingTersedia = $totalCamping - $campingDipinjam;

        // FIX: Cek end_date dari pesanan_detail
        $rentalTerlambat = Pesanan::whereHas('details', function ($q) {
            $q->where('end_date', '<', now());
        })
        ->whereNotIn('status', ['selesai', 'dibatalkan'])
        ->count();

        // ── CHART — 7 hari terakhir ──────────────────────────────
        $days = collect(range(6, 0))->map(fn($i) => Carbon::today()->subDays($i));

        $labels         = [];
        $kameraPerHari  = [];
        $campingPerHari = [];

        foreach ($days as $day) {
            $labels[] = $day->locale('id')->isoFormat('ddd');

            // FIX: Join melewati pesanan_detail
            $kameraPerHari[] = DB::table('pesanan')
                ->join('pesanan_detail', 'pesanan.id_pesanan', '=', 'pesanan_detail.pesanan_id')
                ->join('barang', 'pesanan_detail.product_id', '=', 'barang.id_barang')
                ->whereDate('pesanan.created_at', $day)
                ->where('barang.kategori', 'Kamera')
                ->whereNull('barang.deleted_at')
                ->count();

            $campingPerHari[] = DB::table('pesanan')
                ->join('pesanan_detail', 'pesanan.id_pesanan', '=', 'pesanan_detail.pesanan_id')
                ->join('barang', 'pesanan_detail.product_id', '=', 'barang.id_barang')
                ->whereDate('pesanan.created_at', $day)
                ->where('barang.kategori', 'Camping')
                ->whereNull('barang.deleted_at')
                ->count();
        }

        // ── TREND MINGGU INI ─────────────────────────────────────
        $mingguIni  = Pesanan::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $mingguLalu = Pesanan::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();

        $persenNaik = $mingguLalu > 0
            ? round((($mingguIni - $mingguLalu) / $mingguLalu) * 100)
            : ($mingguIni > 0 ? 100 : 0);

        $trendLabel = ($persenNaik >= 0 ? '↑' : '↓') . ' ' . abs($persenNaik) . '% minggu ini';

        // ── TOP PRODUK bulan ini (hanya status aktif) ────────────
        // FIX: Join melewati pesanan_detail
        $topRaw = DB::table('pesanan')
            ->join('pesanan_detail', 'pesanan.id_pesanan', '=', 'pesanan_detail.pesanan_id')
            ->join('barang', 'pesanan_detail.product_id', '=', 'barang.id_barang')
            ->whereMonth('pesanan.created_at', now()->month)
            ->whereIn('pesanan.status', ['selesai', 'pengiriman', 'proses', 'jalan', 'dikembalikan'])
            ->whereNull('barang.deleted_at')
            ->select('barang.name', DB::raw('COUNT(*) as total'))
            ->groupBy('barang.id_barang', 'barang.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $maxTotal    = $topRaw->max('total') ?: 1;
        $topProducts = $topRaw->map(fn($p) => [
            $p->name,
            $p->total,
            round(($p->total / $maxTotal) * 100),
        ]);

        // ── TRANSAKSI TERBARU ────────────────────────────────────
        $transactions = Pesanan::with('pelanggan')
            ->latest()
            ->limit(5)
            ->get();

        // ── UNREPLIED COUNT ──────────────────────────────────────
        $unrepliedCount = \App\Models\Review::where('is_replied', false)->count();

        return view('pages.admin.dashboard_admin', compact(
            'totalRentalAktif',
            'trendLabel',
            'kameraTersedia', 'totalKamera', 'kameraDipinjam',
            'campingTersedia', 'totalCamping', 'campingDipinjam',
            'rentalTerlambat',
            'labels', 'kameraPerHari', 'campingPerHari',
            'topProducts',
            'transactions',
            'unrepliedCount',
        ));
    }
}