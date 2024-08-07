<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    // Define la tabla asociada al modelo
    protected $table = 'Pago';

    // Define la clave primaria del modelo
    protected $primaryKey = 'codPago';

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'fechaPago',
        'monto',
        'estado',       // Corrige este campo según el nombre en la migración
        'codClienteF',  // Asegúrate de usar el nombre correcto aquí
    ];

    // Convertir atributos a sus tipos de datos correctos
    protected $casts = [
        'fechaPago' => 'date',
        'monto' => 'float',
        'codClienteF' => 'integer',  // Asegúrate de usar el nombre correcto aquí
    ];

    // Definir la relación con el modelo Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'codClienteF', 'codCliente');
    }

    // Desactivar marcas de tiempo
    public $timestamps = false;
}
