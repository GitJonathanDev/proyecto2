@extends('layouts.plantilla')

@section('title', 'Modificar Horario')

@section('content')
<div class="container">
    <h2 class="text-center my-4">EDITAR HORARIO</h2>
    <form action="{{ route('horario.update', $horario->codHorario) }}" method="POST">
        @csrf
        @method('PUT')
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-md-3">
                <label for="horaInicio" class="form-label">Hora de inicio:</label>
            </div>
            <div class="col-md-9">
                <input type="time" id="horaInicio" class="form-control @error('horaInicio') is-invalid @enderror" name="horaInicio" value="{{ old('horaInicio', $horario->horaInicio) }}" required>
                @error('horaInicio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="horaFin" class="form-label">Hora de fin:</label>
            </div>
            <div class="col-md-9">
                <input type="time" id="horaFin" class="form-control @error('horaFin') is-invalid @enderror" name="horaFin" value="{{ old('horaFin', $horario->horaFin) }}" required>
                @error('horaFin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('horario.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-pencil-alt"></i> Modificar
            </button>
        </div>
    </form>
</div>
@endsection
