<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('pages.landing.landing');
    }

    public function rental()
    {
        return view('pages.landing.rental');
    }
}
