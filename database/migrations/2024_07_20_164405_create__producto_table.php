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
        Schema::create('Producto', function (Blueprint $table) {
            $table->string('codProducto')->primary();
            $table->string('nombre');
            $table->string('descripcion');
            $table->float('precio', 8, 2);
            $table->integer('stock');
            $table->string('imagen_url')->nullable();
            $table->foreignId('codCategoriaF')->constrained('Categoria', 'codCategoria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Producto');
    }
};