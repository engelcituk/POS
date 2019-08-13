@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        @php                                                                     
            $zonaPermisoLeer= Session::get('Zonas.leer');                                    
        @endphp
        <a href="{{ route('zonas.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                @if ($zonaPermisoLeer==1)
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <img class="img" src="{{asset('img/faces/zona.png')}}">
                        </div>
                        <div class="card-content">
                            <h3 class="category text-black"><strong>Nombre del hotel:</strong> {{$hotelRestaurante->name}}</h3><br>
                            <h4 class="card-title"><strong>Punto de venta:</strong> {{$datosRestaurantePV->name}}</h4><br>
                            <h4 class="card-title"><strong>Zona:</strong>{{$zona->name}}</h4><br>
                            @php
                            $estado= $zona->status;//para obtener el estado de la zona
                            $resultadoEstado = ($estado == 1) ? "Activo" : "Desactivado";
                            @endphp
                            <h4 class="card-title"><strong>Estado: </strong> {{$resultadoEstado}}</h4><br>
                            <p class="description">
                                <strong> Descripcion: {{$zona->descripcion}} </strong>
                            </p>
                            <a href="{{ route('zonas.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                        </div>
                    </div>
                @else
                    <div class="card">                    
                        <div class="card-content">
                            <div class="col-md-2 text-center">
                                <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                            </div>
                            <div class="col-md-10">
                                    <h3>Usted no tiene permiso para ver una impresora</h3>
                                    <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                            </div>
                        </div>                    
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</div>
@endsection