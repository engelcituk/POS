<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CentrosPreparacionController extends Controller
{
    
    public $urlBase = "http://localhost/TPVApi/CentrosPreparacion/";
    
    public function __construct()    {

        $this->middleware('accesoCPFiltro');
    }
    public function index()
    {
        $centrosP = $this->obtenerTodosLosCentrosDePreparacion();
        // dd($centrosP);
        return view('centrosprep',compact('centrosP'));
    }

    public function AllCentrosPreparacion()
    {
        $centrosP = $this-> obtenerTodosLosCentrosDePreparacion();

        $acciones = 'centrospreparacion.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($centrosP)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }

    public function obtenerTodosLosCentrosDePreparacion()
    {
        //es una funcion que esta en el controller principal        
        $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetCentrosPreparacion');

        $datos = json_decode($respuesta);

        $centrosP = $datos->objeto;

        return $centrosP;
    }

    public function create()
    {
              
        $impresoras = \App::call('App\Http\Controllers\ImpresorasController@obtenerTodasLasImpresoras');
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
        $idCentroPreparacion = $id;
        $centroPreparacion = $this->obtenerUnCentroDePreparación($idCentroPreparacion);

        $idImpresora= $centroPreparacion->idImpresora;
        $datosImpresora= new ImpresorasController(); //para obtener los datos de la zona
        $datosImpresoraCP= $datosImpresora->obtenerUnaImpresora($idImpresora); //los datos de la zona lo envio a la vista

        $impresoras = \App::call('App\Http\Controllers\ImpresorasController@obtenerTodasLasImpresoras');

        return view('centrospreparacion.partials.show', compact('impresoras', 'centroPreparacion', 'datosImpresoraCP')); 
    }

    public function edit($id)
    {
        $idCentroPreparacion = $id;
        $centroPreparacion = $this->obtenerUnCentroDePreparación($idCentroPreparacion);

        $idImpresora = $centroPreparacion->idImpresora;
        $idImpresoraB = $centroPreparacion->idImpresoraB;

        $datosImpresora = new ImpresorasController(); //para obtener los datos de la zona
        $datosImpresoraCP = $datosImpresora->obtenerUnaImpresora($idImpresora); //los datos de la zona lo envio a la vista
        $datosImpresoraCPB = $datosImpresora->obtenerUnaImpresora($idImpresoraB);
       
        $impresoras = \App::call('App\Http\Controllers\ImpresorasController@obtenerTodasLasImpresoras');
        
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
                'imprime' => $request->get('imprime')
            ]            
        ]);

        return redirect('/centrospreparacion');
    }

    
    
    public function destroy( $idCentroPreparacion){        
        
        $respuesta = $this->realizarPeticion('POST', $this->urlBase."DeleteCentroPreparacion/{$idCentroPreparacion}");
        return redirect( '/centrospreparacion');
    }
}
