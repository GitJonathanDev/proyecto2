<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearMenus extends Migration
{
    public function up(): void
    {
        Schema::create('Menu', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('url');
            $table->string('icono')->nullable();
            $table->foreignId('codTipoUsuarioF')->constrained('TipoUsuario', 'codTipoUsuario')->onDelete('cascade');
            $table->foreignId('padreId')->nullable()->constrained('Menu', 'id')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Menu');
    }
}
