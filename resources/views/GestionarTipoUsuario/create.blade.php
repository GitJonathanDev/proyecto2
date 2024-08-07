@extends('layouts.plantilla')

@section('title', 'Registrar Tipo de Usuario')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Registrar Tipo de Usuario</h1>

    <form action="{{ route('tipoUsuario.store') }}" method="POST">
        @csrf

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3 row">
            <label for="descripcion" class="col-sm-3 col-form-label">Descripción:</label>
            <div class="col-sm-9">
                <input type="text" id="descripcion" name="descripcion" value="{{ old('descripcion') }}" class="form-control @error('descripcion') is-invalid @enderror" placeholder="Ingrese la descripción del tipo de usuario" required>
                @error('descripcion')
                    <div class="invalid-feedback">
                        * {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('tipoUsuario.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>
@endsection
