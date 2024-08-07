@extends('layouts.plantilla')

@section('title', 'Modificar Categoría')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Editar Categoría</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('categoria.update', $categoria->codCategoria) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" required>
            @error('nombre')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('categoria.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-pencil-alt"></i> Modificar
            </button>
        </div>
    </form>
</div>
@endsection
