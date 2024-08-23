@extends('layouts.plantilla')

@section('title', 'Gestionar Precios de Servicio')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="mb-3 fw-bold">LISTA DE PRECIOS DE SERVICIO</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('precioServicio.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Registrar Precio de Servicio
            </a>
            <form action="{{ route('precioServicio.index') }}" method="GET" class="d-flex align-items-center">
                <div class="input-group">
                    <select name="criterio" class="form-select">
                        <option value="tipo" {{ request('criterio') === 'tipo' ? 'selected' : '' }}>Tipo</option>
                        <option value="precio" {{ request('criterio') === 'precio' ? 'selected' : '' }}>Precio</option>
                    </select>
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar" value="{{ request('buscar') }}" aria-label="Buscar">
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
                            <th>Tipo</th>
                            <th>Precio</th>
                            <th>Servicio</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($preciosServicio as $precioServicio)
                        <tr>
                            <td>{{ $precioServicio->codPrecioServicio }}</td>
                            <td>{{ $precioServicio->tipo }}</td>
                            <td>{{ $precioServicio->precio }}</td>
                            <td>{{ $precioServicio->servicio->nombre }}</td>
                            <td>
                                <a href="{{ route('precioServicio.edit', $precioServicio->codPrecioServicio) }}" class="btn btn-warning btn-sm me-2">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('precioServicio.destroy', $precioServicio->codPrecioServicio) }}" method="POST" class="d-inline form-delete">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay precios de servicio registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Navegación entre páginas -->
    @if ($preciosServicio->hasPages())
    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            @if ($preciosServicio->onFirstPage())
                <span class="btn btn-secondary disabled">
                    <i class="fas fa-arrow-left"></i> Anterior
                </span>
            @else
                <a href="{{ $preciosServicio->previousPageUrl() }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Anterior
                </a>
            @endif
            @if ($preciosServicio->hasMorePages())
                <a href="{{ $preciosServicio->nextPageUrl() }}" class="btn btn-primary">
                    Siguiente <i class="fas fa-arrow-right"></i>
                </a>
            @else
                <span class="btn btn-secondary disabled">
                    Siguiente <i class="fas fa-arrow-right"></i>
                </span>
            @endif
        </div>
    </div>
    @endif
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
