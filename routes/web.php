<?php

use Illuminate\Support\Facades\Route;
use App\Models\Item;

Route::get('/dashboard_admin', function () {
    return view('dashboard_admin');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/registrasi', function () {
    return view('registrasi');
});

Route::get('/admin/items/camera', function () {

    $items = Item::where('category', 'camera')->get();

    return view('admin.items.camera', compact('items'));

});

Route::get('/admin/items/camping', function () {

    $items = Item::where('category', 'camping')->get();

    return view('admin.items.camping', compact('items'));

});