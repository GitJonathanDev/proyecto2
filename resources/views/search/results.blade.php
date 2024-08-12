<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .result-table {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .result-table h2 {
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .result-table h3 {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .no-results {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Resultados de Búsqueda para "{{ $query }}"</h1>

        @if (!empty($results))
            @foreach ($results as $table => $columns)
                <div class="result-table">
                    <h2>Tabla: {{ $table }}</h2>
                    @foreach ($columns as $column => $rows)
                        <h3>Columna: {{ $column }}</h3>
                        <ul class="list-group">
                            @foreach ($rows as $row)
                                <li class="list-group-item">{{ $row->$column }}</li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="no-results">
                <p class="lead">No se encontraron resultados.</p>
            </div>
        @endif
    </div>
</body>
</html>