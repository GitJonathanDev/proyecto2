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
                <input type="text" id="codProducto" class="form-control" name="codProducto" value="{{ old('codProducto') }}" required>
                <div id="codProducto-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre:</label>
            <div class="col-sm-9">
                <input type="text" id="nombre" class="form-control" name="nombre" value="{{ old('nombre') }}" required>
                <div id="nombre-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="descripcion" class="col-sm-3 col-form-label">Descripción:</label>
            <div class="col-sm-9">
                <input type="text" id="descripcion" class="form-control" name="descripcion" value="{{ old('descripcion') }}" required>
                <div id="descripcion-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="precio" class="col-sm-3 col-form-label">Precio:</label>
            <div class="col-sm-9">
                <input type="number" id="precio" class="form-control" name="precio" value="{{ old('precio') }}" required>
                <div id="precio-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="codCategoriaF" class="col-sm-3 col-form-label">Categoría:</label>
            <div class="col-sm-9">
                <select id="codCategoriaF" class="form-select" name="codCategoriaF" required>
                    <option value="">Seleccione una categoría</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->codCategoria }}" {{ old('codCategoriaF') == $cat->codCategoria ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                    @endforeach
                </select>
                <div id="codCategoriaF-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="imagen" class="col-sm-3 col-form-label">Imagen:</label>
            <div class="col-sm-9">
                <input type="file" id="imagen" class="form-control" name="imagen" accept="image/*">
                <img id="imagenPrevia" src="#" alt="Imagen Previa" class="img-fluid mt-2" style="display: none;">
                <div id="imagen-feedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('producto.index') }}" class="btn btn-secondary me-3">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" id="submit-button" class="btn btn-primary" disabled>
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formulario = document.getElementById('formularioProducto');
        const codProductoInput = document.getElementById('codProducto');
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
            const isCodProductoValid = validateInput(codProductoInput, 2, 20, 'codProducto-feedback');
            const isNombreValid = validateInput(nombreInput, 2, 50, 'nombre-feedback');
            const isDescripcionValid = validateInput(descripcionInput, 5, 250, 'descripcion-feedback');
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

            submitButton.disabled = !(isCodProductoValid && isNombreValid && isDescripcionValid && isPrecioValid && isCategoriaValid);
        }

        codProductoInput.addEventListener('input', validateForm);
        nombreInput.addEventListener('input', validateForm);
        descripcionInput.addEventListener('input', validateForm);
        precioInput.addEventListener('input', validateForm);
        codCategoriaFSelect.addEventListener('change', validateForm);

        // Validar al cargar la página
        validateForm();
    });
</script>
@endsection
@endsection
