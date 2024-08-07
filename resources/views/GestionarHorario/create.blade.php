@extends('layouts.plantilla')

@section('title', 'Registrar Horario')

@section('content')
<div class="container">
    <h1 class="text-center my-4">REGISTRAR HORARIO</h1>
    <form action="{{ route('horario.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3 row">
            <label for="horaInicio" class="col-sm-3 col-form-label">Hora de inicio:</label>
            <div class="col-sm-9">
                <input type="time" id="horaInicio" class="form-control @error('horaInicio') is-invalid @enderror" name="horaInicio" value="{{ old('horaInicio') }}" required>
                @error('horaInicio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="horaFin" class="col-sm-3 col-form-label">Hora de fin:</label>
            <div class="col-sm-9">
                <input type="time" id="horaFin" class="form-control @error('horaFin') is-invalid @enderror" name="horaFin" value="{{ old('horaFin') }}" required>
                @error('horaFin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('horario.index') }}" class="btn btn-secondary me-3">
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
