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
    public $urlBasePermisosUsuario = "http://localhost/TPVApi/PermisosUsuario/";
    

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
    public function obtenerTodosLosUsuarios(){
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
        $respuestaOk = $datos->ok; //obtengo la respuesta del la api con el usuario creado->true/false
           
        if($respuestaOk==1){
            $respuestaObjeto= $datos->objeto; //obtengo el objeto, usuario registrado-> id,name, usuario, status,idRol
            $respuestaMensaje = $datos->mensaje;

            $idUsuario = $respuestaObjeto->id;//obtengo el id del usuario
            $idRolUsuario= $respuestaObjeto->idRol;//el id del rol que se asignó al usuario

            $permisosRol = new ApiRolController(); //instancia para trabajar con permisos del rol
            $permisosRol = $permisosRol->obtenerPermisosPorRol($idRolUsuario); //los datos lo envio a la vista            
            //con el ciclo foreach se va guardando los permisos del rol asignado al usuario 
            foreach ($permisosRol as $permisoRol) {
                $idPermiso = $permisoRol->idPermiso;

                $this->guardarPermisosUsuario($idUsuario, $idPermiso);
            }
            Alert::success('Exito', 'Usuario registrado exitosamente '.$respuestaMensaje);
        }else{
            $respuestaMensaje = $datos->mensaje;
            Alert::error('Error', 'El registro del usuario falló '.$respuestaMensaje);
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
        $usuarioPermisos = $this->obtenerDatosPermisosUsuario($idUsuario); //obtengo todos los datos permisos usuario

        $roles = new ApiRolController(); //para obtener los roles
        $roles = $roles->obtenerTodosLosRoles(); //los datos lo envio a la vista

        $idRolUser = $usuario->idRol; //para obtener los datos del rol que tiene asignado el usuario
        $rolUsuario = new ApiRolController();
        $rolUsuario = $rolUsuario->obtenerUnRol($idRolUser); //los datos lo envio a la vista

        $permisos = new PermisosController(); //Traigo toda mi lista de permisos
        $permisos = $permisos->obtenerTodosLosPermisos(); //los datos lo envio a la vista

        $permisosRol = new ApiRolController(); //instancia para la lista de permisos del rol
        $permisosRol = $permisosRol->obtenerPermisosPorRol($idRolUser); //los datos lo envio a la vista

        $idPermisosRolColeccion = new Collection([]);
        foreach ($permisosRol as $permisoRol) {
            $idPermisosRolColeccion->push($permisoRol->idPermiso);
        }
        $p=[];
        foreach ($permisosRol as $permisoRol) {
            $p[] = [$permisoRol->idPermiso];
        }
        $crear = $p[0][0];
        // dd( $crear);
        $array = [];
        $contador=-1;
        foreach($permisos as $permiso) {
            $contador++;
            $array[]=['idPermiso'=> $permiso->id,'nombrePermiso'=>$permiso->name,'idUsuario'=> $usuario->id,'nUsuario' => $usuario->usuario, 'contador'=> $contador,'arP' => $crear];
            
        }
        //$crear = $array[1];
        // dd( $array);
        //creo una colecion de los permisos del rol para enviarlos a la vista
        

        $crearColeccion = new Collection([]);
        $leerColeccion = new Collection([]);
        $actualizarColeccion = new Collection([]);
        $borrarColeccion = new Collection([]);
        foreach ($usuarioPermisos as $usuarioPermiso) {
            $crearColeccion->push($usuarioPermiso->crear);
            $leerColeccion->push($usuarioPermiso->leer);
            $actualizarColeccion->push($usuarioPermiso->actualizar);
            $borrarColeccion->push($usuarioPermiso->borrar);
        }
        //  dd( $borrarColeccion);
        return view('users.partials.edit', compact('usuario', 'rolUsuario', 'roles','permisos', 'idPermisosRolColeccion', 'crearColeccion', 'leerColeccion', 'actualizarColeccion','borrarColeccion'));
    }
    public function obtenerUnUsuario($idUsuario){
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetUsuario/{$idUsuario}");
        $datos = json_decode($respuesta);
        $usuario = $datos->objeto;
        return $usuario;
    }
    public function obtenerDatosPermisosUsuario($idUsuario){
        $respuesta = $this->realizarPeticion('GET', $this->urlBasePermisosUsuario."GetUsuarioAllPermisos/{$idUsuario}");
        $datos = json_decode($respuesta);
        $usuarioPermisos = $datos->objeto;
        return $usuarioPermisos;
    }
    public function guardarPermisosUsuario($idUsuario, $idPermiso){

        $respuesta = $this->realizarPeticion('POST', $this->urlBasePermisosUsuario.'AddPermisoUsuario', [
            'form_params' => [
                'idUsuario' => $idUsuario,
                'idPermiso' => $idPermiso
            ]
        ]);
        $datos = json_decode($respuesta);
        $respuesta = $datos->mensaje;
        return $respuesta;
    }
    public function guardarAccionPermisoUsuario($idUsuario, $idPermiso, Request $request){
        $opciones= $request->get('opciones');//traigo el array de checks
                
        $crear= $opciones[0][0];
        $leer = $opciones[0][1];
        $actualizar = $opciones[0][2];
        $borrar = $opciones[0][3];
               
        $respuesta = $this->realizarPeticion('PUT', $this->urlBasePermisosUsuario."UpdatePermisoUsuario/{$idUsuario}/{$idPermiso}", [
            'form_params' => [
                'idUsuario' => $idUsuario,
                'idPermiso' => $idPermiso,
                'crear' => $crear,//true o false
                'leer' =>  $leer,
                'actualizar' => $actualizar,
                'borrar' =>  $borrar
            ]
        ]);
        $datos = json_decode($respuesta);
        $respuesta = $datos->mensaje; 
                                     
        return $respuesta;
    }
    public function actualizar(Request $request){//actualiza solo los datos del usuario

        $idUsuario = $request->get('id');

        $password =($request->get('password') == null) ? 'sinCambios' : $request->get('password');          
        $respuesta = $this->realizarPeticion('PUT', $this->urlBase."UpdateUsuario/{$idUsuario}", [
            'form_params' => [
                'name' => $request->get('name'),
                'usuario' => $request->get('usuario'),
                'password' => $password,
                'status'=> $request->get('status'),
                'idRol' => $request->get('idRol')                               
            ]            
        ]);
        $datos = json_decode($respuesta);
        $respuestaOk = $datos->ok;
        $respuestaMensaje = $datos->mensaje; 

        if ($respuestaOk == 1) {
            Alert::success('Exito', 'Usuario modificado exitosamente');
        } else {
            Alert::error('Error', 'La actualización del usuario falló '.$respuestaMensaje);
        }

        return redirect('/users');
    }

   
    public function destroy($idUsuario){        

        $respuesta = $this->realizarPeticion('DELETE', $this->urlBase."DeleteUsuario/{$idUsuario}");
        return $respuesta;
    }
    public function destroyPermisoUsuario($idUsuario, $idPermiso){

        $respuesta = $this->realizarPeticion('DELETE', $this->urlBasePermisosUsuario."DeletePermisoUsuario/{$idUsuario}/{$idPermiso}");
        $datos = json_decode($respuesta);

        $respuesta = $datos->mensaje; 
        return $respuesta;        
    }
}
