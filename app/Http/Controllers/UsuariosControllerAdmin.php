<?php

namespace App\Http\Controllers;

use App\Models\sf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuariosControllerAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function usuarios(Request $request)
    {
        $texto=trim($request->get('texto'));
        $usuarios=DB::table('tbl_usuarios')
               ->select('idusuario','nombre','apaterno','amaterno','telefono','email', 'direccion', 'nombre_usuario', 'password')
               ->where('nombre','LIKE','%'.$texto.'%')
               ->orWhere('apaterno','LIKE','%'.$texto.'%')
               ->orWhere('amaterno','LIKE','%'.$texto.'%')
               ->orWhere('telefono','LIKE','%'.$texto.'%')
               ->orWhere('email','LIKE','%'.$texto.'%')
               ->orWhere('direccion','LIKE','%'.$texto.'%')
               ->orWhere('nombre_usuario','LIKE','%'.$texto.'%')
               ->orWhere('password','LIKE','%'.$texto.'%')
               ->orderBy('nombre','asc')
               ->paginate(30);
        return view('admin.admin_usuarios',compact('usuarios','texto'));
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
