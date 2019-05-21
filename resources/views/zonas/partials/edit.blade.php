@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('zonas.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <form method="POST" action="{{ route('zonas.actualizar')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        {{ method_field('PUT') }}
                        <input id="name" type="hidden" class="form-control" name="id" value="{{$zona->id}}" required>
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-file-signature"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre Zona</label>
                                            <input id="name" type="text" class="form-control" name="name" value="{{$zona->name}}" required autofocus>
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
                                                <option value="{{$datosRestaurantePV->id}}">{{$datosRestaurantePV->name}}</option>
                                                @foreach($hoteles as $hotel)
                                                <optgroup label="{{$hotel->name}}">
                                                    @foreach($restaurantes as $restaurante)
                                                    @php
                                                    $coleccion = collect(['idHotel' => $restaurante->idHotel, 'idHotel' => $hotel->id]);
                                                    $respuesta = $coleccion->contains($restaurante->idHotel);
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
                                <div class="col-md-6">
                                    <strong>Estado</strong>
                                    <div class="form-group">
                                        <div class="radio">
                                            @php
                                            $estado= $zona->status;//para obtener el estado de la zona
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="comment">Descripcion:</label>
                                        <textarea class="form-control" rows="1" name="descripcion">{{$zona->descripcion}}</textarea>
                                    </div>
                                </div>
                                <!-- <small>En la api se registra el <cite title="idPuntoVenta">idPuntoVenta y status </cite></small> -->
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