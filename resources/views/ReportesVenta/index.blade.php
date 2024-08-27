@extends('layouts.plantilla')

@section('title', 'Generar Reporte de Ventas')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Generar Reporte de Ventas por Rango de Fechas</h3>
        </div>
        <div class="card-body">
            <form id="reporte-form" action="{{ route('reporte.generar2') }}" method="GET">
                @csrf
                <div class="form-group">
                    <label for="fecha_inicio">Fecha de inicio:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                    <div id="fecha_inicio-feedback" class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="fecha_fin">Fecha de fin:</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                    <div id="fecha_fin-feedback" class="invalid-feedback"></div>
                </div>
                <button type="submit" id="submit-button" class="btn btn-primary" disabled>Generar Reporte</button>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fechaInicioInput = document.getElementById('fecha_inicio');
        const fechaFinInput = document.getElementById('fecha_fin');
        const submitButton = document.getElementById('submit-button');
        const fechaInicioFeedback = document.getElementById('fecha_inicio-feedback');
        const fechaFinFeedback = document.getElementById('fecha_fin-feedback');

        function validateFechas() {
            const fechaInicio = new Date(fechaInicioInput.value);
            const fechaFin = new Date(fechaFinInput.value);
            let isValid = true;

            if (!fechaInicioInput.value) {
                fechaInicioFeedback.textContent = '* Se requiere una fecha de inicio.';
                fechaInicioInput.classList.add('is-invalid');
                isValid = false;
            } else {
                fechaInicioFeedback.textContent = '';
                fechaInicioInput.classList.remove('is-invalid');
                fechaInicioInput.classList.add('is-valid');
            }

            if (!fechaFinInput.value) {
                fechaFinFeedback.textContent = '* Se requiere una fecha de fin.';
                fechaFinInput.classList.add('is-invalid');
                isValid = false;
            } else {
                fechaFinFeedback.textContent = '';
                fechaFinInput.classList.remove('is-invalid');
                fechaFinInput.classList.add('is-valid');
            }

            if (fechaInicio && fechaFin && fechaInicio > fechaFin) {
                fechaInicioFeedback.textContent = '* La fecha de inicio debe ser menor a la fecha de fin.';
                fechaInicioInput.classList.add('is-invalid');
                fechaFinInput.classList.add('is-invalid');
                isValid = false;
            }

            submitButton.disabled = !isValid;
        }

        fechaInicioInput.addEventListener('input', validateFechas);
        fechaFinInput.addEventListener('input', validateFechas);

        validateFechas(); 
    });
</script>
@endsection
@endsection
