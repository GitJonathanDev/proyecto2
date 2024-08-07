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
        Schema::create('DetalleMembresia', function (Blueprint $table) {
            $table->date('fechaInicio');
            $table->date('fechaFin');
            $table->float('subTotal', 8, 2);
            $table->string('tipo');
            $table->primary(['codServicio', 'codMembresia']);
            $table->foreignId('codServicio')->constrained('Servicio', 'codServicio'); 
            $table->foreignId('codMembresia') ->constrained('Membresia', 'codMembresia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DetalleMembresia');
    }
};
