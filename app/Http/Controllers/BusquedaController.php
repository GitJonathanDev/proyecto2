<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusquedaController extends Controller
{
    public function buscar(Request $request)
    {
        $consulta = $request->input('query');
        $resultados = [];

        $tablasExcluir = ['migrations', 'visitaspagina', 'sessions', 'cache', 'cache_locks', 'failed_jobs', 'jobs', 'jobs_batches', 'menu'];

        if ($consulta) {
            $tablas = DB::select('SHOW TABLES');

            foreach ($tablas as $tabla) {
                $nombreTabla = $tabla->{'Tables_in_' . env('DB_DATABASE')};

                if (in_array($nombreTabla, $tablasExcluir)) {
                    continue;
                }

                $clavePrimaria = $this->obtenerClavePrimaria($nombreTabla);
                $columnas = DB::select('SHOW COLUMNS FROM ' . $nombreTabla);

                foreach ($columnas as $columna) {
                    $nombreColumna = $columna->Field;

                    $resultadosBusqueda = DB::table($nombreTabla)
                        ->where($nombreColumna, 'LIKE', '%' . $consulta . '%')
                        ->get([$nombreColumna, $clavePrimaria]);

                    if ($resultadosBusqueda->isNotEmpty()) {
                        foreach ($resultadosBusqueda as $resultado) {
                            $resultados[$nombreTabla][] = [
                                'id' => $resultado->$clavePrimaria,
                                'columna' => $nombreColumna,
                                'valor' => $resultado->$nombreColumna,
                                'nombreTabla' => $nombreTabla
                            ];
                        }
                    }
                }
            }
        }

        return response()->json($resultados);
    }

    public function obtenerDetallesRegistro(Request $request, $nombreTabla, $idRegistro)
    {
        $clavePrimaria = $this->obtenerClavePrimaria($nombreTabla);

        if (!$clavePrimaria) {
            return response()->json(['error' => 'Clave primaria no encontrada'], 400);
        }

        $registro = DB::table($nombreTabla)
            ->where($clavePrimaria, $idRegistro)
            ->first();

        if ($registro) {
            return response()->json($registro);
        } else {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }
    }

    private function obtenerClavePrimaria($nombreTabla)
    {
        $resultado = DB::select('SHOW KEYS FROM ' . $nombreTabla . ' WHERE Key_name = "PRIMARY"');
        return $resultado[0]->Column_name ?? null; 
    }
}