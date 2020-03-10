@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        @php             
            $zonaPermisoActualizar= Session::get('Zonas.actualizar');                                      
        @endphp
        <a href="{{ route('centrosprod.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        @if ($zonaPermisoActualizar==1)
            <form method="POST" action="{{ route('centrosprod.actualizar')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        {{-- {{ method_field('PUT') }} --}}
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
                                                    @foreach($restaurantes as $restaurante)
                                                                                                      
                                                    <option value="{{$restaurante->id}}">{{$restaurante->name}}</option>                             
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
        @else
            <div class="card">                    
                <div class="card-content">
                    <div class="col-md-2 text-center">
                        <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                    </div>
                    <div class="col-md-10">
                        <h3>Usted no tiene permiso para editar una zona</h3>
                        <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                    </div>
                </div>                    
            </div>            
        @endif        
    </div>
</div>
@endsection