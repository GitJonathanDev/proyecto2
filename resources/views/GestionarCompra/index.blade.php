@extends('layouts.plantilla')

@section('title', 'Gestionar Compras')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-12 text-center">
            <h1 class="mb-3 fw-bold">LISTA DE COMPRAS</h1>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('compra.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Registrar Compra
            </a>
            <form action="{{ route('compra.index') }}" method="get">
                <div class="input-group">
                    <select name="criterio" class="form-select">
                        <option value="fechaCompra">Fecha</option>
                        <option value="codProveedorF">ID Proveedor</option>
                    </select>
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar Compra" aria-label="Buscar Compra" aria-describedby="button-addon2">
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
                            <th scope="col">Código de Compra</th>
                            <th scope="col">Fecha de Compra</th>
                            <th scope="col">Monto Total</th>
                            <th scope="col">Proveedor</th>
                            <th scope="col">Encargado</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($compras as $compra)
                        <tr>
                            <td>{{ $compra->codCompra }}</td>
                            <td>{{ \Carbon\Carbon::parse($compra->fechaCompra)->format('d/m/Y') }}</td>
                            <td>{{ number_format($compra->montoTotal, 2) }} Bs.</td>
                            <td>{{ $compra->proveedor->nombre }}</td>
                            <td>{{ $compra->encargado->nombre }}</td>
                            <td>
                                <a href="{{ route('compra.show', $compra->codCompra) }}" class="btn btn-info btn-sm" title="Ver Detalle">
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

    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-between">
            @if ($compras->currentPage() > 1)
            <a href="{{ $compras->previousPageUrl() }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Anterior
            </a>
            @endif
            @if ($compras->hasMorePages())
            <a href="{{ $compras->nextPageUrl() }}" class="btn btn-primary">
                Siguiente <i class="fas fa-arrow-right"></i>
            </a>
            @endif
        </div>
    </div>

    @if (session('delete'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success mt-3">
                {{ session('delete') }}
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
