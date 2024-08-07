<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\VisitasPagina;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra cualquier binding de servicio en el contenedor de servicios.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap cualquier servicio de aplicación.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        static $haContadoVisita = false;

        View::composer('*', function ($view) use ($request, &$haContadoVisita) {
            $ruta = $request->path();

            if (!$haContadoVisita) {
                DB::transaction(function () use ($ruta) {
                    $visitasPagina = VisitasPagina::firstOrNew(['nombrePagina' => $ruta]);
                    
                    $visitasPagina->conteoVisitas = $visitasPagina->exists ? $visitasPagina->conteoVisitas + 1 : 1;
                
                    $visitasPagina->save();
                });
                $haContadoVisita = true;
            }

            $conteoVisitas = VisitasPagina::where('nombrePagina', $ruta)->value('conteoVisitas');
            $view->with('conteoVisitas', $conteoVisitas);

            if (Auth::check()) {
                $idTipoUsuario = Auth::user()->codTipoUsuarioF; 
                
                $menus = Menu::where('codTipoUsuarioF', $idTipoUsuario) 
                    ->whereNull('padreId')
                    ->with('hijos')
                    ->get();
                
                $view->with('menus', $menus);
            }
        });
    }
}
