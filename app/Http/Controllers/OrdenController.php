<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class OrdenController extends Controller
{
    public $urlBase = "";    
    public $urlVenta= "";
    public $urlBaseProductoAlergeno = "";
    public $urlBaseProducto = "";
    public $urlMenuCarta= "";
    public $urlMesas = "";
    public $urlCategoria = "";
    public $urlAdmin = "";


//
    public function __construct(){
        // $this->middleware('auth');
        $this->middleware('accesoTomarOrdenFiltro');

        $this->urlBase = $this->urlApiTPV()."Zonas/";        
        $this->urlVenta = $this->urlApiTPV()."Venta/";
        $this->urlBaseProductoAlergeno = $this->urlApiTPV()."ProductoAlergeno/";
        $this->urlBaseProducto = $this->urlApiTPV()."Producto/";
        $this->urlMenuCarta = $this->urlApiTPV()."MenuCarta/";
        $this->urlMesas = $this->urlApiTPV()."Mesas/";
        $this->urlCategoria = $this->urlApiTPV()."Categoria/";
        $this->urlAdmin = $this->urlApiTPV()."Admin/";

        
    }
    public function index(Request $request){
        
        $idPuntoVenta = $request->session()->get('idPuntoVenta');

        $idCarta = $request->session()->get('idCarta');

        $respuestaZonas = $this->zonasPV($idPuntoVenta);

        $zonas = $respuestaZonas->objeto;

        $categorias=$this->obtenerCategoriasCarta($idCarta);
       
        $alergenos = \App::call('App\Http\Controllers\AlergenoController@obtenerTodosLosAlergenos');//se cargan en un modal
        //$categorias = \App::call('App\Http\Controllers\CategoriaController@obtenerTodasLasCategorias');//se carga en tabs
        $metodosPago = \App::call('App\Http\Controllers\MetodosPagoController@obtenerTodosLosMetodosPagos'); //se carga en subtabs
        
        return view('ordenar', compact('zonas','alergenos','categorias', 'metodosPago'));
    }

    public function obtenerListaPermisosUsuario($idUsuario){

        $permisos = new ApiUsuarioController(); //Traigo toda mi lista de permisos
        $respuesta = $permisos->obtenerDatosPermisosUsuario($idUsuario);

        $permisos = json_decode($respuesta);
        $respuestaOk = $permisos->ok;
        
        if ($respuestaOk == true) {
            $listaPermisos = $permisos->objeto;
            foreach ($listaPermisos as $permiso) {
                $arrayPermisos[] = array('idPermiso' => $permiso->idPermiso,  'nombrePermiso' => $permiso->nombrePermiso, 'crear' => $permiso->crear,'leer' => $permiso->leer,'actualizar' => $permiso->actualizar,'borrar' => $permiso->borrar,);            
            }            
        } else {
            $arrayPermisos = array();
        }
        return $arrayPermisos;
    }
   
    public function zonasPV($idPuntoVenta){
        
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
    public function getMesasActivas($idZona){

        $respuesta = $this->realizarPeticion('GET', $this->urlMesas."GetMesasPorZonaActivas/{$idZona}");

        return  $respuesta;
    }
    public function obtenerCategoriasCarta($idCarta){
        
        $urlBase= $this->urlCategoria;
        
        $respuesta = $this->realizarPeticion('GET', $urlBase."GetCategoriabyCarta/{$idCarta}");        

        $datos = json_decode($respuesta);

        $categorias = $datos->objeto;

        return $categorias; 

    }

    public function obtenerDatosHuesped($codhotel, $room){
        //es una funcion que esta en el controller principal        
        $respuesta = $this->realizarPeticion('GET', $this->urlVenta."GetHuesped/{$codhotel}/{$room}");
        // $respuesta = json_encode($respuesta);
        return $respuesta;
    }
    
    static public function obtenerMesasPorZona($idZona){
        $metodo="GET";        
        $urlBase= "http://172.16.1.45/TPVApi/Mesas/GetMesasPorZonaActivas/{$idZona}";
        
        $cliente =  new Client();                
        $respuesta = $cliente->request($metodo, $urlBase);
        $respuesta = $respuesta->getBody()->getContents();
        $respuesta = json_decode($respuesta);
        $ok = $respuesta->ok;
        if($ok){
            $mesas = $respuesta->objeto;
        }else {
            $mesas = "";
        }
                
        return  $mesas;
    }
  
    public function getProductosByCat(Request $request){
        $idCarta = $request->session()->get('idCarta');
        $idCategoria = $request->get('idCategoria');

        $respuesta = $this->realizarPeticion('GET', $this->urlMenuCarta."GetProductosMenuCarta/{$idCarta}/{$idCategoria}");
        
        return $respuesta;        
    }

    public function getProductosFavoritos(Request $request){
        
        $idPV = $request->get('idPuntoVenta');
        $idCarta = $request->get('idCarta');

        $respuesta = $this->realizarPeticion('GET', $this->urlMenuCarta."GetProductosMenuCartaFav/{$idCarta}/{$idPV}");

        return $respuesta;
    }

    public function guardarCuenta(Request $request){

        $idMesa = $request->get('idMesa');//obtengo el id de la mesa del modal
        $idUsuario = $request->session()->get('idUsuarioLogueado'); //obtengo el id de usuario logueado
        $reserva = $request->get( 'reserva');
        $habitacion = $request->get('habitacion');
        $nombreCliente = $request->get('nombreCliente');
        $pax = $request->get('pax');
        $brazalete = $request->get('brazalete');

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
                'brazalete'=> $brazalete,
                'idPuntoVenta' => $idPuntoVenta,
                'TPV_AlergenosCuenta' => 
                    $arrayAlergenos                                
            ]
        ]);
        return $respuesta;
    }
    public function updateCuentaRoom(Request $request,$idCuenta){

        $reserva = $request->get('reserva');
        $habitacion = $request->get('habitacion');
        $nombreCliente = $request->get('nombre');
        $pax = $request->get('pax');
        $brazalete = $request->get('brazalete');

        $respuesta = $this->realizarPeticion('POST', $this->urlVenta."UpdateCuenta/{$idCuenta}", [
            'form_params' => [
                'reserva' => $reserva,
                'habitacion' => $habitacion,
                'nombreCliente' => $nombreCliente,
                'pax' => $pax,
                'brazalete' => $brazalete,
            ]
        ]);
        
        return $respuesta;
    }
    public function updateCuentaMesa(Request $request){

        $idPV = $request->get('idPV');
        $idCuenta = $request->get('idCuenta');
        $idMesaNueva = $request->get('idMesaNueva');
        
        $respuesta = $this->realizarPeticion('POST', $this->urlVenta."UpdateMesa/{$idPV}/{$idCuenta}/{$idMesaNueva}");

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

        $urlCerrarDia =$this->urlAdmin;

        $idUsuario = $request->session()->get('idUsuarioLogueado');
        $fecha = Carbon::now()->format('Y-m-d');
        $idCarta = $request->session()->get('idCarta');

        $respuesta = $this->realizarPeticion('POST', $urlCerrarDia."cierreDia/{$idPV}/{$fecha}/{$idUsuario}/{$idCarta}");

        return $respuesta;

        
    }
    public function addCuentaAlergiaPax(Request $request){

        $idCuenta = $request->get('idCuenta');
        $paxConAlergia = $request->get('paxConAlergia');
       
        $respuesta = $this->realizarPeticion('POST', $this->urlVenta."CuentaAlergia/{$idCuenta}/{$paxConAlergia}");

        return $respuesta;
    }
}
// 172.16.1.45 
