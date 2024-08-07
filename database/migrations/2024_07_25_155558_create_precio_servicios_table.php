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
        Schema::create('PrecioServicio', function (Blueprint $table) {
            $table->bigIncrements('codPrecioServicio');
            $table->string('tipo');
            $table->float('precio');
            $table->foreignId('codServicioF')->constrained('Servicio', 'codServicio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PrecioServicio');
    }
};
