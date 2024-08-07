<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    // Especifica la tabla a la que se refiere este modelo
    protected $table = 'Proveedor';

    // La clave primaria personalizada
    protected $primaryKey = 'codProveedor';

    // Indicar que la clave primaria no es un entero auto-incremental
    public $incrementing = false;

    // El tipo de la clave primaria
    protected $keyType = 'int';

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
    ];

    // Convertir atributos a sus tipos de datos correctos
    protected $casts = [
        'nombre' => 'string',
        'direccion' => 'string',
        'telefono' => 'integer',
    ];

    // Desactivar marcas de tiempo
    public $timestamps = false;
}
