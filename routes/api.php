<?php

use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\Pelanggan_DataController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\Penyewaan_DetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/pelanggan', PelangganController::class);
Route::apiResource('/kategori', KategoriController::class);
Route::apiResource('/admin', AdminController::class);
Route::apiResource('/alat', AlatController::class);
Route::apiResource('/pelanggan_data', Pelanggan_DataController::class);
Route::apiResource('/penyewaan', PenyewaanController::class);
Route::apiResource('/penyewaan_detail', Penyewaan_DetailController::class);
