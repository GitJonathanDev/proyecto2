@extends('layouts.plantilla')

@section('title', 'Modificar Usuario')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center my-4">EDITAR USUARIO</h2>
                </div>
                <div class="card-body">
                    <form id="usuario-form" action="{{ route('usuario.update', $usuario->codUsuario) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombreUsuario" class="form-label">Nombre:</label>
                            <input type="text" id="nombreUsuario" class="form-control" name="nombreUsuario" value="{{ old('nombreUsuario', $usuario->nombreUsuario) }}" required>
                            <div id="nombreUsuario-feedback" class="invalid-feedback"></div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" class="form-control" name="email" value="{{ old('email', $usuario->email) }}" required>
                            <div id="email-feedback" class="invalid-feedback"></div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña:</label>
                            <div class="input-group">
                                <input type="password" id="password" class="form-control" name="password">
                                <button type="button" id="toggle-password" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="password-feedback" class="invalid-feedback"></div>
                        </div>

                        <div class="mb-3">
                            <label for="codTipoUsuarioF" class="form-label">Tipo de Usuario:</label>
                            <select name="codTipoUsuarioF" id="codTipoUsuarioF" class="form-select" required>
                                @foreach ($tiposUsuario as $tipoUsuario)
                                    <option value="{{ $tipoUsuario->codTipoUsuario }}" {{ old('codTipoUsuarioF', $usuario->codTipoUsuarioF) == $tipoUsuario->codTipoUsuario ? 'selected' : '' }}>
                                        {{ $tipoUsuario->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="codTipoUsuarioF-feedback" class="invalid-feedback"></div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('usuario.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Atrás
                            </a>
                            <button type="submit" id="submit-button" class="btn btn-primary">
                                <i class="fas fa-pencil-alt"></i> Modificar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nombreUsuarioInput = document.getElementById('nombreUsuario');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const codTipoUsuarioFInput = document.getElementById('codTipoUsuarioF');
        const submitButton = document.getElementById('submit-button');

        const nombreUsuarioFeedback = document.getElementById('nombreUsuario-feedback');
        const emailFeedback = document.getElementById('email-feedback');
        const passwordFeedback = document.getElementById('password-feedback');
        const codTipoUsuarioFFeedback = document.getElementById('codTipoUsuarioF-feedback');

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
            // Contraseña opcional en este formulario
            if (password.length > 0) {
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
            // Si el campo de contraseña está vacío, no validar
            passwordInput.classList.remove('is-invalid', 'is-valid');
            passwordFeedback.textContent = '';
            return true;
        }

        function validateCodTipoUsuarioF() {
            const isValid = codTipoUsuarioFInput.value !== '';
            if (!isValid) {
                codTipoUsuarioFFeedback.textContent = '* Debes seleccionar un tipo de usuario.';
                codTipoUsuarioFInput.classList.add('is-invalid');
                codTipoUsuarioFInput.classList.remove('is-valid');
            } else {
                codTipoUsuarioFFeedback.textContent = '';
                codTipoUsuarioFInput.classList.add('is-valid');
                codTipoUsuarioFInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateForm() {
            const isNombreUsuarioValid = validateNombreUsuario();
            const isEmailValid = validateEmail();
            const isPasswordValid = validatePassword();
            const isCodTipoUsuarioFValid = validateCodTipoUsuarioF();

            submitButton.disabled = !(isNombreUsuarioValid && isEmailValid && isPasswordValid && isCodTipoUsuarioFValid);
        }

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

        codTipoUsuarioFInput.addEventListener('change', function() {
            validateCodTipoUsuarioF();
            validateForm();
        });

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var icon = document.querySelector('#password + .btn i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.getElementById('toggle-password').addEventListener('click', togglePasswordVisibility);

        // Validar al cargar la página
        validateForm();
    });
</script>
@endsection
