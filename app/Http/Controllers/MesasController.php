<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MesasController extends Controller
{
    // 
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public $urlBase = "http://localhost/TPVApi/Mesas/"; 
    public function index()
    {       
        
        return view('mesas');
    }

    public function AllMesas()
    {
        $mesas = $this->obtenerTodosLasMesas();

        $acciones = 'mesas.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($mesas)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    protected function obtenerTodosLasMesas()
    {
        //es una funcion que esta en el controller principal
        $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetMesas');
       
        $datos = json_decode($respuesta);

        $mesas = $datos->objeto;

        return $mesas;       
    }
    protected function create()
    {        
        $restaurantes = \App::call('App\Http\Controllers\RestaurantesController@obtenerTodosLosRestaurantes');
        $zonas = \App::call('App\Http\Controllers\ZonasController@obtenerTodasLasZonas');
          
        return view('mesas.partials.create', ['restaurantes' => $restaurantes, 'zonas' => $zonas]);        
    }
    public function show($id)
    {
        $mesa = $id;

        return view('mesas.partials.show', ['mesa' => $mesa]);
    }
    public function edit($id){

        $idMesa = $id;
        $mesa = $this->obtenerUnaMesa($idMesa);//obtengo los datos de la mesa

        $idZona = $mesa->idZona; //obtengo el idZona de la mesa que ocupo para obtener los datos de la zona

        $datosZona = new ZonasController(); //para obtener los datos de la zona
        $datosZonaMesa = $datosZona->obtenerUnaZona($idZona); //los datos de la zona lo envio a la vista

        $restaurantes = \App::call('App\Http\Controllers\RestaurantesController@obtenerTodosLosRestaurantes');
        $zonas = \App::call('App\Http\Controllers\ZonasController@obtenerTodasLasZonas');

        return view('mesas.partials.edit', ['mesa'=> $mesa,'datosZonaMesa'=>$datosZonaMesa, 'restaurantes' => $restaurantes, 'zonas' => $zonas]); 
        
    }
    public function store(Request $request)
    {
        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'AddMesa', ['form_params' => $request->all()]);

        return redirect('/mesas');
    }
    public function obtenerUnaMesa($idMesa)
    {
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetMesa/{$idMesa}");
        $datos = json_decode($respuesta);
        $mesa = $datos->objeto;
        return $mesa;
    }
    public function actualizar(Request $request)
    {
        $idMesa = $request->get('id');

        $respuesta = $this->realizarPeticion('PUT', $this->urlBase . "UpdateMesa/{$idMesa}", ['form_params' => $request->except('id')]);
        return redirect('/mesas');
    }
    //metodo para borrar mesas
    public function destroy($id)
    {
        $idMesa = $id;
        $respuesta = $this->realizarPeticion('DELETE', $this->urlBase."DeleteMesa/{$idMesa}");
        return redirect('/mesas');
    }
}
 