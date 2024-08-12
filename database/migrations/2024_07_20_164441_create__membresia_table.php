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
        Schema::create('Membresia', function (Blueprint $table) {
            $table->bigIncrements('codMembresia');
            $table->string('descripcion');
            $table->float('precioTotal', 8, 2);
            $table->foreignId('codClienteF') ->constrained('Cliente', 'carnetIdentidad'); 
            $table->foreignId('codEncargadoF')->constrained('Encargado', 'carnetIdentidad'); 
            $table->foreignId('codPagoF')->constrained('Pago', 'codPago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Membresia');
    }
};
