<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthTestController;
use App\Http\Controllers\QcInspectionController;
use App\Http\Controllers\Api\TabletAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesOrderController;

/*
|--------------------------------------------------------------------------
| EXISTING ROUTES (JANGAN DIHAPUS)
|--------------------------------------------------------------------------
*/

Route::post('/test-koneksi', function (Request $request) {
    return response()->json([
        'pesan' => 'Halo dari Laravel!',
        'status' => 'Berhasil Diakses',
    ]);
});

Route::post('/test-register', [AuthTestController::class, 'register']);
Route::post('/test-login', [AuthTestController::class, 'login']);

// Menggunakan apiResource biar ringkas (Handle CRUD QC Default)
Route::apiResource('qc-inspections', QcInspectionController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('tablet')->group(function () {
    Route::post('/login', [TabletAuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| PT4 SYSTEM ROUTES (VERSI CLEAN)
|--------------------------------------------------------------------------
*/

Route::prefix('pt4')->group(function () {
    
    // 1. SALES ORDER 
    // Custom route (Search) wajib di atas Resource
    Route::get('sales-orders/search', [SalesOrderController::class, 'searchBySo']); 
    Route::apiResource('sales-orders', SalesOrderController::class);

    // 2. CUSTOMER (Master Data PT)
    Route::apiResource('customers', CustomerController::class);

    // 3. QC INSPECTION (Versi PT4 Azure)
    Route::apiResource('qc-inspections', QcInspectionController::class);
    
});