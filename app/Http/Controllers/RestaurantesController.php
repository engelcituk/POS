<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RestaurantesController extends Controller
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
    public $urlBase = "http://localhost/TPVApi/PuntosVenta/";    
    public function index()
    {
        return view('restaurantes');
    }
 
    public function AllRestaurantes()
    {
        $restaurantes = $this->obtenerTodosLosRestaurantes();

        
        $acciones = 'restaurantes.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($restaurantes)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    public function obtenerTodosLosRestaurantes()/*metodo no protected porque lo ocuparé en otros metodos de otros controladores */
    {
        //es una funcion que esta en el controller principal
        $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetPuntosVenta');
        
        $datos = json_decode($respuesta);
        $restaurantes = $datos->objeto;
        return $restaurantes;
    } 
    protected function create(){
        /*Obtendo todos los hoteles que me trae mi controlador HOTELESCONTROLLER con su metodo OBTENERTODOSLOSHOTELES*/

        $hoteles =\App::call('App\Http\Controllers\HotelesController@obtenerTodosLosHoteles');
        $impresoras = \App::call( 'App\Http\Controllers\ImpresorasController@obtenerTodasLasImpresoras'); 
        
        return view('restaurantes.partials.create',['hoteles'=> $hoteles, 'impresoras'=> $impresoras]);
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
        $idRestaurante = $id;
        $restaurante = $this->obtenerUnRestaurante($idRestaurante);
        //obtengo los datos del hotel para cargarlo en un select
        $idHotel = $restaurante->idHotel;
        $datosHotel = new HotelesController();
        $hotelRestaurante = $datosHotel->obtenerUnHotel($idHotel);

        return view('restaurantes.partials.edit', ['restaurante' => $restaurante, 'hoteles' => $hoteles, 'hotelRestaurante'=> $hotelRestaurante]);
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

        $respuesta = $this->realizarPeticion('PUT', $this->urlBase."UpdatePuntoVenta/{$idRestaurante}", ['form_params' => $request->except('id')]);
        return redirect('/restaurantes');
    }
    
    public function destroy($id)
    {
        $idRestaurante = $id;
        $respuesta = $this->realizarPeticion('DELETE', $this->urlBase."DeletePuntoVenta/{$idRestaurante}");
        return redirect( '/restaurantes');
    }
}
