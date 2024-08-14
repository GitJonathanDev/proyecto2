<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TipoUsuarioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ConsumirServicioController;
use App\Http\Controllers\VentaClienteController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\CompraReportController;
use App\Http\Controllers\VentaReportController;
use App\Http\Controllers\PrecioServicioController;
use App\Http\Controllers\EstadisticasController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\BusquedaController;

// Página principal y vistas de usuario
Route::view('/', 'principal')->name('principal');
Route::view('/cliente', 'principalCliente')->name('cliente');
Route::get('/vendedor', [MenuController::class, 'index'])->name('encargado');
Route::get('/administrador', [MenuController::class, 'index'])->name('admin');

// Autenticación
Route::middleware('guest')->group(function () {
    Route::get('/Registrar/index', [RegistrarController::class, 'create'])->name('registrar.index');
    Route::post('/Registrar/create', [RegistrarController::class, 'store'])->name('registrar.create');
});

Route::get('/login/index', [LoginController::class, 'create'])->name('login.index');
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login/create', [LoginController::class, 'store'])->name('login.create');
Route::post('/login/clienteVista', [LoginController::class, 'vista'])->name('principalCliente');

Route::middleware([\App\Http\Middleware\VerificarAutenticacion::class])->group(function () {
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');

    Route::middleware('auth')->group(function () {
        Route::get('/mis-membresias', [MembresiaController::class, 'mostrarMembresias'])->name('mis-membresias');
        Route::post('/login/logout', [LoginController::class, 'destroy'])->name('login.destroy');
    });

    Route::prefix('tipoUsuario')->group(function () {
        Route::get('index', [TipoUsuarioController::class, 'index'])->name('tipoUsuario.index');
        Route::get('create', [TipoUsuarioController::class, 'create'])->name('tipoUsuario.create');
        Route::post('store', [TipoUsuarioController::class, 'store'])->name('tipoUsuario.store');
        Route::get('edit/{codTipoUsuario}', [TipoUsuarioController::class, 'edit'])->name('tipoUsuario.edit');
        Route::put('update/{codTipoUsuario}', [TipoUsuarioController::class, 'update'])->name('tipoUsuario.update');
        Route::delete('eliminar/{codTipoUsuario}', [TipoUsuarioController::class, 'destroy'])->name('tipoUsuario.destroy');
        Route::get('buscar', [TipoUsuarioController::class, 'buscarClientes'])->name('tipoUsuario.buscar');
    });

    // Gestionar usuario
    Route::prefix('usuario')->group(function () {
        Route::get('index', [UsuarioController::class, 'index'])->name('usuario.index');
        Route::get('create', [UsuarioController::class, 'create'])->name('usuario.create');
        Route::post('store', [UsuarioController::class, 'store'])->name('usuario.store');
        Route::get('edit/{codUsuario}', [UsuarioController::class, 'edit'])->name('usuario.edit');
        Route::put('update/{codUsuario}', [UsuarioController::class, 'update'])->name('usuario.update');
        Route::delete('eliminar/{codUsuario}', [UsuarioController::class, 'destroy'])->name('usuario.destroy');
        Route::get('buscar', [UsuarioController::class, 'buscarClientes'])->name('usuario.buscar');
    });

    // Gestionar vendedor
    Route::prefix('vendedor')->group(function () {
        Route::get('index', [VendedorController::class, 'index'])->name('vendedor.index');
        Route::get('create', [VendedorController::class, 'create'])->name('vendedor.create');
        Route::post('store', [VendedorController::class, 'store'])->name('vendedor.store');
        Route::get('edit/{carnetIdentidad}', [VendedorController::class, 'edit'])->name('vendedor.edit');
        Route::put('update/{carnetIdentidad}', [VendedorController::class, 'update'])->name('vendedor.update');
        Route::delete('eliminar/{carnetIdentidad}', [VendedorController::class, 'destroy'])->name('vendedor.destroy');
        Route::post('ci-ya-existe', [VendedorController::class, 'ciYaExiste'])->name('ci-ya-existe');
    });

    // Gestionar cliente
    Route::prefix('cliente')->group(function () {
        Route::get('index', [ClienteController::class, 'index'])->name('cliente.index');
        Route::get('create', [ClienteController::class, 'create'])->name('cliente.create');
        Route::post('store', [ClienteController::class, 'store'])->name('cliente.store');
        Route::get('edit/{carnetIdentidad}', [ClienteController::class, 'edit'])->name('cliente.edit');
        Route::put('update/{carnetIdentidad}', [ClienteController::class, 'update'])->name('cliente.update');
        Route::delete('eliminar/{carnetIdentidad}', [ClienteController::class, 'destroy'])->name('cliente.destroy');
        Route::post('ci-ya-existe', [ClienteController::class, 'ciYaExiste'])->name('ci-ya-existe');
        Route::get('buscar', [ClienteController::class, 'index'])->name('clientes.buscar'); // Ajustado para llamar a index
        Route::get('seleccionCliente/{carnetIdentidad}', [MembresiaController::class, 'seleccionCliente'])->name('cliente.seleccion'); // Asegúrate de que esta ruta sea correcta
    });

    // Rutas para gestionar membresía
    Route::prefix('membresia')->group(function () {
        Route::get('index', [MembresiaController::class, 'index'])->name('membresia.index');
        Route::get('create', [MembresiaController::class, 'create'])->name('membresia.create');
        Route::post('store', [MembresiaController::class, 'store'])->name('membresia.store');
        Route::get('edit/{codMembresia}', [MembresiaController::class, 'edit'])->name('membresia.edit');
        Route::get('show/{codMembresia}', [MembresiaController::class, 'show'])->name('membresia.show');
        Route::put('update/{codMembresia}', [MembresiaController::class, 'update'])->name('membresia.update');
        Route::delete('delete/{codMembresia}', [MembresiaController::class, 'destroy'])->name('membresia.destroy');
        Route::get('buscar-cliente', [MembresiaController::class, 'buscarCliente'])->name('membresia.buscar');
        Route::get('seleccion/{codClienteF}', [MembresiaController::class, 'seleccionCliente'])->name('membresia.seleccionCliente');
    });

    Route::get('/estadisticas/index', [EstadisticasController::class, 'index'])->name('inicio.estadistica');

    // Gestionar pago
    Route::prefix('pago')->group(function () {
        Route::get('index', [PagoController::class, 'index'])->name('pago.index');
        Route::get('create', [PagoController::class, 'create'])->name('pago.create');
        Route::post('store', [PagoController::class, 'store'])->name('pago.store');
        Route::get('edit/{codPago}', [PagoController::class, 'edit'])->name('pago.edit');
        Route::put('update/{codPago}', [PagoController::class, 'update'])->name('pago.update');
        Route::delete('eliminar/{codPago}', [PagoController::class, 'destroy'])->name('pago.destroy');
    });

    Route::view('/pago', 'GestionarPago.pago')->name('pago.view');
    Route::post('/consumirServicio', [ConsumirServicioController::class, 'RecolectarDatos'])->name('consumirServicio');
    Route::post('/consultar', [ConsumirServicioController::class, 'ConsultarEstado'])->name('consultarEstado');

    // Gestionar categoría
    Route::prefix('categoria')->group(function () {
        Route::get('index', [CategoriaController::class, 'index'])->name('categoria.index');
        Route::get('index2', [CategoriaController::class, 'index2'])->name('categoria.index2');
        Route::get('create', [CategoriaController::class, 'create'])->name('categoria.create');
        Route::post('store', [CategoriaController::class, 'store'])->name('categoria.store');
        Route::get('edit/{codCategoria}', [CategoriaController::class, 'edit'])->name('categoria.edit');
        Route::put('update/{codCategoria}', [CategoriaController::class, 'update'])->name('categoria.update');
        Route::delete('eliminar/{codCategoria}', [CategoriaController::class, 'destroy'])->name('categoria.destroy');
    });

    // Gestionar producto
    Route::prefix('producto')->group(function () {
        Route::get('index', [ProductoController::class, 'index'])->name('producto.index');
        Route::get('create', [ProductoController::class, 'create'])->name('producto.create');
        Route::post('store', [ProductoController::class, 'store'])->name('producto.store');
        Route::get('edit/{codProducto}', [ProductoController::class, 'edit'])->name('producto.edit');
        Route::put('update/{codProducto}', [ProductoController::class, 'update'])->name('producto.update');
        Route::delete('eliminar/{codProducto}', [ProductoController::class, 'destroy'])->name('producto.destroy');
    });

    // Gestionar proveedor
    Route::prefix('proveedor')->group(function () {
        Route::get('index', [ProveedorController::class, 'index'])->name('proveedor.index');
        Route::get('create', [ProveedorController::class, 'create'])->name('proveedor.create');
        Route::post('store', [ProveedorController::class, 'store'])->name('proveedor.store');
        Route::get('edit/{codProveedor}', [ProveedorController::class, 'edit'])->name('proveedor.edit');
        Route::put('update/{codProveedor}', [ProveedorController::class, 'update'])->name('proveedor.update');
        Route::delete('eliminar/{codProveedor}', [ProveedorController::class, 'destroy'])->name('proveedor.destroy');
    });

    // Gestionar horario
    Route::prefix('horario')->group(function () {
        Route::get('index', [HorarioController::class, 'index'])->name('horario.index');
        Route::get('create', [HorarioController::class, 'create'])->name('horario.create');
        Route::post('store', [HorarioController::class, 'store'])->name('horario.store');
        Route::get('edit/{codHorario}', [HorarioController::class, 'edit'])->name('horario.edit');
        Route::put('update/{codHorario}', [HorarioController::class, 'update'])->name('horario.update');
        Route::delete('eliminar/{codHorario}', [HorarioController::class, 'destroy'])->name('horario.destroy');
    });

    // Gestionar servicio
    Route::prefix('servicio')->group(function () {
        Route::get('index', [ServicioController::class, 'index'])->name('servicio.index');
        Route::get('create', [ServicioController::class, 'create'])->name('servicio.create');
        Route::post('store', [ServicioController::class, 'store'])->name('servicio.store');
        Route::get('edit/{codServicio}', [ServicioController::class, 'edit'])->name('servicio.edit');
        Route::put('update/{codServicio}', [ServicioController::class, 'update'])->name('servicio.update');
        Route::delete('eliminar/{codServicio}', [ServicioController::class, 'destroy'])->name('servicio.destroy');
    });

    // Gestionar compra
    Route::prefix('compra')->group(function () {
        Route::get('index', [CompraController::class, 'index'])->name('compra.index');
        Route::get('create', [CompraController::class, 'create'])->name('compra.create');
        Route::post('store', [CompraController::class, 'store'])->name('compra.store');
        Route::get('edit/{codCompra}', [CompraController::class, 'edit'])->name('compra.edit');
        Route::put('update/{codCompra}', [CompraController::class, 'update'])->name('compra.update');
        Route::delete('eliminar/{codCompra}', [CompraController::class, 'destroy'])->name('compra.destroy');
    });

    // Gestionar venta
    Route::prefix('venta')->group(function () {
        Route::get('index', [VentaController::class, 'index'])->name('venta.index');
        Route::get('create', [VentaController::class, 'create'])->name('venta.create');
        Route::post('store', [VentaController::class, 'store'])->name('venta.store');
        Route::get('edit/{codVenta}', [VentaController::class, 'edit'])->name('venta.edit');
        Route::put('update/{codVenta}', [VentaController::class, 'update'])->name('venta.update');
        Route::delete('eliminar/{codVenta}', [VentaController::class, 'destroy'])->name('venta.destroy');
        Route::get('detalle/{codVenta}', [VentaController::class, 'detalleVenta'])->name('venta.detalle');
        Route::get('filtro/{filtro}', [VentaController::class, 'filtroVenta'])->name('venta.filtro');
    });

    // Gestionar venta a cliente
    Route::prefix('ventaCliente')->group(function () {
        Route::get('index', [VentaClienteController::class, 'index'])->name('ventaCliente.index');
        Route::get('create', [VentaClienteController::class, 'create'])->name('ventaCliente.create');
        Route::post('store', [VentaClienteController::class, 'store'])->name('ventaCliente.store');
        Route::get('edit/{codVenta}', [VentaClienteController::class, 'edit'])->name('ventaCliente.edit');
        Route::put('update/{codVenta}', [VentaClienteController::class, 'update'])->name('ventaCliente.update');
        Route::delete('eliminar/{codVenta}', [VentaClienteController::class, 'destroy'])->name('ventaCliente.destroy');
        Route::get('detalle/{codVenta}', [VentaClienteController::class, 'detalleVenta'])->name('ventaCliente.detalle');
    });

    Route::get('/venta/index', [VentaClienteController::class, 'index'])->name('ventaCliente.index');
    Route::get('/api/categorias/{codCategoria}/productos', [VentaClienteController::class, 'getProductos'])->name('venta.getProductos');
    Route::get('/api/venta/productos', [VentaClienteController::class, 'obtenerProductos'])->name('venta.obtenerProductos');
    Route::get('/comprar/{idsYCantidades}', [VentaClienteController::class, 'mostrarDetalles'])->name('comprar.detalle');
    Route::post('/venta/create', [VentaClienteController::class, 'store']);
    Route::get('/storage/uploads/{filename}', function ($filename) {
        $path = storage_path('app/public/uploads/' . $filename);
        if (file_exists($path)) {
            return response()->file($path);
        }
        abort(404);
    })->name('storage.image');

    // Gestionar precios de servicio
    Route::prefix('precioServicio')->group(function () {
        Route::get('index', [PrecioServicioController::class, 'index'])->name('precioServicio.index');
        Route::get('create', [PrecioServicioController::class, 'create'])->name('precioServicio.create');
        Route::post('store', [PrecioServicioController::class, 'store'])->name('precioServicio.store');
        Route::get('edit/{codPrecioServicio}', [PrecioServicioController::class, 'edit'])->name('precioServicio.edit');
        Route::put('update/{codPrecioServicio}', [PrecioServicioController::class, 'update'])->name('precioServicio.update');
        Route::delete('eliminar/{codPrecioServicio}', [PrecioServicioController::class, 'destroy'])->name('precioServicio.destroy');
    });

    // Reportes
    Route::prefix('reportes')->group(function () {
        Route::get('index', [ReporteController::class, 'index'])->name('reportes.index');
        Route::get('compras', [CompraReportController::class, 'index'])->name('reportes.compras');
        Route::get('ventas', [VentaReportController::class, 'index'])->name('reportes.ventas');
    });
});

