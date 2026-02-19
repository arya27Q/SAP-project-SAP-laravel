<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // 1. WAJIB: Kunci ke database Azure PT 4
    protected $connection = 'pt4';

    // 2. Kolom yang boleh diisi oleh Admin Desktop
    protected $fillable = [
        'nama_customer',
        'kode_sap', // Opsional, misal Admin mau masukin kode referensi internal
    ];

    /**
     * Relasi ke tabel Sales Orders
     * 1 Customer bisa punya banyak pesanan (SO)
     */
    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class, 'customer_id');
    }

    /**
     * Relasi ke tabel QC Inspections
     * 1 Customer bisa punya banyak riwayat barang reject (LBTS)
     */
    public function qcInspections()
    {
        return $this->hasMany(QcInspection::class, 'customer_id');
    }
}