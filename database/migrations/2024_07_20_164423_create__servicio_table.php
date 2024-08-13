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
        Schema::create('Servicio', function (Blueprint $table) {
            $table->bigIncrements('codServicio'); 
            $table->string('nombre');
            $table->string('descripcion');
            $table->integer('capacidad');
            $table->foreignId('codHorarioF')->constrained('Horario', 'codHorario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Servicio');
    }
};