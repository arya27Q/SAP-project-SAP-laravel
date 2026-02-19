<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    protected $connection = 'pt4';
    
    // Nggak perlu custom primaryKey karena udah pake 'id'
    
    protected $fillable = [
        'no_so',
        'customer_id',
        'tanggal_so',
    ];

    // Relasi balik ke Customer (Biar pas cari SO, nama PT-nya ngikut)
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relasi ke QC (1 SO bisa punya banyak laporan LBTS kalau apes wkwk)
    public function qcInspections()
    {
        return $this->hasMany(QcInspection::class, 'sales_order_id');
    }
}