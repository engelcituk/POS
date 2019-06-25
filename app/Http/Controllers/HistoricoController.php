<?php

namespace App\Http\Controllers;


use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;


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
    public function index()
    {
        return view('historico');
    }
    public function AllHistorico(){
        $historico = $this->obtenerHistorico();

        $acciones = 'historico.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($historico)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    public function obtenerHistorico(){
        //es una funcion que esta en el controller principal
        $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetProducto');

        $datos = json_decode($respuesta);

        $historico = $datos->objeto;

        return $historico;
    }
}
 