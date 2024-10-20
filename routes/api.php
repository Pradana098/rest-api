<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;


Route::get('/bukus/search', [BukuController::class, 'search']);
Route::apiResource('kategoris', KategoriController::class);
Route::apiResource('bukus', BukuController::class); 