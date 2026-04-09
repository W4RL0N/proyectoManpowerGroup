<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tickets', function () {
    return view('tickets');
});

require __DIR__ . '/api.php';

Route::get('inicio', function () {
    return view('inicio');
});




