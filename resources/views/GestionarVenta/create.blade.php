@extends('layouts.plantilla')

@section('title', 'Gestionar Venta')

@section('content')

<div class="container">
    <h1 class="mb-4">Realizar Venta</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('venta.store') }}" method="POST" id="ventaForm">
        @csrf
        <input type="hidden" id="productosSeleccionadosInput" name="productosSeleccionados">
        <input type="hidden" id="totalVentaInput" name="totalVenta">
        <input type="hidden" id="codPagoF" name="codPagoF">

        <div class="form-group">
            <label for="encargado">Encargado:</label>
            <input type="hidden" id="encargado" name="codEncargadoF" value="{{ $encargado->carnetIdentidad }}">
            <p>{{ $encargado->nombre }} {{ $encargado->apellidoPaterno }} {{ $encargado->apellidoMaterno }}</p>
        </div>

        <div class="form-group">
            <label for="cliente">Cliente:</label>
            <input type="text" class="form-control" id="buscadorCliente" placeholder="Buscar cliente...">
            <input type="hidden" id="codClienteF" name="codClienteF">
            <input type="hidden" class="form-control" id="telefonoCliente" readonly>
            <ul id="resultadosClientes" class="list-group mt-2" style="max-height: 200px; overflow-y: auto;"></ul>
            <small id="clienteError" class="form-text text-danger" style="display: none;">Debe seleccionar un cliente.</small>
        </div>

        <div class="form-group">
            <label for="fechaventa">Fecha:</label>
            <input type="date" class="form-control" id="fechaventa" name="fechaVenta" value="{{ date('Y-m-d') }}" required>
        </div>
        
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#buscarProductoModal">
            <i class="fas fa-search"></i> Buscar Producto
        </button>
        <button type="submit" class="btn btn-primary mb-3" id="realizarVentaBtn" disabled>
            Realizar Venta
        </button>
        @if(isset($venta))
            <a href="{{ route('venta.show', $venta->codVenta) }}" class="btn btn-info mb-3">
                Ver Detalle de Venta
            </a>
        @endif
    </form>    

    <a href="{{ route('venta.index') }}" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Volver
    </a>

    <!-- Modal para buscar producto -->
    <div class="modal fade" id="buscarProductoModal" tabindex="-1" role="dialog" aria-labelledby="buscarProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buscarProductoModalLabel">Buscar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formBuscarProducto">
                        <div class="form-group">
                            <label for="nombreProducto">Buscar por Nombre:</label>
                            <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" placeholder="Ingrese el nombre del producto">
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Categoría</th>
                                    <th>Imagen</th>
                                    <th>Opción</th> 
                                </tr>
                            </thead>
                            <tbody id="tablaProductos">
                                @foreach ($productos as $producto)
                                <tr>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->precio }} Bs.</td>
                                    <td>{{ $producto->stock }}</td>
                                    <td>{{ $producto->categoria->nombre }}</td>
                                    <td>
                                        @if ($producto->imagen_url)
                                            <img src="{{ asset('storage/uploads/' . $producto->imagen_url) }}" alt="Imagen del producto" class="img-thumbnail" style="max-width: 120px;">
                                        @else
                                            No tiene imagen
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm seleccionar-producto"
                                            data-id="{{ $producto->codProducto }}" 
                                            data-stock="{{ $producto->stock }}">
                                            Seleccionar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de productos seleccionados -->
    <div class="mt-4">
        <h3>Productos Seleccionados</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th> 
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="productosSeleccionados">
            </tbody>
        </table>
    </div>

    <!-- Total de la venta -->
    <div class="mt-4">
        <h3>Total de la Venta</h3>
        <p id="totalVenta">0</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        var productosSeleccionados = [];

        $(document).on('click', '.seleccionar-producto', function () {
            var productoId = $(this).data('id');
            var nombreProducto = $(this).closest('tr').find('td:first').text();
            var precioProducto = parseFloat($(this).closest('tr').find('td:eq(1)').text());
            var stockProducto = parseInt($(this).data('stock'));

            var productoExistente = productosSeleccionados.find(function (producto) {
                return producto.id === productoId;
            });

            if (productoExistente) {
                if (productoExistente.cantidad < stockProducto) {
                    productoExistente.cantidad++;
                } else {
                    alert('La cantidad seleccionada no puede ser mayor al stock disponible.');
                }
            } else {
                productosSeleccionados.push({
                    id: productoId,
                    nombre: nombreProducto,
                    precio: precioProducto,
                    cantidad: 1,
                    stock: stockProducto
                });
            }

            mostrarProductosSeleccionados();
            validarFormulario();
        });

        function mostrarProductosSeleccionados() {
            var tableRows = '';
            var totalVenta = 0;

            productosSeleccionados.forEach(function (producto) {
                var subtotal = producto.cantidad * producto.precio;
                totalVenta += subtotal;

                tableRows += `<tr>
                                <td>${producto.nombre}</td>
                                <td><input type="number" class="form-control cantidad-producto" value="${producto.cantidad}" min="1" max="${producto.stock}" data-id="${producto.id}"></td>
                                <td>${producto.precio} Bs.</td>
                                <td>${subtotal.toFixed(2)} Bs.</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm quitar-producto" data-id="${producto.id}">
                                        <i class="fas fa-times"></i> Quitar
                                    </button>
                                </td>
                             </tr>`;
            });

            $('#productosSeleccionados').html(tableRows);
            $('#totalVenta').text(totalVenta.toFixed(2) + ' Bs.');

            $('#productosSeleccionadosInput').val(JSON.stringify(productosSeleccionados));
            $('#totalVentaInput').val(totalVenta.toFixed(2));
        }

        $(document).on('change', '.cantidad-producto', function () {
            var cantidad = parseInt($(this).val());
            var productoId = $(this).data('id');
            var producto = productosSeleccionados.find(function (prod) {
                return prod.id === productoId;
            });

            if (cantidad > producto.stock) {
                alert('La cantidad seleccionada no puede ser mayor al stock disponible.');
                $(this).val(producto.stock);
            } else {
                producto.cantidad = cantidad;
            }

            mostrarProductosSeleccionados();
            validarFormulario();
        });

        $(document).on('click', '.quitar-producto', function () {
            var productoId = $(this).data('id');

            productosSeleccionados = productosSeleccionados.filter(function (producto) {
                return producto.id !== productoId;
            });

            mostrarProductosSeleccionados();
            validarFormulario();
        });

        $('#buscadorCliente').on('keyup', function () {
    var query = $(this).val().toLowerCase();

    $.ajax({
        url: '{{ route('membresia.buscar') }}',
        type: 'GET',
        data: {
            query: query
        },
        success: function (data) {
            var listItems = '';
            $.each(data, function (key, cliente) {
                var nombreCompleto = `${cliente.nombre} ${cliente.apellidoPaterno} ${cliente.apellidoMaterno}`;
                if (nombreCompleto.toLowerCase().includes(query) || cliente.carnetIdentidad.toLowerCase().includes(query)) {
                    listItems += `<li class="list-group-item cliente-item" data-id="${cliente.carnetIdentidad}" data-telefono="${cliente.telefono}">
                                    ${nombreCompleto} - ${cliente.carnetIdentidad}
                                  </li>`;
                }
            });
            $('#resultadosClientes').html(listItems).show();
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
});

$(document).on('click', '.cliente-item', function () {
    var clienteId = $(this).data('id');
    var telefono = $(this).data('telefono');
    var nombreCompleto = $(this).text().trim();

    $('#buscadorCliente').val(nombreCompleto);
    $('#codClienteF').val(clienteId);
    $('#telefonoCliente').val(telefono);
    $('#resultadosClientes').hide();
    validarFormulario();
});

function validarFormulario() {
    var clienteSeleccionado = $('#codClienteF').val() !== '';
    var hayProductosSeleccionados = productosSeleccionados.length > 0;
    $('#realizarVentaBtn').prop('disabled', !(clienteSeleccionado && hayProductosSeleccionados));
    $('#clienteError').toggle(!clienteSeleccionado);
}

$('#ventaForm').on('submit', function (e) {
    if ($('#codClienteF').val() === '') {
        $('#clienteError').show();
        e.preventDefault();
    }
});
    });
</script>

@endsection
