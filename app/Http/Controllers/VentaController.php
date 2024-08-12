<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Encargado;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $criterio = $request->get('criterio');
        $buscar = $request->get('buscar');

        $query = Venta::query();

        if ($criterio && $buscar) {
            $query->where($criterio, 'like', "%$buscar%");
        }

        $ventas = $query->paginate(10);

        return view('GestionarVenta.index', compact('ventas'));
    }

    public function create()
    {
        $usuario = Auth::user();
        $encargado = Encargado::where('codUsuarioF', $usuario->codUsuario)->first();
        $clientes = Cliente::all();
        $productos = Producto::all();

        return view('GestionarVenta.create', compact('clientes', 'productos', 'encargado'));
    }

    public function store(Request $request)
    {
        // Crear la venta
        $venta = new Venta();
        $venta->fechaVenta = $request->fechaVenta;
        $venta->codEncargadoF = $request->codEncargadoF;
        $venta->codClienteF = $request->codClienteF;

        $productosSeleccionados = json_decode($request->productosSeleccionados);
        $montoTotal = 0;

        foreach ($productosSeleccionados as $producto) {
            $montoTotal += $producto->precio * $producto->cantidad;
        }

        $venta->montoTotal = $request->totalVenta;

        // Registrar el pago
        $pago = new Pago();
        $pago->fechaPago = now();
        $pago->monto = $request->totalVenta;
        $pago->estado = 'pagado';
        $pago->codClienteF = $request->codClienteF;
        $pago->save();

        // Asociar el pago a la venta
        $venta->codPagoF = $pago->codPago;
        $venta->save();

        // Registrar detalles de la venta
        foreach ($productosSeleccionados as $producto) {
            $detalleVenta = new DetalleVenta();
            $detalleVenta->codVenta = $venta->codVenta;
            $detalleVenta->codProducto = $producto->id;
            $detalleVenta->cantidad = $producto->cantidad;
            $detalleVenta->precioV = $producto->precio;
            $detalleVenta->save();
        }

        return redirect()->route('venta.show', $venta->codVenta);
    }

    public function show($codVenta)
    {
        $venta = Venta::findOrFail($codVenta);
        $detalleVenta = DetalleVenta::where('codVenta', $codVenta)->get();
        $pago = Pago::where('codPago', $venta->codPagoF)->first();
    
        return view('GestionarVenta.detalle', compact('venta', 'detalleVenta', 'pago'));
    }
    public function edit($codVenta)
    {
        $venta = Venta::findOrFail($codVenta);
        $clientes = Cliente::all();
        $productos = Producto::all();
        $encargados = Encargado::all();

        return view('GestionarVenta.edit', compact('venta', 'clientes', 'productos', 'encargados'));
    }

    public function update(Request $request, $codVenta)
    {
        $request->validate([
            'fechaVenta' => 'required|date',
            'codEncargadoF' => 'required|exists:Encargado,carnetIdentidad',
            'codClienteF' => 'required|exists:Cliente,carnetIdentidad',
            'productosSeleccionados' => 'required|json',
            'montoPagado' => 'required|numeric|min:0',
        ]);

        $venta = Venta::findOrFail($codVenta);
        $venta->fechaVenta = $request->fechaVenta;
        $venta->codEncargadoF = $request->codEncargadoF;
        $venta->codClienteF = $request->codClienteF;
        $venta->montoTotal = $request->montoTotal;
        $venta->save();

        // Eliminar los detalles de la venta previa
        DetalleVenta::where('codVenta', $codVenta)->delete();

        // Registrar nuevos detalles de la venta
        $productosSeleccionados = json_decode($request->productosSeleccionados);

        foreach ($productosSeleccionados as $producto) {
            $detalleVenta = new DetalleVenta();
            $detalleVenta->codVenta = $codVenta;
            $detalleVenta->codProducto = $producto->codProducto;
            $detalleVenta->cantidad = $producto->cantidad;
            $detalleVenta->precioV = $producto->precio;
            $detalleVenta->save();
        }

        // Actualizar o registrar el pago
        $pago = Pago::findOrFail($venta->codPagoF);
        $pago->fechaPago = now();
        $pago->monto = $request->montoPagado;
        $pago->estado = $request->montoPagado >= $venta->montoTotal ? 'completo' : 'pendiente';
        $pago->codClienteF = $request->codClienteF;
        $pago->save();

        return redirect()->route('venta.show', $codVenta);
    }

    public function destroy($codVenta)
    {
        $venta = Venta::findOrFail($codVenta);
        $venta->delete();

        return redirect()->route('venta.index')->with('delete', 'Venta eliminada exitosamente');
    }
}
