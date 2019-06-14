<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class OrdenController extends Controller
{
    public $urlBase = "http://localhost/TPVApi/Zonas/";
    public $urlHuesped= "http://localhost/TPVApi/Venta/"; //para obtener los datos del huesped para la venta
    // public $urlT= "http://172.16.4.229/TPVApi/Venta/";
    public function __construct(){
        // $this->middleware('auth');
    }
    public function index(){
        $idPuntoVenta = 23;
        $respuesta = $this->obtenerTodasLasZonasPV($idPuntoVenta);
        // $respuesta = json_decode($respuesta);
        $zonas = $respuesta->objeto;
        $alergenos = \App::call('App\Http\Controllers\AlergenoController@obtenerTodosLosAlergenos');
        $categorias = \App::call('App\Http\Controllers\CategoriaController@obtenerTodasLasCategorias');
        $subcategorias = \App::call('App\Http\Controllers\SubCategoriaController@obtenerTodasLasSubCategorias');
        $productos = \App::call( 'App\Http\Controllers\ProductosController@obtenerTodosLosProductos');

        $idSubCatsCollection = new Collection([]);
        foreach ($subcategorias as $subCat) {
            $idSubCatsCollection->push($subCat->id);
        }
        // dd($idSubCatsCollection);

        return view('ordenar', compact('zonas','alergenos','categorias','productos', 'idSubCatsCollection'));
    }
   
    public function obtenerTodasLasZonasPV($idPuntoVenta){
        //es una funcion que esta en el controller principal        
        $respuesta = $this->realizarPeticion('GET', $this->urlBase . "GetZonaPV/{$idPuntoVenta}");

        $respuesta= json_decode($respuesta);        

        return $respuesta;
    }

    public function obtenerDatosHuesped($codhotel, $room){
        //es una funcion que esta en el controller principal        
        $respuesta = $this->realizarPeticion('GET', $this->urlHuesped."GetHuesped/{$codhotel}/{$room}");
        // $respuesta = json_encode($respuesta);
        return $respuesta;
    }
    
    static public function obtenerMesasPorZona($idZona){
        $metodo="GET";        
        $urlBase= "http://localhost/TPVApi/Mesas/GetMesaPorZona/{$idZona}";
        
        $cliente =  new Client();                
        $respuesta = $cliente->request($metodo, $urlBase);
        $respuesta = $respuesta->getBody()->getContents();
        $respuesta = json_decode($respuesta);
        $mesas = $respuesta->objeto;
                
        return  $mesas;
    }
    static public function getSCategoriasByCategoria($idCategoria){
        $metodo = "GET";
        $urlBase = "http://localhost/TPVApi/SubCategoria/GetSubCategoriasPorCategoria/{$idCategoria}";

        $cliente =  new Client();
        $respuesta = $cliente->request($metodo, $urlBase);
        $respuesta = $respuesta->getBody()->getContents();
        $respuesta = json_decode($respuesta);
        $respuestaOk = $respuesta->ok;

        if ($respuestaOk == 1) { 
            $subCategorias = $respuesta->objeto;
        }else{
            $subCategorias = 0;
        }

        return $subCategorias;
    }

    static public function getProductosBySubCat($idSubCategoria){
        $metodo = "GET";
        $urlBase = "http://localhost/TPVApi/Producto/GetProductosPorSubCategoria/{$idSubCategoria}";

        $cliente =  new Client();
        $respuesta = $cliente->request($metodo, $urlBase);
        $respuesta = $respuesta->getBody()->getContents();
        $respuesta = json_decode($respuesta);
        $respuestaOk = $respuesta->ok;

        if ($respuestaOk == 1) {
            $productos = $respuesta->objeto;
        } else {
            $productos = 0;
        }
        return $productos;
    }

    // public function guardarCuenta(Request $request){
    //     $alergenos = $request->get('alergenos');                        
    //     foreach ($alergenos as $alergeno) {
    //         $array[]=array('idAlergeno'=>$alergeno);
            
    //     }                
    //     $respuesta = $this->realizarPeticion('POST', $this->urlT.'AddCuenta', [
    //         'form_params' => [
    //             'idUsuarioAlta' => 34,
    //             'idMesa' => 1,
    //             'reserva' => "RSB",
    //             'habitacion' => "123",
    //             'nombreCliente' => "asd",
    //             'idPuntoVenta' => 10,
    //             'TPV_AlergenosCuenta' => 
    //                 $array
                                
    //         ]
    //     ]);
    //     return $respuesta;
    // }
    
}

