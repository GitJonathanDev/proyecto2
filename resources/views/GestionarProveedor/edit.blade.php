@extends('layouts.plantilla')

@section('title', 'Editar Proveedor')

@section('content')
<div class="container">
    <h2 class="text-center my-4">EDITAR PROVEEDOR</h2>
    <form id="editar-proveedor-form" action="{{ route('proveedor.update', $proveedor->codProveedor) }}" method="POST" class="needs-validation" novalidate>
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

        <div class="mb-3 row">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre:</label>
            <div class="col-sm-9">
                <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $proveedor->nombre) }}" required>
                <div class="invalid-feedback">El nombre debe tener entre 3 y 30 caracteres.</div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="direccion" class="col-sm-3 col-form-label">Dirección:</label>
            <div class="col-sm-9">
                <input type="text" id="direccion" class="form-control @error('direccion') is-invalid @enderror" name="direccion" value="{{ old('direccion', $proveedor->direccion) }}" required>
                <div class="invalid-feedback">La dirección debe tener entre 6 y 200 caracteres.</div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="telefono" class="col-sm-3 col-form-label">Teléfono:</label>
            <div class="col-sm-9">
                <input type="tel" id="telefono" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono', $proveedor->telefono) }}" required>
                <div class="invalid-feedback">El teléfono debe ser un número de entre 8 y 10 dígitos.</div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('proveedor.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" id="submit-button" class="btn btn-primary" disabled>
                <i class="fas fa-pencil-alt"></i> Modificar
            </button>
        </div>
    </form>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nombreInput = document.getElementById('nombre');
        const direccionInput = document.getElementById('direccion');
        const telefonoInput = document.getElementById('telefono');
        const submitButton = document.getElementById('submit-button');

        function validateNombre() {
            const nombre = nombreInput.value.trim();
            const isValid = nombre.length > 2 && nombre.length < 31;
            if (!isValid) {
                nombreInput.classList.add('is-invalid');
                nombreInput.classList.remove('is-valid');
            } else {
                nombreInput.classList.add('is-valid');
                nombreInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateDireccion() {
            const direccion = direccionInput.value.trim();
            const isValid = direccion.length > 5 && direccion.length < 201;
            if (!isValid) {
                direccionInput.classList.add('is-invalid');
                direccionInput.classList.remove('is-valid');
            } else {
                direccionInput.classList.add('is-valid');
                direccionInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateTelefono() {
            const telefono = telefonoInput.value.trim();
            const isValid = /^\d{8,10}$/.test(telefono);
            if (!isValid) {
                telefonoInput.classList.add('is-invalid');
                telefonoInput.classList.remove('is-valid');
            } else {
                telefonoInput.classList.add('is-valid');
                telefonoInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateForm() {
            const isNombreValid = validateNombre();
            const isDireccionValid = validateDireccion();
            const isTelefonoValid = validateTelefono();

            submitButton.disabled = !(isNombreValid && isDireccionValid && isTelefonoValid);
        }

        function restrictInputToNumbers(input) {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, ''); // Reemplaza todo lo que no sea un número
            });
        }

        restrictInputToNumbers(telefonoInput);

        nombreInput.addEventListener('input', function() {
            validateNombre();
            validateForm();
        });

        direccionInput.addEventListener('input', function() {
            validateDireccion();
            validateForm();
        });

        telefonoInput.addEventListener('input', function() {
            validateTelefono();
            validateForm();
        });

        // Validar al cargar la página
        validateForm();
    });
</script>
@endsection
@endsection
