<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si no sigue la convención pluralizada
    protected $table = 'TipoUsuario';

    // Se asegura de que 'codTipoUsuario' sea tratado como la clave primaria
    protected $primaryKey = 'codTipoUsuario';

    // La clave primaria es de tipo 'bigint'
    protected $keyType = 'bigint';

    // No se auto-incrementa por defecto
    public $incrementing = true;

    // No se gestionan las marcas de tiempo (created_at, updated_at)
    public $timestamps = false;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'descripcion',
    ];

    // Define el tipo de datos de los campos
    protected $casts = [
        'descripcion' => 'string',
        'codTipoUsuario' => 'integer'
    ];
}
