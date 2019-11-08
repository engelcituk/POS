<?php

namespace App\Exports;

use GuzzleHttp\Client;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Http\Controllers\RestaurantesController;


class HistoricosExport  implements FromView, ShouldAutoSize 
{
    use Exportable;  
    /**
    * @return \Illuminate\Support\Collection
    
    */
    // 
    
    public $idPV;
    public $idUsuario;
    public $idCarta;
    public $fecha;
    public $nombrePV;


    public function __construct(Request $request, $fecha)
    {        
        $this->idPV = $request->session()->get('idPuntoVenta');;
        $this->idUsuario = $request->session()->get('idUsuarioLogueado');;
        $this->idCarta = $request->session()->get('idCarta');

        $this->fecha = $fecha;
               
        $datosRestaurantePV = app('App\Http\Controllers\RestaurantesController')->obtenerUnRestaurante($this->idPV);

        $this->nombrePV = $datosRestaurantePV->name;

    }

    public function view(): View {
        $idPV= $this->idPV;
        $idUsuario= $this->idUsuario;
        $idCarta = $this->idCarta;
        $fecha = $this->fecha;
        $pv= $this->nombrePV;
        
        $objeto = $this->obtenerDatos($idPV, $idUsuario, $idCarta, $fecha);

        $totalAdultos = $objeto->totalAdultos;
        $totalCuentas = $objeto->totalCuentas;
        $totalNinos = $objeto->totalNinos;
        $totalPax = $objeto->totalPax;

        $productos = $objeto->productos;
       
        return view('historico.excel', compact('fecha', 'pv','totalAdultos', 'totalCuentas', 'totalNinos', 'totalPax', 'productos'));

    }

    public function obtenerDatos($idPV, $idUsuario,$idCarta, $fecha) {
        
        $metodo = "POST";
        $urlBase = "http://localhost/TPVApi/Admin/getcierreDia/{$idPV}/{$fecha}/{$idUsuario}/{$idCarta}";

        $cliente =  new Client();
        $respuesta = $cliente->request($metodo, $urlBase);
        $respuesta = $respuesta->getBody()->getContents();
        $respuesta = json_decode($respuesta);
        $objeto = $respuesta->objeto;
        
        return  $objeto;
    }
}
