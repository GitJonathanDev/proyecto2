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
        Schema::create('Compra', function (Blueprint $table) {
            $table->bigIncrements('codCompra');
            $table->date('fechaCompra');
            $table->float('montoTotal', 8, 2);
            $table->foreignId('codEncargadoF')->constrained('Encargado', 'carnetIdentidad');
            $table->foreignId('codProveedorF')->constrained('Proveedor', 'codProveedor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Compra');
    }
};
