<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MesasController extends Controller
{
    
    public $urlBase = ""; 

    public function __construct()
    {
        $this->middleware('accesoMesasFiltro');
        $this->urlBase = $this->urlApiTPV()."Mesas/";

    }
    
    public function index()
    {
        $mesas = $this->obtenerTodosLasMesas();

        return view('mesas',compact('mesas'));
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
        $idMesa = $id;
        $mesa = $this->obtenerUnaMesa($idMesa);

        $idZona =$mesa->idZona;
        $datosZona = new ZonasController(); //para obtener los datos de la zona
        $datosZonaMesa = $datosZona->obtenerUnaZona($idZona); //los datos de la zona lo envio a la vista

        $idPuntoVenta = $datosZonaMesa->idPuntoVenta; //obtengo el idRestaurante de la zona 
        $datosPuntoVenta = new RestaurantesController(); //para obtener los datos del restaurante
        $datosRestaurantePV = $datosPuntoVenta->obtenerUnRestaurante($idPuntoVenta); //los datos lo envio a la vista

        $idHotel = $datosRestaurantePV->idHotel;
        $datosHotel = new HotelesController();
        $hotelRestaurante = $datosHotel->obtenerUnHotel($idHotel);

        return view('mesas.partials.show', ['mesa' => $mesa, 'datosZonaMesa'=>$datosZonaMesa, 'datosRestaurantePV'=>$datosRestaurantePV, 'hotelRestaurante'=> $hotelRestaurante]);
    }
    public function edit($id){

        $idMesa = $id;
        $mesa = $this->obtenerUnaMesa($idMesa);//obtengo los datos de la mesa

        $idZona = $mesa->idZona; //obtengo el idZona de la mesa que ocupo para obtener los datos de la zona
        
        $datosZona = new ZonasController(); //para obtener los datos de la zona
        $datosZonaMesa = $datosZona->obtenerUnaZona($idZona); //los datos de la zona lo envio a la vista
        
        $restaurantes = \App::call('App\Http\Controllers\RestaurantesController@obtenerTodosLosRestaurantes');
        $zonas = \App::call('App\Http\Controllers\ZonasController@obtenerTodasLasZonas');
        // dd($restaurantes);

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

        $respuesta = $this->realizarPeticion('POST', $this->urlBase . "UpdateMesa/{$idMesa}", ['form_params' => $request->except('id')]);
        return redirect('/mesas');
    }
    //metodo para borrar mesas
    public function destroy($id)
    {
        $idMesa = $id;
        $respuesta = $this->realizarPeticion('POST', $this->urlBase."DeleteMesa/{$idMesa}");
        return redirect('/mesas');
    }
}
 