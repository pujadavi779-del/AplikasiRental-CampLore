<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampingController;
use App\Http\Controllers\CameraController;
use App\Http\Controllers\LandingController;

Route::get('/dashboard/camera', [CameraController::class, 'index'])->name('camera.index');

Route::get('/', [LandingController::class, 'index']);
Route::resource('camping', CampingController::class);
Route::resource('camera', CameraController::class);

Route::get('/landing', [LandingController::class, 'index'])->name('landing');
Route::get('/about', [CameraController::class, 'landing'])->name('about');
Route::get('/camera', [CameraController::class, 'landing'])->name('camera.LP');

// details camera
Route::get('/camera/{id}', [CameraController::class, 'show'])->name('camera.show');

Route::get('/dashboard_admin', function () {
    return view('dashboard_admin');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/registrasi', function () {
    return view('registrasi');
});

Route::get('/about', function () {
    return view('about');
})->name('about');
