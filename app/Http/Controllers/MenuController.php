<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class MenuController extends Controller
{
    /**
     * Muestra el menú basado en el tipo de usuario.
     */
    public function index()
    {
        // Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return Redirect::to('/');
        }

        // Obtiene el tipo de usuario del usuario autenticado
        $tipoUsuarioId = Auth::user()->codTipoUsuarioF;

        // Consulta los menús que correspondan al tipo de usuario y que no tengan un menú padre
        $menus = Menu::where('codTipoUsuarioF', $tipoUsuarioId)
            ->whereNull('padreId')
            ->with('hijos')
            ->get();

        // Pasa los menús a la vista
        return view('layouts.plantilla', compact('menus'));
    }
}
