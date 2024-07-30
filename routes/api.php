<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\barcadiaApi;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/date_to_roman', [barcadiaApi::class, 'dateToRoman']);
Route::post('/roman_to_date', [barcadiaApi::class, 'romanToDate']);