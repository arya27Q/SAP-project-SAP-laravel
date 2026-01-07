<?php

use App\Http\Controllers\AuthTestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Endpoint lama untuk tes (Opsional)
Route::post('/test-koneksi', function (Request $request) {
    return response()->json([
        'pesan' => 'Halo dari Laravel!',
        'status' => 'Berhasil Diakses',
    ]);
});

// Sekarang semua ini akan bisa diakses via /api/test-register dan /api/test-login
Route::post('/test-register', [AuthTestController::class, 'register']);
Route::post('/test-login', [AuthTestController::class, 'login']);