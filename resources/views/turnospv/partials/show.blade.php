@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        @php                                                                    
            $turnoPermisoLeer= Session::get('TurnosPV.leer');                         
        @endphp
        <a href="{{ route('turnos.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                @if ($turnoPermisoLeer==1)
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <img class="img" src="{{asset('img/faces/hora.png')}}">
                        </div>
                        <div class="card-content">
                            
                            <h4 class="card-title"><strong>Hora inicio: </strong>{{$turno->horaInicio}}</h4><br>
                            <h4 class="card-title"><strong>Hora fin: </strong>{{$turno->horaInicio}}</h4><br>

                            <h4 class="card-title"><strong>Turno: </strong> {{$turno->turno}}</h4><br>

                            <a href="{{ route('turnos.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                        </div>
                </div>
                @else
                   <div class="card">                    
                        <div class="card-content">
                        <div class="col-md-2 text-center">
                                <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                        </div>
                            <div class="col-md-10">
                                <h3>Usted no cuenta con permisos para ver un turno</h3>
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