<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    // Define el nombre de la tabla
    protected $table = 'Venta';

    // Define la clave primaria de la tabla (autoincremental)
    protected $primaryKey = 'codVenta';

    // Indicar que la clave primaria es un campo auto-incremental
    public $incrementing = true;

    // El tipo de la clave primaria (por defecto es 'int')
    protected $keyType = 'int';

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'fechaVenta',
        'montoTotal',
        'codEncargadoF',
        'codClienteF',
        'codPagoF',
    ];

    // Convertir atributos a sus tipos de datos correctos
    protected $casts = [
        'fechaVenta' => 'date',
        'montoTotal' => 'float',
        'codEncargadoF' => 'integer',
        'codClienteF' => 'integer',
        'codPagoF' => 'integer',
    ];

    // Definir la relación con el modelo Encargado
    public function encargado()
    {
        return $this->belongsTo(Encargado::class, 'codEncargadoF', 'codEncargado');
    }

    // Definir la relación con el modelo Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'codClienteF', 'codCliente');
    }

    // Definir la relación con el modelo Pago
    public function pago()
    {
        return $this->belongsTo(Pago::class, 'codPagoF', 'codPago');
    }

    // Desactivar marcas de tiempo
    public $timestamps = false;
}
