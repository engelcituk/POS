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
        //$subcategorias = \App::call('App\Http\Controllers\SubCategoriaController@obtenerTodasLasSubCategorias');
        $alergenos = \App::call( 'App\Http\Controllers\AlergenoController@obtenerTodosLosAlergenos');

        return view('productos.partials.create', compact('categorias','alergenos'));  
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
        $idCategoria= $producto->idCategoria;

        
        $categoria = new CategoriaController();
        $categoria = $categoria->obtenerUnaCategoria($idCategoria);

        return view('productos.partials.show', compact('producto','categoria'));
               
    }
    public function edit($idProducto){

        $categorias = \App::call('App\Http\Controllers\CategoriaController@obtenerTodasLasCategorias');        
        $alergenos = \App::call('App\Http\Controllers\AlergenoController@obtenerTodosLosAlergenos');

        $producto = $this->obtenerUnProducto($idProducto);

        // dd( $producto);
        $alergenosProducto = $this->obtenerAlergenosProducto($idProducto);//obtengo un objeto con una respuesta ok
        $respuestaOk = $alergenosProducto->ok;

         
        if ($respuestaOk== 1) {
            $alergenosProducto = $alergenosProducto->objeto;

            $idAlergenosColeccion = new Collection([]);
            foreach ($alergenosProducto as $alergeno) {
                $idAlergenosColeccion->push($alergeno->idAlergeno);
            }

        } else {
            $idAlergenosColeccion = new Collection([]);
         }
                               
        return view('productos.partials.edit', compact('categorias',  'alergenos','producto', 'idAlergenosColeccion')); 
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
        $imagen = $request->file('imagen');
        //$imagenb = base64_encode(file_get_contents($request->file('imagen')->path()));
        $idCategoria = $request->get( 'idCategoria');       
        $codigoProducto = $request->get('codigoProducto');
        $nombreProducto = $request->get('nombreProducto');
        $propina = $request->get('propina');
        $tipoPropina = $request->get('tipoPropina');
        $montoPropina = $request->get('montoPropina');
        $precio = $request->get('precio');
        $complemento = $request->get('complemento');
        $status = $request->get('status');
        
        // dd( $imagen);
       
        if ($imagen == null) {
            $array = array();
            $imagen = "SIN IMAGEN";
            $array=$imagen;
        } else {            
            $imagen = file_get_contents($request->file('imagen')->path());

            $array = array();
            foreach (str_split($imagen) as $char) {
                array_push($array, ord($char));
            }
        }
                       
        $respuesta = $this->realizarPeticion('POST', $this->urlBase . 'AddProducto', [
            'form_params' => [
                'codigoProducto' => $codigoProducto,
                'idCategoria' => $idCategoria,
                'nombreProducto' => $nombreProducto,
                'propina' => $propina,
                'tipoPropina' => $tipoPropina,
                'montoPropina' => $montoPropina,
                'precio' => $precio,
                'complemento' => $complemento,
                'imagen' => $array,
                'status' => $status,


            ]
        ]);

        $datos = json_decode($respuesta);
        $respuestaObjeto = $datos->objeto;

        $idProducto = $respuestaObjeto->id;


        if ($arrayIdAlergenos != null) {
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
        $respuesta = $this->realizarPeticion('POST', $this->urlBase."DeleteProducto/{$idProducto}");

        return redirect('/productos');
    }

    public function destroyAlergeno($idProducto, $idAlergeno){

        $respuesta = $this->realizarPeticion('POST', $this->urlBaseProductoAlergeno."DeleteProductoAlergeno/{$idProducto}/{$idAlergeno}");

        return $respuesta;
    }

}
 
