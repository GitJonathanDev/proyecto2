<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    // Define el nombre de la tabla
    protected $table = 'DetalleVenta';

    // La clave primaria compuesta
    protected $primaryKey = ['codVenta', 'codProducto'];

    // Indicar que la clave primaria no es auto-incremental
    public $incrementing = false;

    // Desactivar marcas de tiempo
    public $timestamps = false;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'precioV',
        'cantidad',
        'codVenta',
        'codProducto',
    ];

    // Convertir atributos a sus tipos de datos correctos
    protected $casts = [
        'precioV' => 'float',
        'cantidad' => 'integer',
        'codVenta' => 'integer',
        'codProducto' => 'integer',
    ];

    // Definir la relación con el modelo Venta
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'codVenta', 'codVenta');
    }

    // Definir la relación con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codProducto', 'codProducto');
    }
}
