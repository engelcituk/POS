@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('hoteles.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            @php
                $hotelPermisoLeer= Session::get('Hoteles.leer');                                                         
            @endphp
            @if ($hotelPermisoLeer==1)
                <div class="col-md-12">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <img class="img" src="{{asset('img/faces/hotel.png')}}">
                        </div>
                        <div class="card-content">
                            <h3 class="category text-black">Nombre del hotel: {{$hotel->name}}</h3><br>
                            <h4 class="card-title">Empresa: {{$hotel->empresa}}</h4><br>
                            <h4 class="card-title">Codigo de Hotel:  {{$hotel->codHotel}}</h4>
                            <a href="{{ route('hoteles.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">                    
                    <div class="card-content">
                      <div class="col-md-2 text-center">
                            <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                      </div>
                        <div class="col-md-10">
                                <h3>Usted no cuenta con permisos para ver un hotel</h3>
                                <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                        </div>
                    </div>                    
                </div>
            @endif
            
        </div>
    </div>
</div>
@endsection