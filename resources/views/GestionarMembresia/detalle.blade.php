@extends('layouts.plantilla')

@section('title', 'Detalle de la venta de membresía')

@section('content')
<div class="container">
    <h1>Detalle de la Venta de Membresía</h1>
    
    @if ($detalleMembresia->isNotEmpty())
        <div class="mt-4">
            <h5>Total Precio Membresía: <strong>{{ number_format($detalleMembresia->first()->membresia->precioTotal, 2) }} Bs.</strong></h5>
        </div>

  
        <div class="mt-4">
            <h3>Servicios Adquiridos</h3>
            <table class="table table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Subtotal</th>
                        <th>Horario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalleMembresia as $detalle)
                    <tr>
                        <td>{{ $detalle->servicio->nombre }}</td>
                        <td>{{ $detalle->servicio->descripcion }}</td>
                        <td>{{ number_format($detalle->subTotal, 2) }} Bs.</td>
                        <td>
                            Hora Inicio: {{ $detalle->servicio->horario->horaInicio }}<br>
                            Hora Fin: {{ $detalle->servicio->horario->horaFin }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No se encontraron detalles de membresía.</p>
    @endif

    <div class="mt-4">
        <a href="{{ route('membresia.create') }}" class="btn btn-primary">Realizar Nueva Venta de Membresía</a>
        <a href="{{ route('membresia.index') }}" class="btn btn-success">Volver</a>
    </div>
</div>
@endsection
