@extends('layouts.plantilla')

@section('title', 'Modificar Cliente')

@section('content')
<div class="container">
    <h2 class="text-center my-4">EDITAR CLIENTE</h2>
    <form id="clienteForm" action="{{ route('cliente.update', $cliente->carnetIdentidad) }}" method="POST" class="needs-validation" novalidate>
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
            <label for="carnetidentidad" class="col-md-3 col-form-label">Cédula de identidad:</label>
            <div class="col-md-9">
                <input type="text" id="carnetidentidad" class="form-control @error('carnetIdentidad') is-invalid @enderror" name="carnetIdentidad" value="{{ old('carnetIdentidad', $cliente->carnetIdentidad) }}" required>
                @error('carnetIdentidad')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="ci-error" class="invalid-feedback" style="display: none;">
                    Esta cédula de identidad ya está registrada. Por favor, introduce otra.
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="nombre" class="col-md-3 col-form-label">Nombre:</label>
            <div class="col-md-9">
                <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="nombre-error" class="invalid-feedback" style="display: none;">
                    El nombre debe tener entre 3 y 30 caracteres y no puede contener números ni caracteres especiales.
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="apellidoPaterno" class="col-md-3 col-form-label">Apellido Paterno:</label>
            <div class="col-md-9">
                <input type="text" id="apellidoPaterno" class="form-control @error('apellidoPaterno') is-invalid @enderror" name="apellidoPaterno" value="{{ old('apellidoPaterno', $cliente->apellidoPaterno) }}" required>
                @error('apellidoPaterno')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="apellido-paterno-error" class="invalid-feedback" style="display: none;">
                    El apellido paterno debe tener entre 3 y 30 caracteres y no puede contener números ni caracteres especiales.
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="apellidoMaterno" class="col-md-3 col-form-label">Apellido Materno:</label>
            <div class="col-md-9">
                <input type="text" id="apellidoMaterno" class="form-control @error('apellidoMaterno') is-invalid @enderror" name="apellidoMaterno" value="{{ old('apellidoMaterno', $cliente->apellidoMaterno) }}" required>
                @error('apellidoMaterno')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="apellido-materno-error" class="invalid-feedback" style="display: none;">
                    El apellido materno debe tener entre 3 y 30 caracteres y no puede contener números ni caracteres especiales.
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="sexo" class="col-md-3 col-form-label">Sexo:</label>
            <div class="col-md-9">
                <select id="sexo" class="form-control @error('sexo') is-invalid @enderror" name="sexo" required>
                    <option value="" disabled>Selecciona el sexo</option>
                    <option value="masculino" {{ old('sexo', $cliente->sexo) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="femenino" {{ old('sexo', $cliente->sexo) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
                @error('sexo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="sexo-error" class="invalid-feedback" style="display: none;">
                    Por favor, selecciona una opción para el sexo.
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="telefono" class="col-md-3 col-form-label">Teléfono:</label>
            <div class="col-md-9">
                <input type="tel" id="telefono" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" required>
                @error('telefono')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="telefono-error" class="invalid-feedback" style="display: none;">
                    El teléfono debe tener entre 8 y 10 dígitos numéricos.
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="edad" class="col-md-3 col-form-label">Edad:</label>
            <div class="col-md-9">
                <input type="number" id="edad" class="form-control @error('edad') is-invalid @enderror" name="edad" value="{{ old('edad', $cliente->edad) }}" required>
                @error('edad')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="edad-error" class="invalid-feedback" style="display: none;">
                    La edad debe ser un número entre 8 y 100 años.
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('cliente.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-pencil-alt"></i> Modificar
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carnetIdentidadInput = document.getElementById('carnetidentidad');
        const nombreInput = document.getElementById('nombre');
        const apellidoPaternoInput = document.getElementById('apellidoPaterno');
        const apellidoMaternoInput = document.getElementById('apellidoMaterno');
        const sexoInput = document.getElementById('sexo');
        const telefonoInput = document.getElementById('telefono');
        const edadInput = document.getElementById('edad');
        const form = document.getElementById('clienteForm');
        const ciError = document.getElementById('ci-error');
        const nombreError = document.getElementById('nombre-error');
        const apellidoPaternoError = document.getElementById('apellido-paterno-error');
        const apellidoMaternoError = document.getElementById('apellido-materno-error');
        const sexoError = document.getElementById('sexo-error');
        const telefonoError = document.getElementById('telefono-error');
        const edadError = document.getElementById('edad-error');

        function validateCarnetIdentidad() {
            const carnetIdentidad = carnetIdentidadInput.value.trim();
            const isValid = /^\d{8,10}$/.test(carnetIdentidad);
            if (!isValid) {
                carnetIdentidadInput.classList.add('is-invalid');
                carnetIdentidadInput.classList.remove('is-valid');
                ciError.style.display = 'block';
            } else {
                carnetIdentidadInput.classList.add('is-valid');
                carnetIdentidadInput.classList.remove('is-invalid');
                ciError.style.display = 'none';
            }
            return isValid;
        }

        function validateNombre() {
            const nombre = nombreInput.value.trim();
            const isValid = /^[a-zA-Z\s]{3,30}$/.test(nombre);
            if (!isValid) {
                nombreInput.classList.add('is-invalid');
                nombreInput.classList.remove('is-valid');
                nombreError.style.display = 'block';
            } else {
                nombreInput.classList.add('is-valid');
                nombreInput.classList.remove('is-invalid');
                nombreError.style.display = 'none';
            }
            return isValid;
        }

        function validateApellidoPaterno() {
            const apellidoPaterno = apellidoPaternoInput.value.trim();
            const isValid = /^[a-zA-Z\s]{3,30}$/.test(apellidoPaterno);
            if (!isValid) {
                apellidoPaternoInput.classList.add('is-invalid');
                apellidoPaternoInput.classList.remove('is-valid');
                apellidoPaternoError.style.display = 'block';
            } else {
                apellidoPaternoInput.classList.add('is-valid');
                apellidoPaternoInput.classList.remove('is-invalid');
                apellidoPaternoError.style.display = 'none';
            }
            return isValid;
        }

        function validateApellidoMaterno() {
            const apellidoMaterno = apellidoMaternoInput.value.trim();
            const isValid = /^[a-zA-Z\s]{3,30}$/.test(apellidoMaterno);
            if (!isValid) {
                apellidoMaternoInput.classList.add('is-invalid');
                apellidoMaternoInput.classList.remove('is-valid');
                apellidoMaternoError.style.display = 'block';
            } else {
                apellidoMaternoInput.classList.add('is-valid');
                apellidoMaternoInput.classList.remove('is-invalid');
                apellidoMaternoError.style.display = 'none';
            }
            return isValid;
        }

        function validateSexo() {
            const sexo = sexoInput.value.trim();
            const isValid = sexo !== '';
            if (!isValid) {
                sexoInput.classList.add('is-invalid');
                sexoInput.classList.remove('is-valid');
                sexoError.style.display = 'block';
            } else {
                sexoInput.classList.add('is-valid');
                sexoInput.classList.remove('is-invalid');
                sexoError.style.display = 'none';
            }
            return isValid;
        }

        function validateTelefono() {
            const telefono = telefonoInput.value.trim();
            const isValid = /^\d{8,10}$/.test(telefono);
            if (!isValid) {
                telefonoInput.classList.add('is-invalid');
                telefonoInput.classList.remove('is-valid');
                telefonoError.style.display = 'block';
            } else {
                telefonoInput.classList.add('is-valid');
                telefonoInput.classList.remove('is-invalid');
                telefonoError.style.display = 'none';
            }
            return isValid;
        }

        function validateEdad() {
            const edad = edadInput.value.trim();
            const isValid = /^\d{1,2}$/.test(edad) && edad >= 8 && edad <= 100;
            if (!isValid) {
                edadInput.classList.add('is-invalid');
                edadInput.classList.remove('is-valid');
                edadError.style.display = 'block';
            } else {
                edadInput.classList.add('is-valid');
                edadInput.classList.remove('is-invalid');
                edadError.style.display = 'none';
            }
            return isValid;
        }

        function validateForm() {
            return validateCarnetIdentidad() &&
                   validateNombre() &&
                   validateApellidoPaterno() &&
                   validateApellidoMaterno() &&
                   validateSexo() &&
                   validateTelefono() &&
                   validateEdad();
        }

        carnetIdentidadInput.addEventListener('input', function() {
            if (validateCarnetIdentidad()) {
                var ci = carnetIdentidadInput.value.trim();
                if (ciYaExiste(ci)) {
                    ciError.style.display = 'block';
                    carnetIdentidadInput.classList.add('is-invalid');
                } else {
                    ciError.style.display = 'none';
                    carnetIdentidadInput.classList.remove('is-invalid');
                }
            }
        });

        nombreInput.addEventListener('input', validateNombre);
        apellidoPaternoInput.addEventListener('input', validateApellidoPaterno);
        apellidoMaternoInput.addEventListener('input', validateApellidoMaterno);
        sexoInput.addEventListener('change', validateSexo);
        telefonoInput.addEventListener('input', validateTelefono);
        edadInput.addEventListener('input', validateEdad);

        form.addEventListener('submit', function(event) {
            if (!validateForm()) {
                event.preventDefault();
                event.stopPropagation();
            }
        });

        function ciYaExiste(ci) {
            var existe = false;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route("ci-ya-existe") }}', false);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.send('ci=' + ci);
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                existe = response.existe;
            }
            return existe;
        }
    });
</script>
@endsection
