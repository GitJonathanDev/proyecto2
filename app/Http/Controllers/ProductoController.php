<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $criterio = $request->input('criterio', 'nombre');
        $buscar = $request->input('buscar', '');

        $query = Producto::query();

        if ($buscar != '') {
            $query->where($criterio, 'like', '%' . $buscar . '%');
        }

        $productos = $query->paginate(5);

        $categorias = Categoria::all();

        return view('GestionarProducto.index', compact('productos', 'criterio', 'buscar', 'categorias'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('GestionarProducto.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $imageUrl = null;

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/uploads'), $fileName);
            $imageUrl = $fileName;
        }

        Producto::create([
            'codProducto' => $request->codProducto,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => 0,
            'codCategoriaF' => $request->codCategoriaF,
            'imagen_url' => $imageUrl,
        ]);

        return redirect()->route('producto.index')->with('success', 'Producto creado exitosamente.');
    }

    public function edit($codProducto)
    {
        $producto = Producto::findOrFail($codProducto);
        $categorias = Categoria::all();

        return view('GestionarProducto.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, $codProducto)
    {
        $producto = Producto::findOrFail($codProducto);
    
        if ($request->hasFile('imagen')) {
            if ($producto->imagen_url) {
                $path = public_path('storage/uploads/' . $producto->imagen_url);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
    
            $file = $request->file('imagen');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/uploads'), $fileName);
            $producto->imagen_url = $fileName;
        }
    
        $producto->update([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'precio' => $request->input('precio'),
            'codCategoriaF' => $request->input('codCategoriaF'),
        ]);
    
        return redirect()->route('producto.index')->with('success', 'Producto actualizado con éxito.');
    }

    public function destroy($codProducto)
{
    try {

        $producto = Producto::findOrFail($codProducto);

        $producto->delete();
        if ($producto->imagen_url) {
            $path = storage_path('app/public/uploads/' . $producto->imagen_url);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        return redirect()->route('producto.index')->with('success', 'Producto eliminado con éxito.');
    } catch (QueryException $e) {
        return redirect()->route('producto.index')->with('error', 'No se puede eliminar este producto porque tiene registros relacionados.');
    }
}

    public function buscar(Request $request)
    {
        $nombre = $request->input('nombre', '');

        $productos = Producto::where('nombre', 'like', '%' . $nombre . '%')->get();

        return response()->json($productos);
    }
}
