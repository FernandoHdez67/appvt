<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrucel;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginApiController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $usuario = Usuarios::where('email', $credentials['email'])->first();

        if ($usuario && Hash::check($credentials['password'], $usuario->password)) {
            // Las credenciales son válidas
            // Puedes personalizar los datos que deseas devolver en la respuesta JSON
            return response()->json(['usuario' => $usuario]);
        }

        return response()->json(['error' => 'Las credenciales proporcionadas son incorrectas.'], 401);
    }
}
