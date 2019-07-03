<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;

class AlergenoController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public $urlBase = "http://localhost/TPVApi/Alergenos/";
    public $urlBase = "http://172.16.4.229/TPVApi/Alergenos/";
    
    public function index()
    {
        return view('alergenos');
        
    }

    public function AllAlergenos()
    {
        $alergenos = $this->obtenerTodosLosAlergenos();

        $acciones = 'alergenos.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($alergenos)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    public function obtenerTodosLosAlergenos(){
        //es una funcion que esta en el controller principal    
        $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetAlergenos');

        $datos = json_decode($respuesta);

        $alergenos = $datos->objeto;

        return $alergenos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('alergenos.partials.create');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $idAlergeno = $id;
        $alergeno = $this->obtenerUnAlergeno($idAlergeno);
             
        return view('alergenos.partials.show', ['alergeno' => $alergeno]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){

        $idAlergeno = $id;
        $alergeno = $this->obtenerUnAlergeno($idAlergeno);

        
        return view('alergenos.partials.edit', ['alergeno' => $alergeno]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request)
    {
        //
    }
    public function obtenerUnAlergeno($idAlergeno)
    {
        $respuesta = $this->realizarPeticion('GET', $this->urlBase . "GetAlergeno/{$idAlergeno}");
        $datos = json_decode($respuesta);
        $alergeno = $datos->objeto;
        return $alergeno;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $icono = base64_encode(file_get_contents($request->file('icono')->path()));        
        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'AddAlergeno', [
            'form_params' => [
                'name' => $request->get('name'),
                'icono' => $icono
            ] 
        ]);        
        return redirect('/alergenos');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $idAlergeno = $id;
        $respuesta = $this->realizarPeticion('DELETE', $this->urlBase."DeleteAlergeno/{$idAlergeno}");
        return redirect('/centrospreparacion');
    }
}
