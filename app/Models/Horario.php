<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Horario extends Model
{
    use HasFactory;

    // Especifica la tabla a la que se refiere este modelo
    protected $table = 'Horario';

    // Desactivar las marcas de tiempo para esta tabla
    public $timestamps = false;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'horaInicio',
        'horaFin',
    ];

    // Definir la clave primaria de la tabla
    protected $primaryKey = 'codHorario';

    // Indicar que la clave primaria es un entero auto-incremental
    public $incrementing = true;

    // Establecer el tipo de clave primaria como entero
    protected $keyType = 'int';

    // Convertir el atributo 'horaInicio' a un formato 'H:i:s' antes de almacenarlo
    public function setHoraInicioAttribute($value)
    {
        $this->attributes['horaInicio'] = Carbon::createFromFormat('H:i', $value)->format('H:i:s');
    }

    // Convertir el atributo 'horaFin' a un formato 'H:i:s' antes de almacenarlo
    public function setHoraFinAttribute($value)
    {
        $this->attributes['horaFin'] = Carbon::createFromFormat('H:i', $value)->format('H:i:s');
    }

    // Formatear el atributo 'horaInicio' de 'H:i:s' a 'H:i' cuando se obtiene
    public function getHoraInicioAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    // Formatear el atributo 'horaFin' de 'H:i:s' a 'H:i' cuando se obtiene
    public function getHoraFinAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }
}
