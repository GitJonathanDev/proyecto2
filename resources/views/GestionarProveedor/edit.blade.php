@extends('layouts.plantilla')

@section('title', 'Editar Proveedor')

@section('content')
<div class="container">
    <h2 class="text-center my-4">EDITAR PROVEEDOR</h2>
    <form action="{{ route('proveedor.update', $proveedor->codProveedor) }}" method="POST">
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
            <label for="nombre" class="col-md-3 col-form-label">Nombre:</label>
            <div class="col-md-9">
                <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $proveedor->nombre) }}" required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="direccion" class="col-md-3 col-form-label">Dirección:</label>
            <div class="col-md-9">
                <input type="text" id="direccion" class="form-control @error('direccion') is-invalid @enderror" name="direccion" value="{{ old('direccion', $proveedor->direccion) }}" required>
                @error('direccion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="telefono" class="col-md-3 col-form-label">Teléfono:</label>
            <div class="col-md-9">
                <input type="tel" id="telefono" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono', $proveedor->telefono) }}" required>
                @error('telefono')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('proveedor.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-pencil-alt"></i> Modificar
            </button>
        </div>
    </form>
</div>
@endsection
