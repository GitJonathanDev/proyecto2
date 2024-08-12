@extends('layouts.plantilla')

@section('title', 'Gestionar Categorías')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="mb-4 fw-bold">Lista de Categorías</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('categoria.create') }}" class="btn btn-primary"> <i class="fas fa-plus"></i> Registrar categoría</a>
            <form action="{{ route('categoria.index') }}" method="GET" class="d-flex align-items-center">
                <div class="input-group">
                    <select name="criterio" class="form-select">
                        <option value="nombre">Nombre</option>
                    </select>
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar">
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
                            <th>Código de Categoría</th>
                            <th>Nombre</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->codCategoria }}</td>
                            <td>{{ $categoria->nombre }}</td>
                            <td>
                                <a href="{{ route('categoria.edit', $categoria->codCategoria) }}" class="btn btn-warning btn-sm me-2"><i class="fas fa-edit"></i> Editar</a>
                                <form action="{{ route('categoria.destroy', $categoria->codCategoria) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</button>
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
            @if ($categorias->currentPage() !== 1)
            <a href="{{ $categorias->previousPageUrl() }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Anterior
            </a>
            @endif
            @if ($categorias->hasMorePages())
            <a href="{{ $categorias->nextPageUrl() }}" class="btn btn-primary">
                Siguiente <i class="fas fa-arrow-right"></i>
            </a>
            @endif
        </div>
    </div>
</div>

@if (session('delete'))
    <div class="alert alert-success mt-4">
        {{ session('delete') }}
    </div>
@endif

@endsection
