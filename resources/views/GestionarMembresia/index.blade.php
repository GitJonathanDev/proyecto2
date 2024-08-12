@extends('layouts.plantilla')

@section('title', 'Gestionar Membresías')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-12 text-center">
            <h1 class="mb-3 fw-bold">LISTA DE MEMBRESÍAS</h1>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('membresia.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Registrar Membresía
            </a>
            <form action="{{ route('membresia.index') }}" method="get">
                <div class="input-group">
                    <select name="criterio" class="form-select">
                        <option value="descripcion">Descripción</option>
                   
                    </select>
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar Membresía" aria-label="Buscar Membresía" aria-describedby="button-addon2">
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
                            <th scope="col">Código Membresía</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Precio Total</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Encargado</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($membresias as $membresia)
                        <tr>
                            <td>{{ $membresia->codMembresia }}</td>
                            <td>{{ $membresia->descripcion }}</td>
                            <td>Bs. {{ number_format($membresia->precioTotal, 2) }}</td>
                            <td>{{ $membresia->cliente->nombre ?? 'No disponible' }}</td>
                            <td>{{ $membresia->encargado->nombre ?? 'No disponible' }}</td>
                            <td>
                                <a href="{{ route('membresia.show', $membresia->codMembresia) }}" class="btn btn-info btn-sm" title="Ver Detalle">
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
            @if ($membresias->currentPage() > 1)
            <a href="{{ $membresias->previousPageUrl() }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Anterior
            </a>
            @endif
            @if ($membresias->hasMorePages())
            <a href="{{ $membresias->nextPageUrl() }}" class="btn btn-primary">
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
