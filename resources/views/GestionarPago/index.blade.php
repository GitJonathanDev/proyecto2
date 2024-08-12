@extends('layouts.plantilla')

@section('title', 'Gestionar pago')

@section('content')
<div class="container">
  <div class="row mb-4">
      <div class="col-12 text-center">
          <h1 class="mb-3 fw-bold">LISTA DE PAGOS</h1>
      </div>
  </div>
  <div class="row mb-4">
      <div class="col-12 d-flex justify-content-between align-items-center">
          <form action="{{ route('pago.index') }}" method="GET" class="d-flex">
              @csrf
              <div class="input-group">
                  <input type="date" name="fecha_inicio" class="form-control" placeholder="Fecha de inicio" aria-label="Fecha de inicio">
                  <input type="date" name="fecha_fin" class="form-control" placeholder="Fecha de fin" aria-label="Fecha de fin">
                  <button class="btn btn-outline-secondary" type="submit">
                      <i class="fas fa-filter"></i> Filtrar por fechas
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
                          <th>Cod Pago</th>
                          <th>Monto</th>
                          <th>Fecha</th>
                          <th>Cliente</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($pagos as $item)
                      <tr>
                          <td>{{ $item->codPago }}</td>
                          <td>Bs. {{ number_format($item->monto, 2) }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->fechaPago)->format('d/m/Y') }}</td>
                          <td>
                              @if ($item->cliente)
                                  {{ $item->cliente->nombre }}
                              @else
                                  Cliente no encontrado
                              @endif
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
          @if ($pagos->currentPage() !== 1)
          <a href="{{ $pagos->previousPageUrl() }}" class="btn btn-primary">
              <i class="fas fa-arrow-left"></i> Anterior
          </a>
          @endif
          @if ($pagos->hasMorePages())
          <a href="{{ $pagos->nextPageUrl() }}" class="btn btn-primary">
              Siguiente <i class="fas fa-arrow-right"></i>
          </a>
          @endif
      </div>
  </div>
</div>

@if (session('delete'))
    <div class="alert alert-success mt-3">
        {{ session('delete') }}
    </div>
@endif
@endsection
