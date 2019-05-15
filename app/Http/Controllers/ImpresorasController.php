<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ImpresorasController extends Controller
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
        return view('impresoras');
    }

    public function AllImpresoras()
    {
        $impresoras = $this->obtenerTodasLasImpresoras();

        $acciones = 'impresoras.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($impresoras)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    protected function obtenerTodasLasImpresoras()
    {
        //es una funcion que esta en el controller principal
        $respuesta = $this->realizarPeticion('GET', 'https://api.myjson.com/bins/qzffg');

        $datos = json_decode($respuesta);

        $impresoras = $datos->impresoras;

        return $impresoras; 
    }
    protected function create() 
    {
        return view('impresoras.partials.create');
    }
    public function show($id)
    {
        $impresora = $id;

        return view('impresoras.partials.show', ['impresora' => $impresora]);
    }
    public function edit($id)
    {
        $impresora = $id;
        return view('impresoras.partials.edit', ['impresora' => $impresora]);
    }
    public function store(Request $request)
    {

        $accessToken = 'Bearer ' . $this->obtenerAccessToken();

        $respuesta = $this->realizarPeticion('POST', 'https://apilumen.juandmegon.com/estudiantes', ['headers' => ['Authorization' => $accessToken], 'form_params' => $request->all()]);

        return redirect('/productos');
    }
}
