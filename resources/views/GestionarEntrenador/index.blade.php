@extends('layouts.plantillaAdministrador')

@section('title', 'Gestionar entrenador')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-12 text-center">
            <h1 class="mb-3 fw-bold">LISTA DE ENTRENADORES</h1>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('entrenador.create') }}" class="btn btn-primary">Registrar</a>
            <form action="{{ route('entrenador.index') }}" method="get">
                <div class="input-group">
                    <select name="criterio" class="form-select">
                        <option value="nombre">Nombre</option>
                    </select>
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar entrenador" aria-label="Buscar entrenador" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
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
                            <th scope="col">ID</th>
                            <th scope="col">Carnte de Identidad</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido Paterno</th>
                            <th scope="col">Apellido Materno</th>
                            <th scope="col">Sexo</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entrenador as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->carnteIdentidad }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->apellidoPaterno }}</td>
                            <td>{{ $item->apellidoMaterno }}</td>
                            <td>{{ $item->sexo }}</td>
                            <td>{{ $item->telefono }}</td>
                            <td>
                                <a href="/entrenador/edit/{{ $item->id }}" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                                <form action="/entrenador/eliminar/{{ $item->id }}" method="POST" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este entrenador?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center">
            {{ $entrenador->links() }}
        </div>
    </div>

    @if (session('delete'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success mt-3">
                {{ session('delete') }}
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
