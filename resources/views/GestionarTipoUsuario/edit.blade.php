@extends('layouts.plantilla')

@section('title', 'Modificar Tipo de Usuario')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h1 class="text-center mb-0">Editar Tipo de Usuario</h1>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('tipoUsuario.update', $tipoUsuario->codTipoUsuario) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3 row">
                            <label for="descripcion" class="col-sm-3 col-form-label">Descripción:</label>
                            <div class="col-sm-9">
                                <input type="text" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" value="{{ old('descripcion', $tipoUsuario->descripcion) }}" required>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('tipoUsuario.index') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left"></i> Atrás
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-pencil-alt"></i> Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
