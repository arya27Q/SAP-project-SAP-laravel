<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        
        Schema::connection('pt4')->create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('no_so', 9)->unique();
            $table->foreignId('customer_id')->constrained('customers') ->onDelete('cascade');
            $table->date('tanggal_so')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
       
        Schema::connection('pt4')->dropIfExists('sales_orders');
    }
};