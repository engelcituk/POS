<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class CartaController extends Controller
{
    
    public $urlBase = "http://localhost/TPVApi/Cartas/";
    public function index()
    {
        return view('cartas');
    }
    public function AllCartas()
    {
        $cartas = $this->obtenerTodosLasCartas();

        $acciones = 'cartas.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($cartas)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    protected function obtenerTodosLasCartas()
    {
        //es una funcion que esta en el controller principal        
        $respuesta = $this->realizarPeticion('GET', $this->urlBase . 'GetCartas');

        $datos = json_decode($respuesta);

        $cartas = $datos->objeto;

        return $cartas;
    }
    
    public function create() 
    {
        $fechaAlta= Carbon::now();//ocupo carbon para obtener fecha actual
        $horaAlta = $fechaAlta->toTimeString(); //obtengo la hora de la fecha

        $restaurantes = \App::call('App\Http\Controllers\RestaurantesController@obtenerTodosLosRestaurantes');
        $turnos = \App::call( 'App\Http\Controllers\TurnosController@obtenerTodosLosTurnos');


        return view('cartas.partials.create',compact('fechaAlta', 'horaAlta','restaurantes','turnos'));
    }
    public function show($id)
    {
        $idCarta = $id;
        $carta = $this->obtenerUnaCarta($idCarta);

        $idTurno = $carta->idTurno;
        $datosTurno = new TurnosController();
        $datosTurnoPV = $datosTurno->obtenerUnTurno($idTurno);

        $idPuntoVenta = $datosTurnoPV->idPuntoVenta; //obtengo el idRestaurante del turno
        $datosPuntoVenta = new RestaurantesController(); //para obtener los datos del restaurante
        $datosRestaurantePV = $datosPuntoVenta->obtenerUnRestaurante($idPuntoVenta); //los datos lo envio a la vista

        $idHotel = $datosRestaurantePV->idHotel;
        $datosHotel = new HotelesController();
        $hotelRestaurante = $datosHotel->obtenerUnHotel($idHotel);
        
        return view('cartas.partials.show', ['carta' => $carta, 'datosTurnoPV'=> $datosTurnoPV, 'datosRestaurantePV'=>$datosRestaurantePV, 'hotelRestaurante'=> $hotelRestaurante]);
    }
    public function edit($id){
        $idCarta = $id;
        $carta = $this->obtenerUnaCarta($idCarta);

        $idTurno = $carta->idTurno;
        $datosTurno = new TurnosController();
        $datosTurnoPV = $datosTurno->obtenerUnTurno($idTurno);

        $restaurantes = \App::call('App\Http\Controllers\RestaurantesController@obtenerTodosLosRestaurantes');
        $turnos = \App::call('App\Http\Controllers\TurnosController@obtenerTodosLosTurnos');


        return view('cartas.partials.edit', compact('carta', 'datosTurnoPV', 'restaurantes', 'turnos'));       
    }
   
    public function obtenerUnaCarta($idCarta)
    {
        $respuesta = $this->realizarPeticion('GET', $this->urlBase . "GetCarta/{$idCarta}");
        $datos = json_decode($respuesta);
        $carta = $datos->objeto;
        return $carta;
    }
    public function actualizar(Request $request)
    {
        $idCarta = $request->get('id');

        $respuesta = $this->realizarPeticion('PUT', $this->urlBase."UpdateCarta/{$idCarta}", ['form_params' => $request->except('id')]);

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
        $respuesta = $this->realizarPeticion('DELETE', $this->urlBase . "DeleteCarta/{$idCarta}");

        return redirect('/cartas');
    }
}
