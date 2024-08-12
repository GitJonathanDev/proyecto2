@extends('layouts.plantilla')

@section('title', 'Modificar pago')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center my-4">EDITAR PAGO</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('pago.update', $pago) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="monto" class="form-label">Monto:</label>
                            <input type="text" id="monto" class="form-control" name="monto" value="{{ old('monto', $pago->monto) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha:</label>
                            <input type="date" id="fecha" class="form-control" name="fecha" value="{{ old('fecha', $pago->fecha) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="formaPago" class="form-label">formaPago:</label>
                            <select id="formaPago" class="form-control" name="formaPago" required>
                                <option value="">Selecciona el formaPago</option>
                                <option value="efectivo" {{ old('formaPago', $pago->formaPago) == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                                <option value="qr" {{ old('formaPago', $pago->formaPago) == 'qr' ? 'selected' : '' }}>Qr</option>
                            </select>
                        </div>
                        <div class="text-center mt-4">
                            <a href="{{ route('pago.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Atrás
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-pencil-alt"></i> Modificar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
