@extends('layouts.plantilla')

@section('title', 'Registrar Producto')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Registrar Producto</h1>
    <form id="formularioProducto" action="{{ route('producto.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3 row">
            <label for="codProducto" class="col-sm-3 col-form-label">Código del Producto:</label>
            <div class="col-sm-9">
                <input type="text" id="codProducto" class="form-control @error('codProducto') is-invalid @enderror" name="codProducto" value="{{ old('codProducto') }}" required minlength="1" maxlength="20">
                @error('codProducto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre:</label>
            <div class="col-sm-9">
                <input type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required minlength="3" maxlength="100">
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="descripcion" class="col-sm-3 col-form-label">Descripción:</label>
            <div class="col-sm-9">
                <input type="text" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" value="{{ old('descripcion') }}" required minlength="5" maxlength="255">
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="precio" class="col-sm-3 col-form-label">Precio:</label>
            <div class="col-sm-9">
                <input type="number" id="precio" class="form-control @error('precio') is-invalid @enderror" name="precio" value="{{ old('precio') }}" required min="0" step="0.01">
                @error('precio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="codCategoriaF" class="col-sm-3 col-form-label">Categoría:</label>
            <div class="col-sm-9">
                <select id="codCategoriaF" class="form-select @error('codCategoriaF') is-invalid @enderror" name="codCategoriaF" required>
                    <option value="">Seleccione una categoría</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->codCategoria }}" {{ old('codCategoriaF') == $cat->codCategoria ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                    @endforeach
                </select>
                @error('codCategoriaF')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="imagen" class="col-sm-3 col-form-label">Imagen:</label>
            <div class="col-sm-9">
                <input type="file" id="imagen" class="form-control @error('imagen') is-invalid @enderror" name="imagen" accept="image/*" onchange="previsualizarImagen(event)">
                <img id="imagenPrevia" src="#" alt="Imagen Previa" class="img-fluid mt-2" style="display: none;">
                @error('imagen')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('producto.index') }}" class="btn btn-secondary me-3">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>

<script>
    function validarPrecio() {
        const precioInput = document.getElementById('precio');
        const precioValue = parseFloat(precioInput.value);
        if (isNaN(precioValue) || precioValue <= 0) {
            alert('Por favor, ingrese un precio válido mayor que cero.');
            precioInput.focus();
            return false;
        }
        return true;
    }

    function previsualizarImagen(event) {
        const imagen = document.getElementById('imagen');
        const imagenPrevia = document.getElementById('imagenPrevia');
        const reader = new FileReader();

        reader.onload = function() {
            if (reader.readyState == 2) {
                imagenPrevia.src = reader.result;
                imagenPrevia.style.display = 'block';
            }
        }

        if (imagen.files[0]) {
            reader.readAsDataURL(imagen.files[0]);
        }
    }

    document.getElementById('formularioProducto').addEventListener('submit', function(event) {
        if (!validarPrecio()) {
            event.preventDefault(); 
        }
    });
</script>
@endsection
