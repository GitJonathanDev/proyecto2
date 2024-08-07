@extends('layouts.plantilla')

@section('title', 'Modificar Cliente')

@section('content')
<div class="container">
    <h2 class="text-center my-4">EDITAR CLIENTE</h2>
    <form action="{{ route('cliente.update', $cliente->carnetIdentidad) }}" method="POST">
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
            <label for="carnetidentidad" class="col-md-3 col-form-label">Cédula de identidad:</label>
            <div class="col-md-9">
                <input type="text" id="carnetidentidad" class="form-control @error('carnetIdentidad') is-invalid @enderror" name="carnetIdentidad" value="{{ old('carnetIdentidad', $cliente->carnetIdentidad) }}" required>
                @error('carnetIdentidad')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="nombre" class="col-md-3 col-form-label">Nombre:</label>
            <div class="col-md-9">
                <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="apellidoPaterno" class="col-md-3 col-form-label">Apellido Paterno:</label>
            <div class="col-md-9">
                <input type="text" id="apellidoPaterno" class="form-control @error('apellidoPaterno') is-invalid @enderror" name="apellidoPaterno" value="{{ old('apellidoPaterno', $cliente->apellidoPaterno) }}" required>
                @error('apellidoPaterno')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="apellidoMaterno" class="col-md-3 col-form-label">Apellido Materno:</label>
            <div class="col-md-9">
                <input type="text" id="apellidoMaterno" class="form-control @error('apellidoMaterno') is-invalid @enderror" name="apellidoMaterno" value="{{ old('apellidoMaterno', $cliente->apellidoMaterno) }}" required>
                @error('apellidoMaterno')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="sexo" class="col-md-3 col-form-label">Sexo:</label>
            <div class="col-md-9">
                <select id="sexo" class="form-control @error('sexo') is-invalid @enderror" name="sexo" required>
                    <option value="" disabled>Selecciona el sexo</option>
                    <option value="masculino" {{ old('sexo', $cliente->sexo) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="femenino" {{ old('sexo', $cliente->sexo) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
                @error('sexo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="telefono" class="col-md-3 col-form-label">Teléfono:</label>
            <div class="col-md-9">
                <input type="tel" id="telefono" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" required>
                @error('telefono')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Campo para edad -->
        <div class="row mb-3">
            <label for="edad" class="col-md-3 col-form-label">Edad:</label>
            <div class="col-md-9">
                <input type="number" id="edad" class="form-control @error('edad') is-invalid @enderror" name="edad" value="{{ old('edad', $cliente->edad) }}" required>
                @error('edad')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('cliente.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-pencil-alt"></i> Modificar
            </button>
        </div>
    </form>
</div>
@endsection
