<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ImpresorasController extends Controller
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
    public $urlBase = "http://localhost/TPVApi/Impresoras/";
    public function index()
    {
        return view('impresoras');
    }

    public function AllImpresoras()
    {
        $impresoras = $this->obtenerTodasLasImpresoras();

        $acciones = 'impresoras.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($impresoras)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    protected function obtenerTodasLasImpresoras()
    {
        //es una funcion que esta en el controller principal        
        $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetImpresoras');

        $datos = json_decode($respuesta);

        $impresoras = $datos->objeto;

        return $impresoras; 
    }
    protected function create() 
    {
        $hoteles = \App::call('App\Http\Controllers\HotelesController@obtenerTodosLosHoteles');
        $restaurantes = \App::call('App\Http\Controllers\RestaurantesController@obtenerTodosLosRestaurantes');
        // $idHotel = $hotel->id;  
        return view('impresoras.partials.create', ['hoteles' => $hoteles, 'restaurantes' => $restaurantes]);      
    }
    public function show($id)
    {        
        $idImpresora = $id;
        $impresora = $this->obtenerUnaImpresora($idImpresora);

        $idPuntoVenta = $impresora->idPuntoVenta; //obtengo el idRestaurante de la impresora 
        $datosPuntoVenta = new RestaurantesController(); //para obtener los datos del restaurante
        $datosRestaurantePV = $datosPuntoVenta->obtenerUnRestaurante($idPuntoVenta); //los datos lo envio a la vista

        $idHotel = $datosRestaurantePV->idHotel;
        $datosHotel = new HotelesController();
        $hotelRestaurante = $datosHotel->obtenerUnHotel($idHotel);

        return view('impresoras.partials.show', ['impresora' => $impresora, 'datosRestaurantePV' => $datosRestaurantePV, 'hotelRestaurante'=> $hotelRestaurante]);
    }
    public function edit($id)
    {
        $idImpresora = $id;
        $impresora = $this->obtenerUnaImpresora($idImpresora);

        $idPuntoVenta = $impresora->idPuntoVenta; //obtengo el idRestaurante de la impresora 
        $datosPuntoVenta = new RestaurantesController(); //para obtener los datos del restaurante
        $datosRestaurantePV = $datosPuntoVenta->obtenerUnRestaurante($idPuntoVenta); //los datos lo envio a la vista

        $hoteles = \App::call('App\Http\Controllers\HotelesController@obtenerTodosLosHoteles');
        $restaurantes = \App::call('App\Http\Controllers\RestaurantesController@obtenerTodosLosRestaurantes');

        return view('impresoras.partials.edit', ['impresora' => $impresora, 'datosRestaurantePV'=>$datosRestaurantePV, 'hoteles' => $hoteles, 'restaurantes' => $restaurantes]); 
        
    }
    public function store(Request $request)
    {
        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'AddImpresora', ['form_params' => $request->all()]);

        return redirect('/impresoras');
    }
    public function obtenerUnaImpresora($idImpresora)
    {
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetImpresora/{$idImpresora}");
        $datos = json_decode($respuesta);
        $impresora = $datos->objeto;
        return $impresora;
    }
    public function actualizar(Request $request)
    {
        $idImpresora = $request->get('id');

        $respuesta = $this->realizarPeticion('PUT', $this->urlBase."UpdateImpresora/{$idImpresora}", ['form_params' =>$request->except('id')]);
        return redirect('/impresoras');
    }
    public function destroy($id)
    {
        $idImpresora = $id;
        $respuesta = $this->realizarPeticion('DELETE', $this->urlBase ."DeleteImpresora/{$idImpresora}");
        return redirect('/impresoras');
    }
}
