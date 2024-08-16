@extends('layouts.plantilla')

@section('title', 'Gestionar Menú')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Gestionar Menú</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="text-end mb-3">
        <a href="{{ route('menu.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Añadir Menú
        </a>
    </div>

    <form method="GET" action="{{ route('menu.index2') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar..." value="{{ request('buscar') }}">
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>URL</th>
                <th>Ícono</th>
                <th>Tipo de Usuario</th>
                <th>Menú Padre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menus as $menu)
                <tr>
                    <td>{{ $menu->id }}</td>
                    <td>{{ $menu->nombre }}</td>
                    <td>{{ $menu->url }}</td>
                    <td>{{ $menu->icono }}</td>
                    <td>{{ $tiposUsuario->firstWhere('codTipoUsuario', $menu->codTipoUsuarioF)->descripcion ?? 'Desconocido' }}</td>
                    <td>{{ $menu->padreId }}</td>
                    <td>
                        <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-pencil-alt"></i> Editar
                        </a>
                        <form action="{{ route('menu.clone', $menu->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-info btn-sm">
                                <i class="fas fa-copy"></i> Clonar
                            </button>
                        </form>
                        <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este menú?')">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection