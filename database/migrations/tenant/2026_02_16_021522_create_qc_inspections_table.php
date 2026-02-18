<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('pt4')->create('qc_inspections', function (Blueprint $table) {
            // 1. Primary Key Custom (id_qc)
            $table->id('id_qc'); 

            // 2. Data Unik & Tanggal
            $table->string('no_lbts')->unique();
            $table->date('tgl_lbts');
            
            // 3. Foreign Keys (Relasi)
            $table->unsignedBigInteger('tablet_user_id');
            $table->foreign('tablet_user_id')->references('id')->on('tablet_users');

            $table->unsignedBigInteger('sales_order_id');
            $table->foreign('sales_order_id')->references('id')->on('sales_orders');

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');

            // 4. Data Isian Form
            $table->string('no_pengganti')->nullable(); // Boleh kosong
            $table->string('jenis_produk');
            $table->integer('qty_check');
            $table->string('status'); // Lolos / Reject
            $table->string('divisi_reject')->nullable(); // Boleh kosong
            $table->text('remark')->nullable(); // Boleh kosong
            $table->string('foto_produk_path')->nullable(); // Boleh kosong
            
            // 5. Timestamp (created_at & updated_at)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('pt4')->dropIfExists('qc_inspections');
    }
};