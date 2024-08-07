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
        Schema::create('Usuario', function (Blueprint $table) {
            $table->bigIncrements('codUsuario');
            $table->string('nombreUsuario');
            $table->string('email')->unique(); 
            $table->string('password', 60);
            $table->boolean('estadoBloqueado')->default(false); 
            $table->foreignId('codTipoUsuarioF')->constrained('TipoUsuario', 'codTipoUsuario'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Usuario');
    }
};
