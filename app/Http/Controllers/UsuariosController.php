<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use App\User;
use Caffeinated\Shinobi\Models\Role;/* Proveedor/nombreDelPaquete/CarpetaModelo/entidaRole o Archivo*/

class UsuariosController extends Controller
{
    
    public function __construct()
    {
        // $this->middleware('auth');
    }

   
    public function index()
    {
        return view('usuarios');
    }
    //Para obtener todos los usuarios y cargarlos en un datatable
    public function AllUser()
    {
        $usuarios=User::all();/*obtengo todos los usuarios*/
              
        $actions= 'usuarios.datatables.botones';/*creo los botones de acciones en una vista*/
        return Datatables::of($usuarios)                          
                          ->addColumn('actions',$actions)
                          ->rawColumns(['actions'])->make(true);/*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/

    }
    protected function create()
    {
        // $permissions = Permission::get();
        return view('usuarios.partials.create', compact('permissions'));
    }
    public function show(User $usuario)
    {           
        return view('usuarios.partials.show',compact('usuario'));/*mando llamar mi archivo partial donde cargo los datos del usuario*/
    }
 
    public function edit(User $usuario) /*tambien funciona si le paso solo el $id como parametro */
    {
        // $usuario = User::find($id);
        $roles = Role::get();//obtengo todos los roles del usuario
        return view('usuarios.partials.edit', compact('usuario','roles'));
        //compact es para enviar la variable usuario y roles
    }

    /*para actualizar los permisos del usuario*/
    public function update(Request $request,User $usuario) /*tambien funciona si le paso solo el $id como parametro */
    {
        /*actualiza los datos del usuario*/        
        $usuario->update($request->all());
        
        // actualiza los roles
        $usuario->roles()->sync($request->get('roles'));/*Se sincroniza con todo lo que le pasamos al controlador name="roles"*/
        
        return redirect()->route('usuarios.edit', $usuario->id);
    }

    public function destroy($id)
    {
        // $usuario = User::find($id)->delete();
        return User::destroy($id);
        
    }        
}


