<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Especifica la tabla a la que se refiere este modelo
    protected $table = 'Categoria';

    // La clave primaria personalizada
    protected $primaryKey = 'codCategoria';

    // Indicar que la clave primaria es auto-incremental
    public $incrementing = true;

    // El tipo de la clave primaria
    protected $keyType = 'int';

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
    ];

    // Convertir atributos a sus tipos de datos correctos
    protected $casts = [
        'nombre' => 'string',
    ];

    // Desactivar marcas de tiempo
    public $timestamps = false;
}
