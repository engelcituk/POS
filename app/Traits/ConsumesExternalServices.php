<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait ConsumeExternalServices{

/* los parametros que ocupa esta funcion,  requeridos u opcionales
    *el metodo http
    *la url de esa peticion
    *los queryparams que van luego de ? 
    *los formparams o cuerpos de una peticion por ejemplo para peticiones post
    *cabeceras
*/
    public function makeRequest($method, $requestUrl, $queryParams = [], $formParams = [], $headers = []){
        
        $client = new Client([
            'base_uri' => $this->baseUri,            
        ]);
        
        if(method_exists($this, 'resolveAuthorization')){
            $this->resolveAuthorization($queryParams, $formParams, $headers);
        }

        $response = $client ->request($method, $requestUrl,[
            'query' => $queryParams,
            'form_params' => $formParams,
            'headers'=>$headers,
        ]);

        $response = $response ->getBody()->getContents();
        
        if (method_exists($this, 'decodeResponse')) {            
            $response = $this->decodeResponse($response);
        }

        if (method_exists($this, 'checkIfErrorResponse')) {
            $this->checkIfErrorResponse($response);
        }
        return $response;
    }
}