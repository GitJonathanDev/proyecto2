<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'Producto';

    // La clave primaria es una cadena, no un entero
    protected $primaryKey = 'codProducto';

    // Indicar que la clave primaria no es autoincrementable
    public $incrementing = false;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'codProducto', // Añadido a los campos llenables
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'imagen_url', // Asegúrate de incluir el campo de imagen
        'codCategoriaF', // Asegúrate de usar el nombre correcto aquí
    ];

    // Convertir atributos a sus tipos de datos correctos
    protected $casts = [
        'precio' => 'float',
        'stock' => 'integer',
        'codCategoriaF' => 'integer', // Asegúrate de usar el nombre correcto aquí
    ];

    // Definir la relación con el modelo Categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'codCategoriaF', 'codCategoria');
    }

    // Desactivar marcas de tiempo
    public $timestamps = false;
}
