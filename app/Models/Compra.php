<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    // Define el nombre de la tabla
    protected $table = 'Compra';

    // La clave primaria de la tabla (autoincremental)
    protected $primaryKey = 'codCompra';

    // Indicar que la clave primaria es un campo auto-incremental
    public $incrementing = true;

    // El tipo de la clave primaria (por defecto es 'int')
    protected $keyType = 'int';

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'fechaCompra',
        'montoTotal',
        'codEncargadoF',
        'codProveedorF',
    ];

    // Convertir atributos a sus tipos de datos correctos
    protected $casts = [
        'fechaCompra' => 'date',
        'montoTotal' => 'float',
        'codEncargadoF' => 'integer',
        'codProveedorF' => 'integer',
    ];

    // Definir la relación con el modelo Encargado
    public function encargado()
    {
        return $this->belongsTo(Encargado::class, 'codEncargadoF', 'carnetIdentidad');
    }

    // Definir la relación con el modelo Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'codProveedorF', 'codProveedor');
    }

    // Desactivar marcas de tiempo
    public $timestamps = false;
}
