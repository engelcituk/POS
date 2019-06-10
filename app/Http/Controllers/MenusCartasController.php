<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;

class MenusCartasController extends Controller{

    public $urlBase = "http://localhost/TPVApi/productos/";
    // public $urlBaseProductoAlergeno = "http://localhost/TPVApi/productoalergeno/";

    public function index(){
        return view('menuscartas');
    }

    public function AllMenuCartas()
    {
        $menucartas = $this->obtenerTodosLosMenusCartas();

        $acciones = 'menuscartas.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($menucartas)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    protected function obtenerTodosLosMenusCartas()
    {
        //es una funcion que esta en el controller principal
        $respuesta = $this->realizarPeticion('GET', 'https://api.myjson.com/bins/ks42s');

        $datos = json_decode($respuesta);

        $menuCartas = $datos->productos;

        return $menuCartas;
    }
 
    
    public function create() {

        $cartas = \App::call( 'App\Http\Controllers\CartaController@obtenerTodosLasCartas');
        $productos = \App::call( 'App\Http\Controllers\ProductosController@obtenerTodosLosProductos');
        $centrosPreparacion = \App::call('App\Http\Controllers\CentrosPreparacionController@obtenerTodosLosCentrosDePreparacion');

        return view('menuscartas.partials.create', compact('cartas', 'productos', 'centrosPreparacion')); 
    }

    
    public function store(Request $request){
        $idProducto= $request->get('idProducto');
        $precio = $request->get('precio');
        $idCentroPrep = $request->get('idCentroPrep');
                        
        dd($idProducto);
    }

    
    public function show($id){
        
        $categorias = \App::call('App\Http\Controllers\CategoriaController@obtenerTodasLasCategorias');
        $subcategorias = \App::call('App\Http\Controllers\SubCategoriaController@obtenerTodasLasSubCategorias');
        $alergenos = \App::call('App\Http\Controllers\AlergenoController@obtenerTodosLosAlergenos');

        return view('menuscartas.partials.show', compact('categorias', 'subcategorias', 'alergenos'));
    }


    public function edit($id){

        $categorias = \App::call('App\Http\Controllers\CategoriaController@obtenerTodasLasCategorias');
        $subcategorias = \App::call('App\Http\Controllers\SubCategoriaController@obtenerTodasLasSubCategorias');
        $alergenos = \App::call('App\Http\Controllers\AlergenoController@obtenerTodosLosAlergenos');

        return view('menuscartas.partials.edit', compact('categorias', 'subcategorias', 'alergenos'));
    }

    
    public function actualizar(Request $request){
    
    }

    
    public function destroy($id){
        
    }
}
