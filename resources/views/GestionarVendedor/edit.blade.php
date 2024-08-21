@extends('layouts.plantilla')

@section('title', 'Modificar Vendedor')

@section('content')
<div class="container">
    <h2 class="text-center my-4">EDITAR ENCARGADO</h2>
    <form id="vendedor-form" action="{{ route('vendedor.update', $vendedor->carnetIdentidad) }}" method="POST" class="needs-validation" novalidate>
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
            <label for="carnetIdentidad" class="col-md-3 col-form-label">Cédula de Identidad:</label>
            <div class="col-md-9">
                <input type="text" id="carnetIdentidad" class="form-control @error('carnetIdentidad') is-invalid @enderror" name="carnetIdentidad" value="{{ old('carnetIdentidad', $vendedor->carnetIdentidad) }}" required>
                <div id="carnetIdentidad-feedback" class="invalid-feedback">
                    * La cédula de identidad debe ser un número de entre 8 y 10 dígitos.
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="nombre" class="col-md-3 col-form-label">Nombre:</label>
            <div class="col-md-9">
                <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $vendedor->nombre) }}" required>
                <div id="nombre-feedback" class="invalid-feedback">
                    * El nombre debe tener entre 3 y 30 caracteres y no debe contener números ni caracteres especiales.
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="apellidoPaterno" class="col-md-3 col-form-label">Apellido Paterno:</label>
            <div class="col-md-9">
                <input type="text" id="apellidoPaterno" class="form-control @error('apellidoPaterno') is-invalid @enderror" name="apellidoPaterno" value="{{ old('apellidoPaterno', $vendedor->apellidoPaterno) }}" required>
                <div id="apellidoPaterno-feedback" class="invalid-feedback">
                    * El apellido paterno debe tener entre 3 y 30 caracteres y no debe contener números ni caracteres especiales.
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="apellidoMaterno" class="col-md-3 col-form-label">Apellido Materno:</label>
            <div class="col-md-9">
                <input type="text" id="apellidoMaterno" class="form-control @error('apellidoMaterno') is-invalid @enderror" name="apellidoMaterno" value="{{ old('apellidoMaterno', $vendedor->apellidoMaterno) }}" required>
                <div id="apellidoMaterno-feedback" class="invalid-feedback">
                    * El apellido materno debe tener entre 3 y 30 caracteres y no debe contener números ni caracteres especiales.
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="sexo" class="col-md-3 col-form-label">Sexo:</label>
            <div class="col-md-9">
                <select id="sexo" class="form-control @error('sexo') is-invalid @enderror" name="sexo" required>
                    <option value="">Selecciona el sexo</option>
                    <option value="masculino" {{ old('sexo', $vendedor->sexo) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="femenino" {{ old('sexo', $vendedor->sexo) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
                <div id="sexo-feedback" class="invalid-feedback">
                    * Debes seleccionar un sexo.
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="telefono" class="col-md-3 col-form-label">Teléfono:</label>
            <div class="col-md-9">
                <input type="tel" id="telefono" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono', $vendedor->telefono) }}" required>
                <div id="telefono-feedback" class="invalid-feedback">
                    * El teléfono debe ser un número de entre 8 y 10 dígitos.
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('vendedor.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" id="submit-button" class="btn btn-primary">
                <i class="fas fa-pencil-alt"></i> Modificar
            </button>
        </div>
    </form>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carnetIdentidadInput = document.getElementById('carnetIdentidad');
        const nombreInput = document.getElementById('nombre');
        const apellidoPaternoInput = document.getElementById('apellidoPaterno');
        const apellidoMaternoInput = document.getElementById('apellidoMaterno');
        const sexoInput = document.getElementById('sexo');
        const telefonoInput = document.getElementById('telefono');
        const submitButton = document.getElementById('submit-button');

        const carnetIdentidadFeedback = document.getElementById('carnetIdentidad-feedback');
        const nombreFeedback = document.getElementById('nombre-feedback');
        const apellidoPaternoFeedback = document.getElementById('apellidoPaterno-feedback');
        const apellidoMaternoFeedback = document.getElementById('apellidoMaterno-feedback');
        const sexoFeedback = document.getElementById('sexo-feedback');
        const telefonoFeedback = document.getElementById('telefono-feedback');

        function validateCarnetIdentidad() {
            const carnetIdentidad = carnetIdentidadInput.value.trim();
            const isValid = /^\d{8,10}$/.test(carnetIdentidad);
            if (!isValid) {
                carnetIdentidadFeedback.textContent = '* La cédula de identidad debe ser un número de entre 8 y 10 dígitos.';
                carnetIdentidadInput.classList.add('is-invalid');
                carnetIdentidadInput.classList.remove('is-valid');
                return false;
            } else {
                carnetIdentidadFeedback.textContent = '';
                carnetIdentidadInput.classList.remove('is-invalid');
                carnetIdentidadInput.classList.add('is-valid');
                return true;
            }
        }

        function validateNombre() {
            const nombre = nombreInput.value.trim();
            const isValid = /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,30}$/.test(nombre);
            if (!isValid) {
                nombreFeedback.textContent = '* El nombre debe tener entre 3 y 30 caracteres y no debe contener números ni caracteres especiales.';
                nombreInput.classList.add('is-invalid');
                nombreInput.classList.remove('is-valid');
                return false;
            } else {
                nombreFeedback.textContent = '';
                nombreInput.classList.remove('is-invalid');
                nombreInput.classList.add('is-valid');
                return true;
            }
        }

        function validateApellidoPaterno() {
            const apellidoPaterno = apellidoPaternoInput.value.trim();
            const isValid = /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,30}$/.test(apellidoPaterno);
            if (!isValid) {
                apellidoPaternoFeedback.textContent = '* El apellido paterno debe tener entre 3 y 30 caracteres y no debe contener números ni caracteres especiales.';
                apellidoPaternoInput.classList.add('is-invalid');
                apellidoPaternoInput.classList.remove('is-valid');
                return false;
            } else {
                apellidoPaternoFeedback.textContent = '';
                apellidoPaternoInput.classList.remove('is-invalid');
                apellidoPaternoInput.classList.add('is-valid');
                return true;
            }
        }

        function validateApellidoMaterno() {
            const apellidoMaterno = apellidoMaternoInput.value.trim();
            const isValid = /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,30}$/.test(apellidoMaterno);
            if (!isValid) {
                apellidoMaternoFeedback.textContent = '* El apellido materno debe tener entre 3 y 30 caracteres y no debe contener números ni caracteres especiales.';
                apellidoMaternoInput.classList.add('is-invalid');
                apellidoMaternoInput.classList.remove('is-valid');
                return false;
            } else {
                apellidoMaternoFeedback.textContent = '';
                apellidoMaternoInput.classList.remove('is-invalid');
                apellidoMaternoInput.classList.add('is-valid');
                return true;
            }
        }

        function validateSexo() {
            const sexo = sexoInput.value.trim();
            const isValid = sexo !== '';
            if (!isValid) {
                sexoFeedback.textContent = '* Debes seleccionar un sexo.';
                sexoInput.classList.add('is-invalid');
                sexoInput.classList.remove('is-valid');
                return false;
            } else {
                sexoFeedback.textContent = '';
                sexoInput.classList.remove('is-invalid');
                sexoInput.classList.add('is-valid');
                return true;
            }
        }

        function validateTelefono() {
            const telefono = telefonoInput.value.trim();
            const isValid = /^\d{8,10}$/.test(telefono);
            if (!isValid) {
                telefonoFeedback.textContent = '* El teléfono debe ser un número de entre 8 y 10 dígitos.';
                telefonoInput.classList.add('is-invalid');
                telefonoInput.classList.remove('is-valid');
                return false;
            } else {
                telefonoFeedback.textContent = '';
                telefonoInput.classList.remove('is-invalid');
                telefonoInput.classList.add('is-valid');
                return true;
            }
        }

        function updateSubmitButtonState() {
            const isValid = validateCarnetIdentidad() &&
                            validateNombre() &&
                            validateApellidoPaterno() &&
                            validateApellidoMaterno() &&
                            validateSexo() &&
                            validateTelefono();
            submitButton.disabled = !isValid;
        }

        carnetIdentidadInput.addEventListener('input', updateSubmitButtonState);
        nombreInput.addEventListener('input', updateSubmitButtonState);
        apellidoPaternoInput.addEventListener('input', updateSubmitButtonState);
        apellidoMaternoInput.addEventListener('input', updateSubmitButtonState);
        sexoInput.addEventListener('change', updateSubmitButtonState);
        telefonoInput.addEventListener('input', updateSubmitButtonState);

        // Initialize form state
        updateSubmitButtonState();
    });
</script>
@endsection
@endsection
