@extends('layouts.plantilla')

@section('title', 'Gestionar horario')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="mb-3 fw-bold">LISTA DE HORARIOS</h1>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('horario.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Registrar Horario</a>
            <form action="{{ route('horario.index') }}" method="POST">
                @csrf
                <div class="input-group">
                    <select name="criterio" class="form-select">
                        <option value="horaInicio">Hora de inicio</option>
                        <option value="horaFin">Hora de fin</option>
                    </select>
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar" aria-label="Buscar">
                    <button class="btn btn-outline-secondary" type="submit">
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
                            <th>Código</th>
                            <th>Hora de Inicio</th>
                            <th>Hora de Fin</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($horarios as $horario)
                        <tr>
                            <td>{{ $horario->codHorario }}</td>
                            <td>{{ $horario->horaInicio }}</td>
                            <td>{{ $horario->horaFin }}</td>
                            <td>
                                <a href="{{ route('horario.edit', $horario->codHorario) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Editar</a>

                                <form action="{{ route('horario.destroy', $horario->codHorario) }}" method="POST" class="d-inline">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este horario?')"><i class="fas fa-trash"></i> Eliminar</button>
                                </form>
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
            @if ($horarios->previousPageUrl())
            <a href="{{ $horarios->previousPageUrl() }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Anterior
            </a>
            @endif
            @if ($horarios->nextPageUrl())
            <a href="{{ $horarios->nextPageUrl() }}" class="btn btn-primary">
                Siguiente <i class="fas fa-arrow-right"></i>
            </a>
            @endif
        </div>
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
@endsection
