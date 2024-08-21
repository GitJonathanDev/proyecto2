@extends('layouts.plantilla')

@section('title', 'Gestionar Compra')

@section('content')

<div class="container">
    <h1>Realizar Compra</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('compra.store') }}" method="POST">
        @csrf
        <input type="hidden" id="productosSeleccionadosInput" name="productosSeleccionados">
        <input type="hidden" id="totalCompraInput" name="totalCompra">
        
        <div class="form-group">
            <label for="encargado">Encargado:</label>
            <input type="hidden" id="encargado" name="codEncargadoF" value="{{ $encargado->carnetIdentidad }}">
            <p>{{ $encargado->nombre }} {{ $encargado->apellidoPaterno }} {{ $encargado->apellidoMaterno }}</p>
        </div>

        <div class="form-group">
            <label for="proveedor">Proveedor:</label>
            <select class="form-control" id="proveedor" name="codProveedorF" required>
                @foreach ($proveedores as $proveedor)
                <option value="{{ $proveedor->codProveedor }}">{{ $proveedor->nombre }} - {{ $proveedor->direccion }} - {{ $proveedor->telefono }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="fechacompra">Fecha:</label>
            <input type="date" class="form-control" id="fechacompra" name="fechaCompra" value="{{ date('Y-m-d') }}" required>
        </div>
        
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#buscarProductoModal">
            <i class="fas fa-search"></i> Buscar Producto
        </button>
        <button type="submit" class="btn btn-primary mb-3" id="realizarCompraBtn" disabled>
            Realizar Compra
        </button>
        @if(isset($compra))
            <a href="{{ route('compra.show', $compra->codCompra) }}" class="btn btn-info mb-3">
                Ver Detalle de Compra
            </a>
        @endif
    </form>    

    <a href="{{ route('compra.index') }}" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Volver
    </a>

    <!-- Modal Buscar Producto -->
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
                                    <td>{{ $producto->precio }}</td>
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
                                        <button type="button" class="btn btn-primary btn-sm seleccionar-producto" data-id="{{ $producto->codProducto }}">Seleccionar</button>
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

    <div class="mt-4">
        <h3>Total de la Compra</h3>
        <p id="totalCompra">0</p>
    </div>
</div>

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
            var totalCompra = 0;

            productosSeleccionados.forEach(function (producto) {
                var subtotal = producto.cantidad * producto.precio;
                totalCompra += subtotal;

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
            $('#totalCompra').text(totalCompra.toFixed(2)); 
            $('#productosSeleccionadosInput').val(JSON.stringify(productosSeleccionados)); 
            $('#totalCompraInput').val(totalCompra.toFixed(2)); 

            // Habilitar o deshabilitar el botón "Realizar Compra" según haya productos seleccionados
            $('#realizarCompraBtn').prop('disabled', productosSeleccionados.length === 0);
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
            var query = $(this).val().toLowerCase();
            $('#tablaProductos tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1);
            });
        });
    });
</script>

@endsection
