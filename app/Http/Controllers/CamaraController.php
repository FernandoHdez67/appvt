<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CamaraController extends Controller
{
    public function usocamara(){
        return view('modulos.camara');
    }
}
