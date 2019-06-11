<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Collection;
use Alert;


// use Carbon\Carbon;


class ApiRolController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $urlBase = "http://localhost/TPVApi/Roles/";
    public $urlBaseRolPermisos = "http://localhost/TPVApi/PermisosRol/";
    
    public function index()
    {
        return view('apiroles');
    }

    public function AllApiRol()
    {
        $roles = $this->obtenerTodosLosRoles();

        $acciones = 'apiroles.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($roles)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    public function obtenerTodosLosRoles()
    {
        //es una funcion que esta en el controller principal        
        $respuesta = $this->realizarPeticion('GET', $this->urlBase . 'GetRoles');
        $datos = json_decode($respuesta);

        $roles = $datos->objeto;

        return $roles;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $listaPermisos = new PermisosController(); //para obtener los permisos
        $listaPermisos= $listaPermisos->obtenerTodosLosPermisos(); //los datos lo envio a la vista
        
        return view('apiroles.partials.create',['listaPermisos' => $listaPermisos]);
    }
    
    public function show($idRol){
    
        $rol = $this->obtenerUnRol($idRol);

        $permisos = new PermisosController(); //para obtener los permisos
        $permisos = $permisos->obtenerTodosLosPermisos(); //los datos lo envio a la vista

        $permisosRol = $this->obtenerPermisosPorRol($idRol);
        $permisosDelRol = collect($permisosRol); //lo convierto en una coleccion
        
        //del objeto PermisoRol me creo una colección con los idPermisos del rol
        $idPermisosRolColeccion = new Collection([]);
        foreach ($permisosDelRol as $permisoRol) {        
            $idPermisosRolColeccion->push($permisoRol->idPermiso);
        }
                
        return view('apiroles.partials.show', compact('rol', 'permisos', 'idPermisosRolColeccion'));
    }

    public function edit($id)
    {
        $idRol = $id;
        $rol = $this->obtenerUnRol($idRol);

        $permisos = new PermisosController(); //para obtener los permisos
        $permisos = $permisos->obtenerTodosLosPermisos(); //los datos lo envio a la vista

        $permisosRol = $this->obtenerPermisosPorRol($idRol);
        $permisosDelRol = collect($permisosRol); //lo convierto en una coleccion

        //del objeto PermisoRol me creo una colección con los idPermisos del rol
        $idPermisosRolColeccion = new Collection([]);
        foreach ($permisosDelRol as $permisoRol) {
            $idPermisosRolColeccion->push($permisoRol->idPermiso);
        }

        // dd($idPermisosColeccion);
       return view('apiroles.partials.edit',compact('rol', 'permisos','idPermisosRolColeccion'));        
    }
    
    public function obtenerUnRol($idRol)
    {
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetRol/{$idRol}");
        $datos = json_decode($respuesta);
        $rol = $datos->objeto;
        return $rol;
    }
    public function obtenerPermisosPorRol($idRol)
    {
        $respuesta = $this->realizarPeticion('GET', $this->urlBaseRolPermisos ."GetPermisosPorRol/{$idRol}");
        $datos = json_decode($respuesta);
        $permisosRol = $datos->objeto;
        return $permisosRol;
    }
    
    public function store(Request $request)
    {
        $arrayIdPermisos = $request->get('idPermiso'); //otengo el array(checkboxes) de permisos que se asignan a los roles
        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'AddRol', ['form_params' => $request->all()]);
        $datos = json_decode($respuesta);
        $respuestaObjeto = $datos->objeto; //obtengo la respuesta del la api con el rol creado

        $idRol = $respuestaObjeto->id;//obtengo el id del rol creado, para usar en el guardado de permisos
        // dd($arrayIdPermisos);
        foreach ($arrayIdPermisos as $idPermiso) {
            $this->guardarPermisosRol($idRol, $idPermiso);
        }

        Alert::success('Exito', 'El rol y sus permisos se han creado exitosamente');

        return redirect('/rolesapi');
    }
    
    public function guardarPermisosRol($idRol, $idPermiso){
        
        $respuesta = $this->realizarPeticion('POST', $this->urlBaseRolPermisos.'AddPermisosRol', [
            'form_params' => [
                'idRol' => $idRol,
                'idPermiso' => $idPermiso
            ]
        ]);
        return $respuesta;
    }
    
    public function actualizar(Request $request)
    {
        $idRol = $request->get('id');

        $respuesta = $this->realizarPeticion('PUT', $this->urlBase."UpdateRol/{$idRol}", ['form_params' => $request->except('id')]);

        return redirect('/rolesapi');
    }

    public function destroy($id)
    {
        $idRol = $id;
        $respuesta = $this->realizarPeticion('DELETE', $this->urlBase."DeleteRol/{$idRol}");
        return $respuesta;
    }
    public function destroyPermiso($idRol, $idPermiso){
        $respuesta = $this->realizarPeticion('DELETE', $this->urlBaseRolPermisos."DeletePermisoRol/{$idRol}/{$idPermiso}");

       return $respuesta;
    }
}
