<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HotelesController extends Controller
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
        return view('hoteles');
    }

    public function AllHoteles()
    {
        $hoteles = $this->obtenerTodosLosHoteles();

        $acciones = 'hoteles.datatables.botones'; /*creo los botones de acciones en una vista*/
        return Datatables::of($hoteles)
            ->addColumn('acciones', $acciones)
            ->rawColumns(['acciones'])->make(true); /*Retorno los datos en un datatables y pinto los botones que obtengo de la vista*/
    }
    protected function obtenerTodosLosHoteles()
    {
        //es una funcion que esta en el controller principal
        $respuesta = $this->realizarPeticion('GET', 'https://api.myjson.com/bins/fy774');

        $datos = json_decode($respuesta);

        $hoteles = $datos->hoteles;

        return $hoteles;
    }
    protected function create()
    {
        return view('hoteles.partials.create');
    }
    public function show($id)
    {      
        $hotel = $id;

        return view('hoteles.partials.show', ['hotel' => $hotel]);
    }
    public function edit($id)
    {
        $hotel =$id;
        return view('hoteles.partials.edit',['hotel' => $hotel]);
    }
    public function store(Request $request)
    {

        $accessToken = 'Bearer ' . $this->obtenerAccessToken();

        $respuesta = $this->realizarPeticion('POST', 'https://apilumen.juandmegon.com/estudiantes', ['headers' => ['Authorization' => $accessToken], 'form_params' => $request->all()]);

        return redirect('/productos');
    }
}
