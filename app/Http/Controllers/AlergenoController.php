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
    public $urlBase = "http://localhost/TPVApi/Alergenos/";
    
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
    public function create(){
        return view('alergenos.partials.create');
    }
    
    public function show($id){
        $idAlergeno = $id;
        $alergeno = $this->obtenerUnAlergeno($idAlergeno);
             
        return view('alergenos.partials.show', ['alergeno' => $alergeno]);
    }

    public function edit($id){

        $idAlergeno = $id;
        $alergeno = $this->obtenerUnAlergeno($idAlergeno);

        
        return view('alergenos.partials.edit', ['alergeno' => $alergeno]);
    }

    
    public function actualizar(Request $request){
        
        $idAlergeno = $request->get('id');    
        $nombre = $request->get('name');
        $imagen = $request->file('icono');

        if ($imagen == null) {
            $array = array();
            $imagen = "SIN IMAGEN";
            $array = $imagen;
        } else {
            $imagen = file_get_contents($request->file('icono')->path());

            $array = array();
            foreach (str_split($imagen) as $char) {
                array_push($array, ord($char));
            }
        }                        
        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'AddAlergeno', [
            'form_params' => [
                'name' => $nombre,
                'icono' => $array
            ]
        ]);
        return redirect('/alergenos');

    }
    public function obtenerUnAlergeno($idAlergeno)
    {
        $respuesta = $this->realizarPeticion('GET', $this->urlBase . "GetAlergeno/{$idAlergeno}");
        $datos = json_decode($respuesta);
        $alergeno = $datos->objeto;
        return $alergeno;
    }
    
    public function store(Request $request){
        
        $nombre = $request->get('name');
        $imagen = $request->file('icono');      

        if ($imagen == null) {
            $array = array();
            $imagen = "SIN IMAGEN";
            $array = $imagen;
        } else {
            $imagen = file_get_contents($request->file('icono')->path());

            $array = array();
            foreach (str_split($imagen) as $char) {
                array_push($array, ord($char));
            }
        }        
        // $icono = base64_encode(file_get_contents($request->file('icono')->path()));        
        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'AddAlergeno', [
            'form_params' => [
                'name' => $nombre,
                'icono' => $array
            ] 
        ]);        
        return redirect('/alergenos');
    }
    
    public function destroy($idAlergeno){
        
        $respuesta = $this->realizarPeticion('DELETE', $this->urlBase."DeleteAlergeno/{$idAlergeno}");
        return redirect('/centrospreparacion');
    }
}
