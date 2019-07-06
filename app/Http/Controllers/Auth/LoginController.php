<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;


class LoginController extends Controller
{
    public $urlBase = "http://localhost/TPVApi/Ingreso/";
    public $urlPuntoVenta = "http://localhost/TPVApi/PuntosVenta/";
    public $urlCartasPV= "http://localhost/TPVApi/Cartas/";

    public function login(Request $request){
        
        //variables para crear sesiones a nivel hotel,pv,carta
        $idHotel= $request->get('idHotel'); 
        $idPuntoVenta = $request->get('listaPuntosVenta');
        $idCarta = $request->get('listaCartas');
        
        //para crear sesion del usuario, datos del usuario
        $usuario = $request->get('usuario');
        $password = $request->get('password');
      
        $respuesta = $this->ingresoUsuario($usuario, $password);
        $respuestaOk = $respuesta->ok;

        if ($respuestaOk == true) {
            $usuario = $respuesta->objeto;

            foreach ($usuario as $item) {
              $idUsuario= $item->id;
              $nombreCompleto = $item->name;
              $nombreDeUsuario = $item->usuario;
            }

            $request->session()->put('idHotel', $idHotel);
            $request->session()->put('UsuarioLogueado', $nombreDeUsuario);
            $request->session()->put('idUsuarioLogueado', $idUsuario);
            $request->session()->put('idPuntoVenta', $idPuntoVenta);
            $request->session()->put('idCarta', $idCarta);
            // $usuarioSesion = $request->session()->get('UsuarioLogueado'); 
                     
            return  redirect('ordenar');
        }         
        return back()->withErrors(['usuario'=>'Estas credenciales no coinciden con nuestros registros']);
    }

    public function ingresoUsuario($usuario, $password){       

        $respuesta = $this->realizarPeticion('POST', $this->urlBase.'login', [
            'form_params' => [
                'username' => $usuario,
                'password' => $password
            ]
        ]);       
        $respuesta = json_decode($respuesta);        
        return $respuesta;
    }

    public function obtenerPuntosVenta($idHotel){
        $respuesta = $this->realizarPeticion('GET', $this->urlPuntoVenta."GetPuntosVentaPorHotel/{$idHotel}");        
        return $respuesta;
    }
    public function obtenerCartasPuntosVenta($idPuntoVenta){
        $respuesta = $this->realizarPeticion('GET', $this->urlCartasPV."GetCartasPV/{$idPuntoVenta}");
        return $respuesta;
    }
    public function logout(Request $request){

        // $usuario = $request->get('UsuarioLogueado');
        //$usuarioLogueado = $request->session()->get('UsuarioLogueado');
        // $password = $request->get('password');
        // dd($usuarioLogueado);
        $request->session()->forget('idHotel');
        $request->session()->forget('UsuarioLogueado');
        $request->session()->forget('idUsuarioLogueado');
        $request->session()->forget('idPuntoVenta');
        $request->session()->forget('idCarta');
        
        
        return redirect('/');
    }
}
