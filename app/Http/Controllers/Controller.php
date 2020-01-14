<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use GuzzleHttp\Client;


class Controller extends BaseController
{
    // protected $apiService;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // public function __construct(ApiService $apiService){

    //     $this->apiService= $apiService;
    // }
    
    protected function realizarPeticion($metodo, $url, $parametros=[]){ //parametros es opcional
        
        $cliente =  new Client(['curl' => [CURLOPT_CAINFO =>base_path('resources/certs/cacert.pem')]]);

        $respuesta = $cliente->request($metodo, $url, $parametros);

        return $respuesta->getBody()->getContents();
    }

    protected function obtenerAccessToken(){
        $clientId = config('services.client_id');
        $clientSecret = config('services.client_id');
        $grantType = config('services.grant_type');

        $respuesta = json_decode($this->realizarPeticion('POST', 'https://apilumen.juandmegon.com/oauth/access_token', ['form_params' => ['grant_type' => $grantType, 'client_id' => $clientId, 'client_secret' => $clientSecret]]));
        $accessToken = $respuesta->access_token;
         
        return $accessToken;
    }

    protected function urlApiTPV(){

        $urlBase= "http://172.16.1.45/TPVApi/";
        
        return $urlBase;
    }
}
// http://172.16.1.45/TPVApi/
