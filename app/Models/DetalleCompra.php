<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    // Define el nombre de la tabla
    protected $table = 'DetalleCompra';

    // La clave primaria compuesta
    protected $primaryKey = ['codCompra', 'codProducto'];

    // Indicar que la clave primaria no es auto-incremental
    public $incrementing = false;

    // Desactivar marcas de tiempo
    public $timestamps = false;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'precioC',
        'cantidad',
        'codCompra',
        'codProducto',
    ];

    // Convertir atributos a sus tipos de datos correctos
    protected $casts = [
        'precioC' => 'float',
        'cantidad' => 'integer',
        'codCompra' => 'integer',
        'codProducto' => 'integer',
    ];

    // Definir la relación con el modelo Compra
    public function compra()
    {
        return $this->belongsTo(Compra::class, 'codCompra', 'codCompra');
    }

    // Definir la relación con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codProducto', 'codProducto');
    }
}
