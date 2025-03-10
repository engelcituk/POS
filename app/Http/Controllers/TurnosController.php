<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TurnosController extends Controller
{
    
    public $urlBase = "";
    public $idHotel; 

    public function __construct(){

        $this->middleware('accesoTurnosFiltro');
        $this->urlBase = $this->urlApiTPV()."Turnos/";
        $this->middleware(function ($request, $next) { //obtengo el valor de la session idHotel            
            $this->idHotel = session()->get('idHotel');
            return $next($request);
        });
        
    }

    public function index()
    {
        $turnos = $this->obtenerTodosLosTurnos($this->idHotel);

        return view('turnospv', compact('turnos'));
    }
    public function AllTurnos()
    {
        $turnos = $this->obtenerTodosLosTurnos($this->idHotel);

        $acciones = 'turnospv.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($turnos)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    public function obtenerTodosLosTurnos($idHotel)
    {
        if($idHotel == null){               
            //es una funcion que esta en el controller principal        
            $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetTurnos');         
        } else {
            $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetTurnosByHotel/{$idHotel}");
        }                
        $datos = json_decode($respuesta);

        $turnos = $datos->objeto;

        return $turnos;
    }

    public function create()
    {
        $idHotel = $this->idHotel;

        $hoteles = new HotelesController();
        $hoteles = $hoteles->obtenerTodosLosHoteles($idHotel);
        
        $restaurantes = new RestaurantesController();
        $restaurantes = $restaurantes->obtenerTodosLosRestaurantes($idHotel);

        // $hoteles = \App::call('App\Http\Controllers\HotelesController@obtenerTodosLosHoteles');
        // $restaurantes = \App::call('App\Http\Controllers\RestaurantesController@obtenerTodosLosRestaurantes');

        return view('turnospv.partials.create', ['hoteles' => $hoteles, 'restaurantes' => $restaurantes]);        
    }

    
    public function show($idTurno){
        $turno = $this->obtenerUnTurno($idTurno);
        
        return view('turnospv.partials.show', ['turno' => $turno]);
    }

    
    public function edit($id)
    {
        $idTurno = $id;
        $turno = $this->obtenerUnTurno($idTurno);
        
        return view('turnospv.partials.edit',[ 'turno'=> $turno]);
    }

    
    public function obtenerUnTurno($idTurno)
    {
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetTurno/{$idTurno}");
        $datos = json_decode($respuesta);
        $zona = $datos->objeto;
        return $zona;
    }
    public function actualizar(Request $request)
    {
        $idTurno = $request->get('id');        

        $respuesta = $this->realizarPeticion('POST', $this->urlBase."UpdateTurno/{$idTurno}",['form_params' => $request->except('id')]);

        return redirect('/turnos');
    }
    
    public function store(Request $request)
    {
        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'AddTurno', ['form_params' => $request->all()]);

        return redirect('/turnos');
    }
        
    public function destroy($id)
    {
        $idTurno = $id;
        $respuesta = $this->realizarPeticion('POST', $this->urlBase . "DeleteTurno/{$idTurno}");
        
        return $respuesta;
    }
}
 