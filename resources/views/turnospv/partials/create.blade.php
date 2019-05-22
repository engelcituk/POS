@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('turnos.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <form method="POST" action="{{ route('turnos.store')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-utensils"></i>
                                        </span>
                                        <div class="form-group">
                                            <select class="form-control" name="idPuntoVenta" required>
                                                <option value="">Seleccione PV para el turno </option>
                                                @foreach($hoteles as $hotel)
                                                <optgroup label="{{$hotel->name}}">
                                                    @foreach($restaurantes as $restaurante)
                                                    @php
                                                    $collection = collect(['idHotel' => $restaurante->idHotel, 'idHotel' => $hotel->id]);
                                                    $respuesta = $collection->contains($restaurante->idHotel);
                                                    @endphp
                                                    @if($respuesta==1)
                                                    <option value="{{$restaurante->id}}">{{$restaurante->name}}</option>
                                                    @endif
                                                    @endforeach
                                                </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Hora inicio en formato 24:00 hrs</label>
                                            <input id="horaInicio" type="text" class="form-control{{ $errors->has('horaInicio') ? ' is-invalid' : '' }}" name="horaInicio" required autofocus>
                                            @if ($errors->has('horaInicio'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('horaInicio') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-outdent"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Turno</label>
                                            <input id="turnoPV" type="number" min="1" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="turno" required autofocus>
                                            @if ($errors->has('turno'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('turno') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- <small>En la api se registar el <cite title="idHotel">idHotel</cite></small> -->
                                <button type="submit" class="btn btn-primary pull-right">{{ __('Guardar') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection