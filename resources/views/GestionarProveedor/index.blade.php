@extends('layouts.plantilla')

@section('title', 'Gestionar Proveedores')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="mb-4 fw-bold">Lista de Proveedores</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('proveedor.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Registrar Proveedor</a>
            <form action="{{ route('proveedor.index') }}" method="GET" class="d-flex align-items-center">
                <div class="input-group">
                    <select name="criterio" class="form-select">
                        <option value="nombre">Nombre</option>
                        <option value="direccion">Dirección</option>
                        <option value="telefono">Teléfono</option>
                    </select>
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar" value="{{ request('buscar') }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i> Buscar</button>
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
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($proveedor as $item)
                        <tr>
                            <td>{{ $item->codProveedor }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->direccion }}</td>
                            <td>{{ $item->telefono }}</td>
                            <td>
                                <a href="{{ route('proveedor.edit', $item->codProveedor) }}" class="btn btn-warning btn-sm me-2"><i class="fas fa-edit"></i> Editar</a>
                                <form action="{{ route('proveedor.destroy', $item->codProveedor) }}" method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"></i> Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No se encontraron proveedores.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            @if ($proveedor->currentPage() !== 1)
            <a href="{{ $proveedor->previousPageUrl() }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Anterior
            </a>
            @endif
            @if ($proveedor->hasMorePages())
            <a href="{{ $proveedor->nextPageUrl() }}" class="btn btn-primary">
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
