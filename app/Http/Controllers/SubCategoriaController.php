<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;

class SubCategoriaController extends Controller {

    public $urlBase = "http://localhost/TPVApi/SubCategoria/";  
    public function index(){
        return view('subcategorias');
    }

    public function AllSubCategorias(){
        $subcategorias = $this->obtenerTodasLasSubCategorias();

        $acciones = 'subcategorias.datatables.botones';
        return Datatables::of($subcategorias)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true);
    }
    public function obtenerTodasLasSubCategorias(){               
        $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetSubCategoria');

        $datos = json_decode($respuesta);

        $subcategorias = $datos->objeto;

        return $subcategorias;
    }
    
    public function create(){

        $categorias = \App::call('App\Http\Controllers\CategoriaController@obtenerTodasLasCategorias');
        $users = \App::call('App\Http\Controllers\ApiUsuarioController@obtenerTodosLosUsuarios');

        return view('subcategorias.partials.create', compact('categorias','users'));
    }

    
    public function store(Request $request){
        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'AddSubCategoria', ['form_params' => $request->all()]);
        // dd($respuesta);
        return redirect('/subcategorias');
    }

    
    public function show($idSubCategoria){

        $subCategoria = $this->obtenerUnaSubCategoria($idSubCategoria);
        $idUsuario = $subCategoria->idUsuarioAlta;
        $idCategoria = $subCategoria->idCategoria;

        $usuario = new ApiUsuarioController();
        $usuario = $usuario->obtenerUnUsuario($idUsuario);

        $categoria = new CategoriaController();
        $categoria = $categoria->obtenerUnaCategoria( $idCategoria);

        return view('subcategorias.partials.show', compact('subCategoria', 'categoria', 'usuario'));
    }

   
    public function edit($idSubCategoria) {
        $subCategoria = $this->obtenerUnaSubCategoria( $idSubCategoria);
        $idUsuario = $subCategoria->idUsuarioAlta;
        $idCategoria = $subCategoria->idCategoria;

        $usuario = new ApiUsuarioController();
        $usuario = $usuario->obtenerUnUsuario($idUsuario);

        $categoria = new CategoriaController();
        $categoria = $categoria->obtenerUnaCategoria($idCategoria);

        $users = \App::call('App\Http\Controllers\ApiUsuarioController@obtenerTodosLosUsuarios');
        $categorias = \App::call('App\Http\Controllers\CategoriaController@obtenerTodasLasCategorias');

        return view('subcategorias.partials.edit', compact('subCategoria', 'categoria', 'categorias','usuario', 'users'));
        
    }
    public function obtenerUnaSubCategoria($idSubCategoria){
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetSubCategoria/{$idSubCategoria}");
        $datos = json_decode($respuesta);
        $subCategoria = $datos->objeto;
        return $subCategoria;
    }


    public function actualizar(Request $request){
        $idSubCategoria = $request->get('id');

        $respuesta = $this->realizarPeticion('PUT', $this->urlBase . "UpdateSubCategoria/{$idSubCategoria}", ['form_params' => $request->except('id')]);

        return redirect('/subcategorias');
    }

    public function destroy($idSubCategoria){

        $respuesta = $this->realizarPeticion('DELETE', $this->urlBase . "DeleteSubCategoria/{$idSubCategoria}");

        return redirect('/subcategorias');
    }
}
