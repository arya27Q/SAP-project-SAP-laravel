<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    // Kunci utama: Pakai koneksi Azure PT 4
    protected $connection = 'pt4';
    
    protected $table = 'sales_orders';

    protected $fillable = ['no_so', 'customer_id', 'tanggal_so'];

    // Relasi ke Customer: Biar otomatis tahu SO ini punya PT mana
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}