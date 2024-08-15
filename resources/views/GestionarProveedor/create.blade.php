@extends('layouts.plantilla')

@section('title', 'Registrar Proveedor')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Registrar Proveedor</h1>
    <form id="proveedor-form" action="{{ route('proveedor.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3 row">
            <label for="codProveedor" class="col-sm-3 col-form-label">Código:</label>
            <div class="col-sm-9">
                <input type="text" id="codProveedor" class="form-control" name="codProveedor" value="{{ old('codProveedor') }}" required>
                <div id="codProveedor-feedback" class="invalid-feedback"></div>
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
            <label for="direccion" class="col-sm-3 col-form-label">Dirección:</label>
            <div class="col-sm-9">
                <input type="text" id="direccion" class="form-control" name="direccion" value="{{ old('direccion') }}" required>
                <div id="direccion-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="telefono" class="col-sm-3 col-form-label">Teléfono:</label>
            <div class="col-sm-9">
                <input type="tel" id="telefono" class="form-control" name="telefono" value="{{ old('telefono') }}" required>
                <div id="telefono-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('proveedor.index') }}" class="btn btn-secondary me-3">
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
        const codProveedorInput = document.getElementById('codProveedor');
        const nombreInput = document.getElementById('nombre');
        const direccionInput = document.getElementById('direccion');
        const telefonoInput = document.getElementById('telefono');
        const submitButton = document.getElementById('submit-button');

        const codProveedorFeedback = document.getElementById('codProveedor-feedback');
        const nombreFeedback = document.getElementById('nombre-feedback');
        const direccionFeedback = document.getElementById('direccion-feedback');
        const telefonoFeedback = document.getElementById('telefono-feedback');

        function validateCodProveedor() {
            const codProveedor = codProveedorInput.value.trim();
            const isValid = /^\d{8,12}$/.test(codProveedor);
            if (!isValid) {
                codProveedorFeedback.textContent = '* El código debe ser un número de entre 8 y 12 dígitos.';
                codProveedorInput.classList.add('is-invalid');
                codProveedorInput.classList.remove('is-valid');
            } else {
                codProveedorFeedback.textContent = '';
                codProveedorInput.classList.add('is-valid');
                codProveedorInput.classList.remove('is-invalid');
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

        function validateDireccion() {
            const direccion = direccionInput.value.trim();
            const isValid = direccion.length > 5 && direccion.length < 201;
            if (!isValid) {
                direccionFeedback.textContent = '* La dirección debe tener entre 6 y 200 caracteres.';
                direccionInput.classList.add('is-invalid');
                direccionInput.classList.remove('is-valid');
            } else {
                direccionFeedback.textContent = '';
                direccionInput.classList.add('is-valid');
                direccionInput.classList.remove('is-invalid');
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

        function validateForm() {
            const isCodProveedorValid = validateCodProveedor();
            const isNombreValid = validateNombre();
            const isDireccionValid = validateDireccion();
            const isTelefonoValid = validateTelefono();

            submitButton.disabled = !(isCodProveedorValid && isNombreValid && isDireccionValid && isTelefonoValid);
        }

        function restrictInputToNumbers(input) {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
            });
        }

        restrictInputToNumbers(codProveedorInput);
        restrictInputToNumbers(telefonoInput);

        codProveedorInput.addEventListener('input', function() {
            validateCodProveedor();
            validateForm();
        });

        telefonoInput.addEventListener('input', function() {
            validateTelefono();
            validateForm();
        });

        nombreInput.addEventListener('input', function() {
            validateNombre();
            validateForm();
        });

        direccionInput.addEventListener('input', function() {
            validateDireccion();
            validateForm();
        });


        validateForm();
    });
</script>
@endsection
@endsection
