<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MesasController extends Controller
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
        
        return view('mesas');
    }

    public function AllMesas()
    {
        $mesas = $this->obtenerTodosLasMesas();

        $acciones = 'mesas.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($mesas)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    protected function obtenerTodosLasMesas()
    {
        //es una funcion que esta en el controller principal
        $respuesta = $this->realizarPeticion('GET', 'https://api.myjson.com/bins/xy5nw');

        $datos = json_decode($respuesta);

        $mesas = $datos->mesas;

        return $mesas;
    }
    protected function create()
    {
        return view('mesas.partials.create');
    }
    public function show($id)
    {
        $mesa = $id;

        return view('mesas.partials.show', ['mesa' => $mesa]);
    }
    public function edit($id)
    {
        $mesa = $id;
        return view('mesas.partials.edit', ['mesa' => $mesa]);
    }
    public function store(Request $request)
    {

        $accessToken = 'Bearer ' . $this->obtenerAccessToken();

        $respuesta = $this->realizarPeticion('POST', 'https://apilumen.juandmegon.com/estudiantes', ['headers' => ['Authorization' => $accessToken], 'form_params' => $request->all()]);

        return redirect('/productos');
    }
}
