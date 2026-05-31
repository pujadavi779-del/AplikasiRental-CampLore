<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SewaController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'semua');

        return view('pages.pelanggan.dashboard.pesanan_saya', compact('status'));
    }
}