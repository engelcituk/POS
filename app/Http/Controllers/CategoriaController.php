<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;

use Alert;

class CategoriaController extends Controller
{
    public $urlBase = "http://localhost/TPVApi/Categoria/";        
    public function index(){
        return view('categorias');
    }

    public function AllCategorias(){
        $categorias = $this->obtenerTodasLasCategorias();

        $acciones = 'categorias.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($categorias)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    public function obtenerTodasLasCategorias(){
        //es una funcion que esta en el controller principal        
        $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetCategoria');

        $datos = json_decode($respuesta);

        $categorias = $datos->objeto;

        return $categorias;
    }
    
    public function create()
    {
        $users = \App::call('App\Http\Controllers\ApiUsuarioController@obtenerTodosLosUsuarios');
        return view('categorias.partials.create', compact('users'));
    }

   
    public function store(Request $request){
        dd( $request->all());
        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'AddCategoria', ['form_params' => $request->all()]);       
        // dd($respuesta);
        return redirect('/categorias');
    }

    
    public function show($idCategoria){
        $categoria = $this->obtenerUnaCategoria($idCategoria);
        $idUsuario = $categoria->idUsuarioAlta;        
        
        $usuario = new ApiUsuarioController();
        $usuario = $usuario->obtenerUnUsuario($idUsuario); 
       
        return view('categorias.partials.show', compact('categoria', 'usuario'));
    }

    public function edit($idCategoria){

        $categoria = $this->obtenerUnaCategoria($idCategoria);
        $idUsuario = $categoria->idUsuarioAlta;

        $usuario = new ApiUsuarioController();
        $usuario = $usuario->obtenerUnUsuario($idUsuario);

        $users = \App::call('App\Http\Controllers\ApiUsuarioController@obtenerTodosLosUsuarios');

        return view('categorias.partials.edit', compact('categoria', 'usuario', 'users'));
    }
    public function obtenerUnaCategoria($idCategoria)
    {
        $respuesta = $this->realizarPeticion('GET', $this->urlBase . "GetCategoria/{$idCategoria}");
        $datos = json_decode($respuesta);
        $categoria = $datos->objeto;
        return $categoria;
    }
          
    public function actualizar(Request $request){
        $idCategoria = $request->get('id');

        $respuesta = $this->realizarPeticion('PUT', $this->urlBase."UpdateCategoria/{$idCategoria}", ['form_params' => $request->except('id')]);

        return redirect('/categorias');
    }

    public function destroy($idCategoria){
        
        $respuesta = $this->realizarPeticion('DELETE', $this->urlBase."DeleteCategoria/{$idCategoria}");

        return redirect('/categorias');
    }
}
