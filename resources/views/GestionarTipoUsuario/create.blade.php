@extends('layouts.plantilla')

@section('title', 'Registrar Tipo de Usuario')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Registrar Tipo de Usuario</h1>

    <form action="{{ route('tipoUsuario.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3 row">
            <label for="descripcion" class="col-sm-3 col-form-label">Descripción:</label>
            <div class="col-sm-9">
                <input type="text" id="descripcion" name="descripcion" value="{{ old('descripcion') }}" class="form-control @error('descripcion') is-invalid @enderror" placeholder="Ingrese la descripción del tipo de usuario" required>
                @error('descripcion')
                    <div class="invalid-feedback">
                        * {{ $message }}
                    </div>
                @enderror
                <div id="descripcion-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('tipoUsuario.index') }}" class="btn btn-secondary me-2">
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
        const descripcionInput = document.getElementById('descripcion');
        const submitButton = document.getElementById('submit-button');
        const descripcionFeedback = document.getElementById('descripcion-feedback');

        function validateDescripcion() {
            const descripcion = descripcionInput.value.trim();
            const isValid = descripcion.length > 2 && descripcion.length < 21;
            if (!isValid) {
                descripcionFeedback.textContent = '* La descripción debe tener entre 3 y 20 caracteres.';
                descripcionInput.classList.add('is-invalid');
                descripcionInput.classList.remove('is-valid');
            } else {
                descripcionFeedback.textContent = '';
                descripcionInput.classList.add('is-valid');
                descripcionInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateForm() {
            const isDescripcionValid = validateDescripcion();
            submitButton.disabled = !isDescripcionValid;
        }

        descripcionInput.addEventListener('input', function() {
            validateDescripcion();
            validateForm();
        });

        // Validar al cargar la página
        validateForm();
    });
</script>
@endsection
@endsection
