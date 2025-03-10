<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;

class MenusCartasController extends Controller{

    public $urlBase = "";
    public $idHotel;
    // public $urlBaseProductoAlergeno = "http://localhost/TPVApi/productoalergeno/";
    public function __construct(){
        $this->middleware('accesoMenusCartaFiltro');
        $this->urlBase = $this->urlApiTPV()."MenuCarta/";
        $this->urlBaseCentroP = $this->urlApiTPV() . "CentrosProd/";
        $this->middleware(function ($request, $next) { //obtengo el valor de la session idHotel            
            $this->idHotel = session()->get('idHotel');
            return $next($request);
        });

    }
    public function index(){
        $menucartas = $this->obtenerTodosLosMenusCartas($this->idHotel);

        return view('menuscartas', compact('menucartas'));
    }

    public function AllMenuCartas(){
        $menucartas = $this->obtenerTodosLosMenusCartas($this->idHotel);

        $acciones = 'menuscartas.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($menucartas)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    public function obtenerTodosLosMenusCartas($idHotel){
        if($idHotel == null){
            //es una funcion que esta en el controller principal        
            $respuesta = $this->realizarPeticion('GET', $this->urlBase. 'GetMenuCarta');             
        } else {
            $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetMenuCartaByHotel/{$idHotel}");
        }
        
        $datos = json_decode($respuesta);

        $menuCartas = $datos->objeto;

        return $menuCartas;
    }
 
    
    public function create() { 

        $idHotel = $this->idHotel;
        $cartas = new CartaController();
        $cartas = $cartas->obtenerTodosLasCartas($idHotel);
        
        $productos = new ProductosController();
        $productos = $productos->obtenerTodosLosProductos($idHotel);

        $centrosPreparacion = new CentrosPreparacionController();
        $centrosPreparacion = $centrosPreparacion->obtenerTodosLosCentrosDePreparacion($idHotel);

        $centrosP = $this->obtenerCentrosProductivo();

        // $cartas = \App::call( 'App\Http\Controllers\CartaController@obtenerTodosLasCartas');
        // $productos = \App::call( 'App\Http\Controllers\ProductosController@obtenerTodosLosProductos');
        // $centrosPreparacion = \App::call('App\Http\Controllers\CentrosPreparacionController@obtenerTodosLosCentrosDePreparacion');

        return view('menuscartas.partials.create', compact('cartas', 'productos', 'centrosPreparacion', 'centrosP')); 
    }

    
    public function store(Request $request){

        $idCarta = $request->get('idCarta');
        $arrayIdProducto= $request->get('idProducto');
        $arrayPrecio = $request->get('precio');
        $arrayIdCentroPrep = $request->get('idCentroPrep');
        
        $contador=-1;
            foreach ($arrayIdProducto as $idProducto) {
                $contador = $contador+1;
                $precio = $arrayPrecio[$contador];
                $idCentroPrep = $arrayIdCentroPrep[$contador];
                $this->guardarProducto($idCarta, $idProducto, $precio, $idCentroPrep);
            }
        return redirect('/menuscartas');
    }
    public function guardarProducto($idCarta,$idProducto, $precio, $idCentroPrep){

        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'AddMenuCarta', [
            'form_params' => [
                'idCarta' => $idCarta,
                'idProducto' => $idProducto,
                'precio' => $precio,
                'idCentroPrep' => $idCentroPrep
            ]
        ]);
        // dd($respuesta);
        return $respuesta;
        
    }
    
    public function show($id){
        
        $categorias = \App::call('App\Http\Controllers\CategoriaController@obtenerTodasLasCategorias');
        
        $alergenos = \App::call('App\Http\Controllers\AlergenoController@obtenerTodosLosAlergenos');

        return view('menuscartas.partials.show', compact('categorias', 'alergenos'));
    }


    public function edit($idMenuCarta){
        $idHotel = $this->idHotel;
        
        $menucarta = $this->obtenerUnMenuCarta($idMenuCarta);
        $idCarta=$menucarta->idCarta;
        $idProducto = $menucarta->idProducto;
        $idCentroPreparacion = $menucarta->idCentroPrep;
        
        $datosCarta = new CartaController();
        $datosCarta = $datosCarta->obtenerUnaCarta($idCarta);

        $datosProducto = new ProductosController();
        $datosProducto = $datosProducto->obtenerUnProducto($idProducto);

        $datosProducto = new ProductosController();
        $datosProducto = $datosProducto->obtenerUnProducto($idProducto);

        $datosCP = new CentrosPreparacionController();
        $datosCP = $datosCP->obtenerUnCentroDePreparación($idCentroPreparacion);

        $cartas = new CartaController();
        $cartas = $cartas->obtenerTodosLasCartas($idHotel);
        
        $productos = new ProductosController();
        $productos = $productos->obtenerTodosLosProductos($idHotel);

        $centrosPreparacion = new CentrosPreparacionController();
        $centrosPreparacion = $centrosPreparacion->obtenerTodosLosCentrosDePreparacion($idHotel);

        $centrosP = $this->obtenerCentrosProductivo();


        // $cartas = \App::call('App\Http\Controllers\CartaController@obtenerTodosLasCartas');
        // $productos = \App::call('App\Http\Controllers\ProductosController@obtenerTodosLosProductos');
        // $centrosPreparacion = \App::call('App\Http\Controllers\CentrosPreparacionController@obtenerTodosLosCentrosDePreparacion');

        return view('menuscartas.partials.edit', compact('cartas', 'productos', 'centrosPreparacion', 'menucarta','datosCarta', 'datosProducto', 'datosCP', 'centrosP'));
    }

    public function obtenerCentrosProductivo()
    {
        $respuesta = $this->realizarPeticion('GET', $this->urlBaseCentroP . "GetCentrosProd");
        $datos = json_decode($respuesta);
        $centrosProductivos = $datos->objeto;
        return $centrosProductivos;
    }
    
    public function obtenerUnMenuCarta($idMenuCarta){
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetMenuCarta/{$idMenuCarta}");
        $datos = json_decode($respuesta);
        $menuCarta = $datos->objeto;
        return $menuCarta;
    }
    
    public function actualizar(Request $request){
        $idMenuCarta = $request->get('id');

        $respuesta = $this->realizarPeticion('POST', $this->urlBase."UpdateMenuCarta/{$idMenuCarta}", ['form_params' => $request->except('id')]);
        
        return redirect('/menuscartas');
    }

    
    public function destroy($idMenuCarta){ 

        $respuesta = $this->realizarPeticion('POST', $this->urlBase."DeleteMenu/{$idMenuCarta}");

        return redirect('/menuscartas');
    }
}
