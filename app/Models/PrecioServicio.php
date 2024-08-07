<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecioServicio extends Model
{
    use HasFactory;

    // Define el nombre de la tabla
    protected $table = 'PrecioServicio'; 

    // La clave primaria de la tabla
    protected $primaryKey = 'codPrecioServicio';

    // Indicar que la clave primaria es auto-incremental
    public $incrementing = true;

    // Desactivar marcas de tiempo
    public $timestamps = false;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'tipo',
        'precio',
        'codServicioF',
    ];

    // Convertir atributos a sus tipos de datos correctos
    protected $casts = [
        'precio' => 'float',
        'codServicioF' => 'integer',
    ];

    // Definir la relación con el modelo Servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'codServicioF', 'codServicio');
    }
}
