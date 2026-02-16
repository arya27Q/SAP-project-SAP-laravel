<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('qc_inspections', function (Blueprint $table) {
            $table->id_qc();
            // --- FOREIGN KEYS (RELASI) ---
            $table->string('no_lbts')->unique();
            $table->date('tgl_lbts');
            $table->foreignId('tablet_user_id')->constrained('tablet_users');
            $table->foreignId('sales_order_id')->constrained('sales_orders_qc');
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('no_pengganti')->nullable(); 
            $table->string('jenis_produk');
            $table->integer('qty_check');
            $table->string('status'); 
            $table->string('divisi_reject')->nullable(); 
            $table->text('remark')->nullable();
            $table->string('foto_produk_path')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qc_inspections');
    }
};
