@extends('layouts.plantilla')

@section('title', 'Resultado del Reporte de Ventas')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Resultado del Reporte de Ventas por Rango de Fechas</h3>
        </div>
        <div class="card-body">
            <p><strong>Fecha de inicio:</strong> {{ $startDate }}</p>
            <p><strong>Fecha de fin:</strong> {{ $endDate }}</p>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Fecha de Venta</th>
                            <th scope="col">Monto Total</th>
                            <th scope="col">Encargado</th>
                            <th scope="col">Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                        <tr>
                            <td>{{ $venta->codVenta }}</td>
                            <td>{{ $venta->fechaVenta->format('d/m/Y') }}</td>
                            <td>{{ $venta->montoTotal }}</td>
                            <td>{{ $venta->encargado->nombre }}</td>
                            <td>{{ $venta->cliente->nombre }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <a href="{{ route('reportes.ventas') }}" class="btn btn-primary">Volver</a>
        </div>
    </div>
</div>
@endsection
