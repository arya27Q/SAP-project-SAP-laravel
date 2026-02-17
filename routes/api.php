<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthTestController;
use App\Http\Controllers\QcInspectionController;
use App\Http\Controllers\Api\TabletAuthController;



Route::post('/test-koneksi', function (Request $request) {
    return response()->json([
        'pesan' => 'Halo dari Laravel!',
        'status' => 'Berhasil Diakses',
    ]);
});

Route::post('/test-register', [AuthTestController::class, 'register']);
Route::post('/test-login', [AuthTestController::class, 'login']);
Route::apiResource('qc-inspections', QcInspectionController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('tablet')->group(function () {
    Route::post('/login', [TabletAuthController::class, 'login']);
    
});