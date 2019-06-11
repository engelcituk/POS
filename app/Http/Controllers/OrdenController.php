<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
class OrdenController extends Controller
{
    public $urlBase = "http://localhost/TPVApi/Zonas/";
    public $urlBase2 = "http://localhost/TPVApi/Mesas/GetMesaPorZona/";
    public function __construct(){
        // $this->middleware('auth');
    }
    public function index(){
        $idPuntoVenta = 23;
        $respuesta = $this->obtenerTodasLasZonasPV($idPuntoVenta);
        // $respuesta = json_decode($respuesta);
        $zonas = $respuesta->objeto;
                
        // dd($zonas);
        return view('ordenar', compact('zonas'));
    }
   
    public function obtenerTodasLasZonasPV($idPuntoVenta){
        //es una funcion que esta en el controller principal        
        $respuesta = $this->realizarPeticion('GET', $this->urlBase . "GetZonaPV/{$idPuntoVenta}");

        $respuesta= json_decode($respuesta);        

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
