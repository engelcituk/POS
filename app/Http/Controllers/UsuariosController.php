<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
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
    //Para obtener todos los usuarios
    public function AllUser()
    {
       $usuario=User::all();
       
       return Datatables::of($usuario)
        ->addColumn('action', function($usuario){
            return '<a onclick="showData('.$usuario->id. ')" class="btn btn-sm btn-success"><i class="fas fa-info-circle"></i></a>'.' '.
                   '<a onclick="editForm('.$usuario->id. ')" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> </a>'.' '.
                   '<a onclick="deleteData('.$usuario->id. ')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>';
        })->make(true);
    }    
}


