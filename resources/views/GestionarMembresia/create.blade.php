@extends('layouts.plantilla')

@section('title', 'Realizar venta de membresía')

@section('content')
<style>
    .iframe-wrapper {
        margin-top: 20px;
    }

    .iframe-container {
        position: relative;
        width: 100%;
        padding-top: 56.25%; 
    }

    .iframe-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-12">
          
            <div class="card border-success" style="max-width: 100%; margin: auto;">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title">Realizar Venta de Membresía</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
    
                    <form id="formularioVenta" action="{{ route('membresia.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="serviciosSeleccionadosInput" name="serviciosSeleccionados">
                        <input type="hidden" id="precioTotalInput" name="precioTotal">
                        <input type="hidden" id="fechaInicioInput" name="fechaInicio">
                        <input type="hidden" id="fechaFinInput" name="fechaFin">
                        <input type="hidden" id="codServiciosF" name="codServiciosF">
                        
                        <div class="form-group">
                            <label for="buscarCliente">Buscar Cliente:</label>
                            <input type="text" class="form-control" id="buscarCliente" placeholder="Buscar cliente...">
                            <ul id="resultadosClientes" class="list-group mt-2" style="max-height: 200px; overflow-y: auto;"></ul>
                            <input type="hidden" id="codClienteF" name="codClienteF" required>
                            <input type="hidden" id="telefono" name="telefono" required>
                        </div>
                        <input type="hidden" id="codEncargadoF" name="codEncargadoF" value="{{ $encargado->carnetIdentidad }}">

                        <div class="form-group row">
                            <label for="descripcion" class="col-sm-3 col-form-label">Descripción:</label>
                            <div class="col-sm-9">
                                <input type="text" id="descripcion" class="form-control" name="descripcion" value="{{ old('descripcion') }}">
                                @error('descripcion')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    
                        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#buscarServicioModal">
                            <i class="fas fa-search"></i> Buscar Servicio
                        </button>
                    
                        <button type="submit" class="btn btn-success mb-3">
                            Realizar Venta de Membresía
                        </button>
                    
                        @if(isset($membresia))
                        <a href="{{ route('membresia.show', $membresia->codMembresia) }}" class="btn btn-info mb-3">
                            Ver Detalle de Venta de Membresía
                        </a>
                        @endif
                    
                        <a href="{{ route('membresia.index') }}" class="btn btn-secondary mb-3">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
  
    <div class="modal fade" id="buscarServicioModal" tabindex="-1" role="dialog" aria-labelledby="buscarServicioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-success">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="buscarServicioModalLabel">Buscar Servicio</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <form id="formBuscarServicio">
                        <div class="form-group">
                            <label for="nombreServicio">Buscar por Nombre:</label>
                            <input type="text" class="form-control" id="nombreServicio" name="nombreServicio" placeholder="Ingrese el nombre del servicio">
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Tipo</th>
                                    <th>Horario</th>
                                    <th>Opción</th>
                                </tr>
                            </thead>
                            <tbody id="tablaServicios">
                                @foreach ($servicios as $servicio)
                                <tr>
                                    <td>{{ $servicio->nombre }}</td>
                                    <td>{{ $servicio->descripcion }}</td>
                                    <td>
                                        <select class="form-control tipo-precio" data-cod-servicio="{{ $servicio->codServicio }}">
                                            @foreach ($servicio->precios as $precio)
                                            <option value="{{ $precio->id }}" data-tipo="{{ $precio->tipo }}" data-precio="{{ $precio->precio }}">
                                                {{ ucfirst($precio->tipo) }} - ${{ $precio->precio }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        {{ $servicio->horario ? $servicio->horario->horaInicio . ' - ' . $servicio->horario->horaFin : 'Sin horario' }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm seleccionar-servicio" data-cod-servicio="{{ $servicio->codServicio }}">Seleccionar</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                   
                    <div class="mt-4 d-none" id="infoServicioCard">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title">Información del Servicio Seleccionado</h5>
                            </div>
                            <div class="card-body">
                                <form id="formServicioSeleccionado">
                                    <div class="form-group">
                                        <label for="fechaInicio">Fecha de Inicio:</label>
                                        <input type="date" class="form-control" id="fechaInicio" name="fechaInicio">
                                    </div>
                                    <div class="form-group">
                                        <label for="cantidadServicio">Cantidad:</label>
                                        <input type="number" class="form-control" id="cantidadServicio" min="1" value="1">
                                    </div>
                                    <div class="form-group">
                                        <label for="fechaFin">Fecha de Fin:</label>
                                        <input type="date" class="form-control" id="fechaFin" name="fechaFin" readonly>
                                    </div>
                                </form>
                                <div id="infoServicioSeleccionado">
                                    <p><strong>Nombre:</strong> <span id="nombreServicioSeleccionado"></span></p>
                                    <p><strong>Descripción:</strong> <span id="descripcionServicioSeleccionado"></span></p>
                                    <p><strong>Tipo de Precio:</strong> <span id="tipoPrecioSeleccionado"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" id="confirmarSeleccionServicio">Confirmar Selección</button>
                </div>
            </div>
        </div>
    </div>
   
    <div class="mt-4">
        <div class="card border-success" style="max-width: 100%; margin: auto;">
            <div class="card-header bg-success text-white">
                <h5 class="card-title">Servicios Seleccionados</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                            <th>Fecha Fin</th>
                            <th>Opción</th>
                        </tr>
                    </thead>
                    <tbody id="serviciosSeleccionados">
              
                    </tbody>
                </table>
            </div>
        </div>
    </div>

  
    <div class="mt-4">
        <div class="card border-success" style="max-width: 400px; margin: auto;">
            <div class="card-header bg-success text-white">
                <h5 class="card-title">Total de la Membresía</h5>
            </div>
            <div class="card-body">
                <p class="card-text" style="font-size: 2rem; font-weight: bold; color: #0c0c0c;">
                    <span id="precioTotal">0</span> Bs.
                </p>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
   
        <div class="row mb-4">
    
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Realizar pago</h3>
                        <form action="{{ route('consumirServicio') }}" method="POST" target="QrImage">
                            @csrf
                            <input type="hidden" name="idcliente" value="112">
                            <input type="hidden" name="tcRazonSocial" value="115" required>
                            <input type="hidden" name="tcCiNit" value="151" required>
                            <input type="hidden" name="tcCorreo" value="asdf@afdsf.com" required>
                            <input type="hidden" name="tnMonto" id="montoTotal" placeholder="Costo Total" value="" required>
            
                            <div class="form-row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="tnTipoServicio">Tipo de Servicio</label>
                                    <select name="tnTipoServicio" id="tnTipoServicio" class="form-control" required>
                                        <option value="1">Servicio QR</option>
                                        <option value="2">Tigo Money</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tnTelefono">Número de cuenta</label>
                                    <input type="text" name="tnTelefono" id="tnTelefono" class="form-control" value="787878" readonly>
                                </div>
                            </div>
            
                            <div class="form-group text-right mt-4">
                                <button type="submit" class="btn btn-secondary">
                                    Consumir
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
           
            <div class="col-md-6">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <iframe name="QrImage" class="w-100" style="height: 400px; border: 1px solid #ddd;"></iframe>
                </div>
            </div>










        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buscarCliente = document.getElementById('buscarCliente');
        const resultadosClientes = document.getElementById('resultadosClientes');
        const telefono = document.getElementById('telefono'); 
        const codClienteF = document.getElementById('codClienteF'); 
        const tnTelefono = document.getElementById('tnTelefono'); 

        const buscarClienteUrl = "{{ route('membresia.buscar') }}";

        buscarCliente.addEventListener('input', () => {
            const query = buscarCliente.value;
            fetch(`${buscarClienteUrl}?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    resultadosClientes.innerHTML = '';
                    data.forEach(cliente => {
                        const item = document.createElement('li');
                        item.classList.add('list-group-item');
                        item.textContent = `${cliente.nombre} ${cliente.apellidoPaterno}`;
                        item.dataset.carnetIdentidad = cliente.carnetIdentidad;
                        item.dataset.telefono = cliente.telefono;
                        item.addEventListener('click', () => {
                            buscarCliente.value = `${cliente.nombre} ${cliente.apellidoPaterno}`;
                            
                            telefono.value = cliente.telefono;
                            codClienteF.value = cliente.carnetIdentidad;
                            tnTelefono.value = cliente.telefono; 

                            resultadosClientes.innerHTML = '';
                        });
                        resultadosClientes.appendChild(item);
                    });
                });
        });

        document.querySelectorAll('.seleccionar-servicio').forEach(button => {
            button.addEventListener('click', function() {
                const servicioId = this.getAttribute('data-cod-servicio');
                const row = this.closest('tr');

                const nombre = row.querySelector('td:nth-child(1)').textContent;
                const descripcion = row.querySelector('td:nth-child(2)').textContent;
                const tipoPrecio = row.querySelector('.tipo-precio option:checked').dataset.tipo + ' - $' + row.querySelector('.tipo-precio option:checked').dataset.precio;

                document.getElementById('nombreServicioSeleccionado').textContent = nombre;
                document.getElementById('descripcionServicioSeleccionado').textContent = descripcion;
                document.getElementById('tipoPrecioSeleccionado').textContent = tipoPrecio;

                document.getElementById('infoServicioCard').classList.remove('d-none');

                $('#confirmarSeleccionServicio').data({
                    id: servicioId,
                    nombre: nombre,
                    descripcion: descripcion,
                    tipoPrecio: tipoPrecio.split(' - ')[0],
                    precio: parseFloat(tipoPrecio.split(' - $')[1]),
                    codServicio: servicioId
                });
            });
        });

        $(document).ready(function () {
            var serviciosSeleccionados = [];

            function calcularFechaFin(fechaInicio, tipo, cantidad) {
                var fecha = new Date(fechaInicio);
                if (tipo === 'Diario') {
                    fecha.setDate(fecha.getDate() + cantidad);
                } else if (tipo === 'Mensual') {
                    fecha.setMonth(fecha.getMonth() + cantidad);
                } else if (tipo === 'Anual') {
                    fecha.setFullYear(fecha.getFullYear() + cantidad);
                }
                var dia = ("0" + fecha.getDate()).slice(-2);
                var mes = ("0" + (fecha.getMonth() + 1)).slice(-2);
                var anio = fecha.getFullYear();
                return `${anio}-${mes}-${dia}`;
            }

            function actualizarFechaFin() {
                var fechaInicio = $('#fechaInicio').val();
                var cantidad = parseInt($('#cantidadServicio').val(), 10);
                var tipoPrecio = $('#confirmarSeleccionServicio').data('tipoPrecio');
                if (fechaInicio && !isNaN(cantidad) && tipoPrecio) {
                    var fechaFin = calcularFechaFin(fechaInicio, tipoPrecio, cantidad);
                    $('#fechaFin').val(fechaFin);
                }
            }

            $(document).on('click', '.seleccionar-servicio', function () {
                var servicioId = $(this).data('cod-servicio');
                var row = $(this).closest('tr');

                var nombre = row.find('td:nth-child(1)').text();
                var descripcion = row.find('td:nth-child(2)').text();
                var tipoPrecio = row.find('.tipo-precio option:selected').data('tipo') + ' - $' + row.find('.tipo-precio option:selected').data('precio');

                $('#nombreServicioSeleccionado').text(nombre);
                $('#descripcionServicioSeleccionado').text(descripcion);
                $('#tipoPrecioSeleccionado').text(tipoPrecio);

                $('#fechaInicio').val(new Date().toISOString().split('T')[0]);
                $('#fechaFin').val(calcularFechaFin($('#fechaInicio').val(), tipoPrecio.split(' - ')[0], 1));
                $('#cantidadServicio').val(1);

                $('#confirmarSeleccionServicio').data({
                    id: servicioId,
                    nombre: nombre,
                    descripcion: descripcion,
                    tipoPrecioId: row.find('.tipo-precio option:selected').data('id'),
                    tipoPrecio: tipoPrecio.split(' - ')[0],
                    precio: parseFloat(tipoPrecio.split(' - $')[1])
                });

                $('#buscarServicioModal').modal('show');
            });

            $('#fechaInicio, #cantidadServicio').on('change', actualizarFechaFin);

            $(document).on('click', '#confirmarSeleccionServicio', function () {
                var cantidad = parseInt($('#cantidadServicio').val(), 10);
                var fechaInicio = $('#fechaInicio').val();
                var tipoPrecio = $(this).data('tipoPrecio');
                var fechaFin = $('#fechaFin').val();
                var servicioData = $(this).data();

                var servicioExistente = serviciosSeleccionados.find(s => s.id === servicioData.id && s.tipoPrecioId === servicioData.tipoPrecioId);
                if (servicioExistente) {
                    servicioExistente.cantidad += cantidad;
                    servicioExistente.fechaFin = calcularFechaFin(fechaInicio, servicioData.tipoPrecio, servicioExistente.cantidad);
                } else {
                    serviciosSeleccionados.push({
                        id: servicioData.id,
                        nombre: servicioData.nombre,
                        descripcion: servicioData.descripcion,
                        tipoPrecioId: servicioData.tipoPrecioId,
                        tipoPrecio: servicioData.tipoPrecio,
                        precio: servicioData.precio,
                        cantidad: cantidad,
                        fechaInicio: fechaInicio,
                        fechaFin: fechaFin,
                        codServicio: servicioData.id
                    });
                }

                mostrarServiciosSeleccionados();
                $('#fechaInicioInput').val(fechaInicio);
                $('#fechaFinInput').val(fechaFin);
                $('#buscarServicioModal').modal('hide');
            });

            function mostrarServiciosSeleccionados() {
                var tableRows = '';
                var precioTotal = 0;

                serviciosSeleccionados.forEach(function (servicio) {
                    var subtotal = servicio.precio * servicio.cantidad;
                    precioTotal += subtotal;

                    tableRows += `<tr>
                                   <td>${servicio.nombre}</td>
                                   <td>${servicio.descripcion}</td>
                                   <td>${servicio.tipoPrecio}</td>
                                   <td>${servicio.precio.toFixed(2)}</td>
                                   <td>${subtotal.toFixed(2)}</td>
                                   <td>${servicio.fechaFin}</td>
                                   <td>
                                       <button type="button" class="btn btn-danger btn-sm quitar-servicio" data-id="${servicio.id}">
                                           <i class="fas fa-times"></i> Quitar
                                       </button>
                                   </td>
                                </tr>`;
                });

                $('#serviciosSeleccionados').html(tableRows);
                $('#precioTotal').text(precioTotal.toFixed(2));
                $('#serviciosSeleccionadosInput').val(JSON.stringify(serviciosSeleccionados));
                $('#precioTotalInput').val(precioTotal.toFixed(2));
                $('#montoTotal').val(precioTotal.toFixed(2));
            }

            $(document).on('click', '.quitar-servicio', function () {
                var id = $(this).data('id');
                serviciosSeleccionados = serviciosSeleccionados.filter(function (servicio) {
                    return servicio.id !== id;
                });

                mostrarServiciosSeleccionados();
            });
        });
    });
</script>
    @endsection
    