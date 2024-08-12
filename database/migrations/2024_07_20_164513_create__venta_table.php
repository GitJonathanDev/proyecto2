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
        Schema::create('Venta', function (Blueprint $table) {
            $table->bigIncrements('codVenta');
            $table->date('fechaVenta');
            $table->float('montoTotal', 8, 2);
            $table->foreignId('codEncargadoF') ->constrained('Encargado', 'carnetIdentidad'); 
            $table->foreignId('codClienteF')->constrained('Cliente', 'carnetIdentidad'); 
            $table->foreignId('codPagoF') ->constrained('Pago', 'codPago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Venta');
    }
};
