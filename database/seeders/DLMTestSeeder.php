<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DLMTestSeeder extends Seeder
{
    public function run(): void
    {
        $db = 'pt4'; // Kunci di sini biar gak nyasar ke PT lain!

        // 1. Cek & Suntik PT SINAR JAYA
        $cust1 = DB::connection($db)->table('customers')->where('nama_customer', 'PT. SINAR JAYA MAKMUR')->first();
        if (!$cust1) {
            $cust1Id = DB::connection($db)->table('customers')->insertGetId([
                'nama_customer' => 'PT. SINAR JAYA MAKMUR',
                'kode_sap' => 'C-1001',
                'created_at' => Carbon::now(),
            ]);
        } else {
            $cust1Id = $cust1->id;
        }

        // 2. Cek & Suntik PT ABC
        $cust2 = DB::connection($db)->table('customers')->where('nama_customer', 'PT. ABC BERSAMA')->first();
        if (!$cust2) {
            $cust2Id = DB::connection($db)->table('customers')->insertGetId([
                'nama_customer' => 'PT. ABC BERSAMA',
                'kode_sap' => 'C-1002',
                'created_at' => Carbon::now(),
            ]);
        } else {
            $cust2Id = $cust2->id;
        }

        // 3. Suntik Sales Order (Gunakan updateOrInsert biar gak duplicate error)
        $sos = [
            ['no_so' => 'SO2026001', 'customer_id' => $cust1Id, 'tanggal_so' => '2026-02-18'],
            ['no_so' => 'SO2026002', 'customer_id' => $cust1Id, 'tanggal_so' => '2026-02-19'],
            ['no_so' => 'SO2026003', 'customer_id' => $cust2Id, 'tanggal_so' => '2026-02-19'],
        ];

        foreach ($sos as $so) {
            DB::connection($db)->table('sales_orders')->updateOrInsert(
                ['no_so' => $so['no_so']], // Cari berdasarkan No SO
                [
                    'customer_id' => $so['customer_id'],
                    'tanggal_so' => $so['tanggal_so'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }

        echo "✅ BERES BRO! Data aman, koneksi bener, gak ada duplikat! 🚀\n";
    }
}