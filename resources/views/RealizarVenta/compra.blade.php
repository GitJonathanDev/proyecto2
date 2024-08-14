@extends('layouts.clienteBase')

@section('title', 'Gimnasio BodyFit')

@section('content')
    <main class="container mt-5">
        <!-- Tabla de Productos -->
        <div class="card mb-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="productos">
                    @foreach ($productos as $index => $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>
                            <input type="number" name="cantidad[{{ $index }}]" id="cantidad{{ $index }}"
                                class="form-control form-control-sm" value="{{ $cantidades[$producto->codProducto] ?? 1 }}" min="1"
                                data-precio="{{ $producto->precio }}" data-stock="{{ $producto->stock }}" oninput="validarCantidad({{ $index }})">
                        </td>
                        <td>Bs. {{ number_format($producto->precio, 2) }}</td>
                        <td>Bs. <span class="subtotal">{{ number_format(($cantidades[$producto->codProducto] ?? 1) * $producto->precio, 2) }}</span></td>
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
                                <input type="hidden" name="productos[{{ $index }}][idproducto]" value="{{ $producto->codProducto }}">
                                <input type="hidden" name="productos[{{ $index }}][nombre]" value="{{ $producto->nombre }}">
                                <input type="hidden" name="productos[{{ $index }}][precio]" value="{{ $producto->precio }}">
                                <input type="hidden" name="productos[{{ $index }}][cantidad]" id="cantidadInput{{ $index }}" value="{{ $cantidades[$producto->codProducto] ?? 1 }}">
                                <input type="hidden" name="productos[{{ $index }}][descuento]" value="1">
                                <input type="hidden" name="productos[{{ $index }}][serial]" value="1">
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
                Registrar Venta
            </button>
        </div>

        <!-- Formulario para Venta (Oculto) -->
        <form id="formVenta" class="d-none" action="{{ route('venta.create') }}" method="POST">
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
                <input type="hidden" name="productos[{{ $index }}][idproducto]" value="{{ $producto->codProducto }}">
                <input type="hidden" name="productos[{{ $index }}][nombre]" value="{{ $producto->nombre }}">
                <input type="hidden" name="productos[{{ $index }}][precio]" value="{{ $producto->precio }}">
                <input type="hidden" name="productos[{{ $index }}][cantidad]" id="cantidadVentaInput{{ $index }}" value="{{ $cantidades[$producto->codProducto] ?? 1 }}">
                <input type="hidden" name="productos[{{ $index }}][descuento]" value="1">
                <input type="hidden" name="productos[{{ $index }}][serial]" value="1">
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
        const cantidades = document.querySelectorAll('input[name^="cantidad["]');

        cantidades.forEach((cantidad, index) => {
            const precio = parseFloat(cantidad.getAttribute('data-precio'));
            const stock = parseInt(cantidad.getAttribute('data-stock'));
            const valorCantidad = parseInt(cantidad.value);

            if (valorCantidad > stock) {
                mostrarAlerta('La cantidad seleccionada excede el stock disponible para ' + cantidad.closest('tr').querySelector('td').innerText.split('\n')[0]);
                cantidad.value = stock;
            }

            const subtotal = cantidad.value * precio;
            subtotals[index].innerText = subtotal.toFixed(2);
            total += subtotal;
            document.getElementById('cantidadInput' + index).value = cantidad.value;
        });

        document.getElementById('subtotalTotal').innerText = 'Bs. ' + total.toFixed(2);
        document.getElementById('montoTotal').value = total.toFixed(2);
        document.getElementById('montoVentaTotal').value = total.toFixed(2);
    }

    function validarCantidad(index) {
        actualizarTotal();
    }

    function mostrarAlerta(mensaje) {
        Swal.fire({
            title: 'Advertencia',
            text: mensaje,
            icon: 'warning',
            confirmButtonText: 'Aceptar'
        });
    }

    document.querySelectorAll('input[name^="cantidad["]').forEach(cantidad => {
        cantidad.addEventListener('input', () => {
            validarCantidad(Array.from(cantidad.parentElement.parentElement.children).indexOf(cantidad.parentElement) / 4);
        });
    });

    document.getElementById('registrarVentaBtn').addEventListener('click', function() {
        const cantidadInputs = document.querySelectorAll('input[name^="cantidad["]');
        const cantidades = [];
        cantidadInputs.forEach((input, index) => {
            cantidades.push(input.value);
            document.getElementById('cantidadVentaInput' + index).value = input.value;
        });

        if (cantidadInputs.length === 0) {
            Swal.fire({
                title: 'Error',
                text: 'No hay productos para registrar.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        Swal.fire({
            title: 'Confirmar Registro',
            text: '¿Estás seguro de que deseas registrar esta venta?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, registrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formVenta').submit();
            }
        });
    });

    actualizarTotal();
</script>
@endpush
