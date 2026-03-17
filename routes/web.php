<?php

use Illuminate\Support\Facades\Route;
use App\Models\Item;
use App\Http\Controllers\CampingController;
use App\Http\Controllers\CameraController;

Route::resource('camping', CampingController::class);

Route::resource('camera', CameraController::class);


Route::get('/dashboard_admin', function () {
    return view('dashboard_admin');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/registrasi', function () {
    return view('registrasi');
});
