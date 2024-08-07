@extends('layouts.plantilla')

@section('title', 'Modificar Usuario')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center my-4">EDITAR USUARIO</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('usuario.update', $usuario->codUsuario) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombreUsuario" class="form-label">Nombre:</label>
                            <input type="text" id="nombreUsuario" class="form-control @error('nombreUsuario') is-invalid @enderror" name="nombreUsuario" value="{{ old('nombreUsuario', $usuario->nombreUsuario) }}" required>
                            @error('nombreUsuario')
                                <div class="invalid-feedback">
                                    * {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $usuario->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">
                                    * {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña:</label>
                            <div class="input-group">
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password">
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

                        <div class="mb-3">
                            <label for="codTipoUsuarioF" class="form-label">Tipo de Usuario:</label>
                            <select name="codTipoUsuarioF" id="codTipoUsuarioF" class="form-select @error('codTipoUsuarioF') is-invalid @enderror" required>
                                @foreach ($tiposUsuario as $tipoUsuario)
                                    <option value="{{ $tipoUsuario->codTipoUsuario }}" {{ old('codTipoUsuarioF', $usuario->codTipoUsuarioF) == $tipoUsuario->codTipoUsuario ? 'selected' : '' }}>
                                        {{ $tipoUsuario->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('codTipoUsuarioF')
                                <div class="invalid-feedback">
                                    * {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('usuario.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Atrás
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-pencil-alt"></i> Modificar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        var icon = document.querySelector('#password + .btn i');

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
