@extends('layouts.plantilla')

@section('title', 'Lista de Usuarios')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="mb-3 fw-bold">LISTA DE USUARIOS</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('usuario.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Registrar Usuario
            </a>
            <form action="{{ route('usuario.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <select name="criterio" class="form-select">
                        <option value="" disabled selected>Seleccionar criterio</option>
                        <option value="nombreUsuario" {{ request('criterio') == 'nombreUsuario' ? 'selected' : '' }}>Nombre</option>
                        <option value="codTipoUsuarioF" {{ request('criterio') == 'codTipoUsuarioF' ? 'selected' : '' }}>Tipo de Usuario</option>
                    </select>
                    <input type="text" name="buscar" class="form-control" value="{{ request('buscar') }}" placeholder="Buscar usuario" aria-label="Buscar usuario">
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
                            <th>Código de Usuario</th>
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
                            <td>********</td>
                            <td>{{ $usuario->tipoUsuario->descripcion }}</td>
                            <td class="d-flex justify-content-around">
                                @if($usuario->codUsuario != 2)
                                <a href="{{ route('usuario.edit', $usuario->codUsuario) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                @endif
                                @if($usuario->codUsuario != 2 && $usuario->codUsuario != 1)
                                <form action="{{ route('usuario.destroy', $usuario->codUsuario) }}" method="POST" class="d-inline form-delete">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete" title="Eliminar">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-between">
            @if ($usuarios->currentPage() > 1)
            <a href="{{ $usuarios->previousPageUrl() }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Anterior
            </a>
            @endif

            @if ($usuarios->hasMorePages())
            <a href="{{ $usuarios->nextPageUrl() }}" class="btn btn-primary">
                Siguiente <i class="fas fa-arrow-right"></i>
            </a>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if (session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: '{{ session('success') }}',
        confirmButtonText: 'Aceptar'
    });
    @elseif (session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        confirmButtonText: 'Aceptar'
    });
    @endif

    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@endsection
