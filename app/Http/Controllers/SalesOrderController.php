<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesOrder; 

class SalesOrderController extends Controller
{
    public function searchByNoSo($no_so)
    {
        // Cari SO berdasarkan nomor 9 digit
        $so = SalesOrder::with('customer') 
            ->where('no_so', $no_so)
            ->first();

        if (!$so) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor SO ' . $no_so . ' tidak ditemukan di sistem PT 4'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'sales_order_id' => $so->id,
                'no_so'          => $so->no_so,
                // Pakai optional() atau ?? biar gak crash kalau customer-nya tiba-tiba ilang di DB
                'customer_name'  => $so->customer->nama_customer ?? 'Customer Tidak Terdaftar',
                'customer_id'    => $so->customer_id,
                'tanggal_so'     => $so->tanggal_so,
            ]
        ]);
    }
}