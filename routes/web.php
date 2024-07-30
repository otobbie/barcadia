<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\barcadiaApi;

Route::get('/', function () {
    return view('welcome');
});
