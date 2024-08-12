@extends('layouts.plantilla')

@section('title', 'Registrar Categoría')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Registrar Categoría</h1>

    <form id="categoria-form" action="{{ route('categoria.store') }}" method="POST">
        @csrf

        <div class="mb-3 row">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre:</label>
            <div class="col-sm-9">
                <input type="text" id="nombre" class="form-control" name="nombre" value="{{ old('nombre') }}" placeholder="Ingrese el nombre de la categoría" required>
                <div id="nombre-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success mt-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="text-center">
            <a href="{{ route('categoria.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" id="submit-button" class="btn btn-primary" disabled>
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nombreInput = document.getElementById('nombre');
        const submitButton = document.getElementById('submit-button');
        const feedback = document.getElementById('nombre-feedback');

        function validateNombre() {
            const nombre = nombreInput.value.trim();
            let isValid = true;

            if (nombre.length === 0) {
                feedback.textContent = '* El campo no puede estar vacío.';
                nombreInput.classList.add('is-invalid');
                nombreInput.classList.remove('is-valid');
                isValid = false;
            } else if (nombre.length < 4) {
                feedback.textContent = '* El nombre debe tener más de 4 caracteres.';
                nombreInput.classList.add('is-invalid');
                nombreInput.classList.remove('is-valid');
                isValid = false;
            } else if (nombre.length > 50) {
                feedback.textContent = '* El nombre debe tener menos de 50 caracteres.';
                nombreInput.classList.add('is-invalid');
                nombreInput.classList.remove('is-valid');
                isValid = false;
            } else {
                feedback.textContent = '';
                nombreInput.classList.add('is-valid');
                nombreInput.classList.remove('is-invalid');
            }

            submitButton.disabled = !isValid;
        }

        nombreInput.addEventListener('input', validateNombre);

        // Validar al cargar la página
        validateNombre();
    });
</script>
@endsection
@endsection
