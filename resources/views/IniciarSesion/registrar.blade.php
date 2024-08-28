@extends('layouts.app')

@section('title', 'Registrar')

@section('content')

<style>
    body {
        background: linear-gradient(rgba(0, 1, 3, 0.7), rgba(0, 0, 0, 0.8)), url('{{ route('imagen.fondo') }}');
        background-size: cover;
        background-position: center center;
        height: 100vh;
        color: #fff;
    }
    .block {
        width: 100%;
        max-width: 400px;
        margin: 50px auto; 
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.9);
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .block h1 {
        font-size: 2rem;
        text-align: center;
        margin-bottom: 20px;
    }

    .block form {
        margin-top: 20px;
    }

    .block label {
        font-weight: bold;
        margin-bottom: 8px;
        display: block;
    }

    .block input[type=text], 
    .block input[type=email], 
    .block input[type=password], 
    .block input[type=number],
    .block select {
        width: 100%;
        padding: 10px;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #f5f5f5;
        margin-bottom: 10px;
    }

    .block .error-message {
        display: none;
        color: #dc3545;
        margin-top: 5px;
    }

    .block button.btn-primary {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .block button.btn-primary:hover {
        background-color: #0056b3;
    }

    .block button.btn-primary:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.5);
    }

    .password-container {
        position: relative;
        margin-bottom: 1rem;
    }

    .password-container button {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
    }

    .password-container button i {
        color: #007bff;
    }
</style>

