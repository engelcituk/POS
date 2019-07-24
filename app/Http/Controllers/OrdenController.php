<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class OrdenController extends Controller
{
    public $urlBase = "http://localhost/TPVApi/Zonas/";
    public $urlHuesped= "http://localhost/TPVApi/Venta/"; //para obtener los datos del huesped para la venta
    public $urlVenta= "http://localhost/TPVApi/Venta/";
    public $urlBaseProductoAlergeno = "http://localhost/TPVApi/ProductoAlergeno/";
    public $urlBaseProducto = "http://localhost/TPVApi/Producto/";
    public $urlMenuCarta= "http://localhost/TPVApi/MenuCarta/";
    public $urlMesas = "http://localhost/TPVApi/Mesas/";
//
    public function __construct(){
        // $this->middleware('auth');
        $this->middleware('accesoTomarOrdenFiltro');
    }
    public function index(Request $request){
        
        $idPuntoVenta = $request->session()->get('idPuntoVenta');
        $idCarta = $request->session()->get('idCarta');

        $respuestaZonas = $this->ZonasPV($idPuntoVenta);        
        $zonas = $respuestaZonas->objeto;

        $categorias=$this->obtenerCategoriasCarta($idCarta);
        
        $alergenos = \App::call('App\Http\Controllers\AlergenoController@obtenerTodosLosAlergenos');//se cargan en un modal
        //$categorias = \App::call('App\Http\Controllers\CategoriaController@obtenerTodasLasCategorias');//se carga en tabs
        $metodosPago = \App::call('App\Http\Controllers\MetodosPagoController@obtenerTodosLosMetodosPagos'); //se carga en subtabs
        // $modos = \App::call('App\Http\Controllers\ModosController@obtenerTodosLosModos');
        // dd($modos);
        return view('ordenar', compact('zonas','alergenos','categorias', 'metodosPago'));
    }
    public function ZonasPV($idPuntoVenta){
        
        $respuesta = $this->realizarPeticion('GET', $this->urlBase . "GetZonaPV/{$idPuntoVenta}");
        $respuesta= json_decode($respuesta);        
        return $respuesta;
    }
    public function obtenerTodasLasZonasPV(Request $request){

        $idPuntoVenta = $request->session()->get('idPuntoVenta');
              
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetZonaPV/{$idPuntoVenta}");

        // $respuesta= json_decode($respuesta);        

        return $respuesta;
    }
     public function getMesasPorZona($idZona){
        
        $respuesta = $this->realizarPeticion('GET', $this->urlMesas."GetMesaPorZona/{$idZona}");       

        return  $respuesta;
    }
    public function obtenerCategoriasCarta($idCarta){
        
        $urlBase= "http://localhost/TPVApi/Categoria/";
        
        $respuesta = $this->realizarPeticion('GET', $urlBase."GetCategoriabyCarta/{$idCarta}");        

        $datos = json_decode($respuesta);

        $categorias = $datos->objeto;

        return $categorias;

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
    // static public function getSCategoriasByCategoria($idCategoria){
    //     $metodo = "GET";
    //     $urlBase = "http://localhost/TPVApi/SubCategoria/GetSubCategoriasPorCategoria/{$idCategoria}";

    //     $cliente =  new Client();
    //     $respuesta = $cliente->request($metodo, $urlBase);
    //     $respuesta = $respuesta->getBody()->getContents();
    //     $respuesta = json_decode($respuesta);
    //     $respuestaOk = $respuesta->ok;

    //     if ($respuestaOk == 1) { 
    //         $subCategorias = $respuesta->objeto;
    //     }else{
    //         $subCategorias = 0;
    //     }

    //     return $subCategorias;
    // }

    public function getProductosByCat(Request $request){
        $idCarta = $request->session()->get('idCarta');
        $idCategoria = $request->get('idCategoria');

        $respuesta = $this->realizarPeticion('GET', $this->urlMenuCarta."GetProductosMenuCarta/{$idCarta}/{$idCategoria}");
        
        return $respuesta;        
    }

    public function getProductosFavoritos(Request $request){
        $urlBase = "http://localhost/TPVApi/menucarta/";
        // http://localhost/TPVApi/menucarta/GetProductosMenuCartaFav/1034/10
        $idPV = $request->get('idPuntoVenta');
        $idCarta = $request->get('idCarta');

        $respuesta = $this->realizarPeticion('GET', $urlBase."GetProductosMenuCartaFav/{$idCarta}/{$idPV}");

        return $respuesta;
    }

    public function guardarCuenta(Request $request){

        $idMesa = $request->get('idMesa');//obtengo el id de la mesa del modal
        $idUsuario = $request->session()->get('idUsuarioLogueado'); //obtengo el id de usuario logueado
        $reserva = $request->get( 'reserva');
        $habitacion = $request->get('habitacion');
        $nombreCliente = $request->get('nombreCliente');
        $pax = $request->get('pax');
        $idPuntoVenta = $request->session()->get('idPuntoVenta'); //obtengo el id del punto de venta

        $alergenos = $request->get('alergenos'); //obtengo el array de alergenos desde ajax

        if ($alergenos != null) {
            foreach ($alergenos as $alergeno) {
                $arrayAlergenos[] = array('idAlergeno' => $alergeno);
            } 
         }else{
            $arrayAlergenos=array();
         }                       
        // return $alergenos;
        $respuesta = $this->realizarPeticion('POST', $this->urlVenta.'AddCuenta', [
            'form_params' => [
                'idMesa' => $idMesa,
                'idUsuarioAlta' => $idUsuario,
                'reserva' => $reserva,
                'habitacion' => $habitacion,
                'nombreCliente' => $nombreCliente,
                'pax' => $pax,
                'idPuntoVenta' => $idPuntoVenta,
                'TPV_AlergenosCuenta' => 
                    $arrayAlergenos                                
            ]
        ]);
        return $respuesta;
    }
    public function obtenerAlergenosProducto($idProducto){
        $respuesta = $this->realizarPeticion('GET', $this->urlBaseProductoAlergeno."GetAlergenosProducto/{$idProducto}");        
        return $respuesta;
    }
    public function enviarACentrosPrep(Request $request){
        $cuentaTemporal = $request->get('cuentaTemporal');        
        
        $contador=0;
        foreach ($cuentaTemporal as $ct) {
            $idCuenta = $cuentaTemporal[$contador]["idCuenta"];
            $idMenuCarta = $cuentaTemporal[$contador]["idMenuCarta"];
            $cantidad = $cuentaTemporal[$contador]["cantidad"];
            $comensal = $cuentaTemporal[$contador]["comensal"];
            $tiempo = $cuentaTemporal[$contador]["tiempo"];
            $precioUnitario = $cuentaTemporal[$contador]["precioUnitario"];
            $idUsuarioAlta = $cuentaTemporal[$contador]["idUsuarioAlta"];
            $nota = $cuentaTemporal[$contador]["nota"];
            $tiempo = $cuentaTemporal[$contador]["tiempo"];
            $modo = $cuentaTemporal[$contador]["modo"];
            
            $arrayCuenta[] =  array('idCuenta' => (int) $idCuenta,
                                    'idMenuCarta'=> (int) $idMenuCarta,
                                    'cantidad'=> (int) $cantidad,
                                    'comensal' => (int) $comensal,
                                    'tiempo' =>(int) $tiempo,
                                    'precioUnitario' => number_format($precioUnitario, 2),
                                    'idUsuarioAlta' => (int) $idUsuarioAlta,
                                    'nota' => $nota,
                                    'idModo' => $modo                                   
                                    );

            $contador++;  
        }          
        $respuesta = $this->realizarPeticion('POST', $this->urlVenta.'AddDetalleCuenta', [
            'form_params' => [
                'ldetalleCuenta' =>
                 $arrayCuenta
            ]
        ]);
        return $respuesta;
    }
    public function getCuenta($idCuenta){

        $respuesta = $this->realizarPeticion('GET', $this->urlVenta."GetCuenta/{$idCuenta}");
        return $respuesta;
    }
    public function obtenerCuentaApi($idCuenta){

        $respuesta = $this->realizarPeticion('GET', $this->urlVenta."GetDetalleCuenta/{$idCuenta}");
        return $respuesta;        
    }
    public function cancelarProductoCuenta(Request $request, $idDetalleCuenta){

        $idUsuarioSesion = $request->session()->get('idUsuarioLogueado');
        $motivo = $request->get('motivo');
        
        $respuesta = $this->realizarPeticion('POST', $this->urlVenta.'CancelProduct', [
            'form_params' => [
                'iddc' => $idDetalleCuenta,
                'idu' => $idUsuarioSesion,
                'motivo' => $motivo            
            ]
        ]);
        return $respuesta;

    }
    public function cerraCuenta(Request $request, $idCuenta){
        // $urlVenta = "http://localhost/TPVApi/Venta/";
        $idUsuarioSesion = $request->session()->get('idUsuarioLogueado'); 

        $porcentajeDescuento = $request->get('porcentajeDescuento');
        $idFormaPago = $request->get('idFormaPago');
                
        $respuesta = $this->realizarPeticion('POST', $this->urlVenta.'cierraCuenta', [
            'form_params' => [
                'idc'=>$idCuenta,
                'idu' => $idUsuarioSesion,
                'descuento' => $porcentajeDescuento,
                'idFormaPago' => $idFormaPago
            ]
        ]);
        return $respuesta;
        
    } 
    public function cerrarDia(Request $request,$idPV){

        $urlCerrarDia = "http://localhost/TPVApi/Admin/";

        $idUsuario = $request->session()->get('idUsuarioLogueado');
        $fecha = Carbon::now()->format('d-m-Y');

        $respuesta = $this->realizarPeticion('POST', $urlCerrarDia."cierreDia/{$idPV}/{$fecha}/{$idUsuario}");

        return $respuesta;

        
    }
}
// 172.16.4.229 
