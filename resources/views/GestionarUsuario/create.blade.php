@extends('layouts.plantilla')

@section('title', 'Registrar Usuario')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Registrar Usuario</h1>

    <form id="usuario-form" action="{{ route('usuario.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3 row">
            <label for="nombreUsuario" class="col-sm-3 col-form-label">Nombre:</label>
            <div class="col-sm-9">
                <input type="text" id="nombreUsuario" class="form-control" name="nombreUsuario" value="{{ old('nombreUsuario') }}" required>
                <div id="nombreUsuario-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="email" class="col-sm-3 col-form-label">Email:</label>
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

        <div class="mb-3 row">
            <label for="codTipoUsuarioF" class="col-sm-3 col-form-label">Tipo de Usuario:</label>
            <div class="col-sm-9">
                <select id="codTipoUsuarioF" class="form-select" name="codTipoUsuarioF" required>
                    <option value="" disabled>Seleccionar tipo de usuario</option>
                    @foreach ($tiposUsuario as $tipoUsuario)
                        <option value="{{ $tipoUsuario->codTipoUsuario }}">{{ $tipoUsuario->descripcion }}</option>
                    @endforeach
                </select>
                <div id="codTipoUsuarioF-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('usuario.index') }}" class="btn btn-secondary me-3">
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
