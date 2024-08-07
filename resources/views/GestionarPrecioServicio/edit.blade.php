@extends('layouts.plantilla')

@section('title', 'Modificar Precio de Servicio')

@section('content')
<div class="container">
    <h2 class="text-center my-4">EDITAR PRECIO DE SERVICIO</h2>
    <form action="{{ route('precioServicio.update', $precioServicio->codPrecioServicio) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="codServicioF" class="form-label">Servicio:</label>
            </div>
            <div class="col-md-9">
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

        <div class="row mb-3">
            <div class="col-md-3">
                <label for="tipo" class="form-label">Tipo:</label>
            </div>
            <div class="col-md-9">
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

        <div class="row mb-3">
            <div class="col-md-3">
                <label for="precio" class="form-label">Precio:</label>
            </div>
            <div class="col-md-9">
                <input type="number" id="precio" class="form-control @error('precio') is-invalid @enderror" name="precio" value="{{ old('precio', $precioServicio->precio) }}" step="0.01" required>
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
@endsection
