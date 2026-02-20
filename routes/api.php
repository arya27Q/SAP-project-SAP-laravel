<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthTestController;


/*
**
*/

Route::post('/test-koneksi', function (Request $request) {
    return response()->json([
        'pesan' => 'Halo dari Laravel!',
        'status' => 'Berhasil Diakses',
    ]);
});

Route::post('/test-register', [AuthTestController::class, 'register']);
Route::post('/test-login', [AuthTestController::class, 'login']);

