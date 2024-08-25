<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\TipoUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class MenuController extends Controller
{
    public function index()
    {

        if (!Auth::check()) {
            return Redirect::to('/');
        }


        $tipoUsuarioId = Auth::user()->codTipoUsuarioF;

        $menus = Menu::where('codTipoUsuarioF', $tipoUsuarioId)
            ->whereNull('padreId')
            ->with('hijos')
            ->get();


        return view('layouts.plantilla', compact('menus'));
    }
    public function create()
    {
        $tiposUsuario = TipoUsuario::all();
        return view('GestionarMenu.create', compact('tiposUsuario'));
    }


    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $tiposUsuario = TipoUsuario::all();
        return view('GestionarMenu.edit', compact('menu', 'tiposUsuario'));
    }

    public function index2(Request $request)
    {
        $criterio = $request->criterio;
        $buscar = $request->buscar;
    
        $query = Menu::query();
    
        if ($buscar) {
            $query->where($criterio, 'like', '%' . $buscar . '%');
        }
    

        $menus = $query->get();
    
        $tiposUsuario = TipoUsuario::all();
    
        return view('GestionarMenu.index', compact('menus', 'tiposUsuario'));
    }
    public function store(Request $request)
    {
        $menu = new Menu();
        $menu->nombre = $request->nombre;
        $menu->url = $request->url;
        $menu->icono = $request->icono;
        $menu->codTipoUsuarioF = $request->codTipoUsuarioF;
        $menu->padreId = $request->padreId;
        $menu->save();

        return back()->with('success', 'Menú registrado con éxito.');
    }

    public function update(Request $request, $id)
    {

        $menu = Menu::findOrFail($id);
        $menu->nombre = $request->nombre;
        $menu->url = $request->url;
        $menu->icono = $request->icono;
        $menu->codTipoUsuarioF = $request->codTipoUsuarioF;
        $menu->padreId = $request->padreId;
        $menu->save();

        return back()->with('success', 'Menú actualizado con éxito.');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menu.index2')->with('success', 'Menú eliminado con éxito.');
    }
    public function clone($id)
{
    $menu = Menu::findOrFail($id);

    $newMenu = $menu->replicate(); 
    $newMenu->nombre .= ' - Copia';
    $newMenu->save();

    return back()->with('success', 'Menú clonado con éxito.');
}
}
