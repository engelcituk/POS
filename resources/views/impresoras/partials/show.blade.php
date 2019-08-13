@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('impresoras.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        @php
            $impresoraPermisoLeer= Session::get('Impresoras.leer');                         
        @endphp
        <div class="row">
            <div class="col-md-12">
                @if ($impresoraPermisoLeer==1)
                 <div class="card card-profile">
                    <div class="card-avatar">
                        <img class="img" src="{{asset('img/faces/impresora.jpg')}}">
                    </div>
                    <div class="card-content">                        
                        <h4 class="card-title"> <strong>Nombre impresora:</strong> {{$impresora->name}}</h4><br>
                        <h4 class="card-title"> <strong>IP impresora: </strong> {{$impresora->ipImpresora}}</h4><br>

                        @php
                        $estado= $impresora->status;//para obtener el estado de la zona
                        $resultadoEstado = ($estado == 1) ? "Activo" : "Desactivado";
                        @endphp
                        <h4 class="card-title"><strong>Estado:</strong> {{$resultadoEstado}}</h4><br>

                        <a href="{{ route('impresoras.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                    </div>
                </div>   
                @else
                    <div class="card">                    
                        <div class="card-content">
                            <div class="col-md-2 text-center">
                                <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                            </div>
                            <div class="col-md-10">
                                    <h3>Usted no cuenta con permiso para ver una impresora</h3>
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