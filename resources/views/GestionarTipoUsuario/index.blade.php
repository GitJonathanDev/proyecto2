@extends('layouts.plantilla')

@section('title', 'Gestionar Tipos de Usuario')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="mb-4 fw-bold">Lista de Tipos de Usuario</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('tipoUsuario.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Registrar
            </a>
            <form action="{{ route('tipoUsuario.index') }}" method="GET" class="d-flex align-items-center">
                <div class="input-group">
                    <select name="criterio" class="form-select">
                        <option value="descripcion" {{ request('criterio') === 'descripcion' ? 'selected' : '' }}>Descripción</option>
                    </select>
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar tipo de usuario" value="{{ request('buscar') }}">
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
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tipoUsuarios as $item)
                        <tr>
                            <td>{{ $item->codTipoUsuario }}</td>
                            <td>{{ $item->descripcion }}</td>
                            <td>
                                <a href="{{ route('tipoUsuario.edit', $item->codTipoUsuario) }}" class="btn btn-warning btn-sm me-2" title="Editar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('tipoUsuario.destroy', $item->codTipoUsuario) }}" method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete" title="Eliminar">
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
        <div class="col-12 d-flex justify-content-between align-items-center">
            @if ($tipoUsuarios->currentPage() !== 1)
            <a href="{{ $tipoUsuarios->previousPageUrl() }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Anterior
            </a>
            @endif
            @if ($tipoUsuarios->hasMorePages())
            <a href="{{ $tipoUsuarios->nextPageUrl() }}" class="btn btn-primary">
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
        title: '¡Éxito!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonText: 'Aceptar'
    });
    @elseif (session('error'))
    Swal.fire({
        title: 'Error',
        text: "{{ session('error') }}",
        icon: 'error',
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
