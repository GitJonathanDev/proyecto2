<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = [];

        // Lista de tablas a excluir de la búsqueda
        $excludeTables = ['migrations', 'visitaspagina', 'sessions', 'cache', 'cache_locks', 'failed_jobs', 'jobs', 'jobs_batches', 'menu'];

        if ($query) {
            // Obtener todos los nombres de tablas
            $tables = DB::select('SHOW TABLES');

            foreach ($tables as $table) {
                $tableName = $table->{'Tables_in_' . env('DB_DATABASE')};

                // Saltar tablas que están en la lista de exclusión
                if (in_array($tableName, $excludeTables)) {
                    continue;
                }

                // Obtener todas las columnas de la tabla actual
                $columns = DB::select('SHOW COLUMNS FROM ' . $tableName);

                foreach ($columns as $column) {
                    $columnName = $column->Field;

                    // Buscar en cada columna
                    $searchResults = DB::table($tableName)
                        ->where($columnName, 'LIKE', '%' . $query . '%')
                        ->get([$columnName]);

                    if ($searchResults->isNotEmpty()) {
                        $results[$tableName][$columnName] = $searchResults;
                    }
                }
            }
        }

        // Devolver la respuesta JSON para AJAX
        return response()->json($results);
    }
}
