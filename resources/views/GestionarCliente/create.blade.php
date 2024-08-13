@extends('layouts.plantilla')

@section('title', 'Registrar Cliente')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Registrar Cliente</h1>
    <form id="cliente-form" action="{{ route('cliente.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3 row">
            <label for="carnetIdentidad" class="col-sm-3 col-form-label">Cédula de identidad:</label>
            <div class="col-sm-9">
                <input type="text" id="carnetIdentidad" class="form-control" name="carnetIdentidad" value="{{ old('carnetIdentidad') }}" required>
                <div id="carnetIdentidad-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre:</label>
            <div class="col-sm-9">
                <input type="text" id="nombre" class="form-control" name="nombre" value="{{ old('nombre') }}" required>
                <div id="nombre-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="apellidoPaterno" class="col-sm-3 col-form-label">Apellido Paterno:</label>
            <div class="col-sm-9">
                <input type="text" id="apellidoPaterno" class="form-control" name="apellidoPaterno" value="{{ old('apellidoPaterno') }}" required>
                <div id="apellidoPaterno-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="apellidoMaterno" class="col-sm-3 col-form-label">Apellido Materno:</label>
            <div class="col-sm-9">
                <input type="text" id="apellidoMaterno" class="form-control" name="apellidoMaterno" value="{{ old('apellidoMaterno') }}" required>
                <div id="apellidoMaterno-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="sexo" class="col-sm-3 col-form-label">Sexo:</label>
            <div class="col-sm-9">
                <select id="sexo" class="form-select" name="sexo" required>
                    <option value="" disabled>Selecciona el sexo</option>
                    <option value="masculino" {{ old('sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="femenino" {{ old('sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
                <div id="sexo-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="edad" class="col-sm-3 col-form-label">Edad:</label>
            <div class="col-sm-9">
                <input type="number" id="edad" class="form-control" name="edad" value="{{ old('edad') }}" required>
                <div id="edad-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="telefono" class="col-sm-3 col-form-label">Teléfono:</label>
            <div class="col-sm-9">
                <input type="tel" id="telefono" class="form-control" name="telefono" value="{{ old('telefono') }}" required>
                <div id="telefono-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="nombreUsuario" class="col-sm-3 col-form-label">Nombre de usuario:</label>
            <div class="col-sm-9">
                <input type="text" id="nombreUsuario" class="form-control" name="nombreUsuario" value="{{ old('nombreUsuario') }}" required>
                <div id="nombreUsuario-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="email" class="col-sm-3 col-form-label">Correo electrónico:</label>
            <div class="col-sm-9">
                <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" required>
                <div id="email-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="password" class="col-sm-3 col-form-label">Contraseña:</label>
            <div class="col-sm-9 position-relative">
                <input type="password" id="password" class="form-control" name="password" required>
                <button type="button" id="toggle-password" class="btn btn-outline-secondary position-absolute" style="top: 50%; right: 0; transform: translateY(-50%);">
                    <i class="fas fa-eye"></i>
                </button>
                <div id="password-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('cliente.index') }}" class="btn btn-secondary me-3">
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
            } else {
                carnetIdentidadFeedback.textContent = '';
                carnetIdentidadInput.classList.add('is-valid');
                carnetIdentidadInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateNombre() {
            const nombre = nombreInput.value.trim();
            const isValid = nombre.length > 2 && nombre.length < 31;
            if (!isValid) {
                nombreFeedback.textContent = '* El nombre debe tener entre 3 y 30 caracteres.';
                nombreInput.classList.add('is-invalid');
                nombreInput.classList.remove('is-valid');
            } else {
                nombreFeedback.textContent = '';
                nombreInput.classList.add('is-valid');
                nombreInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateApellidoPaterno() {
            const apellidoPaterno = apellidoPaternoInput.value.trim();
            const isValid = apellidoPaterno.length > 2 && apellidoPaterno.length < 31;
            if (!isValid) {
                apellidoPaternoFeedback.textContent = '* El apellido paterno debe tener entre 3 y 30 caracteres.';
                apellidoPaternoInput.classList.add('is-invalid');
                apellidoPaternoInput.classList.remove('is-valid');
            } else {
                apellidoPaternoFeedback.textContent = '';
                apellidoPaternoInput.classList.add('is-valid');
                apellidoPaternoInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateApellidoMaterno() {
            const apellidoMaterno = apellidoMaternoInput.value.trim();
            const isValid = apellidoMaterno.length > 2 && apellidoMaterno.length < 31;
            if (!isValid) {
                apellidoMaternoFeedback.textContent = '* El apellido materno debe tener entre 3 y 30 caracteres.';
                apellidoMaternoInput.classList.add('is-invalid');
                apellidoMaternoInput.classList.remove('is-valid');
            } else {
                apellidoMaternoFeedback.textContent = '';
                apellidoMaternoInput.classList.add('is-valid');
                apellidoMaternoInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateSexo() {
            const isValid = sexoInput.value !== '';
            if (!isValid) {
                sexoFeedback.textContent = '* Debes seleccionar un sexo.';
                sexoInput.classList.add('is-invalid');
                sexoInput.classList.remove('is-valid');
            } else {
                sexoFeedback.textContent = '';
                sexoInput.classList.add('is-valid');
                sexoInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateEdad() {
            const edad = edadInput.value.trim();
            const isValid = /^\d{1,2}$/.test(edad) && edad >= 8 && edad <= 100;
            if (!isValid) {
                edadFeedback.textContent = '* La edad debe ser un número entre 8 y 100 años.';
                edadInput.classList.add('is-invalid');
                edadInput.classList.remove('is-valid');
            } else {
                edadFeedback.textContent = '';
                edadInput.classList.add('is-valid');
                edadInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateTelefono() {
            const telefono = telefonoInput.value.trim();
            const isValid = /^\d{8,10}$/.test(telefono);
            if (!isValid) {
                telefonoFeedback.textContent = '* El teléfono debe ser un número de entre 8 y 10 dígitos.';
                telefonoInput.classList.add('is-invalid');
                telefonoInput.classList.remove('is-valid');
            } else {
                telefonoFeedback.textContent = '';
                telefonoInput.classList.add('is-valid');
                telefonoInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateNombreUsuario() {
            const nombreUsuario = nombreUsuarioInput.value.trim();
            const isValid = nombreUsuario.length > 3;
            if (!isValid) {
                nombreUsuarioFeedback.textContent = '* El nombre de usuario debe tener más de 3 caracteres.';
                nombreUsuarioInput.classList.add('is-invalid');
                nombreUsuarioInput.classList.remove('is-valid');
            } else {
                nombreUsuarioFeedback.textContent = '';
                nombreUsuarioInput.classList.add('is-valid');
                nombreUsuarioInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateEmail() {
            const email = emailInput.value.trim();
            const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            if (!isValid) {
                emailFeedback.textContent = '* El correo electrónico debe tener un formato válido.';
                emailInput.classList.add('is-invalid');
                emailInput.classList.remove('is-valid');
            } else {
                emailFeedback.textContent = '';
                emailInput.classList.add('is-valid');
                emailInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validatePassword() {
            const password = passwordInput.value.trim();
            const isValid = password.length > 8;
            if (!isValid) {
                passwordFeedback.textContent = '* La contraseña debe tener más de 8 caracteres.';
                passwordInput.classList.add('is-invalid');
                passwordInput.classList.remove('is-valid');
            } else {
                passwordFeedback.textContent = '';
                passwordInput.classList.add('is-valid');
                passwordInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateForm() {
            const isCarnetIdentidadValid = validateCarnetIdentidad();
            const isNombreValid = validateNombre();
            const isApellidoPaternoValid = validateApellidoPaterno();
            const isApellidoMaternoValid = validateApellidoMaterno();
            const isSexoValid = validateSexo();
            const isEdadValid = validateEdad();
            const isTelefonoValid = validateTelefono();
            const isNombreUsuarioValid = validateNombreUsuario();
            const isEmailValid = validateEmail();
            const isPasswordValid = validatePassword();

            submitButton.disabled = !(isCarnetIdentidadValid && isNombreValid && isApellidoPaternoValid && isApellidoMaternoValid && isSexoValid && isEdadValid && isTelefonoValid && isNombreUsuarioValid && isEmailValid && isPasswordValid);
        }

        function restrictInputToNumbers(input) {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, ''); 
            });
        }

        restrictInputToNumbers(carnetIdentidadInput);
        restrictInputToNumbers(telefonoInput);
        restrictInputToNumbers(edadInput);

        carnetIdentidadInput.addEventListener('input', function() {
            validateCarnetIdentidad();
            validateForm();
        });

        nombreInput.addEventListener('input', function() {
            validateNombre();
            validateForm();
        });

        apellidoPaternoInput.addEventListener('input', function() {
            validateApellidoPaterno();
            validateForm();
        });

        apellidoMaternoInput.addEventListener('input', function() {
            validateApellidoMaterno();
            validateForm();
        });

        sexoInput.addEventListener('change', function() {
            validateSexo();
            validateForm();
        });

        edadInput.addEventListener('input', function() {
            validateEdad();
            validateForm();
        });

        telefonoInput.addEventListener('input', function() {
            validateTelefono();
            validateForm();
        });

        nombreUsuarioInput.addEventListener('input', function() {
            validateNombreUsuario();
            validateForm();
        });

        emailInput.addEventListener('input', function() {
            validateEmail();
            validateForm();
        });

        passwordInput.addEventListener('input', function() {
            validatePassword();
            validateForm();
        });

        document.getElementById('toggle-password').addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        // Validar al cargar la página
        validateForm();
    });
</script>
@endsection
@endsection
