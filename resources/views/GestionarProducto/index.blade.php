@extends('layouts.plantilla')

@section('title', 'Lista de Productos')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="mb-3 fw-bold">LISTA DE PRODUCTOS</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('producto.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Registrar Producto
            </a>
            <form action="{{ route('producto.index') }}" method="GET" class="d-flex">
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
                            <th scope="col">Código</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Imagen</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                        <tr>
                            <td>{{ $producto->codProducto }}</td>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>{{ number_format($producto->precio, 2) }} Bs.</td>
                            <td>{{ $producto->stock }}</td>
                            <td>{{ $producto->categoria->nombre ?? 'No disponible' }}</td>
                            <td>
                                @if ($producto->imagen_url)
                                    <img src="{{ asset('storage/uploads/' . $producto->imagen_url) }}" alt="Imagen del producto" class="img-thumbnail" style="max-width: 120px;">
                                @else
                                    No tiene imagen
                                @endif
                            </td>
                            <td class="d-flex justify-content-around">
                                <a href="{{ route('producto.edit', $producto->codProducto) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('producto.destroy', $producto->codProducto) }}" method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete">
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
            @if ($productos->currentPage() > 1)
            <a href="{{ $productos->previousPageUrl() }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Anterior
            </a>
            @endif

            @if ($productos->hasMorePages())
            <a href="{{ $productos->nextPageUrl() }}" class="btn btn-primary">
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
