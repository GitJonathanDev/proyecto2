@extends('layouts.clienteBase')

@section('title', 'Gimnasio BodyFit')

@section('content')
@auth
<main class="container mt-5">
    <!-- Tabla de Productos -->
    <div class="card mb-4">
        <h3 class="text-center mb-4">Lista de tus productos que comprarás</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="productos">
                @foreach ($productos as $index => $producto)
                <tr id="producto-{{ $index }}">
                    <td>
                        @if ($producto->imagen_url)
                        <img src="{{ asset('storage/uploads/' . $producto->imagen_url) }}" alt="Imagen del producto" class="img-thumbnail" style="max-width: 120px;">
                        @else
                        No tiene imagen
                        @endif
                    </td>
                    <td>{{ $producto->nombre }}</td>
                    <td>
                        <input type="number" name="cantidad[{{ $index }}]" id="cantidad{{ $index }}"
                            class="form-control form-control-sm" value="{{ $cantidades[$producto->codProducto] ?? 1 }}" min="1"
                            data-precio="{{ $producto->precio }}" data-stock="{{ $producto->stock }}" oninput="validarCantidad({{ $index }})">
                    </td>
                    <td>Bs. {{ number_format($producto->precio, 2) }}</td>
                    <td>Bs. <span class="subtotal">{{ number_format(($cantidades[$producto->codProducto] ?? 1) * $producto->precio, 2) }}</span></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto({{ $index }})">Quitar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Subtotal -->
    <div class="container mt-4 d-flex justify-content-end">
        <div class="card p-3 shadow-sm" style="max-width: 300px;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="font-weight-bold">TOTAL:</div>
                <div class="font-weight-bold" id="subtotalTotal">Bs. 0.00</div>
            </div>
        </div>
    </div>

    <!-- Contenedor para Formulario de Pago y iframe -->
    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h3 class="text-center mb-4">Realizar pago</h3>
                    <form action="{{ route('consumirServicio') }}" method="POST" target="QrImage">
                        @csrf
                        <input type="hidden" name="idcliente" value="{{ $cliente->carnetIdentidad }}">
                        <input type="hidden" name="tcRazonSocial" value="{{ Auth::user()->nombreUsuario }}" required>
                        <input type="hidden" name="tcCiNit" value="{{ $cliente->carnetIdentidad }}" required>
                        <input type="hidden" name="tcCorreo" value="{{ Auth::user()->email }}" required>
                        <input type="hidden" name="tnMonto" id="montoTotal" placeholder="Costo Total" required>

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
                                <input type="text" name="tnTelefono" id="tnTelefono" class="form-control" value="{{ $cliente->telefono }}" readonly>
                            </div>
                        </div>

                        @foreach ($productos as $index => $producto)
                            <input type="hidden" name="productos[{{ $index }}][idproducto]" id="productoInput-{{ $index }}" value="{{ $producto->codProducto }}">
                            <input type="hidden" name="productos[{{ $index }}][nombre]" id="nombreInput-{{ $index }}" value="{{ $producto->nombre }}">
                            <input type="hidden" name="productos[{{ $index }}][precio]" id="precioInput-{{ $index }}" value="{{ $producto->precio }}">
                            <input type="hidden" name="productos[{{ $index }}][cantidad]" id="cantidadInput{{ $index }}" value="{{ $cantidades[$producto->codProducto] ?? 1 }}">
                            <input type="hidden" name="productos[{{ $index }}][descuento]" id="descuentoInput-{{ $index }}" value="1">
                            <input type="hidden" name="productos[{{ $index }}][serial]" id="serialInput-{{ $index }}" value="1">
                        @endforeach

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('cliente') }}" class="btn btn-secondary mr-2">
                                Atrás
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Mostrar Qr
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contenedor del iframe para QR -->
        <div class="col-md-6">
            <div class="d-flex justify-content-center align-items-center h-100">
                <iframe name="QrImage" class="w-100" style="height: 400px; border: 1px solid #ddd;"></iframe>
            </div>
        </div>
    </div>

    <!-- Botón para Registrar Venta -->
    <div class="d-flex justify-content-center mb-4">
        <button type="button" id="registrarVentaBtn" class="btn btn-primary">
            Comprar
        </button>
    </div>

    <!-- Formulario para Venta (Oculto) -->
    <form id="formVenta" class="d-none" action="{{ route('ventaCliente.store') }}" method="POST">
        @csrf
        <input type="hidden" name="idcliente" value="{{ $cliente->carnetIdentidad }}">
        <input type="hidden" name="tcRazonSocial" value="{{ Auth::user()->nombreUsuario }}" required>
        <input type="hidden" name="tcCiNit" value="{{ $cliente->carnetIdentidad }}" required>
        <input type="hidden" name="tcCorreo" value="{{ Auth::user()->email }}" required>
        <input type="hidden" name="tnMonto" id="montoVentaTotal" placeholder="Costo Total" required>
        <select name="tnTipoServicio" id="tnTipoServicioVenta" class="form-control" required>
            <option value="1">Servicio QR</option>
            <option value="2">Tigo Money</option>
        </select>

        @foreach ($productos as $index => $producto)
            <input type="hidden" name="productos[{{ $index }}][idproducto]" id="productoInput-{{ $index }}-venta" value="{{ $producto->codProducto }}">
            <input type="hidden" name="productos[{{ $index }}][nombre]" id="nombreInput-{{ $index }}-venta" value="{{ $producto->nombre }}">
            <input type="hidden" name="productos[{{ $index }}][precio]" id="precioInput-{{ $index }}-venta" value="{{ $producto->precio }}">
            <input type="hidden" name="productos[{{ $index }}][cantidad]" id="cantidadVentaInput{{ $index }}" value="{{ $cantidades[$producto->codProducto] ?? 1 }}">
            <input type="hidden" name="productos[{{ $index }}][descuento]" id="descuentoInput-{{ $index }}-venta" value="1">
            <input type="hidden" name="productos[{{ $index }}][serial]" id="serialInput-{{ $index }}-venta" value="1">
        @endforeach
    </form>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function actualizarTotal() {
        let total = 0;
        const subtotals = document.querySelectorAll('.subtotal');

        subtotals.forEach(function (subtotal) {
            total += parseFloat(subtotal.textContent);
        });

        document.getElementById('subtotalTotal').textContent = 'Bs. ' + total.toFixed(2);
        document.getElementById('montoTotal').value = total.toFixed(2);
        document.getElementById('montoVentaTotal').value = total.toFixed(2);
    }

    function validarCantidad(index) {
        const cantidadInput = document.getElementById('cantidad' + index);
        const stock = parseInt(cantidadInput.getAttribute('data-stock'));
        const cantidad = parseInt(cantidadInput.value);

        if (cantidad > stock) {
            mostrarAlerta('La cantidad no puede ser mayor que el stock disponible.');
            cantidadInput.value = stock;
        }

        document.getElementById('cantidadInput' + index).value = cantidadInput.value;
        document.getElementById('cantidadVentaInput' + index).value = cantidadInput.value;
        actualizarTotal();
    }

    function mostrarAlerta(mensaje) {
        Swal.fire({
            icon: 'warning',
            title: 'Advertencia',
            text: mensaje,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
        });
    }

    function eliminarProducto(index) {
        // Elimina la fila visualmente
        const fila = document.getElementById('producto-' + index);
        if (fila) fila.remove();

        // Elimina los campos ocultos correspondientes
        const productoInput = document.getElementById('productoInput-' + index);
        const nombreInput = document.getElementById('nombreInput-' + index);
        const precioInput = document.getElementById('precioInput-' + index);
        const cantidadInput = document.getElementById('cantidadInput' + index);
        const descuentoInput = document.getElementById('descuentoInput-' + index);
        const serialInput = document.getElementById('serialInput-' + index);

        const productoInputVenta = document.getElementById('productoInput-' + index + '-venta');
        const nombreInputVenta = document.getElementById('nombreInput-' + index + '-venta');
        const precioInputVenta = document.getElementById('precioInput-' + index + '-venta');
        const cantidadInputVenta = document.getElementById('cantidadVentaInput' + index);
        const descuentoInputVenta = document.getElementById('descuentoInput-' + index + '-venta');
        const serialInputVenta = document.getElementById('serialInput-' + index + '-venta');

        if (productoInput) productoInput.remove();
        if (nombreInput) nombreInput.remove();
        if (precioInput) precioInput.remove();
        if (cantidadInput) cantidadInput.remove();
        if (descuentoInput) descuentoInput.remove();
        if (serialInput) serialInput.remove();

        if (productoInputVenta) productoInputVenta.remove();
        if (nombreInputVenta) nombreInputVenta.remove();
        if (precioInputVenta) precioInputVenta.remove();
        if (cantidadInputVenta) cantidadInputVenta.remove();
        if (descuentoInputVenta) descuentoInputVenta.remove();
        if (serialInputVenta) serialInputVenta.remove();

        actualizarTotal();
    }

    document.addEventListener('DOMContentLoaded', function () {
        actualizarTotal();

        document.getElementById('registrarVentaBtn').addEventListener('click', function () {
            Swal.fire({
                title: '¿Está seguro de realizar la compra?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, comprar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formVenta').submit();
                }
            });
        });
    });
</script>
@endpush
@endauth
