@extends('layouts.plantilla')

@section('title', 'Modificar Entrenador')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center my-4">EDITAR ENTRENADOR</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('entrenador.update', $entrenador) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="carnteIdentidad" class="form-label">Cédula de Identidad:</label>
                            <input type="number" id="carnteIdentidad" class="form-control" name="carnteIdentidad" value="{{ old('carnteIdentidad', $entrenador->carnteIdentidad) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" id="nombre" class="form-control" name="nombre" value="{{ old('nombre', $entrenador->nombre) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellidoPaterno" class="form-label">Apellido Paterno:</label>
                            <input type="text" id="apellidoPaterno" class="form-control" name="apellidoPaterno" value="{{ old('apellidoPaterno', $entrenador->apellidoPaterno) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellidoMaterno" class="form-label">Apellido Materno:</label>
                            <input type="text" id="apellidoMaterno" class="form-control" name="apellidoMaterno" value="{{ old('apellidoMaterno', $entrenador->apellidoMaterno) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="sexo" class="form-label">Sexo:</label>
                            <select id="sexo" class="form-control" name="sexo" required>
                                <option value="">Selecciona el sexo</option>
                                <option value="masculino" {{ old('sexo', $entrenador->sexo) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ old('sexo', $entrenador->sexo) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="tel" id="telefono" class="form-control" name="telefono" value="{{ old('telefono', $entrenador->telefono) }}" required>
                        </div>
                        <div class="text-center mt-4">
                            <a href="{{ route('entrenador.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Atrás
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-pencil-alt"></i> Modificar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
