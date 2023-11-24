<?php

namespace App\Http\Controllers;

use App\Models\sf;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Hash;
use App\Models\PreguntaSecreta;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class UsuariosContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pregunta(Request $request)
    {
        $pregunta = PreguntaSecreta::all();
        return view('sesiones.registro', ['pregunta' => $pregunta]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */




    public function store(Request $request)
    {
        // dd($request->all());
        $messages = [
            'nombre.required' => 'El Nombre es obligatorio.',
            'nombre.string' => 'El nombre no debe incluir numeros.',
            'nombre.regex' => 'El nombre debe comenzar con una letra mayúscula y no debe contener números.',
            'apaterno.required' => 'El Apellido Paterno es obligatorio.',
            'apaterno.string' => 'El Apellido Paterno no debe incluir numeros.',
            'apaterno.regex' => 'El Apellido Paterno debe comenzar con una letra mayúscula y no debe contener números.',
            'amaterno.required' => 'El Apellido Materno es obligatorio.',
            'amaterno.string' => 'El Apellido Materno no debe incluir numeros.',
            'amaterno.regex' => 'El Apellido Materno debe comenzar con una letra mayúscula y no debe contener números.',
            'telefono.required' => 'El Teléfono es obligatorio.',
            'telefono.numeric' => 'El Teléfono debe ser numérico.',
            'telefono.digits' => 'El Numero de teléfono debe ser de 10 dígitos.',
            'email.required' => 'El Correo es obligatorio.',
            'email.email' => 'El Correo debe ser una dirección de correo válida.',
            'email.unique' => 'Este Correo ya existe.',
            'direccion.required' => 'La Dirección es obligatoria.',
            'nombre_usuario.required' => 'El nombre de usuario es obligatorio.',
            'nombre_usuario.unique' => 'El nombre de usuario ya existe.',
            'password.required' => 'La Contraseña es obligatoria.',
            'idpreguntasecreta.required' => 'Tienes que elegir una pregunta.',
            'respuesta' => 'La respuesta es obligatoria',
            'password.min' => 'la contraseña debe ser mayor a 8 caracteres',
            'confpassword.required' => 'La confirmacion de Contraseña es obligatoria.',
            'confpassword.min' => 'la contraseña debe ser mayor a 8 caracteres',
            'confpassword.same' => 'La contraseña no coincide con la primera.',
            'politicas.required' => 'Es necesario aceptar todos los terminos y condiciones ',
        ];

        $request->validate([
            'nombre' => 'required|string|max:255|regex:/^[A-ZÁÉÍÓÚÜ][a-záéíóúü]+$/u',
            'apaterno' => 'required|string|max:255|regex:/^[A-ZÁÉÍÓÚÜ][a-záéíóúü]+$/u',
            'amaterno' => 'required|string|max:255|regex:/^[A-ZÁÉÍÓÚÜ][a-záéíóúü]+$/u',
            'telefono' => 'required|numeric|digits:10',
            'email' => 'required|email|max:255|unique:tbl_usuarios',
            'direccion' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|max:255|unique:tbl_usuarios',
            'preguntasecreta' => 'required',
            'respuesta' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|max:255|unique:tbl_usuarios',
            'password' => 'required|string|min:8',
            'confpassword' => 'required|string|min:8|same:password',
            'politicas' => 'required',
        ], $messages);


        $usuarios = Usuarios::create([
            'nombre' => $request->input('nombre'),
            'apaterno' => $request->input('apaterno'),
            'amaterno' => $request->input('amaterno'),
            'telefono' => $request->input('telefono'),
            'email' => $request->input('email'),
            'direccion' => $request->input('direccion'),
            'nombre_usuario' => $request->input('nombre_usuario'),
            'idpreguntasecreta' => $request->input('preguntasecreta'),
            'respuesta' => $request->input('respuesta'),
            'password' => Hash::make($request->input('password')),
            'remember_token' => Str::random(60), // Agregue el campo remember_token con un valor aleatorio

        ]);

        return view('sesiones.iniciar');
    }


    public function crearusuario(Request $request)
    {
        // Validar los datos recibidos en la solicitud
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|regex:/^[A-ZÁÉÍÓÚÜ][a-záéíóúü]+$/u',
            'apaterno' => 'required|string|max:255|regex:/^[A-ZÁÉÍÓÚÜ][a-záéíóúü]+$/u',
            'amaterno' => 'required|string|max:255|regex:/^[A-ZÁÉÍÓÚÜ][a-záéíóúü]+$/u',
            'telefono' => 'required|numeric|digits:10',
            'email' => 'required|email|max:255|unique:tbl_usuarios',
            'direccion' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|max:255|unique:tbl_usuarios',
            'idpreguntasecreta' => 'required',
            'respuesta' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Buscar el horario correspondiente a la hora ingresada
        // $preguntasecreta = PreguntaSecreta::where('pregunta', $request->idpreguntasecreta)->first();

        // Validar si ambos ya existen
        $validator->after(function ($validator) use ($request) {
            if ($this->nombreUsuarioExiste($request->nombre_usuario) && $this->emailExiste($request->email)) {
                $validator->errors()->add('usuario', 'El correo y nombre de usuario ya existen.');
            }
        });

        // Validar si el correo electrónico ya existe
        $validator->after(function ($validator) use ($request) {
            if ($this->emailExiste($request->email)) {
                $validator->errors()->add('usuario', 'El correo electrónico ya está registrado.');
            }
        });

        // Validar si el nombre de usuario ya existe
        $validator->after(function ($validator) use ($request) {
            if ($this->nombreUsuarioExiste($request->nombre_usuario)) {
                $validator->errors()->add('usuario', 'El nombre de usuario ya existe.');
            }
        });


        // Si la validación falla, devolver una respuesta JSON con los errores
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->first('usuario')], 400);
        }

        // Resto del código para guardar el usuario
        $usuario = new Usuarios();
        $usuario->nombre = $request->nombre;
        $usuario->apaterno = $request->apaterno;
        $usuario->amaterno = $request->amaterno;
        $usuario->telefono = $request->telefono;
        $usuario->email = $request->email;
        $usuario->direccion = $request->direccion;
        $usuario->nombre_usuario = $request->nombre_usuario;
        $usuario->idpreguntasecreta = $request->idpreguntasecreta;
        $usuario->respuesta = $request->respuesta;
        $usuario->password = Hash::make($request->password);
        $usuario->remember_token = Str::random(60); // Agregar remember_token con valor aleatorio
        $usuario->save();

        return response()->json(['message' => 'Usuario registrado exitosamente.'], 201);
    }

    // Función para verificar si el nombre de usuario ya existe
    private function nombreUsuarioExiste($nombreUsuario)
    {
        return Usuarios::where('nombre_usuario', $nombreUsuario)->exists();
    }

    // Función para verificar si el correo electrónico ya existe
    private function emailExiste($email)
    {
        return Usuarios::where('email', $email)->exists();
    }

    public function usuariosapi(Request $request)
    {
        $usuariosapi = Usuarios::all();
        return response()->json($usuariosapi);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sf  $sf
     * @return \Illuminate\Http\Response
     */
    public function show(sf $sf)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sf  $sf
     * @return \Illuminate\Http\Response
     */
    public function edit(sf $sf)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sf  $sf
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sf $sf)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sf  $sf
     * @return \Illuminate\Http\Response
     */
    public function destroy(sf $sf)
    {
        //
    }
}
