<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Collection;

class ProductosController extends Controller
{
    public $urlBase = "http://localhost/TPVApi/Producto/";
    public $urlBaseProductoAlergeno = "http://localhost/TPVApi/ProductoAlergeno/";

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

        return view('productos');
        
    }
    protected function create(){
        
        $categorias= \App::call('App\Http\Controllers\CategoriaController@obtenerTodasLasCategorias');
        $subcategorias = \App::call('App\Http\Controllers\SubCategoriaController@obtenerTodasLasSubCategorias');
        $alergenos = \App::call( 'App\Http\Controllers\AlergenoController@obtenerTodosLosAlergenos');

        return view('productos.partials.create', compact('categorias','subcategorias','alergenos'));  
    }
    public function AllProduct()
    {
        $productos = $this->obtenerTodosLosProductos();

        $acciones = 'productos.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($productos)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }   
    public function obtenerTodosLosProductos(){
       //es una funcion que esta en el controller principal
       $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetProducto'); 

       $datos = json_decode($respuesta);

       $productos = $datos->objeto;

       return $productos;
    }
    
    public function show($idProducto){
        
        $producto = $this->obtenerUnProducto($idProducto);
        $idSubcategoria= $producto->idSubCategoria;

        $subCategoria = new SubCategoriaController();
        $subCategoria = $subCategoria->obtenerUnaSubCategoria($idSubcategoria);
        $idCategoria = $subCategoria->idCategoria;

        $categoria = new CategoriaController();
        $categoria = $categoria->obtenerUnaCategoria($idCategoria);

        return view('productos.partials.show', compact('producto','subCategoria','categoria'));

        // $respuesta = $this->realizarPeticion('GET', "https://apilumen.juandmegon.com/estudiantes/{$id}");

        // $datos = json_decode($respuesta);

        // $producto = $datos->productos;
       
        // return view('productos.partials.show', ['producto' => $producto]);        
    }
    public function edit($idProducto){

        $categorias = \App::call('App\Http\Controllers\CategoriaController@obtenerTodasLasCategorias');
        $subcategorias = \App::call('App\Http\Controllers\SubCategoriaController@obtenerTodasLasSubCategorias');
        $alergenos = \App::call('App\Http\Controllers\AlergenoController@obtenerTodosLosAlergenos');

        $producto = $this->obtenerUnProducto($idProducto);
        $alergenosProducto = $this->obtenerAlergenosProducto($idProducto);//obtengo un objeto con una respuesta ok
        $respuestaOk = $alergenosProducto->ok;

        $idSubcategoria = $producto->idSubCategoria;

        $subCategoria = new SubCategoriaController();
        $subCategoria = $subCategoria->obtenerUnaSubCategoria($idSubcategoria);
        $idCategoria = $subCategoria->idCategoria;
 
        if ($respuestaOk== 1) {
            $alergenosProducto = $alergenosProducto->objeto;

            $idAlergenosColeccion = new Collection([]);
            foreach ($alergenosProducto as $alergeno) {
                $idAlergenosColeccion->push($alergeno->idAlergeno);
            }

        } else {
            $idAlergenosColeccion = new Collection([]);
         }
                               
        return view('productos.partials.edit', compact('categorias', 'subcategorias', 'alergenos','producto', 'subCategoria', 'idAlergenosColeccion')); 
    }
    public function obtenerUnProducto($idProducto){
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetProducto/{$idProducto}");
        $datos = json_decode($respuesta);
        $producto = $datos->objeto;
        return $producto;
    }
    
    public function obtenerAlergenosProducto($idProducto){
        $respuesta = $this->realizarPeticion('GET', $this->urlBaseProductoAlergeno."GetAlergenosProducto/{$idProducto}");
        $datos = json_decode($respuesta);
        // $respuestaOK = $datos->objeto;
        return $datos;
    }
    public function store(Request $request){

        $arrayIdAlergenos = $request->get('idAlergeno');
        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'AddProducto', ['form_params' => $request->all()]);
        $datos = json_decode($respuesta);
        $respuestaObjeto = $datos->objeto; 

        $idProducto = $respuestaObjeto->id;

        if($arrayIdAlergenos!=null){            
            foreach ($arrayIdAlergenos as $idAlergeno) {
                $this->guardarProductoAlergeno($idProducto, $idAlergeno);
            }
        }                         
        return redirect('/productos');
    }

    public function guardarProductoAlergeno($idProducto, $idAlergeno){
        $respuesta = $this->realizarPeticion('POST', $this->urlBaseProductoAlergeno.'AddProductoAlergeno', [
            'form_params' => [
                'idProducto' => $idProducto,
                'idAlergeno' => $idAlergeno
            ]
        ]);
        return $respuesta;
    }

    public function destroy($idProducto){        
        $respuesta = $this->realizarPeticion('DELETE', $this->urlBase."DeleteProducto/{$idProducto}");

        return redirect('/productos');
    }

    public function destroyAlergeno($idProducto, $idAlergeno){

        $respuesta = $this->realizarPeticion('DELETE', $this->urlBaseProductoAlergeno."DeleteProductoAlergeno/{$idProducto}/{$idAlergeno}");

        return $respuesta;
    }

}
 
