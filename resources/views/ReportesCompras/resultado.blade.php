@extends('layouts.plantilla')

@section('title', 'Resultado del Reporte de Compras')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Resultado del Reporte de Compras por Rango de Fechas</h3>
        </div>
        <div class="card-body">
            <p><strong>Fecha de inicio:</strong> {{ $startDate }}</p>
            <p><strong>Fecha de fin:</strong> {{ $endDate }}</p>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Fecha de Compra</th>
                            <th scope="col">Monto Total</th>
                            <th scope="col">Encargado</th>
                            <th scope="col">Proveedor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($compras as $compra)
                        <tr>
                            <td>{{ $compra->id }}</td>
                            <td>{{ $compra->fechaCompra->format('d/m/Y') }}</td>
                            <td>{{ $compra->montoTotal }} Bs.</td>
                            <td>{{ $compra->encargado->nombre }}</td>
                            <td>{{ $compra->proveedor->nombre }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <a href="{{ route('reporte.index1') }}" class="btn btn-primary">Volver</a>
        </div>
    </div>
</div>
@endsection
