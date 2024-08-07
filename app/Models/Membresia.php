<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    use HasFactory;

    // Define el nombre de la tabla
    protected $table = 'Membresia';

    // Define la clave primaria de la tabla (autoincremental)
    protected $primaryKey = 'codMembresia';

    // Indicar que la clave primaria es un campo auto-incremental
    public $incrementing = true;

    // El tipo de la clave primaria (por defecto es 'int')
    protected $keyType = 'int';

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'descripcion',
        'precioTotal',
        'codClienteF',
        'codEncargadoF',
        'codPagoF',
    ];

    // Convertir atributos a sus tipos de datos correctos
    protected $casts = [
        'precioTotal' => 'float',
        'codClienteF' => 'integer',
        'codEncargadoF' => 'integer',
        'codPagoF' => 'integer',
    ];

    // Definir la relación con el modelo Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'codClienteF', 'carnetIdentidad');
    }

    // Definir la relación con el modelo Encargado
    public function encargado()
    {
        return $this->belongsTo(Encargado::class, 'codEncargadoF', 'carnetIdentidad');
    }

    // Definir la relación con el modelo Pago
    public function pago()
    {
        return $this->belongsTo(Pago::class, 'codPagoF', 'codPago');
    }

    // Definir la relación con el modelo DetalleMembresia
    public function detalles()
    {
        return $this->hasMany(DetalleMembresia::class, 'codMembresia', 'codMembresia');
    }

    // Desactivar marcas de tiempo
    public $timestamps = false;
}
