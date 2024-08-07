@extends('layouts.plantilla')

@section('title', 'Editar Producto')

@section('content')
<div class="container">
    <h2 class="text-center my-4">EDITAR PRODUCTO</h2>
    <form action="{{ route('producto.update', $producto->codProducto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row mb-3">
            <label for="nombre" class="col-md-3 col-form-label">Nombre:</label>
            <div class="col-md-9">
                <input type="text" id="nombre" class="form-control" name="nombre" value="{{ old('nombre', $producto->nombre) }}" minlength="3" maxlength="100" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="descripcion" class="col-md-3 col-form-label">Descripción:</label>
            <div class="col-md-9">
                <textarea id="descripcion" class="form-control" name="descripcion" rows="3" minlength="5" maxlength="255" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
            </div>
        </div>

        <div class="row mb-3">
            <label for="precio" class="col-md-3 col-form-label">Precio:</label>
            <div class="col-md-9">
                <input type="number" id="precio" class="form-control" name="precio" value="{{ old('precio', $producto->precio) }}" step="0.01" min="0" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="codCategoriaF" class="col-md-3 col-form-label">Categoría:</label>
            <div class="col-md-9">
                <select id="codCategoriaF" class="form-select" name="codCategoriaF" required>
                    @foreach ($categorias as $cat)
                        <option value="{{ $cat->codCategoria }}" {{ old('codCategoriaF', $producto->codCategoriaF) == $cat->codCategoria ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="imagen" class="col-md-3 col-form-label">Cambiar Imagen:</label>
            <div class="col-md-9">
                <input type="file" id="imagen" class="form-control" name="imagen" accept="image/*" onchange="previsualizarImagen(event)">
                <label>Imagen Nueva:</label><br>
                <img id="imagenPrevia" src="#" alt="Imagen Previa" class="img-fluid mt-2" style="display: none;">
            </div>
        </div>

        <div class="row mb-3">
            <label for="imagen_actual" class="col-md-3 col-form-label">Imagen Actual:</label>
            <div class="col-md-9">
                @if ($producto->imagen_url)
                    <img src="{{ asset('storage/uploads/' . $producto->imagen_url) }}" alt="Imagen del producto" width="200">
                @else
                    No tiene imagen
                @endif
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('producto.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-pencil-alt"></i> Modificar
            </button>
        </div>
    </form>
</div>

<script>
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
</script>
@endsection
