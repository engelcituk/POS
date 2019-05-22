@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('turnos.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <img class="img" src="{{asset('img/faces/hora.png')}}">
                    </div>
                    <div class="card-content">
                        <h3 class="category text-black"><strong>Nombre hotel:</strong> {{$hotelRestaurante->name}}</h3><br>
                        <h4 class="card-title"><strong>Punto de venta:</strong> {{$datosRestaurantePV->name}}</h4><br>
                        <h4 class="card-title"><strong>hora inicio: </strong>{{$turno->horaInicio}}</h4><br>

                        <h4 class="card-title"><strong>Turno: </strong> {{$turno->turno}}</h4><br>

                        <a href="{{ route('turnos.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection