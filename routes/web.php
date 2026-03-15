<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard_admin', function () {
    return view('dashboard_admin');
});
