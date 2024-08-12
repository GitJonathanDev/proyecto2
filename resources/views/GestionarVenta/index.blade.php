@extends('layouts.plantilla')

@section('title', 'Gestionar Ventas')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-12 text-center">
            <h1 class="mb-3 fw-bold">LISTA DE VENTAS</h1>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('venta.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Registrar Venta
            </a>
            <form action="{{ route('venta.index') }}" method="get">
                <div class="input-group">
                    <select name="criterio" class="form-select">
                        <option value="fechaVenta">Fecha</option>
                        <option value="codClienteF">ID Cliente</option>
                        <option value="codEncargadoF">ID Encargado</option>
                    </select>
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar Venta" aria-label="Buscar Venta" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Código de Venta</th>
                            <th scope="col">Fecha de Venta</th>
                            <th scope="col">Monto Total</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Encargado</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                        <tr>
                            <td>{{ $venta->codVenta }}</td>
                            <td>{{ \Carbon\Carbon::parse($venta->fechaVenta)->format('d/m/Y') }}</td>
                            <td>{{ number_format($venta->montoTotal, 2) }} Bs.</td>
                            <td>{{ $venta->cliente->nombre }}</td>
                            <td>{{ $venta->encargado->nombre }}</td>
                            <td>
                                <a href="{{ route('venta.show', $venta->codVenta) }}" class="btn btn-info btn-sm" title="Ver Detalle">
                                    <i class="fas fa-eye"></i> Ver Detalle
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 d-flex justify-content-between">
            @if ($ventas->currentPage() > 1)
            <a href="{{ $ventas->previousPageUrl() }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Anterior
            </a>
            @endif

            @if ($ventas->hasMorePages())
            <a href="{{ $ventas->nextPageUrl() }}" class="btn btn-primary">
                Siguiente <i class="fas fa-arrow-right"></i>
            </a>
            @endif
        </div>
    </div>

    @if (session('delete'))
    <div class="row mt-3">
        <div class="col-12">
            <div class="alert alert-success">
                {{ session('delete') }}
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
