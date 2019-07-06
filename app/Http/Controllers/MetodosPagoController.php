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
    public $urlBase = "http://localhost/TPVApi/MetodosPago/";
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
    public function obtenerTodosLosMetodosPagos(){
        //es una funcion que esta en el controller principal
        $respuesta = $this->realizarPeticion('GET', $this->urlBase.'GetMetodosPago');

        $datos = json_decode($respuesta);

        $metodosPago = $datos->objeto;

        return $metodosPago;
    }
    protected function create()
    {
        return view('metodospago.partials.create');
    }
    
    public function show($id)
    {
        $idMetodoPago = $id;
        $metodoPago = $this->obtenerUnMetodoPago($idMetodoPago);

        return view('metodospago.partials.show', ['metodoPago' => $metodoPago]);
    }
    public function edit($id)
    {
        $idMetodoPago = $id;
        $metodoPago = $this->obtenerUnMetodoPago($idMetodoPago);
        return view('metodospago.partials.edit', ['metodoPago' => $metodoPago]);
    }
     
    //metodo que se ocupa para obtener el dato de un metodo de pago, se usa para show y edit
    protected function obtenerUnMetodoPago($idMetodoPago)
    {
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."GetMetodoPago/{$idMetodoPago}");
        $datos = json_decode($respuesta);
        $hotel = $datos->objeto;
        return $hotel;
    }
    public function store(Request $request)
    {        
        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'AddMetodoPago', ['form_params' => $request->all()]);

        return redirect('/metodospago');
    }
    public function actualizar(Request $request)
    {
        $idMetodoPago = $request->get('id');
        $respuesta = $this->realizarPeticion('POST', $this->urlBase."UpdateMetodoPago/{$idMetodoPago}", ['form_params' => $request->except('id')]);
        return redirect('/metodospago');
    }
    
    public function destroy($idMetodoPago){        

        $respuesta = $this->realizarPeticion('POST', $this->urlBase."DeleteMetodoPago/{$idMetodoPago}");
        return redirect( '/metodospago');
    }
}
 
