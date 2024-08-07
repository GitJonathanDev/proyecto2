<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrarController extends Controller
{
    public function create()
    {
        return view('IniciarSesion.registrar');
    }

    public function store(Request $request)
    {
        // Crear nuevo usuario
        $usuario = new User();
        $usuario->nombreUsuario = $request->name;
        $usuario->email = $request->email;
        $usuario->password = $request->password; // Suponiendo que la encriptación se maneja en otro lugar
        $usuario->codTipoUsuarioF = 1; // Asignar el tipo de usuario
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
        $cliente->codUsuarioF = $usuario->codUsuario; // Asegúrate de que este campo está correctamente definido
        $cliente->save();

        // Autenticar al usuario
        auth()->login($usuario);

        return redirect()->route('cliente.index'); // Redirigir al listado de clientes
    }
}
