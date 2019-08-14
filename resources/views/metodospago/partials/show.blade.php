@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $mpPermisoLeer= Session::get('MetodosPago.leer'); 
        @endphp
        <a href="{{ route('metodospago.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                @if ($mpPermisoLeer==1)
                    <div class="card card-profile">
                        <div class="card-content">                                                    
                            <div class="well well-sm">
                                <p>El nombre del metodoPago {{$metodoPago->name}}</p>
                            </div>
                            <div class="well well-sm">
                                <p>La descripcion es {{$metodoPago->descripcion}}</p>
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
                                    <h3>Usted no tiene permiso para ver un método de pago</h3>
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