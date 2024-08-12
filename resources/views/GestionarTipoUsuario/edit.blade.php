@extends('layouts.plantilla')

@section('title', 'Modificar Tipo de Usuario')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h1 class="text-center mb-0">Editar Tipo de Usuario</h1>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('tipoUsuario.update', $tipoUsuario->codTipoUsuario) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3 row">
                            <label for="descripcion" class="col-sm-3 col-form-label">Descripción:</label>
                            <div class="col-sm-9">
                                <input type="text" id="descripcion" name="descripcion" value="{{ old('descripcion', $tipoUsuario->descripcion) }}" class="form-control @error('descripcion') is-invalid @enderror" placeholder="Ingrese la descripción del tipo de usuario" required>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="descripcion-feedback" class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('tipoUsuario.index') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left"></i> Atrás
                            </a>
                            <button type="submit" id="submit-button" class="btn btn-primary" disabled>
                                <i class="fas fa-pencil-alt"></i> Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const descripcionInput = document.getElementById('descripcion');
        const submitButton = document.getElementById('submit-button');
        const descripcionFeedback = document.getElementById('descripcion-feedback');

        function validateDescripcion() {
            const descripcion = descripcionInput.value.trim();
            const isValid = descripcion.length > 2 && descripcion.length < 21;
            if (!isValid) {
                descripcionFeedback.textContent = '* La descripción debe tener entre 3 y 20 caracteres.';
                descripcionInput.classList.add('is-invalid');
                descripcionInput.classList.remove('is-valid');
            } else {
                descripcionFeedback.textContent = '';
                descripcionInput.classList.add('is-valid');
                descripcionInput.classList.remove('is-invalid');
            }
            return isValid;
        }

        function validateForm() {
            const isDescripcionValid = validateDescripcion();
            submitButton.disabled = !isDescripcionValid;
        }

        descripcionInput.addEventListener('input', function() {
            validateDescripcion();
            validateForm();
        });

        // Validar al cargar la página
        validateForm();
    });
</script>
@endsection
@endsection
