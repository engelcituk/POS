<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
class OrdenController extends Controller
{
    public $urlBase = "http://localhost/TPVApi/Zonas/";
    public $urlHuesped= "http://localhost/TPVApi/Venta/"; //para obtener los datos del huesped para la venta
    public function __construct(){
        // $this->middleware('auth');
    }
    public function index(){
        $idPuntoVenta = 23;
        $respuesta = $this->obtenerTodasLasZonasPV($idPuntoVenta);
        // $respuesta = json_decode($respuesta);
        $zonas = $respuesta->objeto;
        $alergenos = \App::call('App\Http\Controllers\AlergenoController@obtenerTodosLosAlergenos');
                
        // dd($zonas);
        return view('ordenar', compact('zonas','alergenos'));
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
    
}
