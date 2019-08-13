@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('restaurantes.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                @php
                    $pvPermisoLeer= Session::get('PuntosVenta.leer');                                    
                @endphp
                @if ($pvPermisoLeer==1)
                  <div class="card card-profile">
                    <div class="card-avatar">
                        <img class="img" src="{{asset('img/faces/restaurante.png')}}">
                    </div>
                    <div class="card-content">
                        <h3 class="category text-black">Nombre del hotel: {{$hotel->name}}</h3>
                        <h4 class="card-title">{{$restaurante->name}}</h4>
                        <p class="description">
                           Descripcion:  {{$restaurante->descripcion}}
                        </p>
                        <a href="{{ route('restaurantes.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                    </div>
                </div>  
                @else
                    <div class="card">                    
                        <div class="card-content">
                            <div class="col-md-2 text-center">
                                <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                            </div>
                            <div class="col-md-10">
                                    <h3>Usted no cuenta con permiso para ver un punto de venta</h3>
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