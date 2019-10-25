<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ZonasController extends Controller
{
    public $urlBase = "http://172.16.4.229/TPVApi/Zonas/"; 
    
    public function __construct()
    {
        $this->middleware('accesoZonasFiltro');
    }
    
    public function index()
    {
        $zonas = $this->obtenerTodasLasZonas();
        return view('zonas',compact('zonas'));
    }

    public function AllZonas()
    {
        $zonas = $this->obtenerTodasLasZonas();

        $acciones = 'zonas.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($zonas)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    public function obtenerTodasLasZonas()
    {
        //es una funcion que esta en el controller principal
        $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetZonas');

        $datos = json_decode($respuesta);

        $zonas = $datos->objeto;

        return $zonas;
    }
    protected function create()
    {
        $hoteles =\App::call('App\Http\Controllers\HotelesController@obtenerTodosLosHoteles');
        $restaurantes = \App::call( 'App\Http\Controllers\RestaurantesController@obtenerTodosLosRestaurantes');
        // $idHotel = $hotel->id;  
        return view('zonas.partials.create',['hoteles' => $hoteles, 'restaurantes'=>$restaurantes]);
        
    }
    public function show($id)
    {        
        $idZona = $id;
        $zona = $this->obtenerUnaZona($idZona);
        //para obtener el nombre del restaurante al que corresponde la zona

        $idPuntoVenta = $zona->idPuntoVenta;//obtengo el idRestaurante de la zona 
        $datosPuntoVenta= new RestaurantesController();//para obtener los datos del restaurante
        $datosRestaurantePV = $datosPuntoVenta->obtenerUnRestaurante($idPuntoVenta); //los datos lo envio a la vista

        $idHotel = $datosRestaurantePV->idHotel;
        $datosHotel = new HotelesController();
        $hotelRestaurante = $datosHotel->obtenerUnHotel($idHotel);

        return view('zonas.partials.show', ['zona' => $zona, 'datosRestaurantePV'=> $datosRestaurantePV, 'hotelRestaurante' => $hotelRestaurante]);
    }
    public function edit($id)
    {
        $idZona = $id;
        $zona = $this->obtenerUnaZona($idZona);
        //para obtener el nombre del restaurante al que corresponde la zona        
        $idPuntoVenta = $zona->idPuntoVenta; //obtengo el idRestaurante de la zona 

        $datosPuntoVenta = new RestaurantesController(); //para obtener los datos del restaurante
        $datosRestaurantePV = $datosPuntoVenta->obtenerUnRestaurante($idPuntoVenta); //los datos lo envio a la vista

        $hoteles = \App::call('App\Http\Controllers\HotelesController@obtenerTodosLosHoteles');
        $restaurantes = \App::call('App\Http\Controllers\RestaurantesController@obtenerTodosLosRestaurantes');

        return view('zonas.partials.edit', ['zona' => $zona, 'datosRestaurantePV' => $datosRestaurantePV, 'hoteles' => $hoteles, 'restaurantes' => $restaurantes]);
    }
    
    public function store(Request $request)
    {
        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'AddZona', ['form_params' => $request->all()]);
// dd($respuesta);
        return redirect('/zonas');
    }
    public function obtenerUnaZona($idZona)
    {
        $respuesta = $this->realizarPeticion('GET', $this->urlBase . "GetZona/{$idZona}");
        $datos = json_decode($respuesta);
        $zona = $datos->objeto;
        return $zona;
    }
    public function actualizar(Request $request){
        $idZona = $request->get('id');

        $respuesta = $this->realizarPeticion('POST', $this->urlBase."UpdateZona/{$idZona}", ['form_params' => $request->except('id')]);
        return redirect('/zonas');
    }
    public function destroy($idZona){         

        $respuesta = $this->realizarPeticion('POST', $this->urlBase."DeleteZona/{$idZona}");
        return redirect('/zonas');
    }
    
}
