<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard_admin', function () {
    return view('dashboard_admin');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/registrasi', function () {
    return view('registrasi');
});