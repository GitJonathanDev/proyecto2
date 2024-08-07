@extends('layouts.plantilla')

@section('title', 'Registrar Usuario')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Registrar Usuario</h1>

    <form action="{{ route('usuario.store') }}" method="POST">
        @csrf

        <div class="mb-3 row">
            <label for="nombreUsuario" class="col-sm-3 col-form-label">Nombre:</label>
            <div class="col-sm-9">
                <input type="text" id="nombreUsuario" name="nombreUsuario" value="{{ old('nombreUsuario') }}" class="form-control @error('nombreUsuario') is-invalid @enderror" placeholder="Ingrese el nombre del usuario">
                @error('nombreUsuario')
                    <div class="invalid-feedback">
                        * {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="email" class="col-sm-3 col-form-label">Email:</label>
            <div class="col-sm-9">
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Ingrese el email del usuario">
                @error('email')
                    <div class="invalid-feedback">
                        * {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="password" class="col-sm-3 col-form-label">Contraseña:</label>
            <div class="col-sm-9">
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Ingrese la contraseña">
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">
                        * {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="codTipoUsuarioF" class="col-sm-3 col-form-label">Tipo de Usuario:</label>
            <div class="col-sm-9">
                <select name="codTipoUsuarioF" id="codTipoUsuarioF" class="form-select @error('codTipoUsuarioF') is-invalid @enderror">
                    <option value="">Seleccionar tipo de usuario</option>
                    @foreach ($tiposUsuario as $tipoUsuario)
                        <option value="{{ $tipoUsuario->codTipoUsuario }}">{{ $tipoUsuario->descripcion }}</option>
                    @endforeach
                </select>
                @error('codTipoUsuarioF')
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
            <a href="{{ route('usuario.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>

<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        var icon = document.querySelector('#password + button i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection
