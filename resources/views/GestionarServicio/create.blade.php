@extends('layouts.plantilla')

@section('title', 'Registrar Servicio')

@section('content')
<div class="container">
    <h1 class="text-center my-4">REGISTRAR SERVICIO</h1>
    <form id="registrar-servicio-form" action="{{ route('servicio.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3 row">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre:</label>
            <div class="col-sm-9">
                <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required>
                <div class="invalid-feedback">El nombre es obligatorio y debe tener entre 3 y 150 caracteres.</div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="descripcion" class="col-sm-3 col-form-label">Descripción:</label>
            <div class="col-sm-9">
                <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" rows="3" required>{{ old('descripcion') }}</textarea>
                <div class="invalid-feedback">La descripción es obligatoria.</div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="codHorarioF" class="col-sm-3 col-form-label">Horario:</label>
            <div class="col-sm-9">
                <select id="codHorarioF" class="form-select @error('codHorarioF') is-invalid @enderror" name="codHorarioF" required>
                    <option value="">Seleccione un horario</option>
                    @foreach($horarios as $horario)
                        <option value="{{ $horario->codHorario }}" {{ old('codHorarioF') == $horario->codHorario ? 'selected' : '' }}>
                            Hora Inicio: {{ $horario->horaInicio }} - Hora Fin: {{ $horario->horaFin }}
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Debe seleccionar un horario.</div>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('servicio.index') }}" class="btn btn-secondary me-3">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nombreInput = document.getElementById('nombre');
        const descripcionInput = document.getElementById('descripcion');
        const codHorarioFSelect = document.getElementById('codHorarioF');
        const submitButton = document.querySelector('button[type="submit"]');

        function validateNombre() {
            const nombre = nombreInput.value.trim();
            const isValid = nombre.length > 2 && nombre.length < 151;
            if (!isValid) {
                nombreInput.classList.add('is-invalid');
                nombreInput.classList.remove('is-valid');
            } else {
                nombreInput.classList.add('is-valid');
                nombreInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateDescripcion() {
            const descripcion = descripcionInput.value.trim();
            const isValid = descripcion !== '';
            if (!isValid) {
                descripcionInput.classList.add('is-invalid');
                descripcionInput.classList.remove('is-valid');
            } else {
                descripcionInput.classList.add('is-valid');
                descripcionInput.classList.remove('is-invalid');
            }
            return isValid;
        }
        
        function validateCodHorarioF() {
            const isValid = codHorarioFSelect.value !== '';
            if (!isValid) {
                codHorarioFSelect.classList.add('is-invalid');
                codHorarioFSelect.classList.remove('is-valid');
            } else {
                codHorarioFSelect.classList.add('is-valid');
                codHorarioFSelect.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateForm() {
            const isNombreValid = validateNombre();
            const isDescripcionValid = validateDescripcion();
            const isCodHorarioFValid = validateCodHorarioF();

            submitButton.disabled = !(isNombreValid && isDescripcionValid && isCodHorarioFValid);
        }

        function restrictInputToNumbers(input) {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, ''); // Reemplaza todo lo que no sea un número
            });
        }

        nombreInput.addEventListener('input', function() {
            validateNombre();
            validateForm();
        });

        descripcionInput.addEventListener('input', function() {
            validateDescripcion();
            validateForm();
        });

        codHorarioFSelect.addEventListener('change', function() {
            validateCodHorarioF();
            validateForm();
        });

        // Validar al cargar la página
        validateForm();
    });
</script>
@endsection
@endsection
