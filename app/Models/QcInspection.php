<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QcInspection extends Model
{
    use HasFactory;

    // WAJIB: Karena kita pakai koneksi Azure PT 4
    protected $connection = 'pt4';
    
    // WAJIB: Karena primary key kamu bukan 'id' tapi 'id_qc'
    protected $primaryKey = 'id';

    protected $fillable = [
        'no_lbts', 'tgl_lbts', 'tablet_user_id', 'sales_order_id', 
        'customer_id', 'no_pengganti', 'jenis_produk', 'qty_check', 
        'status', 'divisi_reject', 'remark', 'foto_produk_path'
    ];

    // Relasi ke Customer
    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relasi ke TabletUser (Di controller kamu panggil 'user')
    public function user() {
        return $this->belongsTo(TabletUser::class, 'tablet_user_id');
    }

    // Relasi ke Sales Order
    public function salesOrder() {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id');
    }
}