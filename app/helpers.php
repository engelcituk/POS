<?php

function activarRutaMenu($nombreRuta){

    return request()->routeIs($nombreRuta) ? 'active' : '';
}
function collapsarItemMenu($nombreRuta){

    return request()->routeIs($nombreRuta) ? 'in' : '';
}
function rutaApi(){
    $ruta = "http://10.10.99.18/TPVApi";

    return  ['ruta' => $ruta];    
}