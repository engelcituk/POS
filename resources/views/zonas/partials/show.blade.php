@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('zonas.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <img class="img" src="{{asset('img/faces/zona.png')}}">
                    </div>
                    <div class="card-content">
                        <h3 class="category text-black">Hotel al que pertenece: {{$hotelRestaurante->name}}</h3><br>
                        <h4 class="card-title">Pertenece al punto de venta : {{$datosRestaurantePV->name}}</h4><br>
                        <h4 class="card-title">Nombre de la zona : {{$zona->name}}</h4><br>
                            @php
                            $estado= $zona->status;//para obtener el estado de la zona
                            $resultadoEstado = ($estado == 1) ? "Activo" : "Desactivado";
                            @endphp
                        <h4 class="card-title">Estado : {{$resultadoEstado}}</h4><br>
                        <p class="description">
                            <strong> Descripcion: {{$zona->descripcion}} </strong>
                        </p>
                        <a href="{{ route('zonas.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection