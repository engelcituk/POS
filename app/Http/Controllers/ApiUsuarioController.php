<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Collection;
use Alert;

class ApiUsuarioController extends Controller
{
    
    public $urlBase = "http://localhost/TPVApi/Usuarios/";
    public function index()
    {
        return view('users');
    }
    public function AllApiUsuario()
    {
        $users = $this->obtenerTodosLosUsuarios();

        $acciones = 'users.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($users)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    protected function obtenerTodosLosUsuarios()
    {
        //es una funcion que esta en el controller principal        
        $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetUsuarios');

        $datos = json_decode($respuesta);

        $users = $datos->objeto;

        return $users;
    }
    
    public function create(){

        $roles = new ApiRolController(); //para obtener los roles
        $roles = $roles->obtenerTodosLosRoles(); //los datos lo envio a la vista

        return view('users.partials.create', compact('roles'));
    }
    
    public function store(Request $request){
        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'AddUsuario', ['form_params' => $request->all()]);
        $datos = json_decode($respuesta);
        $respuestaOk = $datos->ok; //obtengo la respuesta del la api con el rol creado
        //$respuestaMensaje=$datos->mensaje;
        
        if($respuestaOk==1){
            Alert::success('Exito', 'Usuario registrado exitosamente');
        }else{
            Alert::error('Error', 'El registro del usuario falló');
        }
        return redirect('/users');
    }
    
    public function show($idUsuario){
        $usuario = $this->obtenerUnUsuario($idUsuario);//obtengo los datos del usuario

        
        $idRolUser= $usuario->idRol;//para obtener los datos del rol que tiene asignado el usuario
        $rolUsuario = new ApiRolController(); 
        $rolUsuario = $rolUsuario->obtenerUnRol($idRolUser); //los datos lo envio a la vista

        $permisos = new PermisosController(); //Traigo toda mi lista de permisos
        $permisos = $permisos->obtenerTodosLosPermisos(); //los datos lo envio a la vista

        $permisosRol = new ApiRolController(); //instancia para la lista de permisos del rol
        $permisosRol = $permisosRol->obtenerPermisosPorRol($idRolUser); //los datos lo envio a la vista

        //creo una colecion de los permisos del rol para enviarlos a la vista
        $idPermisosRolColeccion = new Collection([]);
        foreach ($permisosRol as $permisoRol) {
            $idPermisosRolColeccion->push($permisoRol->idPermiso);
        }
        // dd($idPermisosRolColeccion);
        return view('users.partials.show', compact('usuario', 'rolUsuario', 'permisos', 'idPermisosRolColeccion'));
    }
    
    public function edit($idUsuario){
        $usuario = $this->obtenerUnUsuario($idUsuario); //obtengo los datos del usuario

        $roles = new ApiRolController(); //para obtener los roles
        $roles = $roles->obtenerTodosLosRoles(); //los datos lo envio a la vista

        $idRolUser = $usuario->idRol; //para obtener los datos del rol que tiene asignado el usuario
        $rolUsuario = new ApiRolController();
        $rolUsuario = $rolUsuario->obtenerUnRol($idRolUser); //los datos lo envio a la vista
        
        return view('users.partials.edit', ['usuario' => $usuario, 'rolUsuario' => $rolUsuario, 'roles' => $roles]);
    }
    public function obtenerUnUsuario($idUsuario){
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetUsuario/{$idUsuario}");
        $datos = json_decode($respuesta);
        $usuario = $datos->objeto;
        return $usuario;
    }


    public function actualizar(Request $request){

        $idUsuario = $request->get('id');

        $respuesta = $this->realizarPeticion('PUT', $this->urlBase."UpdateUsuario/{$idUsuario}", ['form_params' => $request->except('id')]);
        $datos = json_decode($respuesta);
        $respuestaOk = $datos->ok; 

        if ($respuestaOk == 1) {
            Alert::success('Exito', 'Usuario modificado exitosamente');
        } else {
            Alert::error('Error', 'La actualización del usuario falló');
        }

        return redirect('/users');
    }

   
    public function destroy($idUsuario){        

        $respuesta = $this->realizarPeticion('DELETE', $this->urlBase."DeleteUsuario/{$idUsuario}");
        return $respuesta;
    }
}
