<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MetodosPagoController extends Controller
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
        return view('metodospago');
    }
    public function AllMetodosPago()
    {
        $metodosPago = $this->obtenerTodosLosMetodosPagos();

        $acciones = 'metodospago.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($metodosPago)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    protected function obtenerTodosLosMetodosPagos()
    {
        //es una funcion que esta en el controller principal
        $respuesta = $this->realizarPeticion('GET', 'https://api.myjson.com/bins/1bayb0');

        $datos = json_decode($respuesta);

        $metodosPago = $datos->metodospago;

        return $metodosPago;
    }
    protected function create()
    {
        return view('metodospago.partials.create');
    }
    public function show($id)
    {
        $metodosPago = $id;

        return view('metodospago.partials.show', ['metodosPago' => $metodosPago]);
    }
    public function edit($id)
    {
        $metodosPago = $id;
        return view('metodospago.partials.edit', ['metodosPago' => $metodosPago]);
    }
    public function store(Request $request)
    {

        $accessToken = 'Bearer ' . $this->obtenerAccessToken();

        $respuesta = $this->realizarPeticion('POST', 'https://apilumen.juandmegon.com/estudiantes', ['headers' => ['Authorization' => $accessToken], 'form_params' => $request->all()]);

        return redirect('/productos');
    }
}
