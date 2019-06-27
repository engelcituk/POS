<?php

namespace App\Http\Controllers;


use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HistoricoController extends Controller
{
    public $urlBase = "http://localhost/TPVApi/Producto/";
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
        
        $fechaHoy = Carbon::now()->toDateString();  //solo fecha sin hora     

        return view('historico', compact('fechaHoy'));
    }
    public function AllHistorico(){
        // $idPV = $request->session()->get('idPuntoVenta');
        $historico = $this->obtenerHistorico();

        $acciones = 'historico.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($historico)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    public function obtenerHistorico(){
        //es una funcion que esta en el controller principal
        $urlBase= "http://172.16.4.229/TPVApi/historico/";
                        
        $respuesta = $this->realizarPeticion('GET', $urlBase."getCuentas");

        $datos = json_decode($respuesta);

        $historico = $datos->objeto;

        return $historico;
    }
    public function obtenerHistoricoFechas(Request $request){
        //es una funcion que esta en el controller principal
        $urlBase = "http://172.16.4.229/TPVApi/historico/";

        $idPV = $request->session()->get('idPuntoVenta'); 
        $fechaInicial = $request->get('fechaInicial');        
        $fechaFinal = $request->get('fechaFinal');

        $fechaInicialF = date("d-m-Y", strtotime($fechaInicial));
        $fechaFinalF = date("d-m-Y", strtotime($fechaFinal));

        $respuesta = $this->realizarPeticion('GET', $urlBase."getCuentas/{$idPV}/{$fechaInicialF}/{$fechaFinalF}");

        $datos = json_decode($respuesta);

        $historico = $datos->objeto;

        return $historico;
    }
}
 