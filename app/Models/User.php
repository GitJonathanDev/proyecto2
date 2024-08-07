<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Especifica el nombre de la tabla si no sigue la convención pluralizada
    protected $table = 'Usuario';

    // La clave primaria es 'codUsuario', que es de tipo 'bigint'
    protected $primaryKey = 'codUsuario';
    protected $keyType = 'bigint';
    public $incrementing = true;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombreUsuario',
        'email',
        'password',
        'estadoBloqueado',
        'codTipoUsuarioF', // Ajustar el nombre del campo para que coincida con la migración
    ];

    // Campos ocultos para el modelo
    protected $hidden = [
        'password',
    ];

    // Definir cómo se deben manejar los campos booleanos
    protected $casts = [
        'estadoBloqueado' => 'boolean',
        'codUsuario' => 'integer',
    ];

    // Relación con la tabla TipoUsuario
    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'codTipoUsuarioF'); // Ajustar el nombre del campo de la clave foránea
    }

    // Encriptar la contraseña antes de guardarla
    public function setPasswordAttribute($password) {
        $this->attributes['password'] = bcrypt($password);
    }

    // Desactivar las marcas de tiempo
    public $timestamps = false;
}
