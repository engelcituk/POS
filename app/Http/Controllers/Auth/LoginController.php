<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;


class LoginController extends Controller
{
    public $urlBase = "http://172.16.4.229/TPVApi/Ingreso/";
    public $urlPuntoVenta = "http://172.16.4.229/TPVApi/PuntosVenta/";
    public $urlCartasPV= "http://172.16.4.229/TPVApi/Cartas/";

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
            //   $nombreCompleto = $item->name;
              $nombreDeUsuario = $item->usuario;
            }
            //variables de sesion que se ocupan tanto si es admin o usuario normal
            $request->session()->put('UsuarioLogueado', $nombreDeUsuario);
            $request->session()->put('idUsuarioLogueado', $idUsuario);
            $idUsuarioSesion = $request->session()->get('idUsuarioLogueado');//obtengo el id del usuario logueado

            if($nombreDeUsuario=="admin"){                
                $ruta = "hoteles";                                                
                /**Bloque que genera las sesiones de los permisos */
                $permisos = $this->obtenerListaPermisosUsuario($idUsuarioSesion);
                $count = count($permisos);                             
                if ($count > 0) {
                    $counter = 0;
                    foreach ($permisos as $permiso) {
                        $request->session()->put($permisos[$counter]["nombrePermiso"], ["idPermiso" => $permisos[$counter]["idPermiso"], "crear" => $permisos[$counter]["crear"], "leer" => $permisos[$counter]["leer"], "actualizar" => $permisos[$counter]["actualizar"], "borrar" => $permisos[$counter]["borrar"]]);
                        $counter++;
                    }
                }              
            }else{                
                $ruta = "ordenar";
                $request->session()->put('idHotel', $idHotel);                               
                $request->session()->put('idPuntoVenta', $idPuntoVenta);
                $request->session()->put('idCarta', $idCarta);
                /**Bloque que genera las sesiones de los permisos */                
                $permisos = $this->obtenerListaPermisosUsuario($idUsuarioSesion);
                $count = count($permisos);
                // $ruta = ($count>0) ? "ordenar" : "sinpermisos";
                if ($count > 0) {
                    $counter = 0;
                    foreach ($permisos as $permiso) {
                        $request->session()->put($permisos[$counter]["nombrePermiso"], ["idPermiso" => $permisos[$counter]["idPermiso"], "crear" => $permisos[$counter]["crear"], "leer" => $permisos[$counter]["leer"], "actualizar" => $permisos[$counter]["actualizar"], "borrar" => $permisos[$counter]["borrar"]]);
                        $counter++;
                    }
                } 
                /**Fin de bloque que genera las sesiones de los permisos */
            }               
            return  redirect($ruta);//lo redirijo a la ruta de acuerdo si es admin
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
    
    public function obtenerListaPermisosUsuario($idUsuario){

        $respuesta = app('App\Http\Controllers\ApiUsuarioController')->obtenerDatosPermisosUsuario($idUsuario);
        
        $permisos = json_decode($respuesta);
        $respuestaOk = $permisos->ok;

        if ($respuestaOk == true) {
            $listaPermisos = $permisos->objeto;
            foreach ($listaPermisos as $permiso) {
                $arrayPermisos[] = array('idPermiso' => $permiso->idPermiso,'nombrePermiso'=> $permiso->nombrePermiso,'crear' => $permiso->crear, 'leer' => $permiso->leer, 'actualizar' => $permiso->actualizar, 'borrar' => $permiso->borrar,);
            }
        } else {
            $arrayPermisos = array();
        }
        return $arrayPermisos;
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

        $usuario = $request->session()->get('UsuarioLogueado');
        $idUsuarioSesion = $request->session()->get('idUsuarioLogueado');
        
        $ruta="/";
        if($usuario=="admin"){
            $ruta="admin";
        }                              
        $permisos = $this->obtenerListaPermisosUsuario($idUsuarioSesion);//traigo la lista de permisos del usuario
        $count = count($permisos);//cuento los permisos
        if ($count > 0) {//si array es mayor a 0
            $counter = 0;
            foreach ($permisos as $permiso) { //ejecuto el foreach que borra todos los permisos               
                $request->session()->forget($permisos[$counter]["nombrePermiso"]);
                $counter++;
            }
            //despues de borrar todos los permisos de sesion, borro las otras variables de sesion restantes
            $request->session()->forget('idHotel');
            $request->session()->forget('UsuarioLogueado');
            $request->session()->forget('idUsuarioLogueado');
            $request->session()->forget('idPuntoVenta');
            $request->session()->forget('idCarta');
            $request->session()->forget('UsuarioAdmin');
        } else {            
            $request->session()->forget('sinPermisos');
        }        
        return redirect($ruta);
    }
}
