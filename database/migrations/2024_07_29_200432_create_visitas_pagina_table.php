<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        Schema::create('visitasPagina', function (Blueprint $table) {
            $table->id();
            $table->string('nombrePagina')->unique();
            $table->integer('conteoVisitas')->default(0);
        });
    }

    /**
     * Reversa las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitasPagina');
    }
};
