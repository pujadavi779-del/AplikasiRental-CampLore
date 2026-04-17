<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // Jika sudah pakai login, ambil data user yang sedang login
        $pelanggan = Auth::user();

        return view('pelanggan.profil', compact('pelanggan'));
    }
}

