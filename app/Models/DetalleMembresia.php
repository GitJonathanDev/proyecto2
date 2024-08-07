<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleMembresia extends Model
{
    use HasFactory;
    
    // Define el nombre de la tabla
    protected $table = 'DetalleMembresia';

    // La clave primaria compuesta
    protected $primaryKey = ['codServicio', 'codMembresia'];

    // Indicar que la clave primaria no es auto-incremental
    public $incrementing = false;

    // Desactivar marcas de tiempo
    public $timestamps = false;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'fechaInicio',
        'fechaFin',
        'subTotal',
        'tipo',
        'codServicio',
        'codMembresia',
    ];

    // Convertir atributos a sus tipos de datos correctos
    protected $casts = [
        'fechaInicio' => 'date',
        'fechaFin' => 'date',
        'subTotal' => 'float',
        'codServicio' => 'integer',
        'codMembresia' => 'integer',
    ];

    // Definir la relación con el modelo Servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'codServicio', 'codServicio');
    }

    // Definir la relación con el modelo Membresia
    public function membresia()
    {
        return $this->belongsTo(Membresia::class, 'codMembresia', 'codMembresia');
    }
}
