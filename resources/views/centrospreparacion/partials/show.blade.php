@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('centrospreparacion.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <img class="img" src="{{asset('img/faces/cocina.png')}}">
                    </div>
                    <div class="card-content">                                                                                       
                        <h4 class="card-title"><strong>Nombre Centro preparación: </strong>{{$centroPreparacion->name}} </h4><br>
                        <h4 class="card-title"><strong>Nombre impresora: </strong> {{$datosImpresoraCP->name}}</h4>
                        <h4 class="card-title"><strong>Ip impresora: </strong> {{$datosImpresoraCP->ipImpresora}}</h4><br> 
                        <h4 class="card-title"><strong>Descripción Centro Preparación: </strong> {{$centroPreparacion->descripcion}}</h4><br>
                        @php
                            $estado= $centroPreparacion->status;//para obtener el estado de la zona
                            $estado = ($estado == 1) ? "Activo" : "Desactivado";
                        @endphp
                        <h4 class="card-title"><strong>Estado: </strong> {{$estado}}</h4><br>


                        <a href="{{ route('centrospreparacion.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection