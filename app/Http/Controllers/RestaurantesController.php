<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RestaurantesController extends Controller
{
    public $urlBase = "";  
    public $idHotel; 
    
    public function __construct()
    {
        $this->middleware('accesoPVentaFiltro');
        $this->urlBase = $this->urlApiTPV()."PuntosVenta/";        
        
        $this->middleware(function ($request, $next) { //obtengo el valor de la session idHotel            
            $this->idHotel = session()->get('idHotel');
            return $next($request);
        });

    }
    
    public function index()
    {
             
        $restaurantes = $this->obtenerTodosLosRestaurantes($this->idHotel);
        return view('restaurantes', compact('restaurantes'));
    }
 
    public function AllRestaurantes()
    {
        $restaurantes = $this->obtenerTodosLosRestaurantes($this->idHotel);

        
        $acciones = 'restaurantes.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($restaurantes)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    public function obtenerTodosLosRestaurantes($idHotel)/*metodo no protected porque lo ocuparé en otros metodos de otros controladores */
    {
        if($idHotel == null){
            //realizarPeticiones una funcion que esta en el controller principal
            $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetPuntosVenta');
        } else {
            $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetPuntosVentaPorHotel/{$idHotel}");
        }
        
        $datos = json_decode($respuesta);
        $restaurantes = $datos->objeto;
        return $restaurantes;
    }
    public function obtenerMonedas(){ 
        /*metodo no protected porque lo ocuparé en otros metodos de otros controladores */
        //es una funcion que esta en el controller principal
        $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetMoneda');

        $datos = json_decode($respuesta);
        $monedas = $datos->objeto;
        return $monedas;
    } 
    protected function create(){
        /*Obtendo todos los hoteles que me trae mi controlador HOTELESCONTROLLER con su metodo OBTENERTODOSLOSHOTELES*/

        $hoteles =\App::call('App\Http\Controllers\HotelesController@obtenerTodosLosHoteles');
        $impresoras = \App::call( 'App\Http\Controllers\ImpresorasController@obtenerTodasLasImpresoras');
        $monedas = $this->obtenerMonedas();
        // dd($monedas);
        return view('restaurantes.partials.create', compact('hoteles', 'impresoras', 'monedas'));
    }   
    public function show($id)
    {        
        $idRestaurante = $id;
        $restaurante = $this->obtenerUnRestaurante($idRestaurante);
        $idHotel= $restaurante->idHotel;
        $datosHotel = new HotelesController();
        $hotel=$datosHotel->obtenerUnHotel($idHotel);

        return view('restaurantes.partials.show', ['restaurante' => $restaurante, 'hotel' => $hotel]);
    }
    public function edit($id)
    {
        $hoteles = \App::call('App\Http\Controllers\HotelesController@obtenerTodosLosHoteles');
        $impresoras = \App::call('App\Http\Controllers\ImpresorasController@obtenerTodasLasImpresoras'); 

        $idRestaurante = $id;
        $restaurante = $this->obtenerUnRestaurante($idRestaurante);
        //obtengo los datos del hotel para cargarlo en un select
        $idHotel = $restaurante->idHotel;
        $datosHotel = new HotelesController();
        $hotelRestaurante = $datosHotel->obtenerUnHotel($idHotel);
        //obtengo los datos de la impresora
        $idImpresora = $restaurante->idImpresora;
        $datosImpresora = new ImpresorasController();
        $impresora = $datosImpresora->obtenerUnaImpresora($idImpresora);
                
        return view('restaurantes.partials.edit', ['restaurante' => $restaurante, 'hoteles' => $hoteles, 'hotelRestaurante'=> $hotelRestaurante,'impresora' => $impresora, 'impresoras'=> $impresoras]);
    }
    //metodo que se ocupara para obtener el dato de un hotel, se ocupa para show y edit
    public function obtenerUnRestaurante($idRestaurante)
    {
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetPuntoVenta/{$idRestaurante}");
        $datos = json_decode($respuesta);
        $restaurante = $datos->objeto;
        return $restaurante;
    }
    
    public function store(Request $request)
    {       
        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'AddPuntoVenta', ['form_params' => $request->all()]);
        //  dd($respuesta);
        return redirect('/restaurantes');
    }
    public function actualizar(Request $request)
    {
        $idRestaurante = $request->get('id');

        $respuesta = $this->realizarPeticion('POST', $this->urlBase."UpdatePuntoVenta/{$idRestaurante}", ['form_params' => $request->except('id')]);
        return redirect('/restaurantes');
    }
    
    public function destroy($id)
    {
        $idRestaurante = $id;
        $respuesta = $this->realizarPeticion('POST', $this->urlBase."DeletePuntoVenta/{$idRestaurante}");
        return redirect( '/restaurantes');
    }
}
