<?php

namespace App\Http\Controllers;

use App\Models\Encargado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class VendedorController extends Controller
{
    public function index(Request $request)
    {
        $criterio = $request->input('criterio', 'nombre');
        $buscar = $request->input('buscar', '');
    
        $query = Encargado::where('carnetIdentidad', '!=', '11111111');
    
        if ($buscar != '') {
            $query->where($criterio, 'like', '%' . $buscar . '%');
        }
    
        $vendedores = $query->paginate(5);
    
        return view('GestionarVendedor.index', compact('vendedores'));
    }
    
    public function create()
    {
        $usuarios = User::all();
        return view('GestionarVendedor.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        // Crear el usuario
        $user = User::create([
            'nombreUsuario' => $request->input('nombreUsuario'),
            'email' => $request->input('email'),
            'password' => $request->input('password'), 
            'codTipoUsuarioF' => 2, 
        ]);

        // Crear el encargado
        $vendedor = new Encargado();
        $vendedor->carnetIdentidad = $request->input('carnetIdentidad');
        $vendedor->nombre = $request->input('nombre');
        $vendedor->apellidoPaterno = $request->input('apellidoPaterno');
        $vendedor->apellidoMaterno = $request->input('apellidoMaterno');
        $vendedor->sexo = $request->input('sexo');
        $vendedor->edad = $request->input('edad');
        $vendedor->telefono = $request->input('telefono');
        $vendedor->codUsuarioF = $user->codUsuario; 
        $vendedor->save();

        return redirect()->route('vendedor.index')->with('success', 'Encargado registrado exitosamente.');
    }

    public function edit($carnetIdentidad)
    {
        $vendedor = Encargado::where('carnetIdentidad', $carnetIdentidad)->firstOrFail();
        return view('GestionarVendedor.edit', compact('vendedor'));
    }

    public function update(Request $request, $carnetIdentidad)
    {
        // Obtener el vendedor
        $vendedor = Encargado::where('carnetIdentidad', $carnetIdentidad)->firstOrFail();

        // Actualizar los datos del vendedor
        $vendedor->nombre = $request->input('nombre');
        $vendedor->apellidoPaterno = $request->input('apellidoPaterno');
        $vendedor->apellidoMaterno = $request->input('apellidoMaterno');
        $vendedor->sexo = $request->input('sexo');
        $vendedor->telefono = $request->input('telefono');
        $vendedor->save();

        return redirect()->route('vendedor.index')->with('success', 'Encargado actualizado exitosamente.');
    }

    public function destroy($carnetIdentidad)
{
    try {
        $vendedor = Encargado::where('carnetIdentidad', $carnetIdentidad)->firstOrFail();
        $vendedor->delete();

        return redirect()->route('vendedor.index')->with('success', 'Encargado eliminado exitosamente.');
    } catch (QueryException $e) {
        return redirect()->route('vendedor.index')->with('error', 'No se puede eliminar el encargado porque tiene registros relacionados.');
    } catch (\Exception $e) {
        return redirect()->route('vendedor.index')->with('error', 'No se puede eliminar el encargado debido a un error inesperado.');
    }
}

    public function ciYaExiste(Request $request)
    {
        $request->validate([
            'carnetIdentidad' => 'required|integer',
        ]);

        $ci = $request->input('carnetIdentidad');
        $existe = Encargado::where('carnetIdentidad', $ci)->exists();
        return response()->json(['existe' => $existe]);
    }
}
