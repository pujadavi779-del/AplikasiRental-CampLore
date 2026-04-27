<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $data_pengembalian = Pemesanan::with(['user', 'product'])
                            ->where('status', 'disewa')
                            ->get();

        return view('pages.admin.pengembalian', compact('data_pengembalian'));
    }
}
