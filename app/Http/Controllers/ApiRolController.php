<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;


class ApiRolController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $urlBase = "http://localhost/TPVApi/Roles/";
    
    public function index()
    {
        return view('apiroles');
    }

    public function AllApiRoll()
    {
        $roles = $this->obtenerTodosLosRoles();

        $acciones = 'apiroles.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($roles)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    protected function obtenerTodosLosRoles()
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
    public function create()
    {
        //$fechaAlta = Carbon::now(); //ocupo carbon para obtener fecha actual
        
        return view('apiroles.partials.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){

        $idRol= $id;
        $rol = $this->obtenerUnRol($idRol);
        
        return view( 'apiroles.partials.show', ['rol' => $rol]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $idRol = $id;
        $rol = $this->obtenerUnRol($idRol);

       return view('apiroles.partials.edit', ['rol' => $rol]);        
    }
     
    public function obtenerUnRol($idRol)
    {
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetRol/{$idRol}");
        $datos = json_decode($respuesta);
        $rol = $datos->objeto;
        return $rol;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $respuesta = $this->realizarPeticion('POST', $this->urlBase . 'AddRol', ['form_params' => $request->all()]);

        return redirect('/rolesapi');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request)
    {
        $idRol = $request->get('id');

        $respuesta = $this->realizarPeticion('PUT', $this->urlBase . "UpdateRol/{$idRol}", ['form_params' => $request->except('id')]);

        return redirect('/rolesapi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $idRol = $id;
        $respuesta = $this->realizarPeticion('DELETE', $this->urlBase."DeleteRol/{$idRol}");
        return redirect('/rolesapi');
    }
}
