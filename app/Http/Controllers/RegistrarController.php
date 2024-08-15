<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrarController extends Controller
{
    public function create()
    {
        return view('IniciarSesion.registrar');
    }

    public function store(Request $request)
{

    $usuario = new User();
    $usuario->nombreUsuario = $request->name;
    $usuario->email = $request->email;
    $usuario->password = $request->password;
    $usuario->codTipoUsuarioF = 1; 
    $usuario->save();

    // Crear nuevo cliente
    $cliente = new Cliente();
    $cliente->carnetIdentidad = $request->carnetIdentidad;
    $cliente->nombre = $request->nombre;
    $cliente->apellidoPaterno = $request->apellidoPaterno;
    $cliente->apellidoMaterno = $request->apellidoMaterno;
    $cliente->edad = $request->edad;
    $cliente->sexo = $request->sexo;
    $cliente->telefono = $request->telefono;
    $cliente->codUsuarioF = $usuario->codUsuario; 
    $cliente->save();

    // Autenticar al usuario
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        return redirect()->route('cliente');
    } else {
        return redirect()->back()->with('error', 'Error al autenticar al usuario');
    }
}
}
