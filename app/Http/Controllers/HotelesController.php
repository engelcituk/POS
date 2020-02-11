<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
 
class HotelesController extends Controller
{
    // URL_API_TPV 

    public $urlApi = "";

    public function __construct(){
           
        $this->middleware('accesoHotelesFiltro');
        $this->urlApi = $this->urlApiTPV()."Hoteles/";        
    }
        
    public function index()
    {
        $hoteles = $this->obtenerTodosLosHoteles();
        
        return view('hoteles', compact('hoteles'));
    }
        
    public function AllHoteles()
    {
        $hoteles = $this->obtenerTodosLosHoteles();
        
        $acciones = 'hoteles.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($hoteles)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    public function obtenerTodosLosHoteles()//siel metodo es protected no lo puedo usar en otro lado, como en restaurantes
    {
        //es una funcion que esta en el controller principal
        $respuesta = $this->realizarPeticion('GET', $this->urlApi.'GetHoteles');

        $datos = json_decode($respuesta);

        $hoteles = $datos->objeto;

        return $hoteles;
    }

    public function obtenerZonasHorarias()//siel metodo es protected no lo puedo usar en otro lado, como en restaurantes
    {
        //es una funcion que esta en el controller principal
        $respuesta = $this->realizarPeticion('GET', $this->urlApi.'getTimeZone');

        $datos = json_decode($respuesta);
        
        $ok = $datos->ok;
                
        $zonasHorarias = ($ok == true) ? $datos->Zonas : "";

        return $zonasHorarias;
    }
    public function create()
    {
        $zonasHorarias = $this->obtenerZonasHorarias();
        //   dd($zonasHorarias);      
        return view('hoteles.partials.create', compact('zonasHorarias'));
    }
    public function show($id)
    {             
        $idHotel= $id;
        $hotel = $this->obtenerUnHotel($idHotel);
        return view('hoteles.partials.show',['hotel'=> $hotel]);
    }
    public function edit($id)
    {
        $idHotel = $id;
        $hotel = $this->obtenerUnHotel($idHotel);
        $zonasHorarias = $this->obtenerZonasHorarias();

        return view('hoteles.partials.edit',['hotel' => $hotel,'zonasHorarias'=>$zonasHorarias]);
    }    
    //metodo que se ocupara para obtener el dato de un hotel, se ocupa para show y edit
    public function obtenerUnHotel($idHotel){
        $respuesta = $this->realizarPeticion('GET', $this->urlApi."GetHotel/{$idHotel}");
        $datos = json_decode($respuesta);
        $hotel = $datos->objeto;
        return $hotel;
    }

    static public function obtenerHotelSesion($idHotel){//funcion que uso desde la vista
        $metodo = "GET";
        $urlBase = "http://172.16.1.45/TPVApi/Hoteles/GetHotel/{$idHotel}";

        $cliente =  new Client();
        $respuesta = $cliente->request($metodo, $urlBase);
        $respuesta = $respuesta->getBody()->getContents();
        $respuesta = json_decode($respuesta);
        $hotel = $respuesta->objeto;

        return  $hotel;        
    }

    public function store(Request $request)
    {
        // $accessToken = 'Bearer ' . $this->obtenerAccessToken();
        $respuesta = $this->realizarPeticion('POST', $this->urlApi.'AddHotel', ['form_params' => $request->all()]);

        return redirect('/hoteles');
    }

    public function actualizar(Request $request)
    {
        $idHotel= $request->get('id');

        $respuesta = $this->realizarPeticion('POST', $this->urlApi."UpdateHotel/{$idHotel}", ['form_params' => $request->except('id')]);
        return redirect('/hoteles');
    }
    public function destroy($id)
    {
        $idHotel = $id;
        $respuesta = $this->realizarPeticion('POST', $this->urlApi."DeleteHotel/{$idHotel}");
        return redirect('/hoteles');
    }
}
