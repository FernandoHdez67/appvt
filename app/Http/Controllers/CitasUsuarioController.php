<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CitasUsuarioController extends Controller
{
    public function miscitas(){
        return view('modulos.citasusuario');
    }
}
