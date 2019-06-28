<?php

namespace App\Http\Controllers;


use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HistoricoController extends Controller
{
    public $urlBase = "http://localhost/TPVApi/Historico/";
    public function __construct()
    {
        // $this->middleware('auth');
    }
 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){ 
        
        $fechaHoy = Carbon::now()->toDateString();  //solo fecha sin hora  addDays(1)
        $fechaManiana= Carbon::now()->addDays(1)->toDateString();
             
        $fechaHoyDMY = Carbon::now()->format('d-m-Y'); //fecha sin hora formato DMY 
        
        return view('historico', compact('fechaHoy', 'fechaManiana'));
    }
    public function AllHistorico(Request $request){
        
        $idPV = $request->session()->get('idPuntoVenta');    
     
        $inicio= $request->get('inicio');
        $final= $request->get('final');

        if ($inicio && $final) {
            $historico = $this->obtenerHistorico($idPV, $inicio,  $final);
        }                      
        $acciones = 'historico.datatables.botones';
        return Datatables::of($historico)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); 
    }
    public function obtenerHistorico($idPV, $fechaInicialFiltro, $fechaFinalFiltro){
                              
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetCuentas/{$idPV}/{$fechaInicialFiltro}/{$fechaFinalFiltro}");

        $datos = json_decode($respuesta);

        $historico = $datos->objeto;

        return $historico;
    }
   
   
}
  //es una funcion que esta en el controller principal
        // $urlBase= "http://172.16.4.229/TPVApi/historico/"; 
