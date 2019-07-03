<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;


class LoginController extends Controller
{
    public $urlBase = "http://localhost/TPVApi/Ingreso/";
    public $urlPuntoVenta = "http://localhost/TPVApi/PuntosVenta/";

    public function login(Request $request){
 
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

            $request->session()->put('UsuarioLogueado', $nombreDeUsuario);
            $request->session()->put('idUsuarioLogueado', $idUsuario);
            $request->session()->put('idPuntoVenta', 10);
            $request->session()->put('idCarta', 1034);
            // $usuarioSesion = $request->session()->get('UsuarioLogueado'); 
                     
            return  redirect('ordenar');
        }         
        return back()->withErrors(['usuario'=>'Estas credenciales no coinciden con nuestros registros']);
    }

    public function ingresoUsuario($usuario, $password){
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."{$usuario}/{$password}");
        $respuesta = json_decode($respuesta);        
        return $respuesta;
    }

    public function obtenerPuntosVenta($idHotel){
        $respuesta = $this->realizarPeticion('GET', $this->urlPuntoVenta."GetPuntosVentaPorHotel/{$idHotel}");        
        return $respuesta;
    }
    public function logout(Request $request){

        // $usuario = $request->get('UsuarioLogueado');
        //$usuarioLogueado = $request->session()->get('UsuarioLogueado');
        // $password = $request->get('password');
        // dd($usuarioLogueado);
        $request->session()->forget('UsuarioLogueado');
        $request->session()->forget('idUsuarioLogueado');
        $request->session()->forget('idPuntoVenta');
        $request->session()->forget('idMenuCarta');

        
        return redirect('/');
    }
}
