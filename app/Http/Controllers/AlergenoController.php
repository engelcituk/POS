<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class AlergenoController extends Controller
{

    public $urlBase = "http://localhost/TPVApi/Alergenos/";

    public function __construct(){

        // $this->middleware('accesoAlergenosFiltro');
    }     
    public function index(){
        $alergenos = $this->obtenerTodosLosAlergenos();
        // dd($alergenos);
        return view('alergenos', compact('alergenos'));        
        
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
        $nombreImgApi = $request->get('iconoValor');
        $imagen = $request->file('icono');

        $nombreImgApi = $request->get('iconoValor');

        if ($imagen == null) {
            $nombreImg = $nombreImgApi;
        } else {
            $rutaImg= "/storage/alergenos/".$nombreImgApi;

            $imgUrlBorrar=str_replace('storage','public', $rutaImg);

            Storage::delete($imgUrlBorrar);

            $imgUrl = $imagen->store('public/alergenos');
            $nombreImg = basename($imgUrl);
        }       
        // dd($imgUrlBorrar);
        $this->actualizarAlergeno($idAlergeno, $nombre, $nombreImg);
        
        return redirect('/alergenos');

    }
    public function obtenerUnAlergeno($idAlergeno){

        $respuesta = $this->realizarPeticion('GET', $this->urlBase . "GetAlergeno/{$idAlergeno}");
        $datos = json_decode($respuesta);
        $alergeno = $datos->objeto;
        return $alergeno;
    }
    
    public function store(Request $request){
        
        $nombre = $request->get('name');
        $imagen = $request->file('icono');

        if($imagen == null){
            $nombreImg="SIN IMAGEN";
        }else{
            $imgUrl = $imagen->store('public/alergenos');
            $nombreImg = basename($imgUrl);
        }        
         $this->guardarAlergeno($nombre, $nombreImg);
                         
        return redirect('/alergenos');
        
    }
    public function guardarAlergeno($nombre, $icono){

        
        $respuesta = $this->realizarPeticion('POST', $this->urlBase . 'AddAlergeno', [
            'form_params' => [
                'name' => $nombre,
                'icono' => $icono
            ]
        ]);
        // dd($respuesta);
        return $respuesta;
    }
    public function actualizarAlergeno($idAlergeno,$nombre, $nombreImg){
        
        $respuesta = $this->realizarPeticion('POST', $this->urlBase. "UpdateAlergeno/{$idAlergeno}", [
            'form_params' => [
                'name' => $nombre,
                'icono' => $nombreImg
            ]
        ]);
        
        return $respuesta;
    }

    public function destroy($idAlergeno){
        
        $respuesta = $this->realizarPeticion('POST', $this->urlBase."DeleteAlergeno/{$idAlergeno}");
        return redirect('/alergenos');
    }
}
