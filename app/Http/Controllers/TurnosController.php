<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TurnosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $urlBase = "http://localhost/TPVApi/Turnos/";
    public function index()
    {
        return view('turnospv');
    }
    public function AllTurnos()
    {
        $turnos = $this->obtenerTodosLosTurnos();

        $acciones = 'turnospv.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($turnos)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    public function obtenerTodosLosTurnos()
    {
        //es una funcion que esta en el controller principal        
        $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetTurnos');

        $datos = json_decode($respuesta);

        $turnos = $datos->objeto;

        return $turnos;
    }

    public function create()
    {
        $hoteles = \App::call('App\Http\Controllers\HotelesController@obtenerTodosLosHoteles');
        $restaurantes = \App::call('App\Http\Controllers\RestaurantesController@obtenerTodosLosRestaurantes');

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

        $respuesta = $this->realizarPeticion('POST', $this->urlBase."UpdateTurno/{$idTurno}", ['form_params' => $request->except('id')]);

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
        
        return redirect('/turnos');
    }
}
 