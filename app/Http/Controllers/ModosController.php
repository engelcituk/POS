<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;

class ModosController extends Controller
{
    public $urlBase = "http://localhost/TPVApi/Modos/";
    public function __construct(){

        // $this->middleware('accesoModosFiltro');
    }

    public function index()
    {
        return view('modos'); 
    }

    public function AllModos()
    {
        $modos = $this->obtenerTodosLosModos();

        $acciones = 'modos.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($modos)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    protected function obtenerTodosLosModos()
    {
        //es una funcion que esta en el controller principal       
        $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetModos');

        $datos = json_decode($respuesta);

        $modos = $datos->objeto;

        return $modos;
    }
   public function obtenerUnModo($idModo){

        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetModo/{$idModo}");
        $datos = json_decode($respuesta);
        $modo = $datos->objeto;
        return $modo;
   }
    public function create()
    {
        return view('modos.partials.create');
    }
    
    public function store(Request $request)
    {
        $descripcion = $request->get('descripcion');
        $idUsuario = $request->session()->get('idUsuarioLogueado');
      
        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'AddModo', [
            'form_params' => [
                'descripcion' => $descripcion,
                "idUsuarioAlta" => $idUsuario
            ]
        ]);

        return redirect('/modos');
    }

    public function show($idModo)
    {
        $modo = $this->obtenerUnModo($idModo);

        $idUsuario = $modo->idUsuarioAlta; 
        $usuario = new ApiUsuarioController();
        $usuario = $usuario->obtenerUnUsuario($idUsuario);        

        return view('modos.partials.show', ['modo' => $modo,'usuario'=> $usuario]);
    }
       
    public function edit($idModo)
    {
        $modo = $this->obtenerUnModo($idModo);
        return view('modos.partials.edit', ['modo' => $modo]);
    }
        
    public function actualizar(Request $request)
    {
        $idModo = $request->get('id');
        $descripcion = $request->get('descripcion');
        $idUsuario = $request->session()->get('idUsuarioLogueado');

        $respuesta = $this->realizarPeticion('POST', $this->urlBase."UpdateModo/{$idModo}", [
            'form_params' => [
                'descripcion' => $descripcion,
                "idUsuarioAlta" => $idUsuario
            ]
        ]);

        return redirect('/modos');
    }

    public function destroy($idModo){

        $respuesta = $this->realizarPeticion('POST', $this->urlBase."DeleteModo/{$idModo}");
        return redirect('/impresoras');

    }
}
