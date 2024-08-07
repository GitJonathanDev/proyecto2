@extends('layouts.plantilla')

@section('title', 'Registrar Precio de Servicio')

@section('content')
<div class="container">
    <h1 class="text-center my-4">REGISTRAR PRECIO DE SERVICIO</h1>
    <form action="{{ route('precioServicio.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3 row">
            <label for="codServicioF" class="col-sm-3 col-form-label">Servicio:</label>
            <div class="col-sm-9">
                <select id="codServicioF" class="form-select @error('codServicioF') is-invalid @enderror" name="codServicioF" required onchange="actualizarTipos()">
                    <option value="">Seleccione un servicio</option>
                    @foreach($servicios as $servicio)
                        <option value="{{ $servicio->codServicio }}" {{ old('codServicioF') == $servicio->codServicio ? 'selected' : '' }}>
                            {{ $servicio->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('codServicioF')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row" id="tipoRow" style="display: none;">
            <label for="tipo" class="col-sm-3 col-form-label">Tipo:</label>
            <div class="col-sm-9">
                <select id="tipo" class="form-select @error('tipo') is-invalid @enderror" name="tipo" required>
                    <option value="">Seleccione un tipo</option>
                </select>
                <div id="mensajeTipo" class="invalid-feedback d-none">No hay tipos disponibles para seleccionar.</div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="precio" class="col-sm-3 col-form-label">Precio:</label>
            <div class="col-sm-9">
                <input type="number" id="precio" class="form-control @error('precio') is-invalid @enderror" name="precio" value="{{ old('precio') }}" step="0.01" required>
                @error('precio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('precioServicio.index') }}" class="btn btn-secondary me-3">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>

<script>
    function actualizarTipos() {
        var servicioId = document.getElementById('codServicioF').value;
        var tipoRow = document.getElementById('tipoRow');
        var tipoSelect = document.getElementById('tipo');
        var mensajeTipo = document.getElementById('mensajeTipo');
        
        if (servicioId) {
            tipoRow.style.display = 'block';

            var tiposRegistrados = @json($tiposRegistrados);
            tipoSelect.innerHTML = '<option value="">Seleccione un tipo</option>';
            mensajeTipo.classList.add('d-none');

            var tiposRegistradosServicio = tiposRegistrados[servicioId] || [];
            var tiposDisponibles = @json(['Diario', 'Mensual', 'Anual']); 

            var tiposMostrar = tiposDisponibles.filter(function(tipo) {
                return !tiposRegistradosServicio.includes(tipo);
            });

            if (tiposMostrar.length === 0) {
                tipoSelect.innerHTML = '';
                mensajeTipo.classList.remove('d-none');
            } else {
                tiposMostrar.forEach(function(tipo) {
                    var option = document.createElement('option');
                    option.value = tipo;
                    option.text = tipo;
                    tipoSelect.appendChild(option);
                });
            }
        } else {
            tipoRow.style.display = 'none';
            mensajeTipo.classList.add('d-none'); 
        }
    }

    window.onload = function() {
        actualizarTipos();
    };
</script>

@endsection
