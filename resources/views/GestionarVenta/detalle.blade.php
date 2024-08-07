@extends('layouts.plantilla')

@section('title', 'Detalle de la venta')

@section('content')

<div class="container">
    <h1>Detalle de venta</h1>
    <h2>Venta realizada el: {{ $venta->fechaventa }}</h2>
    <h3>ID Cliente: {{ $venta->idcliente }}</h3>
    <h3>ID Encargado: {{ $venta->idencargado }}</h3>
    <h3>Monto Total: {{ $venta->montoTotal }}</h3>

    <!-- Tabla de productos comprados -->
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
                @foreach ($detalleVenta as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ $detalle->preciov }}</td>
                    <td>{{ $detalle->cantidad * $detalle->preciov }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Botón para anular la venta -->
    <form action="{{ route('venta.anular', $venta->id) }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="btn btn-danger">Anular Venta</button>
    </form>

    <a href="{{ route('venta.index') }}" class="btn btn-primary mt-3">Volver a la Lista de Ventas</a>
</div>

@endsection
