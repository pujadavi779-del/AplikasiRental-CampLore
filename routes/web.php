<?php

use Illuminate\Support\Facades\Route;
use App\Models\Item;
use App\Http\Controllers\CampingController;
use App\Http\Controllers\CameraController;


Route::get('/dashboard_admin', function () {
    return view('dashboard_admin');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/registrasi', function () {
    return view('registrasi');
});

Route::get('/camera', function () {
    return view('camera.index');
})->name('camera.index');

Route::get('/camping', function () {
    return view('camping.index');
})->name('camping.index');