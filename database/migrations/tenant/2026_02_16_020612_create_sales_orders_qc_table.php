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
        Schema::create('sales_orders_qc', function (Blueprint $table) {
            $table->id();
            $table->string('no_so',9)->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); // constrained buat otomatis ambil data cust dr table cust , onDelete buat otomatis ikut kehapus (opsional)
            $table->date('tanggal_so')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders_qc');
    }
};
