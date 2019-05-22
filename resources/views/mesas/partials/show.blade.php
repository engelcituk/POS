@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('mesas.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <img class="img" src="{{asset('img/faces/mesa.jpg')}}">
                    </div>
                    <div class="card-content">
                        <h3 class="category text-black"><strong>Nombre del hotel:</strong> {{$hotelRestaurante->name}} </h3><br>
                        <h4 class="card-title"> <strong>Punto de venta:</strong> {{$datosRestaurantePV->name}}</h4><br>
                        <h4 class="card-title"> <strong>Zona:</strong> {{$datosZonaMesa->name}}</h4><br>
                        <h4 class="card-title"> <strong>Nombre:</strong> {{$mesa->name}}</h4><br>
                        @php
                        $estado= $mesa->status;//para obtener el estado de la zona
                        $resultadoEstado = ($estado == 1) ? "Activo" : "Desactivado";
                        @endphp
                        <h4 class="card-title"><strong>Estado:</strong> {{$resultadoEstado}}</h4><br>

                        <a href="{{ route('mesas.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection