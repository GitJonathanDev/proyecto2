@extends('layouts.plantilla')

@section('title', 'Modificar Precio de Servicio')

@section('content')
<div class="container">
    <h2 class="text-center my-4">EDITAR PRECIO DE SERVICIO</h2>
    <form id="modificar-precio-servicio-form" action="{{ route('precioServicio.update', $precioServicio->codPrecioServicio) }}" method="POST" class="needs-validation" novalidate>
        @csrf
        @method('PUT')
        
        <div class="mb-3 row">
            <label for="codServicioF" class="col-sm-3 col-form-label">Servicio:</label>
            <div class="col-sm-9">
                <select id="codServicioF" class="form-select @error('codServicioF') is-invalid @enderror" name="codServicioF" required>
                    <option value="">Seleccione un servicio</option>
                    @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->codServicio }}" {{ old('codServicioF', $precioServicio->codServicioF) == $servicio->codServicio ? 'selected' : '' }}>
                            {{ $servicio->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('codServicioF')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="tipo" class="col-sm-3 col-form-label">Tipo:</label>
            <div class="col-sm-9">
                <select id="tipo" class="form-select @error('tipo') is-invalid @enderror" name="tipo" required>
                    @foreach ($tiposDisponibles as $tipo)
                        <option value="{{ $tipo }}" {{ old('tipo', $precioServicio->tipo) == $tipo ? 'selected' : '' }}>
                            {{ $tipo }}
                        </option>
                    @endforeach
                </select>
                @error('tipo')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="precio" class="col-sm-3 col-form-label">Precio:</label>
            <div class="col-sm-9">
                <input type="text" id="precio" class="form-control @error('precio') is-invalid @enderror" name="precio" value="{{ old('precio', $precioServicio->precio) }}" required>
                <div class="invalid-feedback">El precio debe ser un número mayor a 0, incluyendo decimales.</div>
                @error('precio')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('precioServicio.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-pencil-alt"></i> Modificar
            </button>
        </div>
    </form>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const codServicioFSelect = document.getElementById('codServicioF');
        const tipoSelect = document.getElementById('tipo');
        const precioInput = document.getElementById('precio');
        const submitButton = document.querySelector('button[type="submit"]');

        function validateCodServicioF() {
            const isValid = codServicioFSelect.value !== '';
            if (!isValid) {
                codServicioFSelect.classList.add('is-invalid');
                codServicioFSelect.classList.remove('is-valid');
            } else {
                codServicioFSelect.classList.add('is-valid');
                codServicioFSelect.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateTipo() {
            const isValid = tipoSelect.value !== '';
            if (!isValid) {
                tipoSelect.classList.add('is-invalid');
                tipoSelect.classList.remove('is-valid');
            } else {
                tipoSelect.classList.add('is-valid');
                tipoSelect.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validatePrecio() {
            const precio = precioInput.value.trim();
            const isValid = /^\d+(\.\d{1,2})?$/.test(precio) && parseFloat(precio) > 0;
            if (!isValid) {
                precioInput.classList.add('is-invalid');
                precioInput.classList.remove('is-valid');
            } else {
                precioInput.classList.add('is-valid');
                precioInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateForm() {
            const isCodServicioFValid = validateCodServicioF();
            const isTipoValid = validateTipo();
            const isPrecioValid = validatePrecio();

            submitButton.disabled = !(isCodServicioFValid && isTipoValid && isPrecioValid);
        }

        function restrictInputToNumbers(input) {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9.]/g, ''); // Reemplaza todo lo que no sea un número o punto
            });
        }

        codServicioFSelect.addEventListener('change', function() {
            validateCodServicioF();
            validateForm();
        });

        tipoSelect.addEventListener('change', function() {
            validateTipo();
            validateForm();
        });

        restrictInputToNumbers(precioInput);
        precioInput.addEventListener('input', function() {
            validatePrecio();
            validateForm();
        });

        // Validar al cargar la página
        validateForm();
    });
</script>
@endsection
@endsection
