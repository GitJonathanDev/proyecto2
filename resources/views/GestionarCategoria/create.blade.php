@extends('layouts.plantilla')

@section('title', 'Registrar Categoría')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Registrar Categoría</h1>

    <form action="{{ route('categoria.store') }}" method="POST">
        @csrf

        <div class="mb-3 row">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre:</label>
            <div class="col-sm-9">
                <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" placeholder="Ingrese el nombre de la categoría" required>
                @error('nombre')
                    <div class="invalid-feedback">
                        * {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success mt-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="text-center">
            <a href="{{ route('categoria.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>
@endsection
