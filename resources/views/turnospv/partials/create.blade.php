@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $turnoPermisocrear= Session::get('TurnosPV.crear');                    
        @endphp
        <a href="{{ route('turnos.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        @if ($turnoPermisocrear==1)
             <form method="POST" action="{{ route('turnos.store')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        <div class="row">
                            <div class="card-content">                                
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Hora inicio en formato 24:00 hrs</label>
                                            <input id="horaInicio" type="text" class="form-control{{ $errors->has('horaInicio') ? ' is-invalid' : '' }}" name="horaInicio" required >
                                            @if ($errors->has('horaInicio'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('horaInicio') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Hora fin en formato 24:00 hrs</label>
                                            <input id="horaFin" type="text" class="form-control{{ $errors->has('horaFin') ? ' is-invalid' : '' }}" name="horaFin" required >
                                            @if ($errors->has('horaFin'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('horaFin') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-outdent"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Turno</label>
                                            <input id="turnoNumber" type="number" min="1" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="turno" required>
                                            @if ($errors->has('turno'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('turno') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- <small>En la api se registar el <cite title="idHotel">idHotel</cite></small> -->
                                <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-save"></i> {{ __('Guardar') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @else
           <div class="card">                    
                <div class="card-content">
                    <div class="col-md-2 text-center">
                        <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                    </div>
                    <div class="col-md-10">
                            <h3>Usted no cuenta con permisos para crear un turno</h3>
                            <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                    </div>
                </div>                    
            </div> 
        @endif
       
    </div>
</div>
@endsection