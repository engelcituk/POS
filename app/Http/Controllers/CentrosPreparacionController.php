<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CentrosPreparacionController extends Controller
{
    
    public $urlBase = "";
    public $idHotel; 
    
    public function __construct()    {

        $this->middleware('accesoCPFiltro');
        $this->urlBase = $this->urlApiTPV()."CentrosPreparacion/";
        $this->middleware(function ($request, $next) { //obtengo el valor de la session idHotel            
            $this->idHotel = session()->get('idHotel');
            return $next($request);
        });

    }
    public function index()
    {
        $centrosP = $this->obtenerTodosLosCentrosDePreparacion($this->idHotel);
        // dd($centrosP);
        return view('centrosprep',compact('centrosP'));
    }

    public function AllCentrosPreparacion()
    {
        $centrosP = $this-> obtenerTodosLosCentrosDePreparacion($this->idHotel);

        $acciones = 'centrospreparacion.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($centrosP)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }

    public function obtenerTodosLosCentrosDePreparacion($idHotel)
    {
        if($idHotel == null){               
             //es una funcion que esta en el controller principal        
            $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetCentrosPreparacion');         
        } else {
            $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetCentrosPreparacionByHotel/{$idHotel}");
        }
        $datos = json_decode($respuesta);

        $centrosP = $datos->objeto;

        return $centrosP;
    }

    public function create()
    {
        $idHotel = $this->idHotel;
        $impresoras = new ImpresorasController();
        $impresoras = $impresoras->obtenerTodasLasImpresoras($idHotel);  

        //$impresoras = \App::call('App\Http\Controllers\ImpresorasController@obtenerTodasLasImpresoras');
        // dd($impresoras);  
        return view('centrospreparacion.partials.create', compact('impresoras'));   
    }

  
    public function store(Request $request){
        
        $respuesta = $this->realizarPeticion('POST', $this->urlBase . 'AddCentroPreparacion', [
            'form_params' => [
                'name' => $request->get('name'),
                'status' => $request->get('status'),
                'idImpresora' => $request->get('idImpresora'),
                'idImpresoraB' => $request->get('idImpresoraB'),
                'descripcion' => $request->get('descripcion'),
                'imprime' => $request->get('imprime')
                ]
            ]);

        // dd($respuesta);
        return redirect( '/centrospreparacion');
    }

    public function show($id)
    {
        $idHotel = $this->idHotel;

        $idCentroPreparacion = $id;
        $centroPreparacion = $this->obtenerUnCentroDePreparación($idCentroPreparacion);

        $idImpresora= $centroPreparacion->idImpresora;
        $datosImpresora= new ImpresorasController(); //para obtener los datos de la zona
        $datosImpresoraCP= $datosImpresora->obtenerUnaImpresora($idImpresora); //los datos de la zona lo envio a la vista

        $impresoras = new ImpresorasController();
        $impresoras = $impresoras->obtenerTodasLasImpresoras($idHotel);

       // $impresoras = \App::call('App\Http\Controllers\ImpresorasController@obtenerTodasLasImpresoras');

        return view('centrospreparacion.partials.show', compact('impresoras', 'centroPreparacion', 'datosImpresoraCP')); 
    }

    public function edit($id)
    {
        $idHotel = $this->idHotel;
        
        $idCentroPreparacion = $id;
        $centroPreparacion = $this->obtenerUnCentroDePreparación($idCentroPreparacion);
// dd($centroPreparacion);
        $idImpresora = $centroPreparacion->idImpresora;
        $idImpresoraB = $centroPreparacion->idImpresoraB;

        $datosImpresora = new ImpresorasController(); //para obtener los datos de la zona
        $datosImpresoraCP = $datosImpresora->obtenerUnaImpresora($idImpresora); //los datos de la zona lo envio a la vista
        $datosImpresoraCPB = $datosImpresora->obtenerUnaImpresora($idImpresoraB);
       
        $impresoras = new ImpresorasController();
        $impresoras = $impresoras->obtenerTodasLasImpresoras($idHotel);

        //$impresoras = \App::call('App\Http\Controllers\ImpresorasController@obtenerTodasLasImpresoras');
        
        return view('centrospreparacion.partials.edit', compact('impresoras', 'centroPreparacion', 'datosImpresoraCP', 'datosImpresoraCPB')); 
    }
    public function obtenerUnCentroDePreparación($idCentroPreparacion)
    {
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetCentroPreparacion/{$idCentroPreparacion}");
        $datos = json_decode($respuesta);
        $centroPreparacion = $datos->objeto;
        return $centroPreparacion;
    }
    
    public function actualizar(Request $request)
    {
        $idCentroPreparacion = $request->get('id');
        
        $respuesta = $this->realizarPeticion('POST', $this->urlBase."UpdateCentroPreparacion/{$idCentroPreparacion}", [
            'form_params' =>[
                'name' => $request->get('name'),
                'status' => $request->get('status'),
                'idImpresora' => $request->get('idImpresora'),
                'idImpresoraB' => $request->get('idImpresoraB'),
                'descripcion' => $request->get('descripcion'),
                'imprime' => $request->get('imprime'),
                'imprimeComanda' => $request->get('imprimeComanda')

            ]            
        ]);

        return redirect('/centrospreparacion');
    }    
    
    public function destroy( $idCentroPreparacion){        
        
        $respuesta = $this->realizarPeticion('POST', $this->urlBase."DeleteCentroPreparacion/{$idCentroPreparacion}");
        return redirect( '/centrospreparacion');
    }
}
