@extends('layouts.plantilla')

@section('title', 'Modificar Horario')

@section('content')
<div class="container">
    <h2 class="text-center my-4">EDITAR HORARIO</h2>
    <form id="editar-horario-form" action="{{ route('horario.update', $horario->codHorario) }}" method="POST" class="needs-validation" novalidate>
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

        <div class="row mb-3">
            <div class="col-md-3">
                <label for="horaInicio" class="form-label">Hora de inicio:</label>
            </div>
            <div class="col-md-9">
                <input type="time" id="horaInicio" class="form-control @error('horaInicio') is-invalid @enderror" name="horaInicio" value="{{ old('horaInicio', $horario->horaInicio) }}" required>
                <div class="invalid-feedback">La hora de inicio es obligatoria.</div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label for="horaFin" class="form-label">Hora de fin:</label>
            </div>
            <div class="col-md-9">
                <input type="time" id="horaFin" class="form-control @error('horaFin') is-invalid @enderror" name="horaFin" value="{{ old('horaFin', $horario->horaFin) }}" required>
                <div class="invalid-feedback">La hora de fin es obligatoria.</div>
                <div class="invalid-feedback" id="hora-range-error">La hora de fin debe ser mayor que la hora de inicio.</div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('horario.index') }}" class="btn btn-secondary me-2">
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
        const horaInicioInput = document.getElementById('horaInicio');
        const horaFinInput = document.getElementById('horaFin');
        const submitButton = document.getElementById('submit-button');
        const horaRangeError = document.getElementById('hora-range-error');

        function validateHoraInicio() {
            const horaInicio = horaInicioInput.value.trim();
            const isValid = horaInicio !== '';
            if (!isValid) {
                horaInicioInput.classList.add('is-invalid');
                horaInicioInput.classList.remove('is-valid');
            } else {
                horaInicioInput.classList.add('is-valid');
                horaInicioInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateHoraFin() {
            const horaFin = horaFinInput.value.trim();
            const isValid = horaFin !== '';
            if (!isValid) {
                horaFinInput.classList.add('is-invalid');
                horaFinInput.classList.remove('is-valid');
            } else {
                horaFinInput.classList.add('is-valid');
                horaFinInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateHoraRange() {
            const horaInicio = horaInicioInput.value;
            const horaFin = horaFinInput.value;
            const isValid = horaInicio < horaFin;
            if (!isValid) {
                horaFinInput.classList.add('is-invalid');
                horaRangeError.style.display = 'block';
            } else {
                horaFinInput.classList.add('is-valid');
                horaRangeError.style.display = 'none';
            }
            return isValid;
        }

        function validateForm() {
            const isHoraInicioValid = validateHoraInicio();
            const isHoraFinValid = validateHoraFin();
            const isHoraRangeValid = validateHoraRange();
            submitButton.disabled = !(isHoraInicioValid && isHoraFinValid && isHoraRangeValid);
        }

        horaInicioInput.addEventListener('input', function() {
            validateHoraInicio();
            validateForm();
        });

        horaFinInput.addEventListener('input', function() {
            validateHoraFin();
            validateHoraRange();
            validateForm();
        });

        // Validar al cargar la página
        validateForm();
    });
</script>
@endsection
@endsection
