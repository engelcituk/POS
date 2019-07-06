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
                        {{-- {{ method_field('PUT') }} --}}
                        <input id="name" type="hidden" class="form-control" name="id" value="{{$carta->id}}" required>
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-6">
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
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-utensils"></i>
                                        </span>
                                        <div class="form-group">
                                            <select class="form-control" name="idPuntoVenta" required>
                                                <option value="{{$datosPV->id}}">{{$datosPV->name}}</option>
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
                                            <option value="{{$datosTurno->id}}">{{$datosTurno->turno}}</option>
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