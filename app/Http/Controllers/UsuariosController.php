<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsuariosController extends Controller
{
    
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('usuarios');
    }
    //Para obtener todos los usuarios y cargarlos en un datatable
    public function AllUser()
    {
        $usuarios=User::all();
        // $usuarios = User::paginate(100);
        // return view( "usuarios.index")->with("usuarios", $usuarios);
        // return view('usuarios', ['usuarios' => $usuarios]);

        // return Datatables::of($usuario)
        //     ->addColumn('actions', function($usuario){
        //           return '<a onclick="showData('.$usuario->id.')" class= "btn btn-sm btn-success"><i class="fas fa-info-circle"></i></a>'.' '.
        //                '<a onclick="editForm('.$usuario->id.')" class= "btn btn-sm btn-info"><i class="fas fa-edit"></i> </a>'.' '.
        //                '<a onclick="deleteData('.$usuario->id.')" class= "btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>';
        //     })->make(true);       
        $actions= 'usuarios.datatables.botones';
        return Datatables::of($usuarios)                          
                          ->addColumn('actions',$actions)
                          ->rawColumns(['actions'])->make(true);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data =[
        //     'name'=>$request['nombreCompleto'],
        //     'email'=>$request['email'],
        //     'password' => Hash::make($data['password']),
        // ];
        // return User::create($data);

        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);
        // return response()->json(['res'=> false]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario)
    {   
        //mando llamar mi archivo partial donde cargo los datos del usuario
        return view('usuarios.partials.show',compact('usuario'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = User::find($id);
        return view('usuarios.partials.edit', compact('usuario'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $usuario = User::find($id)->delete();
        return User::destroy($id);
        
    }        
}


