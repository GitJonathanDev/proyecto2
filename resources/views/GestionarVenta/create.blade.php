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

    <form action="{{ route('venta.store') }}" method="POST">
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
            
                            
        </div>

        <div class="form-group">
            <label for="fechaventa">Fecha:</label>
            <input type="date" class="form-control" id="fechaventa" name="fechaVenta" value="{{ date('Y-m-d') }}" required>
        </div>
        
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#buscarProductoModal">
            <i class="fas fa-search"></i> Buscar Producto
        </button>
        <button type="submit" class="btn btn-primary mb-3">
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
                                    <th>Categoría</th>
                                    <th>Opción</th> 
                                </tr>
                            </thead>
                            <tbody id="tablaProductos">
                                @foreach ($productos as $producto)
                                <tr>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->precio }}</td>
                                    <td>{{ $producto->categoria->nombre }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm seleccionar-producto"
                                            data-id="{{ $producto->codProducto }}">Seleccionar</button>
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

        var productoExistente = productosSeleccionados.find(function (producto) {
            return producto.id === productoId;
        });

        if (productoExistente) {
            productoExistente.cantidad++;
        } else {
            productosSeleccionados.push({
                id: productoId,
                nombre: nombreProducto,
                precio: precioProducto,
                cantidad: 1 
            });
        }

        mostrarProductosSeleccionados();
    });

    function mostrarProductosSeleccionados() {
        var tableRows = '';
        var totalVenta = 0;

        productosSeleccionados.forEach(function (producto) {
            var subtotal = producto.cantidad * producto.precio;
            totalVenta += subtotal;

            tableRows += `<tr>
                            <td>${producto.nombre}</td>
                            <td><input type="number" class="form-control cantidad-producto" value="${producto.cantidad}" min="1" data-id="${producto.id}"></td>
                            <td>${producto.precio}</td>
                            <td>${subtotal.toFixed(2)}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm quitar-producto" data-id="${producto.id}">
                                    <i class="fas fa-times"></i> Quitar
                                </button>
                            </td>
                         </tr>`;
        });

        $('#productosSeleccionados').html(tableRows); 
        $('#totalVenta').text(totalVenta.toFixed(2)); 

        $('#productosSeleccionadosInput').val(JSON.stringify(productosSeleccionados)); 
        $('#totalVentaInput').val(totalVenta.toFixed(2)); 
    }

    $(document).on('change', '.cantidad-producto', function () {
        var cantidad = parseInt($(this).val());
        var productoId = $(this).data('id');

        productosSeleccionados.forEach(function (producto) {
            if (producto.id === productoId) {
                producto.cantidad = cantidad;
            }
        });

        mostrarProductosSeleccionados();
    });

    $(document).on('click', '.quitar-producto', function () {
        var productoId = $(this).data('id');

        productosSeleccionados = productosSeleccionados.filter(function (producto) {
            return producto.id !== productoId;
        });

        mostrarProductosSeleccionados();
    });

    $('#nombreProducto').on('keyup', function () {
        var query = $(this).val();

        $.ajax({
            url: '{{ route('producto.buscar') }}',
            type: 'GET',
            data: {
                nombre: query
            },
            success: function (data) {
                var tableRows = '';
                $.each(data, function (key, producto) {
                    tableRows += `<tr>
                                    <td>${producto.nombre}</td>
                                    <td>${producto.precio}</td>
                                    <td>${producto.categoria.nombre}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm seleccionar-producto"
                                            data-id="${producto.codProducto}">Seleccionar</button>
                                    </td>
                                 </tr>`;
                });
                $('#tablaProductos').html(tableRows);
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

    $('#buscadorCliente').on('keyup', function () {
    var query = $(this).val().toLowerCase();

    $.ajax({
        url: '{{ route('membresia.buscar') }}',
        type: 'GET',
        data: {
            nombre: query
        },
        success: function (data) {
            var listItems = '';
            $.each(data, function (key, cliente) {
                if (cliente.nombre.toLowerCase().includes(query) || cliente.apellidoPaterno.toLowerCase().includes(query) || cliente.apellidoMaterno.toLowerCase().includes(query)) {
                    listItems += `<li class="list-group-item cliente-item" data-id="${cliente.carnetIdentidad}" data-telefono="${cliente.telefono}">
                                    ${cliente.nombre} ${cliente.apellidoPaterno} ${cliente.apellidoMaterno} - ${cliente.telefono}
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
    var nombreCompleto = $(this).text();

    $('#buscadorCliente').val(nombreCompleto);
    $('#codClienteF').val(clienteId);
    $('#telefonoCliente').val(telefono);
    $('#resultadosClientes').hide();
});

    $(document).mouseup(function (e) {
    var container = $("#resultadosClientes");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.hide();
    }
});
});

</script>
@endsection

<style>
    .modal-dialog {
        max-width: 80%;
    }
    
    .list-group-item {
        cursor: pointer;
    }
    
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    
    .form-group.position-relative {
        position: relative;
    }
    
    #resultadosClientes {
        max-height: 200px;
        overflow-y: auto;
    }
</style>
