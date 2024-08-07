@extends('layouts.plantilla')

@section('title', 'Registrar Proveedor')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Registrar Proveedor</h1>
    <form action="{{ route('proveedor.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3 row">
            <label for="codProveedor" class="col-sm-3 col-form-label">Código:</label>
            <div class="col-sm-9">
                <input type="text" id="codProveedor" class="form-control @error('codProveedor') is-invalid @enderror" name="codProveedor" value="{{ old('codProveedor') }}" required>
                @error('codProveedor')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre:</label>
            <div class="col-sm-9">
                <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="direccion" class="col-sm-3 col-form-label">Dirección:</label>
            <div class="col-sm-9">
                <input type="text" id="direccion" class="form-control @error('direccion') is-invalid @enderror" name="direccion" value="{{ old('direccion') }}" required>
                @error('direccion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="telefono" class="col-sm-3 col-form-label">Teléfono:</label>
            <div class="col-sm-9">
                <input type="tel" id="telefono" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" required>
                @error('telefono')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('proveedor.index') }}" class="btn btn-secondary me-3">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>
@endsection
