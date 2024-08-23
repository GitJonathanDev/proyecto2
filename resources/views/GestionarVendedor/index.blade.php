@extends('layouts.plantilla')

@section('title', 'Lista de Encargados')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="mb-3 fw-bold">LISTA DE ENCARGADOS</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('vendedor.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Registrar</a>
            <form action="{{ route('vendedor.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <select name="criterio" class="form-select">
                        <option value="" disabled selected>Seleccionar criterio</option>
                        <option value="nombre">Nombre</option>
                    </select>
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar" aria-label="Buscar">
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
                            <th scope="col">Carnet de Identidad</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido Paterno</th>
                            <th scope="col">Apellido Materno</th>
                            <th scope="col">Sexo</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendedores as $item)
                        <tr>
                            <td>{{ $item->carnetIdentidad }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->apellidoPaterno }}</td>
                            <td>{{ $item->apellidoMaterno }}</td>
                            <td>{{ $item->sexo }}</td>
                            <td>{{ $item->telefono }}</td>
                            <td>{{ $item->usuario ? $item->usuario->nombreUsuario : 'N/A' }}</td>
                            <td class="d-flex justify-content-around">
                                <a href="{{ route('vendedor.edit', $item->carnetIdentidad) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('vendedor.destroy', $item->carnetIdentidad) }}" method="POST" class="d-inline form-delete">
                                    @method('DELETE')
                                    @csrf
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
        <div class="col-12 d-flex justify-content-between">
            @if ($vendedores->currentPage() > 1)
            <a href="{{ $vendedores->previousPageUrl() }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Anterior
            </a>
            @endif

            @if ($vendedores->hasMorePages())
            <a href="{{ $vendedores->nextPageUrl() }}" class="btn btn-primary">
                Siguiente <i class="fas fa-arrow-right"></i>
            </a>
            @endif
        </div>
    </div>
</div>

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
@endsection
