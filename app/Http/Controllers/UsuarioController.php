<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TipoUsuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Muestra una lista de los usuarios.
     */
    public function index(Request $request)
    {
        $criterio = $request->input('criterio', 'nombreUsuario'); // Por defecto, usar 'nombreUsuario'
        $buscar = $request->input('buscar', '');

        $query = User::query();

        if (!empty($buscar)) {
            $query->where($criterio, 'like', '%'.$buscar.'%');
        }

        $usuarios = $query->paginate(5);

        return view('GestionarUsuario.index', compact('usuarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        $tiposUsuario = TipoUsuario::all();
        return view('GestionarUsuario.create', compact('tiposUsuario'));
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        // Crear nuevo usuario
        User::create([
            'nombreUsuario' => $request->input('nombreUsuario'),
            'email' => $request->input('email'),
            'password' => $request->input('password'), // No encriptar la contraseña
            'codTipoUsuarioF' => $request->input('codTipoUsuarioF'),
        ]);

        return redirect()->route('usuario.index')->with('success', 'Usuario registrado con éxito.');
    }

    /**
     * Muestra el formulario para editar el usuario especificado.
     */
    public function edit($codUsuario)
    {
        $usuario = User::where('codUsuario', $codUsuario)->firstOrFail();
        $tiposUsuario = TipoUsuario::all();
        return view('GestionarUsuario.edit', compact('usuario', 'tiposUsuario'));
    }

    /**
     * Actualiza el usuario especificado en la base de datos.
     */
    public function update(Request $request, $codUsuario)
    {
        $usuario = User::where('codUsuario', $codUsuario)->firstOrFail();
        $usuario->nombreUsuario = $request->input('nombreUsuario');
        $usuario->email = $request->input('email');

        if (!empty($request->input('password'))) {
            $usuario->password = $request->input('password'); // No encriptar la contraseña
        }

        $usuario->codTipoUsuarioF = $request->input('codTipoUsuarioF');
        $usuario->save();

        return redirect()->route('usuario.index')->with('success', 'Usuario actualizado con éxito.');
    }

    /**
     * Elimina el usuario especificado de la base de datos.
     */
    public function destroy($codUsuario)
    {
        $usuario = User::where('codUsuario', $codUsuario)->firstOrFail();
        $usuario->delete();

        return redirect()->route('usuario.index')->with('success', 'Usuario eliminado con éxito.');
    }
}
