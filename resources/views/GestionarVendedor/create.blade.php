@extends('layouts.plantilla')

@section('title', 'Registrar Vendedor')

@section('content')
<div class="container">
    <h1 class="text-center my-4">REGISTRAR VENDEDOR</h1>
    <form action="{{ route('vendedor.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="form-group row mb-3">
            <label for="carnetIdentidad" class="col-sm-3 col-form-label">Cédula de identidad:</label>
            <div class="col-sm-9">
                <input type="number" id="carnetIdentidad" class="form-control @error('carnetIdentidad') is-invalid @enderror" name="carnetIdentidad" value="{{ old('carnetIdentidad') }}" required>
                <div class="invalid-feedback">
                    Por favor, introduce una cédula de identidad válida.
                </div>
                <div id="ci-error" class="invalid-feedback">
                    Esta cédula de identidad ya está registrada. Por favor, introduce otra.
                </div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre:</label>
            <div class="col-sm-9">
                <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required>
                <div class="invalid-feedback">
                    Por favor, introduce un nombre.
                </div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="apellidoPaterno" class="col-sm-3 col-form-label">Apellido Paterno:</label>
            <div class="col-sm-9">
                <input type="text" id="apellidoPaterno" class="form-control @error('apellidoPaterno') is-invalid @enderror" name="apellidoPaterno" value="{{ old('apellidoPaterno') }}" required>
                <div class="invalid-feedback">
                    Por favor, introduce un apellido paterno.
                </div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="apellidoMaterno" class="col-sm-3 col-form-label">Apellido Materno:</label>
            <div class="col-sm-9">
                <input type="text" id="apellidoMaterno" class="form-control @error('apellidoMaterno') is-invalid @enderror" name="apellidoMaterno" value="{{ old('apellidoMaterno') }}" required>
                <div class="invalid-feedback">
                    Por favor, introduce un apellido materno.
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
                <div class="invalid-feedback">
                    Por favor, selecciona un sexo.
                </div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="edad" class="col-sm-3 col-form-label">Edad:</label>
            <div class="col-sm-9">
                <input type="number" id="edad" class="form-control @error('edad') is-invalid @enderror" name="edad" value="{{ old('edad') }}" required>
                <div class="invalid-feedback">
                    Por favor, introduce la edad.
                </div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="telefono" class="col-sm-3 col-form-label">Teléfono:</label>
            <div class="col-sm-9">
                <input type="tel" id="telefono" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" required>
                <div class="invalid-feedback">
                    Por favor, introduce un número de teléfono válido.
                </div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="nombreUsuario" class="col-sm-3 col-form-label">Nombre de usuario:</label>
            <div class="col-sm-9">
                <input type="text" id="nombreUsuario" class="form-control @error('nombreUsuario') is-invalid @enderror" name="nombreUsuario" value="{{ old('nombreUsuario') }}" required>
                <div class="invalid-feedback">
                    Por favor, introduce un nombre de usuario.
                </div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="email" class="col-sm-3 col-form-label">Correo electrónico:</label>
            <div class="col-sm-9">
                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                <div class="invalid-feedback">
                    Por favor, introduce un correo electrónico válido.
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
                <div class="invalid-feedback">
                    Por favor, introduce una contraseña.
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('vendedor.index') }}" class="btn btn-secondary">ATRÁS</a>
            <button type="submit" class="btn btn-primary">GUARDAR</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación del formulario
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                var ci = document.getElementById('carnetIdentidad').value;

                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    var ciError = document.getElementById('ci-error');
                    ciError.style.display = 'none';

                    if (ciYaExiste(ci)) {
                        event.preventDefault();
                        event.stopPropagation();
                        ciError.style.display = 'block';
                    }
                }
                form.classList.add('was-validated');
            }, false);
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

        // Toggle password visibility
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
    });
</script>
@endsection
