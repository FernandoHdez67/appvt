<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Carrito;

class CarritoControllerApi extends Controller
{
    public function agregarProducto(Request $request)
    {
        $idusuario = $request->input('idusuario');
        $producto = Producto::find($request->input('idproducto'));

        $messages = [
            'cantidad.required' => 'La cantidad es obligatoria',
            'cantidad.numeric' => 'La cantidad debe ser numérica',
            'cantidad.min' => 'La cantidad debe ser mayor que cero',
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

        return response()->json(['message' => 'Producto agregado al carrito']);
    }

    public function eliminarProducto($idcarrito)
    {
        // Buscar el producto en el carrito
        $carrito = Carrito::find($idcarrito);

        // Verificar si se encontró el producto en el carrito
        if ($carrito) {
            // Eliminar el producto del carrito
            $carrito->delete();

            return response()->json(['message' => 'Producto eliminado del carrito']);
        }

        // Si no se encuentra el producto, retornar un mensaje de error
        return response()->json(['error' => 'Producto no encontrado en el carrito']);
    }

    public function getCarrito()
    {
        $idusuario = request('idusuario'); // Asegúrate de recibir el idusuario desde la solicitud

        $carrito = Carrito::with('producto')->where('idusuario', $idusuario)->get();
        // Calcular el total sumando los totales de cada producto
        $totalCarrito = $carrito->sum('total');

        return response()->json(['carrito' => $carrito, 'totalCarrito' => $totalCarrito]);
    }

    public function success()
    {
        return response()->json(['message' => 'Gracias por tu pedido. Acabas de completar tu pago. El vendedor se comunicará contigo lo antes posible.']);
    }
}
