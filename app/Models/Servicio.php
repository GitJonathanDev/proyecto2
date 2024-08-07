<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    // Define el nombre de la tabla
    protected $table = 'Servicio';

    // La clave primaria de la tabla (autoincremental)
    protected $primaryKey = 'codServicio';

    // Indicar que la clave primaria es un campo auto-incremental
    public $incrementing = true;

    // El tipo de la clave primaria (por defecto es 'int')
    protected $keyType = 'int';

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'capacidad',
        'codHorarioF',
    ];

    // Convertir atributos a sus tipos de datos correctos
    protected $casts = [
        'capacidad' => 'integer',
        'codHorarioF' => 'integer',
    ];

    // Definir la relación con el modelo Horario
    public function horario()
    {
        return $this->belongsTo(Horario::class, 'codHorarioF', 'codHorario');
    }

    // Definir la relación con el modelo PrecioServicio
    public function precios()
    {
        return $this->hasMany(PrecioServicio::class, 'codServicioF', 'codServicio');
    }

    // Desactivar marcas de tiempo
    public $timestamps = false;
}
