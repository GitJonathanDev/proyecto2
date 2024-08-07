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
        Schema::create('DetalleVenta', function (Blueprint $table) {
            $table->float('precioV', 8, 2);
            $table->integer('cantidad');
            $table->primary(['codVenta', 'codProducto']);
            $table->foreignId('codVenta')->constrained('Venta', 'codVenta');
            $table->string('codProducto'); 
            $table->foreign('codProducto')->references('codProducto')->on('Producto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DetalleVenta');
    }
};
