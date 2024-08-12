@extends('layouts.plantilla')

@section('title', 'Gestionar Servicio')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="mb-3 fw-bold">LISTA DE SERVICIOS</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('servicio.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Registrar Servicio</a>
            <form action="{{ route('servicio.index') }}" method="GET" class="d-flex">
                @csrf
                <div class="input-group">
                    <select name="criterio" class="form-select">
                        <option value="nombre">Nombre</option>
                        <option value="descripcion">Descripción</option>
                        <option value="capacidad">Capacidad</option>
                    </select>
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar" aria-label="Buscar" aria-describedby="button-addon2">
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
                            <th>Código de Servicio</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Capacidad</th>
                            <th>Horario</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($servicios as $servicio)
                        <tr>
                            <td>{{ $servicio->codServicio }}</td> 
                            <td>{{ $servicio->nombre }}</td>
                            <td>{{ $servicio->descripcion }}</td>
                            <td>{{ $servicio->capacidad }}</td>
                            <td>
                                @if ($servicio->horario)
                                    Hora Inicio: {{ $servicio->horario->horaInicio }}<br>
                                    Hora Fin: {{ $servicio->horario->horaFin }}
                                @else
                                    No se ha definido un horario
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('servicio.edit', $servicio->codServicio) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('servicio.destroy', $servicio->codServicio) }}" method="POST" class="d-inline">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este servicio?')">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center">
            {{ $servicios->links() }} 
        </div>
    </div>

    @if (session('success'))
    <div class="row mt-3">
        <div class="col-12">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
