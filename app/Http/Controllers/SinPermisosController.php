<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SinPermisosController extends Controller
{
    public function __construct(){

        // $this->middleware('accesoSinPermisosFiltro');
    }

    public function index(){
       
        return view('sinpermisos');
    }
}
 