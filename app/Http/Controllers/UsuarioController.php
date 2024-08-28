<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TipoUsuario;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class UsuarioController extends Controller
{
    public function index(Request $request)
{
    $criterio = $request->input('criterio', 'nombreUsuario'); 
    $buscar = $request->input('buscar', '');

    $query = User::where('codUsuario', '!=', 2); 

    if (!empty($buscar)) {
        $query->where($criterio, 'like', '%'.$buscar.'%');
    }

    $usuarios = $query->paginate(5);

    return view('GestionarUsuario.index', compact('usuarios'));
}

    public function create()
    {
        $tiposUsuario = TipoUsuario::all();
        return view('GestionarUsuario.create', compact('tiposUsuario'));
    }

    public function store(Request $request)
    {
        // Crear nuevo usuario
        User::create([
            'nombreUsuario' => $request->input('nombreUsuario'),
            'email' => $request->input('email'),
            'password' => $request->input('password'), 
            'codTipoUsuarioF' => $request->input('codTipoUsuarioF'),
        ]);

        return redirect()->route('usuario.index')->with('success', 'Usuario registrado con éxito.');
    }


    public function edit($codUsuario)
    {
        $usuario = User::where('codUsuario', $codUsuario)->firstOrFail();
        $tiposUsuario = TipoUsuario::all();
        return view('GestionarUsuario.edit', compact('usuario', 'tiposUsuario'));
    }


    public function update(Request $request, $codUsuario)
    {
        $usuario = User::where('codUsuario', $codUsuario)->firstOrFail();
        $usuario->nombreUsuario = $request->input('nombreUsuario');
        $usuario->email = $request->input('email');

        if (!empty($request->input('password'))) {
            $usuario->password = $request->input('password'); 
        }

        $usuario->codTipoUsuarioF = $request->input('codTipoUsuarioF');
        $usuario->save();

        return redirect()->route('usuario.index')->with('success', 'Usuario actualizado con éxito.');
    }


    public function destroy($codUsuario)
    {
        try {
            $usuario = User::where('codUsuario', $codUsuario)->firstOrFail();
            $usuario->delete();
    
            return redirect()->route('usuario.index')->with('success', 'Usuario eliminado con éxito.');
        } catch (QueryException $e) {
            return redirect()->route('usuario.index')->with('error', 'No se puede eliminar el usuario porque tiene registros relacionados.');
        }
    }
    public function emailYaExiste(Request $request)
{
    $email = $request->input('email');
    $existe = User::where('email', $email)->exists();
    return response()->json(['existe' => $existe]);
}
}
