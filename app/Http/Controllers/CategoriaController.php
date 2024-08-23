<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $criterio = $request->criterio;
        $buscar = $request->buscar;

        $query = Categoria::query();

        if ($buscar != '') {
            $query->where($criterio, 'like', '%'.$buscar.'%');
        }

        $categorias = $query->paginate(5);

        return view('GestionarCategoria.index', compact('categorias'));
    }

    public function index2()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }

    public function create()
    {
        return view('GestionarCategoria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:Categoria,nombre',
        ]);

        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->save();

        return redirect()->route('categoria.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function edit($codCategoria)
    {
        $categoria = Categoria::findOrFail($codCategoria);
        return view('GestionarCategoria.edit', compact('categoria'));
    }

    public function update(Request $request, $codCategoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:Categoria,nombre,' . $codCategoria . ',codCategoria',
        ]);

        $categoria = Categoria::findOrFail($codCategoria);
        $categoria->nombre = $request->nombre;
        $categoria->save();

        return redirect()->route('categoria.index')->with('success', 'Categoría modificada exitosamente.');
    }

    public function destroy($codCategoria)
{
    try {
        $categoria = Categoria::findOrFail($codCategoria);
        $categoria->delete();

        return redirect()->route('categoria.index')->with('success', 'Categoría eliminada con éxito.');
    } catch (QueryException $e) {
        return redirect()->route('categoria.index')->with('error', 'No se puede eliminar el tipo de usuario porque tiene registros relacionados.');
    }
}
}
