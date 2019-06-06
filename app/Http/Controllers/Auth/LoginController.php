<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;


class LoginController extends Controller
{
    public $urlBase = "http://localhost/TPVApi/Ingreso/";

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
            $usuarioSesion = $request->session()->get('UsuarioLogueado'); 
                     
            return  redirect('ordenar');
        }         
        return back()->withErrors(['usuario'=>'Estas credenciales no coinciden con nuestros registros']);
    }

    public function ingresoUsuario($usuario, $password){
        $respuesta = $this->realizarPeticion('GET', $this->urlBase."{$usuario}/{$password}");
        $respuesta = json_decode($respuesta);        
        return $respuesta;
    }
}
