<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Define la tabla asociada al modelo
    protected $table = 'Cliente';

    // Define la clave primaria del modelo
    protected $primaryKey = 'carnetIdentidad';

    // Indica que la clave primaria no es auto-incremental
    public $incrementing = false;

    // Define el tipo de la clave primaria
    protected $keyType = 'integer';

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'carnetIdentidad',
        'nombre',
        'apellidoPaterno',
        'apellidoMaterno',
        'sexo',
        'edad',
        'telefono',
        'codUsuarioF',
    ];

    // Convertir atributos a sus tipos de datos correctos
    protected $casts = [
        'carnetIdentidad' => 'integer',
        'nombre' => 'string',
        'apellidoPaterno' => 'string',
        'apellidoMaterno' => 'string',
        'sexo' => 'string',
        'edad' => 'integer',
        'telefono' => 'integer',
        'codUsuarioF' => 'integer',
    ];

    // Definir la relación con el modelo User
    public function usuario()
    {
        return $this->belongsTo(User::class, 'codUsuarioF', 'codUsuario');
    }

    // Desactivar marcas de tiempo
    public $timestamps = false;
}
