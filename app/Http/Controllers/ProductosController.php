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
    protected function create()
    {        
        return view('productos.partials.create');
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
       $respuesta = $this->realizarPeticion('GET', 'https://api.myjson.com/bins/ks42s');

       $datos = json_decode($respuesta);

       $productos = $datos->productos;

       return $productos;
    }
    
    public function show($id){

        $producto = $id;

        return view('productos.partials.show', ['producto' => $producto]);

        // $respuesta = $this->realizarPeticion('GET', "https://apilumen.juandmegon.com/estudiantes/{$id}");

        // $datos = json_decode($respuesta);

        // $producto = $datos->productos;
       
        // return view('productos.partials.show', ['producto' => $producto]);        
    }
    public function edit($id)
    {
        $producto = $id;
        return view('productos.partials.edit', ['producto' => $producto]);
    }

    public function store(Request $request){

        $accessToken = 'Bearer '.$this->obtenerAccessToken();

        $respuesta = $this->realizarPeticion('POST', 'https://apilumen.juandmegon.com/estudiantes', ['headers'=> ['Authorization' => $accessToken], 'form_params' => $request->all()]); 
          
        return redirect('/productos');
    }
}
 