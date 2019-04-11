<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;

class ProductosController extends Controller
{
    //
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $productos = $this->obtenerTodosLosProductos();

        return view('productos', compact('productos'));
        
    }
    public function AllProduct()
    {
        $productos = $this->obtenerTodosLosProductos();

        $acciones = 'productos.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($productos)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }   
    protected function obtenerTodosLosProductos(){
       //es una funcion que esta en el controller principal
       $respuesta = $this->realizarPeticion('GET','https://apilumen.juandmegon.com/estudiantes');

       $datos = json_decode($respuesta);

       $productos = $datos->data;

       return $productos;
    }
    
    public function show($id){

        $respuesta = $this->realizarPeticion('GET', "https://apilumen.juandmegon.com/estudiantes/{$id}");

        $datos = json_decode($respuesta);

        $producto = $datos->data;
       
        return view('productos.partials.show', ['producto' => $producto]);        
    }    
}
