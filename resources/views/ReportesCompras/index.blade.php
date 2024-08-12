@extends('layouts.plantilla')

@section('title', 'Generar Reporte de Compras')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Generar Reporte de Compras por Rango de Fechas</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('reporte.generar1') }}" method="GET">
                @csrf
            
                <div class="form-group">
                    <label for="fecha_inicio">Fecha de inicio:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="fecha_fin">Fecha de fin:</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Generar Reporte</button>
            </form>
        </div>
    </div>
</div>
@endsection
