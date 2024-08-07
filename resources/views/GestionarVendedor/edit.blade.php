@extends('layouts.plantilla')

@section('title', 'Modificar Vendedor')

@section('content')
<div class="container">
    <h2 class="text-center my-4">EDITAR VENDEDOR</h2>
    <form action="{{ route('vendedor.update', $vendedor->carnetIdentidad) }}" method="POST">
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
            <label for="carnetIdentidad" class="col-md-3 col-form-label">Carnet de Identidad:</label>
            <div class="col-md-9">
                <input type="number" id="carnetIdentidad" class="form-control @error('carnetIdentidad') is-invalid @enderror" name="carnetIdentidad" value="{{ old('carnetIdentidad', $vendedor->carnetIdentidad) }}" required>
                @error('carnetIdentidad')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="nombre" class="col-md-3 col-form-label">Nombre:</label>
            <div class="col-md-9">
                <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $vendedor->nombre) }}" required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="apellidoPaterno" class="col-md-3 col-form-label">Apellido Paterno:</label>
            <div class="col-md-9">
                <input type="text" id="apellidoPaterno" class="form-control @error('apellidoPaterno') is-invalid @enderror" name="apellidoPaterno" value="{{ old('apellidoPaterno', $vendedor->apellidoPaterno) }}" required>
                @error('apellidoPaterno')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="apellidoMaterno" class="col-md-3 col-form-label">Apellido Materno:</label>
            <div class="col-md-9">
                <input type="text" id="apellidoMaterno" class="form-control @error('apellidoMaterno') is-invalid @enderror" name="apellidoMaterno" value="{{ old('apellidoMaterno', $vendedor->apellidoMaterno) }}" required>
                @error('apellidoMaterno')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="sexo" class="col-md-3 col-form-label">Sexo:</label>
            <div class="col-md-9">
                <select id="sexo" class="form-control @error('sexo') is-invalid @enderror" name="sexo" required>
                    <option value="">Selecciona el sexo</option>
                    <option value="masculino" {{ old('sexo', $vendedor->sexo) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="femenino" {{ old('sexo', $vendedor->sexo) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
                @error('sexo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="telefono" class="col-md-3 col-form-label">Teléfono:</label>
            <div class="col-md-9">
                <input type="tel" id="telefono" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono', $vendedor->telefono) }}" required>
                @error('telefono')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('vendedor.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-pencil-alt"></i> Modificar
            </button>
        </div>
    </form>
</div>
@endsection
