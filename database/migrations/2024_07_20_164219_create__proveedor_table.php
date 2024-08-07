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
        Schema::create('Proveedor', function (Blueprint $table) {
            $table->unsignedBigInteger('codProveedor')->primary();
            $table->string('nombre');
            $table->string('direccion');
            $table->integer('telefono');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Proveedor');
    }
};