<div class="block">
    <h1>Registrar Cliente</h1>
    <form id="cliente-form" action="{{ route('cliente.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <label for="carnetIdentidad">Cédula de identidad:</label>
        <input type="text" id="carnetIdentidad" name="carnetIdentidad" value="{{ old('carnetIdentidad') }}" required>
        <div id="carnetIdentidad-feedback" class="error-message"></div>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        <div id="nombre-feedback" class="error-message"></div>

        <label for="apellidoPaterno">Apellido Paterno:</label>
        <input type="text" id="apellidoPaterno" name="apellidoPaterno" value="{{ old('apellidoPaterno') }}" required>
        <div id="apellidoPaterno-feedback" class="error-message"></div>

        <label for="apellidoMaterno">Apellido Materno:</label>
        <input type="text" id="apellidoMaterno" name="apellidoMaterno" value="{{ old('apellidoMaterno') }}" required>
        <div id="apellidoMaterno-feedback" class="error-message"></div>

        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" required>
            <option value="" disabled selected>Selecciona el sexo</option>
            <option value="masculino" {{ old('sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
            <option value="femenino" {{ old('sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
        </select>
        <div id="sexo-feedback" class="error-message"></div>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" value="{{ old('edad') }}" required>
        <div id="edad-feedback" class="error-message"></div>

        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}" required>
        <div id="telefono-feedback" class="error-message"></div>

        <label for="nombreUsuario">Nombre de usuario:</label>
        <input type="text" id="nombreUsuario" name="nombreUsuario" value="{{ old('nombreUsuario') }}" required>
        <div id="nombreUsuario-feedback" class="error-message"></div>

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        <div id="email-feedback" class="error-message"></div>

        <div class="password-container">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <button type="button" id="toggle-password">
                <i class="fas fa-eye"></i>
            </button>
            <div id="password-feedback" class="error-message"></div>
        </div>

        <button type="submit" id="submit-button" class="btn-primary" disabled>Guardar</button>
    </form>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Código de validaciones y funcionalidad del botón de toggle para contraseña
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
                submitButton.disabled = true; 
            } else {
                carnetIdentidadFeedback.textContent = '';
                carnetIdentidadInput.classList.add('is-valid');
                carnetIdentidadInput.classList.remove('is-invalid');
                checkCarnetIdentidadExists(carnetIdentidad); 
            }
            return isValid;
        }

        function checkCarnetIdentidadExists(carnetIdentidad) {
            fetch('{{ route("ci-ya-existe") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ carnetIdentidad })
            })
            .then(response => response.json())
            .then(data => {
                if (data.existe) {
                    carnetIdentidadFeedback.textContent = '* El número de cédula de identidad ya está registrado.';
                    carnetIdentidadInput.classList.add('is-invalid');
                    carnetIdentidadInput.classList.remove('is-valid');
                    submitButton.disabled = true; 
                } else {
                    carnetIdentidadFeedback.textContent = '';
                    carnetIdentidadInput.classList.add('is-valid');
                    carnetIdentidadInput.classList.remove('is-invalid');
                    checkFormValidity(); 
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function validateNombre() {
            const nombre = nombreInput.value.trim();
            const isValid = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(nombre);
            if (!isValid) {
                nombreFeedback.textContent = '* El nombre solo debe contener letras y espacios.';
                nombreInput.classList.add('is-invalid');
                nombreInput.classList.remove('is-valid');
                submitButton.disabled = true; 
            } else {
                nombreFeedback.textContent = '';
                nombreInput.classList.add('is-valid');
                nombreInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateApellidoPaterno() {
            const apellidoPaterno = apellidoPaternoInput.value.trim();
            const isValid = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(apellidoPaterno);
            if (!isValid) {
                apellidoPaternoFeedback.textContent = '* El apellido paterno solo debe contener letras y espacios.';
                apellidoPaternoInput.classList.add('is-invalid');
                apellidoPaternoInput.classList.remove('is-valid');
                submitButton.disabled = true; 
            } else {
                apellidoPaternoFeedback.textContent = '';
                apellidoPaternoInput.classList.add('is-valid');
                apellidoPaternoInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateApellidoMaterno() {
            const apellidoMaterno = apellidoMaternoInput.value.trim();
            const isValid = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(apellidoMaterno);
            if (!isValid) {
                apellidoMaternoFeedback.textContent = '* El apellido materno solo debe contener letras y espacios.';
                apellidoMaternoInput.classList.add('is-invalid');
                apellidoMaternoInput.classList.remove('is-valid');
                submitButton.disabled = true; 
            } else {
                apellidoMaternoFeedback.textContent = '';
                apellidoMaternoInput.classList.add('is-valid');
                apellidoMaternoInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateSexo() {
            const sexo = sexoInput.value;
            const isValid = sexo === 'masculino' || sexo === 'femenino';
            if (!isValid) {
                sexoFeedback.textContent = '* Debes seleccionar una opción válida para el sexo.';
                sexoInput.classList.add('is-invalid');
                sexoInput.classList.remove('is-valid');
                submitButton.disabled = true; 
            } else {
                sexoFeedback.textContent = '';
                sexoInput.classList.add('is-valid');
                sexoInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateEdad() {
            const edad = edadInput.value.trim();
            const isValid = /^\d{1,3}$/.test(edad) && parseInt(edad) >= 0;
            if (!isValid) {
                edadFeedback.textContent = '* La edad debe ser un número positivo de hasta 3 dígitos.';
                edadInput.classList.add('is-invalid');
                edadInput.classList.remove('is-valid');
                submitButton.disabled = true; 
            } else {
                edadFeedback.textContent = '';
                edadInput.classList.add('is-valid');
                edadInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateTelefono() {
            const telefono = telefonoInput.value.trim();
            const isValid = /^[0-9]{8}$/.test(telefono);
            if (!isValid) {
                telefonoFeedback.textContent = '* El teléfono debe ser un número de 8 dígitos.';
                telefonoInput.classList.add('is-invalid');
                telefonoInput.classList.remove('is-valid');
                submitButton.disabled = true; 
            } else {
                telefonoFeedback.textContent = '';
                telefonoInput.classList.add('is-valid');
                telefonoInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateNombreUsuario() {
            const nombreUsuario = nombreUsuarioInput.value.trim();
            const isValid = /^[a-zA-Z0-9_]+$/.test(nombreUsuario);
            if (!isValid) {
                nombreUsuarioFeedback.textContent = '* El nombre de usuario solo debe contener letras, números y guiones bajos.';
                nombreUsuarioInput.classList.add('is-invalid');
                nombreUsuarioInput.classList.remove('is-valid');
                submitButton.disabled = true; 
            } else {
                nombreUsuarioFeedback.textContent = '';
                nombreUsuarioInput.classList.add('is-valid');
                nombreUsuarioInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateEmail() {
            const email = emailInput.value.trim();
            const isValid = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email);
            if (!isValid) {
                emailFeedback.textContent = '* El correo electrónico no es válido.';
                emailInput.classList.add('is-invalid');
                emailInput.classList.remove('is-valid');
                submitButton.disabled = true; 
            } else {
                emailFeedback.textContent = '';
                emailInput.classList.add('is-valid');
                emailInput.classList.remove('is-invalid');
                checkEmailExists(email); 
            }
            return isValid;
        }

        function checkEmailExists(email) {
            fetch('{{ route("email-ya-existe") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.existe) {
                    emailFeedback.textContent = '* El correo electrónico ya está registrado.';
                    emailInput.classList.add('is-invalid');
                    emailInput.classList.remove('is-valid');
                    submitButton.disabled = true; 
                } else {
                    emailFeedback.textContent = '';
                    emailInput.classList.add('is-valid');
                    emailInput.classList.remove('is-invalid');
                    checkFormValidity(); 
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function validatePassword() {
            const password = passwordInput.value.trim();
            const isValid = password.length >= 8;
            if (!isValid) {
                passwordFeedback.textContent = '* La contraseña debe tener al menos 8 caracteres.';
                passwordInput.classList.add('is-invalid');
                passwordInput.classList.remove('is-valid');
                submitButton.disabled = true; 
            } else {
                passwordFeedback.textContent = '';
                passwordInput.classList.add('is-valid');
                passwordInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function checkFormValidity() {
            const isFormValid = validateCarnetIdentidad() &&
                                validateNombre() &&
                                validateApellidoPaterno() &&
                                validateApellidoMaterno() &&
                                validateSexo() &&
                                validateEdad() &&
                                validateTelefono() &&
                                validateNombreUsuario() &&
                                validateEmail() &&
                                validatePassword();

            submitButton.disabled = !isFormValid;
        }

        carnetIdentidadInput.addEventListener('input', validateCarnetIdentidad);
        nombreInput.addEventListener('input', validateNombre);
        apellidoPaternoInput.addEventListener('input', validateApellidoPaterno);
        apellidoMaternoInput.addEventListener('input', validateApellidoMaterno);
        sexoInput.addEventListener('change', validateSexo);
        edadInput.addEventListener('input', validateEdad);
        telefonoInput.addEventListener('input', validateTelefono);
        nombreUsuarioInput.addEventListener('input', validateNombreUsuario);
        emailInput.addEventListener('input', validateEmail);
        passwordInput.addEventListener('input', validatePassword);

        document.getElementById('toggle-password').addEventListener('click', function () {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                this.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });

        checkFormValidity(); 
    });
</script>
@endsection

@endsection
