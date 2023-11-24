<?php

namespace App\Http\Controllers;

use App\Models\sf;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Carrito;

class CarritoController extends Controller
{

    public function index()
    {
        $idusuario = session('idusuario');
        $carrito = Carrito::with('producto')->where('idusuario', $idusuario)->get();
        // Calcular el total sumando los totales de cada producto
        $totalCarrito = $carrito->sum('total');

        return view('modulos.carrito', compact('carrito', 'totalCarrito'));
    }

    public function comprarahora()
    {
        $idusuario = session('idusuario');
        $carrito = Carrito::with('producto')->where('idusuario', $idusuario)->get();
        // Calcular el total sumando los totales de cada producto
        $totalCarrito = $carrito->sum('total');

        return view('modulos.detalles', compact('carrito', 'totalCarrito'));
    }



    public function agregarProducto(Request $request)
    {
        $idusuario = session('idusuario');
        $producto = Producto::find($request->input('idproducto'));

        $messages = [
            'cantidad.required' => 'La cantidad es obligatoria',
            'cantidad.numeric' => 'La cantidad debe ser numerica',
            'cantidad.min' => 'La cantidad debe mayor que cero',
        ];

        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ], $messages);

        $cantidad = $request->input('cantidad');

        // Buscar si el producto ya está en el carrito del usuario
        $carritoExistente = Carrito::where('idusuario', $idusuario)
            ->where('idproducto', $producto->idproducto)
            ->first();

        if ($carritoExistente) {
            // Si el producto ya está en el carrito, actualiza la cantidad
            $carritoExistente->update([
                'cantidad' => $carritoExistente->cantidad + $cantidad,
                'total' => $carritoExistente->total + ($producto->precio * $cantidad),
            ]);
        } else {
            // Si el producto no está en el carrito, crea un nuevo registro
            $carrito = new Carrito([
                'idproducto' => $producto->idproducto,
                'idusuario' => $idusuario,
                'imagen' => $producto->imagen,
                'nombre' => $producto->nombre,
                'cantidad' => $cantidad,
                'precio' => $producto->precio,
                'total' => $producto->precio * $cantidad,
            ]);

            $carrito->save();
        }

        return redirect()->route('carrito.index')->with('success', 'Producto agregado al carrito');
    }

    public function eliminarProducto($idcarrito)
    {
        // Buscar el producto en el carrito
        $carrito = Carrito::find($idcarrito);

        // Verificar si se encontró el producto en el carrito
        if ($carrito) {
            // Eliminar el producto del carrito
            $carrito->delete();

            return redirect()->route('carrito.index')->with('success', 'Producto eliminado del carrito');
        }

        // Si no se encuentra el producto, redirigir con un mensaje de error
        return redirect()->route('carrito.index')->with('error', 'Producto no encontrado en el carrito');
    }

    public function limpiarCarrito()
    {
        $idusuario = session('idusuario');

        // Eliminar todos los productos del carrito para el usuario actual
        Carrito::where('idusuario', $idusuario)->delete();

        return redirect()->route('carrito.index')->with('success', 'Carrito limpiado');
    }


    public function session(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        $productname = $request->get('productname');
        $totalprice = $request->get('total');
        $two0 = "00";
        $total = "$totalprice$two0";

        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'MXN',
                        'product_data' => [
                            "name" => $productname,
                        ],
                        'unit_amount'  => $total,
                    ],
                    'quantity'   => 1,
                ],

            ],
            'mode'        => 'payment',
            'success_url' => route('success'),
            'cancel_url'  => route('carrito.index'),
        ]);

        return redirect()->away($session->url);
    }

    public function sessionproduct(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        $productname = $request->get('productname');
        $totalprice = $request->get('total');
        $two0 = "00";
        $total = "$totalprice$two0";

        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'MXN',
                        'product_data' => [
                            "name" => $productname,
                        ],
                        'unit_amount'  => $total,
                    ],
                    'quantity'   => 1,
                ],

            ],
            'mode'        => 'payment',
            'success_url' => route('success'),
            'cancel_url'  => route('productos'),
        ]);

        return redirect()->away($session->url);
    }

    public function success()
    {
        return "Gracias por tu pedido. Acabas de completar tu pago. El vendedor se comunicará con usted lo antes posible.";
    }
}
