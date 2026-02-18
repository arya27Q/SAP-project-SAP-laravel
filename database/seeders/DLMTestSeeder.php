<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DLMTestSeeder extends Seeder
{
    public function run(): void
    {
        $db = 'pt4'; // Tetap kunci di PT 4 ya!

        // 1. Suntik Data Customer
        $custId = DB::connection($db)->table('customers')->insertGetId([
            'nama_customer' => 'PT. SINAR JAYA MAKMUR',
            'kode_sap' => 'C-1001',
            'created_at' => Carbon::now(),
        ]);

        // 2. Suntik Data Sales Order (Pura-puranya kiriman dari Desktop)
        DB::connection($db)->table('sales_orders')->insert([
            'no_so' => 'SO2026001', 
            'customer_id' => $custId,
            'tanggal_so' => '2026-02-18',
            'created_at' => Carbon::now(),
        ]);

        echo "✅ Data Simulasi DLM Berhasil Disuntik! 🚀\n";
    }
}