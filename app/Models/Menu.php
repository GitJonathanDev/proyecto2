<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'Menu';

    // La clave primaria de la tabla
    protected $primaryKey = 'id';

    // Desactivar marcas de tiempo
    public $timestamps = false;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'url',
        'icono',
        'codTipoUsuarioF',
        'padreId'
    ];

    // Definir la relación con el modelo Menu para la jerarquía padre-hijo
    public function padre()
    {
        return $this->belongsTo(Menu::class, 'padreId', 'id');
    }

    public function hijos()
    {
        return $this->hasMany(Menu::class, 'padreId', 'id');
    }

    // Definir la relación con el modelo TipoUsuario
    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'codTipoUsuarioF', 'codTipoUsuario');
    }
}
