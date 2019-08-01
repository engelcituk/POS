<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Alert;
 
class CategoriaController extends Controller
{
    
    public $urlBase = "http://localhost/TPVApi/Categoria/";

    public function __construct()
    {

        // $this->middleware('accesoCategoriasFiltro');
    }
    public function index(){

        $categorias = $this->obtenerTodasLasCategorias();
        return view('categorias',compact('categorias'));
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
        // $users = \App::call('App\Http\Controllers\ApiUsuarioController@obtenerTodosLosUsuarios');
        return view('categorias.partials.create');
    }

   
    public function store(Request $request){

        $nombreCategoria = $request->get('name'); 
        $idUsuario = $request->get('idUsuarioAlta');        
        $orden = $request->get('orden');
        $imagen = $request->file('imagen');

        if ($imagen == null) {
            $nombreImg = "SIN IMAGEN";
        } else {
            $imgUrl = $imagen->store('public/categorias');
            $nombreImg = basename($imgUrl);
        }

        // dd( $icono);
        $this->guardarCategoria($nombreCategoria, $idUsuario, $orden, $nombreImg);

        return redirect('/categorias');
    }
    public function guardarCategoria($nombreCategoria, $idUsuario, $orden, $nombreImg){

        $respuesta = $this->realizarPeticion('POST', $this->urlBase . 'AddCategoria', [
            'form_params' => [
                'name' => $nombreCategoria,
                "idUsuarioAlta" => $idUsuario,
                'orden' => $orden,
                "imagen" =>$nombreImg
            ]
        ]);
        return $respuesta;
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
    public function obtenerUnaCategoria($idCategoria){
        $respuesta = $this->realizarPeticion('GET', $this->urlBase . "GetCategoria/{$idCategoria}");
        $datos = json_decode($respuesta);
        $categoria = $datos->objeto;
        return $categoria;
    }
          
    public function actualizar(Request $request){
        $idCategoria = $request->get('id');
        $nombreCategoria = $request->get('name');
        $idUsuario = $request->get('idUsuarioAlta');
        $orden = $request->get('orden');
        $imagen = $request->file('imagen');

        $nombreImgApi = $request->get('imagenValor');

        if ($imagen == null) {
            $nombreImg = $nombreImgApi;
        } else {
            $rutaImg = "/storage/categorias/" . $nombreImgApi;

            $imgUrlBorrar = str_replace('storage', 'public', $rutaImg);

            Storage::delete($imgUrlBorrar);

            $imgUrl = $imagen->store('public/categorias');
            $nombreImg = basename($imgUrl);
        }
        // dd( $icono);     
        $this-> actualizarCategoria($idCategoria, $nombreCategoria, $idUsuario, $orden, $nombreImg);
      
        return redirect('/categorias');
    }
    public function actualizarCategoria($idCategoria,$nombreCategoria,$idUsuario,$orden, $nombreImg){

        $respuesta = $this->realizarPeticion('POST', $this->urlBase . "UpdateCategoria/{$idCategoria}", [
            'form_params' => [
                'name' => $nombreCategoria,
                "idUsuarioAlta"=> $idUsuario,
                'orden' => $orden,
                "imagen"=> $nombreImg
            ]
        ]);

        return $respuesta;
    }

    public function destroy($idCategoria){
        
        $respuesta = $this->realizarPeticion('POST', $this->urlBase."DeleteCategoria/{$idCategoria}");

        return redirect('/categorias');
    }
}
