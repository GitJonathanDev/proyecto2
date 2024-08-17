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
            $tablas = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");

            foreach ($tablas as $tabla) {
                $nombreTabla = $tabla->tablename;

                if (in_array($nombreTabla, $tablasExcluir)) {
                    continue;
                }

                // Obtener la clave primaria de la tabla
                $clavePrimaria = $this->obtenerClavePrimaria($nombreTabla);
                if (!$clavePrimaria) {
                    continue;
                }

                // Obtener las columnas de la tabla
                $columnas = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name = ?", [$nombreTabla]);

                foreach ($columnas as $columna) {
                    $nombreColumna = $columna->column_name;

                    // Buscar coincidencias en la columna
                    $resultadosBusqueda = DB::table($nombreTabla)
                        ->where($nombreColumna, 'ILIKE', '%' . $consulta . '%')
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
        $resultado = DB::select("
            SELECT a.attname AS column_name
            FROM pg_index i
            JOIN pg_attribute a ON a.attnum = ANY(i.indkey)
            WHERE i.indrelid = ?::regclass AND i.indisprimary
        ", [$nombreTabla]);

        return $resultado[0]->column_name ?? null;
    }
}
