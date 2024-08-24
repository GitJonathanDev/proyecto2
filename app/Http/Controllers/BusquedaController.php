<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BusquedaController extends Controller
{
    private $tablasExcluir = [
        'migrations', 'visitaspagina', 'sessions', 
        'cache', 'cache_locks', 'failed_jobs', 
        'jobs', 'jobs_batches', 'menu'
    ];

    public function buscar(Request $request)
    {
        set_time_limit(120); 
        $consulta = $request->input('query');
        $resultados = [];

        if (!$consulta) {
            return response()->json($resultados);
        }

        try {
            // Obtener tablas excluyendo las especificadas
            $tablas = DB::table('pg_tables')
                ->select('tablename')
                ->where('schemaname', 'public')
                ->whereNotIn('tablename', $this->tablasExcluir)
                ->pluck('tablename');

            foreach ($tablas as $nombreTabla) {
                // Obtener columnas para la tabla actual
                $columnas = DB::table('information_schema.columns')
                    ->select('column_name')
                    ->where('table_name', $nombreTabla)
                    ->pluck('column_name');

                foreach ($columnas as $nombreColumna) {
                    // Realizar búsqueda en la columna actual de la tabla
                    $resultadosBusqueda = DB::table($nombreTabla)
                        ->select($nombreColumna)
                        ->where($nombreColumna, 'ILIKE', '%' . $consulta . '%')
                        ->limit(10)
                        ->get();

                    if ($resultadosBusqueda->isNotEmpty()) {
                        if (!isset($resultados[$nombreTabla])) {
                            $resultados[$nombreTabla] = [];
                        }
                        $resultados[$nombreTabla][] = [
                            'columna' => $nombreColumna,
                            'coincidencias' => $resultadosBusqueda->pluck($nombreColumna)->all()
                        ];
                    }
                }
            }

            return response()->json($resultados);

        } catch (\Exception $e) {
            Log::error('Error en la búsqueda: ' . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error en la búsqueda'], 500);
        }
    }
}
