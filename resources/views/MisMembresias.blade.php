@extends('layouts.clienteBase')

@section('title', 'Mis Membresías')

@section('content')
<div class="row justify-content-center mb-4">
  <div class="col-12 text-center">
    <h2 class="font-weight-bold" style="font-size: 2rem;">
      <em>¡Impulsa Tu Rutina con Tus Membresías Exclusivas aquí!</em>
    </h2>
  </div>
</div>
@if($membresias->isEmpty())
  <div class="row justify-content-center mb-4">
    <div class="col-12 text-center">
      <a class="navbar-brand" href="#">
        <span class="font-weight-bold">¡No tienes membresías aún!</span>
      </a>
      <p class="lead">Explora nuestras opciones para encontrar la membresía ideal para ti.</p>
    </div>
  </div>
@else
<div class="row justify-content-left mb-3">
  <div class="col-4 text-left">
    <label for="filter" class="font-weight-bold">Filtrar Membresías:</label>
    <select id="filter" class="form-control" aria-label="Filtrar Membresías">
      <option value="all">Todas</option>
      <option value="expired">Vencidas</option>
      <option value="active">Vigentes</option>
    </select>
  </div>
</div>

<div class="row">
  @foreach ($membresias as $membresia)
    @php

      $todosExpirados = $membresia->detalles->every(function ($detalle) {
        $fechaFin = \Carbon\Carbon::parse($detalle->fechaFin);
        return \Carbon\Carbon::now()->startOfDay()->gt($fechaFin);
      });
    @endphp
    <div class="col-md-4 mb-3">
      <div class="card membership-card">
        <div class="card-body">
          <div class="card-summary">
            <h5 class="card-title">Membresía: {{ $membresia->descripcion }}</h5>
            <p class="card-text pb-4"><strong>Precio total:</strong> {{ number_format($membresia->precioTotal, 2) }} Bs.</p>
          </div>
          <div class="card-details" style="display: none;">
            @if($membresia->detalles->isNotEmpty())
              @foreach ($membresia->detalles as $detalle)
                @php
                
                  $fechaInicio = \Carbon\Carbon::parse($detalle->fechaInicio);
                  $fechaFin = \Carbon\Carbon::parse($detalle->fechaFin);
                  $estado = 'Activo';
                  $fechaHoy = \Carbon\Carbon::now()->startOfDay(); 

             
                  if ($fechaHoy->gt($fechaFin)) {
                    $estado = 'Vencida';
                  } elseif ($fechaHoy->diffInDays($fechaFin) <= 7) {
                    $estado = 'Próximo a Expirar';
                  }
                @endphp
                <div class="service-details mb-4 p-3 border rounded">
                  <p><strong>Servicio:</strong> {{ $detalle->servicio->nombre }}</p>
                  <p><strong>Descripción:</strong> {{ $detalle->servicio->descripcion }}</p>
                  <p><strong>Tipo:</strong> {{ $detalle->tipo }}</p>     
                  <p><strong>Subtotal:</strong> {{ number_format($detalle->subTotal, 2) }} Bs.</p>
                  <p><strong>Fecha de inicio del servicio:</strong> 
                    {{ $fechaInicio->format('d/m/Y') }}
                  </p>
                  <p><strong>Fecha de fin del servicio:</strong> 
                    {{ $fechaFin->format('d/m/Y') }}
                  </p>
                  <p><strong>Horario:</strong> 
                    {{ $detalle->servicio->horario->horaInicio }} - {{ $detalle->servicio->horario->horaFin }}
                  </p>
                  <p><strong>Estado:</strong> 
                    <span class="badge badge-{{ $estado == 'Vencida' ? 'danger' : ($estado == 'Próximo a Expirar' ? 'warning' : 'success') }}">{{ $estado }}</span>
                  </p>
                </div>
              @endforeach
            @else
              <p>No hay detalles disponibles para esta membresía.</p>
            @endif
          </div>
          @if($todosExpirados)
            <div class="overlay">
              <div class="overlay-text">Vencida</div>
            </div>
          @endif
        </div>
      </div>
    </div>
  @endforeach
</div>
@endif
@endsection

@push('styles')
<style>
.membership-card {
  position: relative;
  cursor: pointer;
  transition: box-shadow 0.3s ease;
}

.membership-card:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.card-summary {
  margin-bottom: 0;
}

.card-details {
  transition: max-height 0.3s ease-out;
  overflow: hidden;
}

.card-details.expanded {
  display: block;
}

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 0, 0, 0.5);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  font-weight: bold;
  text-align: center;
  z-index: 10;
}
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const filterSelect = document.getElementById('filter');

  function filterCards() {
    const filterValue = filterSelect.value;
    document.querySelectorAll('.membership-card').forEach(card => {
      const overlay = card.querySelector('.overlay');
      const isExpired = overlay !== null;
      
      switch (filterValue) {
        case 'all':
          card.style.display = 'block';
          break;
        case 'expired':
          card.style.display = isExpired ? 'block' : 'none';
          break;
        case 'active':
          card.style.display = isExpired ? 'none' : 'block';
          break;
      }
    });
  }

  filterSelect.addEventListener('change', filterCards);
  
  document.querySelectorAll('.membership-card').forEach(card => {
    card.addEventListener('click', function() {
      const details = this.querySelector('.card-details');
      if (details.style.display === 'none' || !details.style.display) {
        details.style.display = 'block';
      } else {
        details.style.display = 'none';
      }
    });
  });

  // Inicializar el filtro para mostrar todos los cards al cargar
  filterCards();
});
</script>
@endpush
