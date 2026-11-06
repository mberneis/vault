<?php

use App\Http\Controllers\VaultController;
use Illuminate\Support\Facades\Route;

Route::get('/', [VaultController::class, 'index']);
Route::post('/', [VaultController::class, 'store']);
Route::get('view/{key}', [VaultController::class, 'show']);
Route::view('/expired', 'expired');
