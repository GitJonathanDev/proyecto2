@extends('layouts.plantilla')

@section('title', 'Gestionar venta')

@section('content')
<div class="container">
    <h1>Realizar Venta</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('ventaCliente.create') }}" method="POST">
        @csrf
        <input type="hidden" id="productosSeleccionadosInput" name="productos_seleccionados">
        <input type="hidden" id="totalVentaInput" name="total_venta">
        
        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="input-group mb-3">
            <input type="text" class="form-control" id="buscarClienteInput" readonly>
            <input type="hidden" id="clienteId" name="cliente_id"> 
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" id="cliente" data-toggle="modal" data-target="#buscarClienteModal">
                    <i class="fas fa-search"></i> Buscar Cliente
                </button>
            </div>
        </div>

        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#buscarProductoModal">
            <i class="fas fa-search"></i> Buscar Producto
        </button>
        <button type="submit" class="btn btn-primary mb-3">
            Realizar venta
        </button>

        <div class="form-group">
            <label for="metodoPago">Método de Pago:</label>
            <select class="form-control" id="metodoPago" name="metodo_pago" required>
                <option value="efectivo">Pago en Efectivo</option>
                <option value="qr">Pago por QR</option>
            </select>
        </div>
        
        <button type="button" class="btn btn-success mb-3" id="realizarPagoQRBtn" style="display: none;" onclick="showQRModal()">
            Pagar por QR
        </button>
                
        @if(isset($venta))
            <a href="{{ route('compra.show', $venta->id) }}" class="btn btn-info mb-3">
                Ver Detalle de venta
            </a>
        @endif
    </form>


    <div class="mt-4">
        <h3>Productos Seleccionados</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Opción</th>
                </tr>
            </thead>
            <tbody id="tablaProductosSeleccionados">
               
            </tbody>
        </table>
        <p id="totalVenta"></p>
    </div>
</div>

<!-- Script para QRCode -->
<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
<script>
    
    let productosSeleccionados = [];
    let totalVenta = 0;

   
    function actualizarTablaProductos() {
        const tabla = document.getElementById('tablaProductosSeleccionados');
        tabla.innerHTML = '';
        totalVenta = 0;

        productosSeleccionados.forEach(producto => {
            const row = tabla.insertRow();

            let cell = row.insertCell();
            cell.textContent = producto.nombre;

            cell = row.insertCell();
            cell.textContent = producto.precio.toFixed(2);

            cell = row.insertCell();
            const cantidadInput = document.createElement('input');
            cantidadInput.type = 'number';
            cantidadInput.value = producto.cantidad;
            cantidadInput.min = '1';
            cantidadInput.classList.add('form-control', 'cantidad-producto');
            cantidadInput.addEventListener('input', function () {
                const nuevaCantidad = parseInt(this.value);
                if (nuevaCantidad >= 1) {
                    producto.cantidad = nuevaCantidad;
                    actualizarTablaProductos();
                } else {
                    this.value = producto.cantidad;
                }
            });
            cell.appendChild(cantidadInput);

            cell = row.insertCell();
            const subtotal = (producto.precio * producto.cantidad).toFixed(2);
            cell.textContent = subtotal;
            totalVenta += parseFloat(subtotal);

            cell = row.insertCell();
            const button = document.createElement('button');
            button.classList.add('btn', 'btn-danger', 'btn-sm');
            button.textContent = 'Eliminar';
            button.addEventListener('click', () => eliminarProducto(producto.id));
            cell.appendChild(button);
        });

        document.getElementById('totalVenta').textContent = `Total Venta: ${totalVenta.toFixed(2)}`;
        document.getElementById('totalVentaInput').value = totalVenta.toFixed(2);
        document.getElementById('productosSeleccionadosInput').value = JSON.stringify(productosSeleccionados);
    }

 
    function eliminarProducto(idProducto) {
        productosSeleccionados = productosSeleccionados.filter(producto => producto.id !== idProducto);
        actualizarTablaProductos();
    }


    document.getElementById('nombreProducto').addEventListener('input', function () {
        const nombre = this.value.toLowerCase();
        const productos = document.querySelectorAll('#tablaProductos tr');
        productos.forEach(producto => {
            const nombreProducto = producto.firstElementChild.textContent.toLowerCase();
            producto.style.display = nombreProducto.includes(nombre) ? 'table-row' : 'none';
        });
    });

 
    const seleccionarProductoButtons = document.querySelectorAll('.seleccionar-producto');
    seleccionarProductoButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const precio = parseFloat(this.getAttribute('data-precio'));

            const productoExistente = productosSeleccionados.find(producto => producto.id === id);
            if (productoExistente) {
                productoExistente.cantidad++;
            } else {
                productosSeleccionados.push({ id, nombre, precio, cantidad: 1 });
            }
            actualizarTablaProductos();
        });
    });


    document.getElementById('nombreClienteInput').addEventListener('input', function () {
        const nombre = this.value.toLowerCase();
        const clientes = document.querySelectorAll('#tablaClientes tr');
        clientes.forEach(cliente => {
            const nombreCliente = cliente.children[1].textContent.toLowerCase();
            cliente.style.display = nombreCliente.includes(nombre) ? 'table-row' : 'none';
        });
    });

  
    const seleccionarClienteButtons = document.querySelectorAll('.seleccionar-cliente');
    seleccionarClienteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const nombre = this.parentNode.parentNode.children[1].textContent;
            document.getElementById('buscarClienteInput').value = `${nombre}`;
            document.getElementById('clienteId').value = id;
            $('#buscarClienteModal').modal('hide');
        });
    });

  
    document.getElementById('metodoPago').addEventListener('change', function () {
        const metodoPago = this.value;
        const realizarPagoQRBtn = document.getElementById('realizarPagoQRBtn');
        if (metodoPago === 'qr') {
            realizarPagoQRBtn.style.display = 'block';
        } else {
            realizarPagoQRBtn.style.display = 'none';
        }
    });

    function showQRModal() {
        $('#qrModal').modal('show');
    }
    $(document).ready(function() {
        $('#qrModal').on('shown.bs.modal', function () {
            setTimeout(function() {
                var mensajeExito = "¡Pago realizado con éxito!";
                alert(mensajeExito + "\nFecha: {{ $pago->fecha }}\nMonto: {{ $pago->precio }}");
            }, 8000); 
        });
    });
</script>
@endsection
