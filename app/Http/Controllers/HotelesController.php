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
        $respuesta = $this->realizarPeticion('GET', 'http://localhost/TPVApi/Hoteles/GetHoteles');

        $datos = json_decode($respuesta);

        $hoteles = $datos->objeto;

        return $hoteles;
    }
    protected function create()
    {
        return view('hoteles.partials.create');
    }
    public function show($id)
    {             
        $idHotel= $id;
        $hotel = $this->obtenerUnHotel($idHotel);
        return view('hoteles.partials.show',['hotel'=> $hotel]);
    }
    public function edit($id)
    {
        $idHotel = $id;
        $hotel = $this->obtenerUnHotel($idHotel);
        return view('hoteles.partials.edit',['hotel' => $hotel]);
    }    
    //metodo que se ocupara para obtener el dato de un hotel, se ocupa para show y edit
    protected function obtenerUnHotel($idHotel){
        $respuesta = $this->realizarPeticion('GET', "http://localhost/TPVApi/Hoteles/GetHotel/{$idHotel}");
        $datos = json_decode($respuesta);
        $hotel = $datos->objeto;
        return $hotel;
    }
    public function store(Request $request)
    {
        // $accessToken = 'Bearer ' . $this->obtenerAccessToken();
        $respuesta = $this->realizarPeticion('POST', 'http://localhost/TPVApi/Hoteles/AddHotel', ['form_params' => $request->all()]);

        return redirect('/hoteles');
    }

    public function actualizar(Request $request)
    {
        $idHotel= $request->get('id');

        $respuesta = $this->realizarPeticion('PUT', "http://localhost/TPVApi/Hoteles/UpdateHotel/{$idHotel}", ['form_params' => $request->except('id')]);
        return redirect('/hoteles');
    }
    public function destroy($id)
    {
        $idHotel = $id;
        $respuesta = $this->realizarPeticion('DELETE', "http://localhost/TPVApi/Hoteles/DeleteHotel/{$idHotel}");
        return redirect('/hoteles');
    }
}
