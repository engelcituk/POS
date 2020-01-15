<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class CartaController extends Controller
{
    
    public $urlBase = "";
    public $idHotel;

    public function __construct()
    {

        $this->middleware('accesoCartasFiltro');
        $this->urlBase = $this->urlApiTPV()."Cartas/";
        $this->middleware(function ($request, $next) { //obtengo el valor de la session idHotel            
            $this->idHotel = session()->get('idHotel');
            return $next($request);
        });

    }
    public function index()
    {
        $cartas = $this->obtenerTodosLasCartas($this->idHotel);
        // dd($cartas);
        return view('cartas',compact('cartas'));
    }
    public function AllCartas()
    {
        $cartas = $this->obtenerTodosLasCartas($this->idHotel);

        $acciones = 'cartas.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($cartas)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    public function obtenerTodosLasCartas($idHotel){
        if($idHotel == null){
            //es una funcion que esta en el controller principal        
            $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetCartas');                                    
        } else {
            $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetCartasByHotel/{$idHotel}");
        }
        
        $datos = json_decode($respuesta);

        $cartas = $datos->objeto;

        return $cartas;
    }
    
    public function create(){

        $fechaAlta= Carbon::now();//ocupo carbon para obtener fecha actual
        $horaAlta = $fechaAlta->toTimeString(); //obtengo la hora de la fecha

        $restaurantes = \App::call('App\Http\Controllers\RestaurantesController@obtenerTodosLosRestaurantes');
        $turnos = \App::call( 'App\Http\Controllers\TurnosController@obtenerTodosLosTurnos');


        return view('cartas.partials.create',compact('fechaAlta', 'horaAlta','restaurantes','turnos'));
    }
    public function show( $idCarta){       

        $carta = $this->obtenerUnaCarta($idCarta);

        $idPuntoVenta = $carta->idPuntoVenta;
        $datosPV = new RestaurantesController();
        $datosPV = $datosPV->obtenerUnRestaurante($idPuntoVenta);

        $idTurno = $carta->idTurno;
        $datosTurno = new TurnosController();
        $datosTurno = $datosTurno->obtenerUnTurno($idTurno);

        $idhotel = $datosPV->idHotel;     
        $datosHotel = new HotelesController();
        $datosHotel = $datosHotel->obtenerUnHotel($idhotel);
        
        return view('cartas.partials.show', compact('carta','datosPV', 'datosTurno', 'datosHotel'));
    }
    public function edit($id){
        $idCarta = $id;
        $carta = $this->obtenerUnaCarta($idCarta);

        $idTurno = $carta->idTurno;
        $datosTurno = new TurnosController();
        $datosTurno = $datosTurno->obtenerUnTurno($idTurno);

        $idPuntoVenta = $carta->idPuntoVenta;
        $datosPV = new RestaurantesController();
        $datosPV = $datosPV->obtenerUnRestaurante($idPuntoVenta);

        $restaurantes = \App::call('App\Http\Controllers\RestaurantesController@obtenerTodosLosRestaurantes');
        $turnos = \App::call('App\Http\Controllers\TurnosController@obtenerTodosLosTurnos');


        return view('cartas.partials.edit', compact('carta', 'datosPV','datosTurno', 'restaurantes', 'turnos'));       
    }
   
    public function obtenerUnaCarta($idCarta)
    {
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetCarta/{$idCarta}");
        $datos = json_decode($respuesta);
        $carta = $datos->objeto;
        return $carta;
    }
    public function actualizar(Request $request)
    {
        $idCarta = $request->get('id');

        $respuesta = $this->realizarPeticion('POST', $this->urlBase."UpdateCarta/{$idCarta}", ['form_params' => $request->except('id')]);

        return redirect('/cartas');
    }
    
    public function store(Request $request)
    {
        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'AddCarta', ['form_params' => $request->all()]);

        return redirect('/cartas');
    }
   
    public function destroy($id)
    {
        $idCarta = $id;
        $respuesta = $this->realizarPeticion('POST', $this->urlBase . "DeleteCarta/{$idCarta}");

        return redirect('/cartas');
    }
}
