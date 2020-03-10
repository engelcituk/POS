<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CentrosProdController extends Controller
{
    public $urlBase = "";
    public $idHotel; 

    public function __construct()
    {
        $this->middleware('accesoZonasFiltro');
        $this->urlBase = $this->urlApiTPV() . "Zonas/";
        $this->middleware(function ($request, $next) { //obtengo el valor de la session idHotel            
            $this->idHotel = session()->get('idHotel');
            return $next($request);
        });
    }
    
    public function index()
    {
        $centrosProd = $this->obtenerTodosLosCentrosProd($this->idHotel);
        
        return view('centrosProd', compact('centrosProd'));
        
    }
    public function obtenerTodosLosCentrosProd($idHotel)
    {
        if ($idHotel == null) {
            //realizarPeticiones una funcion que esta en el controller principal
            $respuesta = $this->realizarPeticion('GET', $this->urlBase . 'GetZonas');
        } else {
            $respuesta = $this->realizarPeticion('GET', $this->urlBase . "GetZonasByHotel/{$idHotel}");
        }

        $datos = json_decode($respuesta);

        $centrosProd = $datos->objeto;

        return $centrosProd;
    }

    protected function create()
    {
        $idHotel = $this->idHotel;

        $hoteles = \App::call('App\Http\Controllers\HotelesController@obtenerTodosLosHoteles');

        $restaurantes = new RestaurantesController();
        $restaurantes = $restaurantes->obtenerTodosLosRestaurantes($idHotel);

        //$restaurantes = \App::call( 'App\Http\Controllers\RestaurantesController@obtenerTodosLosRestaurantes');
        // $idHotel = $hotel->id;  
        return view('centrosProd.create', ['hoteles' => $hoteles, 'restaurantes' => $restaurantes]);
    }
    public function show($id)
    {
        $idZona = $id;
        $zona = $this->obtenerUnaZona($idZona);
        //para obtener el nombre del restaurante al que corresponde la zona

        $idPuntoVenta = $zona->idPuntoVenta; //obtengo el idRestaurante de la zona 
        $datosPuntoVenta = new RestaurantesController(); //para obtener los datos del restaurante
        $datosRestaurantePV = $datosPuntoVenta->obtenerUnRestaurante($idPuntoVenta); //los datos lo envio a la vista

        $idHotel = $datosRestaurantePV->idHotel;
        $datosHotel = new HotelesController();
        $hotelRestaurante = $datosHotel->obtenerUnHotel($idHotel);

        return view('centrosProd.show', ['zona' => $zona, 'datosRestaurantePV' => $datosRestaurantePV, 'hotelRestaurante' => $hotelRestaurante]);
    }
    public function edit($id)
    {
        $idHotel = $this->idHotel;

        $idZona = $id;
        $zona = $this->obtenerUnaZona($idZona);
        //para obtener el nombre del restaurante al que corresponde la zona        
        $idPuntoVenta = $zona->idPuntoVenta; //obtengo el idRestaurante de la zona 

        $datosPuntoVenta = new RestaurantesController(); //para obtener los datos del restaurante
        $datosRestaurantePV = $datosPuntoVenta->obtenerUnRestaurante($idPuntoVenta); //los datos lo envio a la vista

        $hoteles = new HotelesController();
        $hoteles = $hoteles->obtenerTodosLosHoteles($idHotel);

        $restaurantes = new RestaurantesController();
        $restaurantes = $restaurantes->obtenerTodosLosRestaurantes($idHotel);

        // $hoteles = \App::call('App\Http\Controllers\HotelesController@obtenerTodosLosHoteles');
        // $restaurantes = \App::call('App\Http\Controllers\RestaurantesController@obtenerTodosLosRestaurantes');

        return view('centrosProd.edit', ['zona' => $zona, 'datosRestaurantePV' => $datosRestaurantePV, 'hoteles' => $hoteles, 'restaurantes' => $restaurantes]);
    }

    public function store(Request $request)
    {
        $respuesta = $this->realizarPeticion('POST', $this->urlBase . 'AddZona', ['form_params' => $request->all()]);
        // dd($respuesta);
        return redirect('/centrosprod');
    }
    public function obtenerUnaZona($idZona)
    {
        $respuesta = $this->realizarPeticion('GET', $this->urlBase . "GetZona/{$idZona}");
        $datos = json_decode($respuesta);
        $zona = $datos->objeto;
        return $zona;
    }
    public function actualizar(Request $request)
    {
        $idZona = $request->get('id');

        $respuesta = $this->realizarPeticion('POST', $this->urlBase . "UpdateZona/{$idZona}", ['form_params' => $request->except('id')]);
        return redirect('/centrosprod');
    }
    public function destroy($idZona)
    {

        $respuesta = $this->realizarPeticion('POST', $this->urlBase . "DeleteZona/{$idZona}");
        return redirect('/centrosprod');
    }
}
