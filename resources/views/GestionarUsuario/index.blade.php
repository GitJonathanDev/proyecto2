@extends('layouts.plantilla')

@section('title', 'Gestionar Usuarios')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="mb-4 fw-bold">Lista de Usuarios</h1>
            <a href="{{ route('usuario.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Registrar Usuario
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 d-flex">
            <form action="{{ route('usuario.index') }}" method="GET" class="d-flex align-items-center w-100">
                <div class="input-group w-100">
                    <select name="criterio" class="form-select">
                        <option value="nombreUsuario" {{ request('criterio') == 'nombreUsuario' ? 'selected' : '' }}>Nombre</option>
                        <option value="codTipoUsuarioF" {{ request('criterio') == 'codTipoUsuarioF' ? 'selected' : '' }}>Tipo de Usuario</option>
                    </select>
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar usuario" aria-label="Buscar usuario" value="{{ request('buscar') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre de Usuario</th>
                            <th>Email</th>
                            <th>Contraseña</th>
                            <th>Tipo de Usuario</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->codUsuario }}</td>
                            <td>{{ $usuario->nombreUsuario }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>********</td> <!-- Muestra texto en lugar de la contraseña -->
                            <td>{{ $usuario->tipoUsuario->descripcion }}</td>
                            <td>
                                <a href="{{ route('usuario.edit', $usuario->codUsuario) }}" class="btn btn-warning btn-sm me-2" title="Editar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('usuario.destroy', $usuario->codUsuario) }}" method="POST" class="d-inline">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
            {{ $usuarios->links() }}
        </div>
    </div>

    @if (session('success'))
    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
