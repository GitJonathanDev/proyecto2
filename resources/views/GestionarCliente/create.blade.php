@extends('layouts.plantilla')

@section('title', 'Registrar Cliente')

@section('content')
<div class="container">
    <h1 class="text-center my-4">REGISTRAR CLIENTE</h1>
    <form action="{{ route('cliente.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3 row">
            <label for="carnetidentidad" class="col-sm-3 col-form-label">Cédula de identidad:</label>
            <div class="col-sm-9">
                <input type="text" id="carnetidentidad" class="form-control @error('carnetIdentidad') is-invalid @enderror" name="carnetIdentidad" value="{{ old('carnetIdentidad') }}" required>
                @error('carnetIdentidad')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="ci-error" class="invalid-feedback d-none">
                    Esta cédula de identidad ya está registrada. Por favor, introduce otra.
                </div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre:</label>
            <div class="col-sm-9">
                <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="apellidoPaterno" class="col-sm-3 col-form-label">Apellido Paterno:</label>
            <div class="col-sm-9">
                <input type="text" id="apellidoPaterno" class="form-control @error('apellidoPaterno') is-invalid @enderror" name="apellidoPaterno" value="{{ old('apellidoPaterno') }}" required>
                @error('apellidoPaterno')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="apellidoMaterno" class="col-sm-3 col-form-label">Apellido Materno:</label>
            <div class="col-sm-9">
                <input type="text" id="apellidoMaterno" class="form-control @error('apellidoMaterno') is-invalid @enderror" name="apellidoMaterno" value="{{ old('apellidoMaterno') }}" required>
                @error('apellidoMaterno')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="sexo" class="col-sm-3 col-form-label">Sexo:</label>
            <div class="col-sm-9">
                <select id="sexo" class="form-select @error('sexo') is-invalid @enderror" name="sexo" required>
                    <option value="" disabled>Selecciona el sexo</option>
                    <option value="masculino" {{ old('sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="femenino" {{ old('sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
                @error('sexo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
         <!-- Campo para edad -->
         <div class="mb-3 row">
            <label for="edad" class="col-sm-3 col-form-label">Edad:</label>
            <div class="col-sm-9">
                <input type="number" id="edad" class="form-control @error('edad') is-invalid @enderror" name="edad" value="{{ old('edad') }}" required>
                @error('edad')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="telefono" class="col-sm-3 col-form-label">Teléfono:</label>
            <div class="col-sm-9">
                <input type="tel" id="telefono" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" required>
                @error('telefono')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="nombreUsuario" class="col-sm-3 col-form-label">Nombre de usuario:</label>
            <div class="col-sm-9">
                <input type="text" id="nombreUsuario" class="form-control @error('nombreUsuario') is-invalid @enderror" name="nombreUsuario" value="{{ old('nombreUsuario') }}" required>
                @error('nombreUsuario')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="email" class="col-sm-3 col-form-label">Correo electrónico:</label>
            <div class="col-sm-9">
                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="password" class="col-sm-3 col-form-label">Contraseña:</label>
            <div class="col-sm-9 position-relative">
                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                <button type="button" id="toggle-password" class="btn btn-outline-secondary position-absolute" style="top: 50%; right: 0; transform: translateY(-50%);">
                    <i class="fas fa-eye"></i>
                </button>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

       

        <div class="text-center">
            <a href="{{ route('cliente.index') }}" class="btn btn-secondary me-3">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>

<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        var ci = document.getElementById('carnetidentidad').value;
                        if (ciYaExiste(ci)) {
                            event.preventDefault();
                            event.stopPropagation();
                            document.getElementById('ci-error').classList.remove('d-none');
                        } else {
                            document.getElementById('ci-error').classList.add('d-none');
                            form.submit();
                        }
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    function ciYaExiste(ci) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route("ci-ya-existe") }}', false);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.send('carnetIdentidad=' + encodeURIComponent(ci));
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            return response.existe;
        }
        return false;
    }

    document.getElementById('toggle-password').addEventListener('click', function() {
        var passwordField = document.getElementById('password');
        var icon = this.querySelector('i');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
@endsection
