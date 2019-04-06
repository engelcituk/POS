<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Caffeinated\Shinobi\Models\Permission; 
use Caffeinated\Shinobi\Models\Role; /* Proveedor/nombreDelPaquete/CarpetaModelo/entidaRole o Archivo*/

class RolesController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
    }


    public function index()
    {
        return view('roles');
    }
    
    public function AllRole()
    {
        $roles = Role::all(); /*obtengo todos los usuarios*/

        $acciones = 'roles.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($roles)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); 
    }
   

    public function store(Request $request)
    {
        // $role = Role::create($request->all());
        // $role->permissions()->sync($request->get('permissions'));
        // return redirect()->route('roles.edit', $role->id)
        //     ->with('info', 'Rol guardado con éxito');
    }
    public function show(Role $role)
    {
        return view('roles.partials.show', compact('role')); /*mando llamar mi archivo partial donde cargo los datos del usuario*/
    }
    protected function create(array $data)
    {
        return Role::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    public function edit(Role $role) /*tambien funciona si le paso solo el $id como parametro */
    {
        // $role = Role::find($id);
        $roles = Role::get(); //obtengo todos los roles del usuario
        return view('roles.partials.edit', compact('role'));
        //compact es para enviar la variable usuario y roles
    }

    /*para actualizar los permisos del usuario*/
    public function update(Request $request, Role $role) /*tambien funciona si le paso solo el $id como parametro */
    {
        /*actualiza los datos del usuario*/
        $role->update($request->all());

        // actualiza los roles
        $role->roles()->sync($request->get('roles')); /*Se sincroniza con todo lo que le pasamos al controlador name="roles"*/

        return redirect()->route('roles.edit', $role->id);
    }

    public function destroy($id)
    {
        // $role = Role::find($id)->delete();
        return Role::destroy($id);
    }
}
