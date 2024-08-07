@extends('layouts.plantilla')

@section('title', 'Registrar Servicio')

@section('content')
<div class="container">
    <h1 class="text-center my-4">REGISTRAR SERVICIO</h1>
    <form action="{{ route('servicio.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3 row">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre:</label>
            <div class="col-sm-9">
                <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="descripcion" class="col-sm-3 col-form-label">Descripción:</label>
            <div class="col-sm-9">
                <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" rows="3" required>{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="capacidad" class="col-sm-3 col-form-label">Capacidad:</label>
            <div class="col-sm-9">
                <input type="number" id="capacidad" class="form-control @error('capacidad') is-invalid @enderror" name="capacidad" value="{{ old('capacidad') }}" required>
                @error('capacidad')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="codHorarioF" class="col-sm-3 col-form-label">Horario:</label>
            <div class="col-sm-9">
                <select id="codHorarioF" class="form-select @error('codHorarioF') is-invalid @enderror" name="codHorarioF" required>
                    <option value="">Seleccione un horario</option>
                    @foreach($horarios as $horario)
                        <option value="{{ $horario->codHorario }}" {{ old('codHorarioF') == $horario->codHorario ? 'selected' : '' }}>
                            Hora Inicio: {{ $horario->horaInicio }} - Hora Fin: {{ $horario->horaFin }}
                        </option>
                    @endforeach
                </select>
                @error('codHorarioF')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('servicio.index') }}" class="btn btn-secondary me-3">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>

<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endsection
