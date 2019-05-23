@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('cartas.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <form method="POST" action="{{ route('cartas.actualizar')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf                        
                        {{ method_field('PUT') }}
                        <input id="name" type="hidden" class="form-control" name="id" value="{{$carta->id}}" required>
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fab fa-elementor"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre de la carta</label>
                                        <input id="name" type="text" class="form-control" name="name" value="{{$carta->name}}" required autofocus>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-utensils"></i>
                                        </span>
                                        <div class="form-group">
                                            <select class="form-control" name="idTurno" required>
                                            <option value="{{$datosTurnoPV->id}}">Turno {{$datosTurnoPV->turno}}</option>
                                                @foreach($restaurantes as $restaurante)
                                                <optgroup label="{{$restaurante->name}}">
                                                    @foreach($turnos as $turno)
                                                        @php
                                                        $collection = collect(['idPV' =>$turno->idPuntoVenta, 'idPV' => $restaurante->id]);
                                                        $respuesta = $collection->contains($turno->idPuntoVenta);
                                                        @endphp
                                                            @if($respuesta==1)
                                                            <option value="{{$turno->id}}">Turno {{$turno->turno}}</option>
                                                            @endif
                                                    @endforeach
                                                </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="radio">
                                            @php
                                            $estado= $carta->status;//para obtener el estado de la impresora
                                            $radios = ($estado == 1) ?
                                            "<label><input type='radio' name='status' value='True' checked>Activado</label>
                                            <label><input type='radio' name='status' value='False'>Desactivado</label>" :
                                            "<label><input type='radio' name='status' value='True'>Activado</label>
                                            <label><input type='radio' name='status' value='False' checked>Desactivado</label>";
                                            echo $radios;
                                            @endphp
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 hidden">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fab fa-elementor"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Fecha</label>
                                            <input id="fechaAlta" type="text" class="form-control" name="fechaAlta" value="{{$carta->fechaAlta}}" readonly>
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
                                            <input id="horaAlta" type="text" class="form-control" name="horaAlta" value="{{$carta->horaAlta}}" readonly>
                                        </div>
                                    </div>
                                </div>
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