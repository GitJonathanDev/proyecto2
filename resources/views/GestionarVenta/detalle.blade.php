@extends('layouts.plantilla')

@section('title', 'Detalle de la Venta')

@section('content')

<div class="container">
    <h1>Detalle de Venta</h1>
    <h2>Venta realizada el: {{ \Carbon\Carbon::parse($venta->fechaVenta)->format('d-m-Y') }}</h2>

    <div class="mt-4">
        <h3>Productos Vendidos</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($detalleVenta as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ number_format($detalle->precioV, 2, ',', '.') }}</td>
                    <td>{{ number_format($detalle->cantidad * $detalle->precioV, 2, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No se han encontrado detalles de venta.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <h3>Total de la Venta</h3>
        <p>{{ number_format($venta->montoTotal, 2, ',', '.') }}</p>
    </div>

    <div class="mt-4">
        <h3>Información de Pago</h3>
        <p>Monto Pagado: {{ number_format($pago->monto, 2, ',', '.') }}</p>
        <p>Estado del Pago: {{ $pago->estado }}</p>
    </div>

    <a href="{{ route('venta.index') }}" class="btn btn-primary">Volver a la Lista de Ventas</a>
</div>

@endsection
