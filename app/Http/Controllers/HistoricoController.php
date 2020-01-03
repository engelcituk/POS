<?php

namespace App\Http\Controllers;


use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use App\Exports\HistoricosExport;
use Maatwebsite\Excel\Facades\Excel;


class HistoricoController extends Controller
{
    public $urlBase = "";
    public $urlCuenta = "";
    public $urlAdmin = "";

    public function __construct()
    {
        $this->middleware('accesoHistoricoFiltro');
        // inicializo endpoints api requeridos
        $this->urlBase = $this->urlApiTPV()."Historico/";
        $this->urlCuenta = $this->urlApiTPV() ."Venta/";        
        $this->urlAdmin = $this->urlApiTPV()."Admin/";        


    }     
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
    public function cierreDiaDetalle(Request $request){
        //varaibles de sesión
        $idPV = $request->session()->get('idPuntoVenta');
        $idUsuario = $request->session()->get('idUsuarioLogueado');
        $idCarta = $request->session()->get('idCarta');
        //recibido desde ajax
        $fecha = $request->get('fecha');

        $respuesta = $this->realizarPeticion('POST', $this->urlAdmin."getcierreDia/{$idPV}/{$fecha}/{$idUsuario}/{$idCarta}");
                
        return $respuesta;
    }
    public function generaPdf(Request $request){
        //varaibles de sesión
        $idPV = $request->session()->get('idPuntoVenta');
        $idUsuario = $request->session()->get('idUsuarioLogueado');
        $idCarta = $request->session()->get('idCarta');
        //recibido desde ajax
        $fecha = $request->get('fechaPDF');

        $respuesta = $this->realizarPeticion('POST', $this->urlAdmin."getcierreDia/{$idPV}/{$fecha}/{$idUsuario}/{$idCarta}");
        $respuesta = json_decode($respuesta);

        $objeto = $respuesta->objeto;

        $totalAdultos = $objeto->totalAdultos;
        $totalCuentas = $objeto->totalCuentas;
        $totalNinos = $objeto->totalNinos;
        $totalPax = $objeto->totalPax;

        $cuentas = $objeto->cuentas;
        $productos = $objeto->productos;
    
        $pdf = PDF::loadView('historico.pdf', compact('totalAdultos', 'totalCuentas', 'totalNinos', 'totalPax', 'cuentas', 'productos'));

        return $pdf->download('lista-informe.pdf');
    }
    //genero un excel llamando a la clase HistoricosExport dentro de  Exports/HistoricosExport.php
    public function generaExcel(Request $request,$fecha){
                
        return Excel::download(new HistoricosExport($request,$fecha), 'lista.xlsx');
        
    }

    public function obtenerCuenta($idCuenta){

        $respuesta = $this->realizarPeticion('GET', $this->urlCuenta."GetCuenta/{$idCuenta}");
        return $respuesta;
    }

    public function obtenerDetalleCuenta($idCuenta){

        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetDetalleCuenta/{$idCuenta}");                
        return $respuesta;
    }
    public function imprimirCuenta($idCuenta){
               
        $respuesta = $this->realizarPeticion('POST', $this->urlAdmin."imprimeCuenta/{$idCuenta}"); 
                      
        return $respuesta;                
        
    }
    // esta funcinon imprime una cuenta pero en este se muestra el listado de costo de esta cuenta
    public function imprimirCuentaHistorico($idCuenta){
               
        $respuesta = $this->realizarPeticion('POST', $this->urlAdmin."imprimeCuentaHistorico/{$idCuenta}"); 
        
        return $respuesta;        
    }
    public function cancelarCuenta(Request $request, $idCuenta){
        
        $idUsuario = $request->session()->get('idUsuarioLogueado');
        $motivo = $request->get('motivo');
        
        $respuesta = $this->realizarPeticion('POST', $this->urlAdmin .'cancelaCuenta', [
            'form_params' => [
                'idc' => $idCuenta,
                'idu' => $idUsuario,
                'motivo' => $motivo                
            ]
        ]);
        return $respuesta;
        
    }
    public function imprimirDesgloseHistorico(Request $request){

        $urlCerrarDia = $this->urlAdmin;

        $idPV = $request->session()->get('idPuntoVenta');
        $fecha = $request->get('fecha');        
        $idUsuario = $request->session()->get('idUsuarioLogueado');
        $idCarta = $request->session()->get('idCarta');
                                                    //Admin/cierreDia
        $respuesta = $this->realizarPeticion('POST', $urlCerrarDia."cierreDia/{$idPV}/{$fecha}/{$idUsuario}/{$idCarta}");

        return $respuesta;
    }
}
//es una funcion que esta en el controller principal
// $urlBase= "http://localhost/TPVApi/historico/"; 
//http://localhost/TPVApi/admin/imprimeCuenta/127
