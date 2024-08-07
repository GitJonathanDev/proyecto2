@extends('layouts.plantilla')

@section('title', 'Modificar Servicio')

@section('content')
<div class="container">
    <h2 class="text-center my-4">EDITAR SERVICIO</h2>
    <form action="{{ route('servicio.update', $servicio->codServicio) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="nombre" class="form-label">Nombre:</label>
            </div>
            <div class="col-md-9">
                <input type="text" id="nombre" class="form-control" name="nombre" value="{{ old('nombre', $servicio->nombre) }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="descripcion" class="form-label">Descripción:</label>
            </div>
            <div class="col-md-9">
                <textarea id="descripcion" class="form-control" name="descripcion" rows="3" required>{{ old('descripcion', $servicio->descripcion) }}</textarea>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="capacidad" class="form-label">Capacidad:</label>
            </div>
            <div class="col-md-9">
                <input type="number" id="capacidad" class="form-control" name="capacidad" value="{{ old('capacidad', $servicio->capacidad) }}" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="codHorarioF" class="form-label">Horario:</label>
            <select id="codHorarioF" class="form-control" name="codHorarioF" required>
                @foreach ($horarios as $horario)
                    <option value="{{ $horario->codHorario }}" {{ $horario->codHorario == $servicio->codHorarioF ? 'selected' : '' }}>
                        Hora inicio: {{ $horario->horaInicio }} - Hora fin: {{ $horario->horaFin }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('servicio.index') }}" class="btn btn-secondary mr-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-pencil-alt"></i> Modificar
            </button>
        </div>
    </form>
</div>
@endsection
