<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;

Route::apiResource('kategoris', KategoriController::class);
Route::apiResource('bukus', BukuController::class); 