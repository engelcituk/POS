@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('cartas.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <form method="POST" action="{{ route('cartas.store')}}">
            <div class="row">
                <div class="col-md-12"> 
                    <div class="card card-profile">
                        @csrf
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fab fa-elementor"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre de la carta</label>
                                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required autofocus>
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-utensils"></i>
                                        </span>
                                        <div class="form-group">
                                            <select class="form-control" name="idPuntoVenta" required>
                                                <option value="">Seleccione PV para la carta</option>
                                                @foreach($restaurantes as $restaurante)         
                                                    <option value="{{$restaurante->id}}"> {{$restaurante->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-utensils"></i>
                                        </span>
                                        <div class="form-group">
                                            <select class="form-control" name="idTurno" required>
                                                <option value="">Seleccione turno para la carta</option>
                                                @foreach($turnos as $turno)         
                                                    <option value="{{$turno->id}}"> {{$turno->turno}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="radio">
                                            <strong>Estado</strong>
                                            <label><input type="radio" name="status" value="True" checked>Activado</label>
                                            <label><input type="radio" name="status" value="False">Desactivado</label>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-4 hidden">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fab fa-elementor"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Fecha</label>
                                            <input id="fechaAlta" type="text" class="form-control" name="fechaAlta" value="{{$fechaAlta}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 hidden">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fab fa-elementor"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Hora</label>
                                            <input id="horaAlta" type="text" class="form-control" name="horaAlta" value="{{$horaAlta}}" readonly>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- <small>En la api se registar el <cite title="idHotel">idHotel</cite></small> -->
                                <button type="submit" class="btn btn-primary pull-right"> <i class="fas fa-save"></i> {{ __('Guardar') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection