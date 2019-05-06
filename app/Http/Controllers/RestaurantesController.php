<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RestaurantesController extends Controller
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
        return view('restaurantes');
    }

    public function AllRestaurantes()
    {
        $restaurantes = $this->obtenerTodosLosRestaurantes();

        $acciones = 'restaurantes.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($restaurantes)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    protected function obtenerTodosLosRestaurantes()
    {
        //es una funcion que esta en el controller principal
        $respuesta = $this->realizarPeticion('GET', 'https://api.myjson.com/bins/x80b0');

        $datos = json_decode($respuesta);

        $restaurantes = $datos->puntosVenta;

        return $restaurantes;
    }
    protected function create()
    {
        return view('restaurantes.partials.create');
    }
    public function show($id)
    {
        $restaurante = $id;

        return view('restaurantes.partials.show', ['restaurante' => $restaurante]);
    }
    public function edit($id)
    {
        $restaurante = $id;
        return view('restaurantes.partials.edit', ['restaurante' => $restaurante]);
    }
    public function store(Request $request)
    {

        $accessToken = 'Bearer ' . $this->obtenerAccessToken();

        $respuesta = $this->realizarPeticion('POST', 'https://apilumen.juandmegon.com/estudiantes', ['headers' => ['Authorization' => $accessToken], 'form_params' => $request->all()]);

        return redirect('/productos');
    }
}
