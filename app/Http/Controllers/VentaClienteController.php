<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VentaClienteController extends Controller
{
    public function index() {
        $categorias = Categoria::all();
        $productos = Producto::all();
        return view('RealizarVenta.index', compact('categorias', 'productos'));
    }

    public function getProductos($codCategoria)
    {
        $productos = Producto::where('codCategoriaF', $codCategoria)->get();
        return response()->json($productos);
    }

    public function obtenerProductos(Request $request)
    {
        $codCategoria = $request->query('categoria');
        
        if ($codCategoria) {
            $productos = Producto::where('codCategoriaF', $codCategoria)->get();
        } else {
            $productos = Producto::all();
        }
        
        return response()->json($productos);
    }
    public function mostrarDetalles($idsYCantidades)
    {
        // Dividir los datos codificados en partes
        $items = explode(',', $idsYCantidades);
        $ids = [];
        $cantidades = [];
        
        foreach ($items as $item) {
            list($id, $cantidad) = explode(':', $item);
            $ids[] = $id;
            $cantidades[$id] = $cantidad;
        }
        
        // Obtener los productos de la base de datos
        $productos = Producto::whereIn('codProducto', $ids)->get();
        
        if ($productos->isEmpty()) {
            abort(404); // Error 404 si no se encuentran productos
        }
        
        // Obtener el cliente logueado
        $user = Auth::user();
        $cliente = Cliente::where('codUsuarioF', $user->codUsuario)->first();
        
        // Renderizar la vista 'RealizarVenta.compra' con los datos
        return view('RealizarVenta.compra', [
            'productos' => $productos,
            'cantidades' => $cantidades,
            'cliente' => $cliente
        ]);
    }
    public function store(Request $request) {
    
        // Obtener el ID del usuario logueado
        $userId = Auth::user()->codUsuario;
        // Buscar el cliente asociado con el usuario
        $cliente = Cliente::where('codUsuarioF', $userId)->first();
    
        // Verificar si el cliente existe
        if (!$cliente) {
            return redirect()->back()->withErrors('Cliente no encontrado.');
        }
    
        // Obtener el carnetIdentidad del cliente
        $idCliente = $cliente->carnetIdentidad;
        $montoTotal = 0;
    
        // Calcular el monto total de la compra
        foreach ($request->productos as $producto) {
            $montoTotal += $producto['cantidad'] * $producto['precio'];
        }
    
        // Crear un nuevo registro de pago
        $pago = new Pago();
        $pago->monto = $request->tnMonto;
        $pago->fechaPago = now()->toDateString();  
        $pago->codClienteF = $idCliente;
        $pago->save();
    
        // Crear un nuevo registro de venta
        $venta = new Venta();
        $venta->fechaVenta = now()->toDateString();
        $venta->montoTotal = $montoTotal; 
        $venta->codClienteF = $idCliente;
        $venta->codEncargadoF = 13434434; // Ajustar el ID del encargado según sea necesario
        $venta->codPagoF = $pago->codPago;
        $venta->save();
    
        // Registrar los detalles de la venta
        foreach ($request->productos as $producto) {
            $detalleVenta = new DetalleVenta();
            $detalleVenta->codVenta = $venta->codVenta;
            $detalleVenta->codProducto = $producto['idproducto'];
            $detalleVenta->cantidad = $producto['cantidad'];
            $detalleVenta->precioV = $producto['precio'];
            $detalleVenta->save();
        }
    
        // Redirigir con un mensaje de éxito
        return redirect()->route('cliente')->with('success', 'Compra realizada con éxito.');
    }
    
}
