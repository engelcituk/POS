<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsuariosController extends Controller
{
    //
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
        $usuario=User::all() ;

        // return Datatables::of($usuario)
        //     ->addColumn('actions', function($usuario){
        //           return '<a onclick="showData('.$usuario->id.')" class= "btn btn-sm btn-success"><i class="fas fa-info-circle"></i></a>'.' '.
        //                '<a onclick="editForm('.$usuario->id.')" class= "btn btn-sm btn-info"><i class="fas fa-edit"></i> </a>'.' '.
        //                '<a onclick="deleteData('.$usuario->id.')" class= "btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>';
        //     })->make(true);
        $enlaces= '<a href="home">h</a>';
        $actions= 'usuarios.datatables.botones';/**Tengo 
        una vista con botones de acciones */
        return Datatables::of($usuario)
                          ->addColumn('enlaces', $enlaces)
                          ->addColumn('actions',$actions)
                          ->rawColumns(['enlaces','actions'])->make(true);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =[
            'name'=>$request['nombreCompleto'],
            'email'=>$request['email'],
            'password' => Hash::make($data['password']),
        ];
        return User::create($data);

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
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }        
}


