<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ZonasController extends Controller
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
        return view('zonas');
    }

    public function AllZonas()
    {
        $zonas = $this->obtenerTodosLasZonas();

        $acciones = 'zonas.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($zonas)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    protected function obtenerTodosLasZonas()
    {
        //es una funcion que esta en el controller principal
        $respuesta = $this->realizarPeticion('GET', 'http://api.myjson.com/bins/zfiyk');

        $datos = json_decode($respuesta);

        $zonas = $datos->zonas;

        return $zonas;
    }
    protected function create()
    {
        return view('zonas.partials.create');
    }
    public function show($id)
    {
        $zona = $id;

        return view('zonas.partials.show', ['zona' => $zona]);
    }
    public function edit($id)
    {
        $zona = $id;
        return view('zonas.partials.edit', ['zona' => $zona]);
    }
    public function store(Request $request)
    {

        $accessToken = 'Bearer ' . $this->obtenerAccessToken();

        $respuesta = $this->realizarPeticion('POST', 'https://apilumen.juandmegon.com/estudiantes', ['headers' => ['Authorization' => $accessToken], 'form_params' => $request->all()]);

        return redirect('/productos');
    }
}
