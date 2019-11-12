<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Image;
 
class ProductosController extends Controller
{
    public $urlBase = "";
    public $urlBaseProductoAlergeno = "";
    public $urlPModo= "";

    public function __construct(){

        $this->middleware('accesoProductosFiltro');
        $this->urlBase = $this->urlApiTPV()."Producto/";
        $this->urlBaseProductoAlergeno = $this->urlApiTPV()."ProductoAlergeno/";
        $this->urlPModo = $this->urlApiTPV()."ProductoModo/";

    }

    public function index(){
        // $productos = $this->obtenerTodosLosProductos();
        $productos = $this->obtenerTodosLosProductos();
        // dd($productos);
        $modos = new ModosController();
        $modos = $modos->obtenerTodosLosModos(); 
        // dd($modos);
        return view('productos',compact('productos','modos'));
        
    }
    protected function create(){
        
        $categorias= \App::call('App\Http\Controllers\CategoriaController@obtenerTodasLasCategorias');
        $modos = \App::call('App\Http\Controllers\ModosController@obtenerTodosLosModos');
        $alergenos = \App::call( 'App\Http\Controllers\AlergenoController@obtenerTodosLosAlergenos');
       
        return view('productos.partials.create', compact('categorias','alergenos', 'modos'));  
    }
    public function AllProduct()
    {
        $productos = $this->obtenerTodosLosProductos();

        $acciones = 'productos.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($productos)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }   
    public function obtenerTodosLosProductos(){
       //es una funcion que esta en el controller principal
       $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetProducto'); 

       $datos = json_decode($respuesta);

       $productos = $datos->objeto;

       return $productos;
    }
    
    public function show($idProducto){
        
        $producto = $this->obtenerUnProducto($idProducto);
        $idCategoria= $producto->idCategoria;

        
        $categoria = new CategoriaController();
        $categoria = $categoria->obtenerUnaCategoria($idCategoria);

        return view('productos.partials.show', compact('producto','categoria'));
               
    }
    public function edit($idProducto){

        $categorias = \App::call('App\Http\Controllers\CategoriaController@obtenerTodasLasCategorias');        
        $alergenos = \App::call('App\Http\Controllers\AlergenoController@obtenerTodosLosAlergenos');

        $producto = $this->obtenerUnProducto($idProducto);

        $idCategoria = $producto->idCategoria;
        $categoriaProducto = new CategoriaController();
        $categoriaProducto = $categoriaProducto->obtenerUnaCategoria($idCategoria);

        // dd( $categoriaProducto);
        $alergenosProducto = $this->obtenerAlergenosProducto($idProducto);//obtengo un objeto con una respuesta ok
        $respuestaOk = $alergenosProducto->ok;
         
        if ($respuestaOk== 1) {
            $alergenosProducto = $alergenosProducto->objeto;

            $idAlergenosColeccion = new Collection([]); 
            foreach ($alergenosProducto as $alergeno) {
                $idAlergenosColeccion->push($alergeno->idAlergeno);
            }

        } else {
            $idAlergenosColeccion = new Collection([]);
         }
                               
        return view('productos.partials.edit', compact('categorias',  'alergenos','producto', 'categoriaProducto', 'idAlergenosColeccion')); 
    }
    public function obtenerUnProducto($idProducto){
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetProducto/{$idProducto}");
        $datos = json_decode($respuesta);
        $producto = $datos->objeto;
        return $producto;
    }
    
    public function obtenerAlergenosProducto($idProducto){
        $respuesta = $this->realizarPeticion('GET', $this->urlBaseProductoAlergeno."GetAlergenosProducto/{$idProducto}");
        $datos = json_decode($respuesta);
        // $respuestaOK = $datos->objeto;
        return $datos;
    }
   
    public function store(Request $request){

        $arrayIdAlergenos = $request->get('idAlergeno');
        $arrayIdModos = $request->get('idModo');
        $arrayModoPrincipal = $request->get('principal');//0 o 1 

        // dd($arrayIdModos);
        $imagen = $request->file('imagen');
        //$imagenb = base64_encode(file_get_contents($request->file('imagen')->path()));
        $idCategoria = $request->get( 'idCategoria');       
        $codigoProducto = $request->get('codigoProducto');
        $nombreProducto = $request->get('nombreProducto');
        $propina = $request->get('propina');
        $tipoPropina = $request->get('tipoPropina');
        $montoPropina = $request->get('montoPropina');
        $precio = $request->get('precio');
        $complemento = $request->get('complemento');
        $temporada = $request->get('temporada');
        $status = $request->get('status');
        
        // dd( $imagen);
       $mntPropina = ($montoPropina == NULL) ? 0 : $montoPropina;    

        if ($imagen == null) {
            $nombreImg = "SIN IMAGEN";
        } else {
            $imgUrl = $imagen->store('public/productos');
            $nombreImg = basename($imgUrl);

            $image = Image::make(Storage::get($imgUrl)); //obtengo la img
            $image->resize(400, 300);//redimensiono
            Storage::put($imgUrl, (string) $image->encode('jpg', 50)); //reemplazo la imagen anterior.
        }        
                       
        $respuesta = $this->realizarPeticion('POST', $this->urlBase . 'AddProducto', [
            'form_params' => [
                'codigoProducto' => $codigoProducto,
                'idCategoria' => $idCategoria,
                'nombreProducto' => $nombreProducto,
                'propina' => $propina,
                'tipoPropina' => $tipoPropina,
                'montoPropina' => $mntPropina,
                'precio' => $precio,
                'complemento' => $complemento,
                'imagen' => $nombreImg,
                'status' => $status,
                'temporada' => $temporada

            ]
        ]);
        // dd($respuesta);
        $datos = json_decode($respuesta);
        $respuestaObjeto = $datos->objeto;

        $idProducto = $respuestaObjeto->id;

        if ($arrayIdAlergenos != null) {
            foreach ($arrayIdAlergenos as $idAlergeno) {
                $this->guardarProductoAlergeno($idProducto, $idAlergeno);
            }
        }
        // guardo los modos para el producto
        if($arrayIdModos != null){
            $contador = -1;
            foreach ($arrayIdModos as $idModo) {
                $contador = $contador + 1;
                $principal = $arrayModoPrincipal[$contador];
                $this->guardarProductoModo($idProducto, $idModo, $principal);
            }
        }
        

        return redirect('/productos');
    }
    public function getModosProducto(Request $request){

        $idProducto = $request->get('idProducto');

        $respuesta = $this->realizarPeticion('GET', $this->urlPModo."GetModoProducto/{$idProducto}");
        // $datos = json_decode($respuesta);
        // $producto = $datos->objeto;
        return $respuesta;
    }
    public function guardarProductoModo($idProducto, $idModo, $principal){

        $respuesta = $this->realizarPeticion('POST', $this->urlPModo.'AddProductoModo', [
            'form_params' => [               
                'idProducto' => $idProducto,
                'idModo' => $idModo,
                'principal' => $principal
            ]
        ]);
        return $respuesta;
    }
    //para agregar, quitar modos de preparaciona prodcutos , mediante ajax 
    public function AddProductoModoEdit(Request $request){

        $idProducto = $request->get('idProducto');
        $idModo = $request->get('idModo');
        $principal = $request->get('principal');

        $respuesta = $this->realizarPeticion('POST', $this->urlPModo.'AddProductoModo', [
            'form_params' => [
                'idProducto' => $idProducto,
                'idModo' => $idModo,
                'principal' => $principal
            ]
        ]);
        return $respuesta;
    }
    public function deleteModoProducto(Request $request){

        $idProducto = $request->get('idProducto');
        $idModo = $request->get('idModo');

        $respuesta = $this->realizarPeticion('POST', $this->urlPModo."DeleteProductoModo/{$idProducto}/{$idModo}");
        
        return $respuesta;
    }
    public function actualizar(Request $request){
        
        $idProducto = $request->get('id');
        $imagen = $request->file('imagen');      
        $idCategoria = $request->get('idCategoria');
        $codigoProducto = $request->get('codigoProducto');
        $nombreProducto = $request->get('nombreProducto');
        $propina = $request->get('propina');
        $tipoPropina = $request->get('tipoPropina');
        $montoPropina = $request->get('montoPropina');
        $precio = $request->get('precio');
        $complemento = $request->get('complemento');
        $status = $request->get('status');
        $temporada = $request->get('temporada');

        $nombreImgApi = $request->get('nombreImg');
        // dd(request()->all());
        $mntPropina = ($montoPropina == NULL) ? 0 : $montoPropina;    

        if ($imagen == null) {
            $nombreImg = $nombreImgApi;
        } else {
            $rutaImg = "/storage/productos/".$nombreImgApi;

            $imgUrlBorrar = str_replace('storage', 'public', $rutaImg);

            Storage::delete($imgUrlBorrar);

            $imgUrl = $imagen->store('public/productos');
            $nombreImg = basename($imgUrl);

            //modifico las dimensiones de la img agregada
            $image = Image::make(Storage::get($imgUrl)); //obtengo la img
            $image->resize(400, 300);            
            Storage::put($imgUrl, (string) $image->encode('jpg', 50)); //reemplazo la imagen anterior.
        }       
    
        // dd( $array);
        $respuesta = $this->realizarPeticion('POST', $this->urlBase."UpdateProducto/{$idProducto}", [
            'form_params' => [
                'codigoProducto' => $codigoProducto,
                'idCategoria' => $idCategoria,
                'nombreProducto' => $nombreProducto,
                'propina' => $propina,
                'tipoPropina' => $tipoPropina,
                'montoPropina' => $mntPropina,
                'precio' => $precio,
                'complemento' => $complemento,
                'imagen' => $nombreImg,
                'status' => $status,
                'temporada' => $temporada,
            ]
        ]);        
        return redirect('/productos');
    }

    public function guardarProductoAlergeno($idProducto, $idAlergeno){
        $respuesta = $this->realizarPeticion('POST', $this->urlBaseProductoAlergeno.'AddProductoAlergeno', [
            'form_params' => [
                'idProducto' => $idProducto,
                'idAlergeno' => $idAlergeno
            ]
        ]);
        return $respuesta;
    }

    public function destroy(Request $request, $idProducto){

        $nombreImg = $request->get('nombreImagen');

        $respuesta = $this->realizarPeticion('POST', $this->urlBase."DeleteProducto/{$idProducto}");

        $datos = json_decode($respuesta);

        $ok = $datos->ok;
        //si respuesta de api es true borro en mi carpeta el archivo
        if ($ok) {
            $rutaImg = "/sandostpv/storage/productos/" . $nombreImg;

            $imgUrlBorrar = str_replace('storage', 'public', $rutaImg);

            Storage::delete($imgUrlBorrar);
        }

        return redirect('/productos');
    }

    public function destroyAlergeno($idProducto, $idAlergeno){
                
        $respuesta = $this->realizarPeticion('POST', $this->urlBaseProductoAlergeno."DeleteProductoAlergeno/{$idProducto}/{$idAlergeno}");
        
        return $respuesta;
    }

}
 
