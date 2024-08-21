@extends('layouts.plantilla')

@section('title', 'Registrar Vendedor')

@section('content')
<div class="container">
    <h1 class="text-center my-4">REGISTRAR ENCARGADO</h1>
    <form id="vendedor-form" action="{{ route('vendedor.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="form-group row mb-3">
            <label for="carnetIdentidad" class="col-sm-3 col-form-label">Cédula de identidad:</label>
            <div class="col-sm-9">
                <input type="text" id="carnetIdentidad" class="form-control @error('carnetIdentidad') is-invalid @enderror" name="carnetIdentidad" value="{{ old('carnetIdentidad') }}" required>
                <div id="carnetIdentidad-feedback" class="invalid-feedback">
                    * La cédula de identidad debe ser un número de entre 8 y 10 dígitos.
                </div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre:</label>
            <div class="col-sm-9">
                <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required>
                <div id="nombre-feedback" class="invalid-feedback">
                    * El nombre debe tener entre 3 y 30 caracteres.
                </div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="apellidoPaterno" class="col-sm-3 col-form-label">Apellido Paterno:</label>
            <div class="col-sm-9">
                <input type="text" id="apellidoPaterno" class="form-control @error('apellidoPaterno') is-invalid @enderror" name="apellidoPaterno" value="{{ old('apellidoPaterno') }}" required>
                <div id="apellidoPaterno-feedback" class="invalid-feedback">
                    * El apellido paterno debe tener entre 3 y 30 caracteres.
                </div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="apellidoMaterno" class="col-sm-3 col-form-label">Apellido Materno:</label>
            <div class="col-sm-9">
                <input type="text" id="apellidoMaterno" class="form-control @error('apellidoMaterno') is-invalid @enderror" name="apellidoMaterno" value="{{ old('apellidoMaterno') }}" required>
                <div id="apellidoMaterno-feedback" class="invalid-feedback">
                    * El apellido materno debe tener entre 3 y 30 caracteres.
                </div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="sexo" class="col-sm-3 col-form-label">Sexo:</label>
            <div class="col-sm-9">
                <select id="sexo" class="form-control @error('sexo') is-invalid @enderror" name="sexo" required>
                    <option value="">Selecciona el sexo</option>
                    <option value="masculino" {{ old('sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="femenino" {{ old('sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
                <div id="sexo-feedback" class="invalid-feedback">
                    * Debes seleccionar un sexo.
                </div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="edad" class="col-sm-3 col-form-label">Edad:</label>
            <div class="col-sm-9">
                <input type="number" id="edad" class="form-control @error('edad') is-invalid @enderror" name="edad" value="{{ old('edad') }}" required>
                <div id="edad-feedback" class="invalid-feedback">
                    * La edad debe ser un número entre 8 y 100 años.
                </div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="telefono" class="col-sm-3 col-form-label">Teléfono:</label>
            <div class="col-sm-9">
                <input type="tel" id="telefono" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" required>
                <div id="telefono-feedback" class="invalid-feedback">
                    * El teléfono debe ser un número de entre 8 y 10 dígitos.
                </div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="nombreUsuario" class="col-sm-3 col-form-label">Nombre de usuario:</label>
            <div class="col-sm-9">
                <input type="text" id="nombreUsuario" class="form-control @error('nombreUsuario') is-invalid @enderror" name="nombreUsuario" value="{{ old('nombreUsuario') }}" required>
                <div id="nombreUsuario-feedback" class="invalid-feedback">
                    * El nombre de usuario debe tener más de 3 caracteres.
                </div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="email" class="col-sm-3 col-form-label">Correo electrónico:</label>
            <div class="col-sm-9">
                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                <div id="email-feedback" class="invalid-feedback">
                    * El correo electrónico debe tener un formato válido.
                </div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="password" class="col-sm-3 col-form-label">Contraseña:</label>
            <div class="col-sm-9 position-relative">
                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                <button type="button" id="toggle-password" class="btn btn-outline-secondary position-absolute" style="top: 50%; right: 0; transform: translateY(-50%);">
                    <i class="fas fa-eye"></i>
                </button>
                <div id="password-feedback" class="invalid-feedback">
                    * La contraseña debe tener más de 8 caracteres.
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('vendedor.index') }}" class="btn btn-secondary">ATRÁS</a>
            <button type="submit" id="submit-button" class="btn btn-primary" disabled>GUARDAR</button>
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
        const edadInput = document.getElementById('edad');
        const telefonoInput = document.getElementById('telefono');
        const nombreUsuarioInput = document.getElementById('nombreUsuario');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const submitButton = document.getElementById('submit-button');

        const carnetIdentidadFeedback = document.getElementById('carnetIdentidad-feedback');
        const nombreFeedback = document.getElementById('nombre-feedback');
        const apellidoPaternoFeedback = document.getElementById('apellidoPaterno-feedback');
        const apellidoMaternoFeedback = document.getElementById('apellidoMaterno-feedback');
        const sexoFeedback = document.getElementById('sexo-feedback');
        const edadFeedback = document.getElementById('edad-feedback');
        const telefonoFeedback = document.getElementById('telefono-feedback');
        const nombreUsuarioFeedback = document.getElementById('nombreUsuario-feedback');
        const emailFeedback = document.getElementById('email-feedback');
        const passwordFeedback = document.getElementById('password-feedback');

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

        function validateEdad() {
            const edad = edadInput.value.trim();
            const isValid = /^\d{1,2}$/.test(edad) && edad >= 8 && edad <= 100;
            if (!isValid) {
                edadFeedback.textContent = '* La edad debe ser un número entre 8 y 100 años.';
                edadInput.classList.add('is-invalid');
                edadInput.classList.remove('is-valid');
                return false;
            } else {
                edadFeedback.textContent = '';
                edadInput.classList.remove('is-invalid');
                edadInput.classList.add('is-valid');
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

        function validateNombreUsuario() {
            const nombreUsuario = nombreUsuarioInput.value.trim();
            const isValid = nombreUsuario.length > 3;
            if (!isValid) {
                nombreUsuarioFeedback.textContent = '* El nombre de usuario debe tener más de 3 caracteres.';
                nombreUsuarioInput.classList.add('is-invalid');
                nombreUsuarioInput.classList.remove('is-valid');
                return false;
            } else {
                nombreUsuarioFeedback.textContent = '';
                nombreUsuarioInput.classList.remove('is-invalid');
                nombreUsuarioInput.classList.add('is-valid');
                return true;
            }
        }

        function validateEmail() {
            const email = emailInput.value.trim();
            const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            if (!isValid) {
                emailFeedback.textContent = '* El correo electrónico debe tener un formato válido.';
                emailInput.classList.add('is-invalid');
                emailInput.classList.remove('is-valid');
                return false;
            } else {
                emailFeedback.textContent = '';
                emailInput.classList.remove('is-invalid');
                emailInput.classList.add('is-valid');
                return true;
            }
        }

        function validatePassword() {
            const password = passwordInput.value.trim();
            const isValid = password.length > 8;
            if (!isValid) {
                passwordFeedback.textContent = '* La contraseña debe tener más de 8 caracteres.';
                passwordInput.classList.add('is-invalid');
                passwordInput.classList.remove('is-valid');
                return false;
            } else {
                passwordFeedback.textContent = '';
                passwordInput.classList.remove('is-invalid');
                passwordInput.classList.add('is-valid');
                return true;
            }
        }

        function updateSubmitButtonState() {
            const isValid = validateCarnetIdentidad() &&
                            validateNombre() &&
                            validateApellidoPaterno() &&
                            validateApellidoMaterno() &&
                            validateSexo() &&
                            validateEdad() &&
                            validateTelefono() &&
                            validateNombreUsuario() &&
                            validateEmail() &&
                            validatePassword();
            submitButton.disabled = !isValid;
        }

        carnetIdentidadInput.addEventListener('input', updateSubmitButtonState);
        nombreInput.addEventListener('input', updateSubmitButtonState);
        apellidoPaternoInput.addEventListener('input', updateSubmitButtonState);
        apellidoMaternoInput.addEventListener('input', updateSubmitButtonState);
        sexoInput.addEventListener('change', updateSubmitButtonState);
        edadInput.addEventListener('input', updateSubmitButtonState);
        telefonoInput.addEventListener('input', updateSubmitButtonState);
        nombreUsuarioInput.addEventListener('input', updateSubmitButtonState);
        emailInput.addEventListener('input', updateSubmitButtonState);
        passwordInput.addEventListener('input', updateSubmitButtonState);

        document.getElementById('toggle-password').addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
    });
</script>
@endsection
@endsection
