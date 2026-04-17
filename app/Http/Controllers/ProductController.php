<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Ini adalah data yang akan dikirim ke view
        $data = [
            ['id' => 1, 'produk' => 'Laptop ASUS'],
            ['id' => 2, 'produk' => 'Keyboard Mechanical'],
            ['id' => 3, 'produk' => 'Monitor Gaming'],
        ];

        // Merujuk ke view/list_product dan mengirimkan variabel $data
        return view('list_product', compact('data'));
    }
}