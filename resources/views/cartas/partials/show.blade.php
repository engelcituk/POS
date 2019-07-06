@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('cartas.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <img class="img" src="{{asset('img/faces/carta.png')}}">
                    </div>
                    <div class="card-content">
                        @php
                        $fechaAlta = $carta->fechaAlta;
                        $fechaAlta = substr($fechaAlta,0,10);
                        //para el estado de la carta
                        $estado= $carta->status;//para obtener el estado de la zona
                        $estado = ($estado == 1) ? "Activo" : "Desactivado";
                        @endphp
                        <h3 class="category text-black"><strong>Nombre hotel:</strong> {{$datosHotel->name}}</h3><br>
                        <h4 class="card-title"><strong>Punto de venta:</strong> {{$datosPV->name}}</h4><br>
                        <h4 class="card-title"><strong>Turno: </strong> {{$datosTurno->turno}}</h4><br>
                        <h4 class="card-title"><strong>Hora inicio turno: </strong>{{$datosTurno->horaInicio}}</h4><br>
                        <h4 class="card-title"><strong>Hora fin turno: </strong>{{$datosTurno->horaFin}}</h4><br>
                        <h4 class="card-title"><strong>Nombre Carta: </strong> {{$carta->name}}</h4><br>
                        <h4 class="card-title"><strong>Fecha alta Carta: </strong> {{$fechaAlta}}</h4><br>
                        <h4 class="card-title"><strong>Hora alta Carta: </strong>{{$carta->horaAlta}}</h4><br>
                        <h4 class="card-title"><strong>Estado: </strong>{{$estado}}</h4><br>


                        <a href="{{ route('cartas.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection