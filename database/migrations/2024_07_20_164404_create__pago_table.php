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
        Schema::create('Pago', function (Blueprint $table) {
            $table->bigIncrements('codPago'); 
            $table->date('fechaPago');
            $table->float('monto', 8, 2);
            $table->string('estado')->default('Pendiente');
            $table->foreignId('codClienteF')->constrained('Cliente', 'carnetIdentidad'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Pago');
    }
};
