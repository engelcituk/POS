<?php

namespace App\Service;

use App\Traits\AuthorizesApiRequests;
use App\Traits\ConsumeExternalServices;
use App\Traits\InteractsWithApiServiceResponses;

class ApiService{
    
    use ConsumeExternalServices,AuthorizesApiRequests, InteractsWithApiServiceResponses;

    protected $baseUri;

    public function __construct(){
        
        $this->baseUri = config('services.tpvSandos.base_uri');
    }

    public function getProducts(){

        return $this->makeRequest('GET', 'products');
    }
    
}
