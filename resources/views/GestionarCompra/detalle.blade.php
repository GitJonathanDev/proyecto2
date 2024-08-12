@extends('layouts.plantilla')

@section('title', 'Detalle de la Compra')

@section('content')

<div class="container">
    <h1>Detalle de Compra</h1>
    <h2>Compra realizada el: {{ \Carbon\Carbon::parse($compra->fechaCompra)->format('d-m-Y') }}</h2>

    <div class="mt-4">
        <h3>Productos Comprados</h3>
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
                @forelse ($detalleCompra as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ number_format($detalle->precioC, 2, ',', '.') }}</td>
                    <td>{{ number_format($detalle->cantidad * $detalle->precioC, 2, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No se han encontrado detalles de compra.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <h3>Total de la Compra</h3>
        <p>{{ number_format($compra->montoTotal, 2, ',', '.') }}</p>
    </div>

    <a href="{{ route('compra.index') }}" class="btn btn-primary">Realizar Nueva Compra</a>
</div>

@endsection
