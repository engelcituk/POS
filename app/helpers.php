<?php

function activarRutaMenu($nombreRuta){

    return request()->routeIs($nombreRuta) ? 'active' : '';
}
function collapsarItemMenu($nombreRuta){

    return request()->routeIs($nombreRuta) ? 'in' : '';
}
