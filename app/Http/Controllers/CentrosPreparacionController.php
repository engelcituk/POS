<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CentrosPreparacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $urlBase = "http://localhost/TPVApi/CentrosPreparacion/";
    public function index()
    {
        return view('centrosprep');
    }

    public function AllCentrosPreparacion()
    {
        $impresoras = $this-> obtenerTodosLosCentrosDePreparacion();

        $acciones = 'centrospreparacion.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($impresoras)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }

    public function obtenerTodosLosCentrosDePreparacion()
    {
        //es una funcion que esta en el controller principal        
        $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetCentrosPreparacion');

        $datos = json_decode($respuesta);

        $impresoras = $datos->objeto;

        return $impresoras;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
              
        $impresoras = \App::call( 'App\Http\Controllers\ImpresorasController@obtenerTodasLasImpresoras');  
        return view('centrospreparacion.partials.create', compact('impresoras'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        
        $respuesta = $this->realizarPeticion('POST', $this->urlBase . 'AddCentroPreparacion', [
            'form_params' => [
                'name' => $request->get('name'),
                'idImpresora' => $request->get('idImpresora'),
                'descripcion' => $request->get('descripcion'),
                'status' => $request->get('status')
                ]
            ]);

        return redirect( '/centrospreparacion');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $idCentroPreparacion = $id;
        $centroPreparacion = $this->obtenerUnCentroDePreparación($idCentroPreparacion);

        $idImpresora = $centroPreparacion->idImpresora;
        $datosImpresora = new ImpresorasController(); //para obtener los datos de la zona
        $datosImpresoraCP = $datosImpresora->obtenerUnaImpresora($idImpresora); //los datos de la zona lo envio a la vista

        $impresoras = \App::call('App\Http\Controllers\ImpresorasController@obtenerTodasLasImpresoras');

        return view('centrospreparacion.partials.edit', compact('impresoras', 'centroPreparacion', 'datosImpresoraCP')); 
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
        
        $respuesta = $this->realizarPeticion('PUT', $this->urlBase."UpdateCentroPreparacion/{$idCentroPreparacion}", [
            'form_params' =>[
                'name' => $request->get('name'),
                'idImpresora' => $request->get('idImpresora'),
                'descripcion' => $request->get('descripcion'),
                'status' => $request->get('status')
            ]            
        ]);

        return redirect('/centrospreparacion');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
    {
        $idCentroPreparacion = $id;
        $respuesta = $this->realizarPeticion('DELETE', $this->urlBase."DeleteCentroPreparacion/{$idCentroPreparacion}");
        return redirect( '/centrospreparacion');
    }
}
