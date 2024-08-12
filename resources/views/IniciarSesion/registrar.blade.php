@extends('layouts.app')

@section('title', 'Registrar')

@section('content')

<style>
    body {
        background: linear-gradient(rgba(0, 1, 3, 0.7), rgba(0, 0, 0, 0.8)), url('/img/fondo.jpg');
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

    .block .password-toggle {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #555;
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
</style>

<div class="block">
    <h1>REGISTRAR</h1>
    <form action="{{ route('registrar.create') }}" method="POST" onsubmit="return validarFormulario()">
        @csrf
        
        <div class="mb-4">
            <label for="carnetIdentidad">Cédula de Identidad:</label>
            <input type="text" name="carnetIdentidad" id="carnetIdentidad" required>
            @error('carnetIdentidad')
                <small class="error-message">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <small id="error-nombre" class="error-message">Por favor, ingrese el Nombre.</small>
        </div>

        <div class="mb-4">
            <label for="apellidoPaterno">Apellido Paterno:</label>
            <input type="text" name="apellidoPaterno" id="apellidoPaterno" required>
            <small id="error-apellidoPaterno" class="error-message">Por favor, ingrese el Apellido Paterno.</small>
        </div>

        <div class="mb-4">
            <label for="apellidoMaterno">Apellido Materno:</label>
            <input type="text" name="apellidoMaterno" id="apellidoMaterno" required>
            <small id="error-apellidoMaterno" class="error-message">Por favor, ingrese el Apellido Materno.</small>
        </div>

        <div class="mb-4">
            <label for="sexo">Sexo:</label>
            <select name="sexo" id="sexo" required>
                <option value="">Seleccione una opción</option>
                <option value="masculino">Masculino</option>
                <option value="femenino">Femenino</option>
            </select>
            <small id="error-sexo" class="error-message">Por favor, seleccione el Sexo.</small>
        </div>

        <div class="mb-4">
            <label for="edad">Edad:</label>
            <input type="number" name="edad" id="edad" min="0" required>
            <small id="error-edad" class="error-message">Por favor, ingrese una edad válida.</small>
        </div>

        <div class="mb-4">
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" required>
            <small id="error-telefono" class="error-message">Por favor, ingrese un número de teléfono válido (mínimo 8 dígitos).</small>
        </div>

        <div class="mb-4">
            <label for="name">Nombre de Usuario:</label>
            <input type="text" name="name" id="name" required>
            <small id="error-name" class="error-message">Por favor, ingrese el Nombre de Usuario.</small>
        </div>

        <div class="mb-4">
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" required>
            @error('email')
                <small class="error-message">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4 position-relative">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
            <span class="password-toggle" onclick="togglePasswordVisibility()">
                <i id="password-toggle" class="fas fa-eye"></i>
            </span>
            <small id="error-password" class="error-message">Por favor, ingrese una contraseña de al menos 8 caracteres.</small>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">
                REGISTRARME
            </button>
        </div>
    </form>
</div>

<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var passwordToggle = document.getElementById("password-toggle");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordToggle.classList.remove("fa-eye");
            passwordToggle.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            passwordToggle.classList.remove("fa-eye-slash");
            passwordToggle.classList.add("fa-eye");
        }
    }

    function validarFormulario() {
        var cedula = document.getElementById("carnetIdentidad").value.trim();
        var nombre = document.getElementById("nombre").value.trim();
        var apellidoPaterno = document.getElementById("apellidoPaterno").value.trim();
        var apellidoMaterno = document.getElementById("apellidoMaterno").value.trim();
        var sexo = document.getElementById("sexo").value;
        var edad = document.getElementById("edad").value.trim();
        var telefono = document.getElementById("telefono").value.trim();
        var username = document.getElementById("name").value.trim();
        var password = document.getElementById("password").value.trim();

        var valido = true;

        if (cedula === "") {
            document.getElementById("carnetIdentidad").classList.add("is-invalid");
            valido = false;
        } else {
            document.getElementById("carnetIdentidad").classList.remove("is-invalid");
        }

        if (nombre === "") {
            document.getElementById("error-nombre").classList.remove("d-none");
            valido = false;
        } else {
            document.getElementById("error-nombre").classList.add("d-none");
        }

        if (apellidoPaterno === "") {
            document.getElementById("error-apellidoPaterno").classList.remove("d-none");
            valido = false;
        } else {
            document.getElementById("error-apellidoPaterno").classList.add("d-none");
        }

        if (apellidoMaterno === "") {
            document.getElementById("error-apellidoMaterno").classList.remove("d-none");
            valido = false;
        } else {
            document.getElementById("error-apellidoMaterno").classList.add("d-none");
        }

        if (sexo === "") {
            document.getElementById("error-sexo").classList.remove("d-none");
            valido = false;
        } else {
            document.getElementById("error-sexo").classList.add("d-none");
        }

        if (edad === "" || edad < 0) {
            document.getElementById("error-edad").classList.remove("d-none");
            valido = false;
        } else {
            document.getElementById("error-edad").classList.add("d-none");
        }

        if (telefono === "" || !(/^\d{8,}$/.test(telefono))) {
            document.getElementById("error-telefono").classList.remove("d-none");
            valido = false;
        } else {
            document.getElementById("error-telefono").classList.add("d-none");
        }

        if (username === "") {
            document.getElementById("error-name").classList.remove("d-none");
            valido = false;
        } else {
            document.getElementById("error-name").classList.add("d-none");
        }

        if (password.length < 8) {
            document.getElementById("error-password").classList.remove("d-none");
            valido = false;
        } else {
            document.getElementById("error-password").classList.add("d-none");
        }

        return valido;
    }
</script>

@endsection
