@extends('layouts.plantillaAdministrador')

@section('title', 'Registrar Entrenador')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center mb-3">REGISTRAR ENTRENADORES</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('entrenador.store') }}" method="POST">
                        @csrf
                        <div class="mb-3 row">
                            <label for="carnetIdentidad" class="col-sm-3 col-form-label">Cédula de Identidad:</label>
                            <div class="col-sm-9">
                                <input type="number" id="carnetIdentidad" class="form-control" name="carnetIdentidad" value="{{ old('carnetIdentidad') }}" required>
                                @error('carnetIdentidad')
                                    <p class="text-danger mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="nombre" class="col-sm-3 col-form-label">Nombre:</label>
                            <div class="col-sm-9">
                                <input type="text" id="nombre" class="form-control" name="nombre" value="{{ old('nombre') }}" required>
                                @error('nombre')
                                    <p class="text-danger mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="apellidoPaterno" class="col-sm-3 col-form-label">Apellido Paterno:</label>
                            <div class="col-sm-9">
                                <input type="text" id="apellidoPaterno" class="form-control" name="apellidoPaterno" value="{{ old('apellidoPaterno') }}" required>
                                @error('apellidoPaterno')
                                    <p class="text-danger mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="apellidoMaterno" class="col-sm-3 col-form-label">Apellido Materno:</label>
                            <div class="col-sm-9">
                                <input type="text" id="apellidoMaterno" class="form-control" name="apellidoMaterno" value="{{ old('apellidoMaterno') }}" required>
                                @error('apellidoMaterno')
                                    <p class="text-danger mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="sexo" class="col-sm-3 col-form-label">Sexo:</label>
                            <div class="col-sm-9">
                                <select id="sexo" class="form-control" name="sexo" required>
                                    <option value="">Selecciona el sexo</option>
                                    <option value="masculino" {{ old('sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="femenino" {{ old('sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                </select>
                                @error('sexo')
                                    <p class="text-danger mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="telefono" class="col-sm-3 col-form-label">Teléfono:</label>
                            <div class="col-sm-9">
                                <input type="tel" id="telefono" class="form-control" name="telefono" value="{{ old('telefono') }}" required>
                                @error('telefono')
                                    <p class="text-danger mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="{{ route('entrenador.index') }}" class="btn btn-secondary">ATRÁS</a>
                            <button type="submit" class="btn btn-primary">GUARDAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
