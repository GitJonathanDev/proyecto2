@extends('layouts.plantilla')

@section('title', 'Registrar Menú')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Registrar Menú</h1>

    <form id="menu-form" action="{{ route('menu.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" id="nombre" class="form-control" name="nombre" value="{{ old('nombre') }}" placeholder="Ingrese el nombre del menú" required>
            <div id="nombre-feedback" class="invalid-feedback"></div>
        </div>

        <div class="mb-3">
            <label for="url" class="form-label">URL:</label>
            <input type="text" id="url" class="form-control" name="url" value="{{ old('url') }}" placeholder="Ingrese la URL del menú" required>
        </div>

        <div class="mb-3">
            <label for="icono" class="form-label">Ícono:</label>
            <input type="text" id="icono" class="form-control" name="icono" value="{{ old('icono') }}" placeholder="Ingrese el ícono del menú">
        </div>

        <div class="mb-3">
            <label for="codTipoUsuarioF" class="form-label">Tipo de Usuario:</label>
            <select id="codTipoUsuarioF" class="form-select" name="codTipoUsuarioF" required>
                <option value="">Seleccione un tipo de usuario</option>
                @foreach($tiposUsuario as $tipo)
                    <option value="{{ $tipo->codTipoUsuario }}" {{ old('codTipoUsuarioF') == $tipo->codTipoUsuario ? 'selected' : '' }}>
                        {{ $tipo->descripcion }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="padreId" class="form-label">Menú Padre:</label>
            <input type="text" id="padreId" class="form-control" name="padreId" value="{{ old('padreId') }}" placeholder="Ingrese el ID del menú padre (opcional)">
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('menu.index2') }}" class="btn btn-secondary me-2">
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
