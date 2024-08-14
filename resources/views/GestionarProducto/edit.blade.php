@extends('layouts.plantilla')

@section('title', 'Editar Producto')

@section('content')
<div class="container">
    <h2 class="text-center my-4">EDITAR PRODUCTO</h2>
    <form id="formularioProducto" action="{{ route('producto.update', $producto->codProducto) }}" method="POST" enctype="multipart/form-data">
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
                <input type="text" id="nombre" class="form-control" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
                <div id="nombre-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="descripcion" class="col-md-3 col-form-label">Descripción:</label>
            <div class="col-md-9">
                <textarea id="descripcion" class="form-control" name="descripcion" rows="3" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
                <div id="descripcion-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="precio" class="col-md-3 col-form-label">Precio:</label>
            <div class="col-md-9">
                <input type="number" id="precio" class="form-control" name="precio" value="{{ old('precio', $producto->precio) }}" step="0.01" min="0" required>
                <div id="precio-feedback" class="invalid-feedback"></div>
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
                <div id="codCategoriaF-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="imagen" class="col-md-3 col-form-label">Cambiar Imagen:</label>
            <div class="col-md-9">
                <input type="file" id="imagen" class="form-control" name="imagen" accept="image/*" onchange="previsualizarImagen(event)">
                <img id="imagenPrevia" src="#" alt="Imagen Previa" class="img-fluid mt-2" style="display: none;">
                <div id="imagen-feedback" class="invalid-feedback"></div>
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
            <button type="submit" id="submit-button" class="btn btn-primary" disabled>
                <i class="fas fa-pencil-alt"></i> Modificar
            </button>
        </div>
    </form>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formulario = document.getElementById('formularioProducto');
        const nombreInput = document.getElementById('nombre');
        const descripcionInput = document.getElementById('descripcion');
        const precioInput = document.getElementById('precio');
        const codCategoriaFSelect = document.getElementById('codCategoriaF');
        const submitButton = document.getElementById('submit-button');

        function validateInput(input, minLength, maxLength, feedbackId) {
            const value = input.value.trim();
            const feedback = document.getElementById(feedbackId);
            let isValid = true;

            if (value.length === 0) {
                feedback.textContent = '* El campo no puede estar vacío.';
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                isValid = false;
            } else if (value.length < minLength) {
                feedback.textContent = `* El campo debe tener al menos ${minLength} caracteres.`;
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                isValid = false;
            } else if (value.length > maxLength) {
                feedback.textContent = `* El campo debe tener menos de ${maxLength} caracteres.`;
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                isValid = false;
            } else {
                feedback.textContent = '';
                input.classList.add('is-valid');
                input.classList.remove('is-invalid');
            }

            return isValid;
        }

        function validateForm() {
            const isNombreValid = validateInput(nombreInput, 3, 100, 'nombre-feedback');
            const isDescripcionValid = validateInput(descripcionInput, 5, 255, 'descripcion-feedback');
            const isPrecioValid = parseFloat(precioInput.value) > 0;
            const isCategoriaValid = codCategoriaFSelect.value !== '';

            if (!isPrecioValid) {
                document.getElementById('precio-feedback').textContent = '* El precio debe ser mayor a 0.';
                precioInput.classList.add('is-invalid');
                precioInput.classList.remove('is-valid');
            } else {
                document.getElementById('precio-feedback').textContent = '';
                precioInput.classList.add('is-valid');
                precioInput.classList.remove('is-invalid');
            }

            document.getElementById('codCategoriaF-feedback').textContent = isCategoriaValid ? '' : '* Debe seleccionar una categoría.';
            codCategoriaFSelect.classList.toggle('is-invalid', !isCategoriaValid);
            codCategoriaFSelect.classList.toggle('is-valid', isCategoriaValid);

            submitButton.disabled = !(isNombreValid && isDescripcionValid && isPrecioValid && isCategoriaValid);
        }

        nombreInput.addEventListener('input', validateForm);
        descripcionInput.addEventListener('input', validateForm);
        precioInput.addEventListener('input', validateForm);
        codCategoriaFSelect.addEventListener('change', validateForm);

        // Validar al cargar la página
        validateForm();
    });

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
@endsection
