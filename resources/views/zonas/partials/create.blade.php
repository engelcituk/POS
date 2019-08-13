@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $zonaPermisocrear= Session::get('Zonas.crear');                                    
        @endphp
        <a href="{{ route('zonas.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        @if ($zonaPermisocrear==1)
            <form method="POST" action="{{ route('zonas.store')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-file-signature"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre Zona</label>
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
                                            @if ($restaurantes!="")
                                             <select class="form-control" name="idPuntoVenta" required>
                                                <option value="">Seleccione punto de venta </option>                                    
                                                    @foreach($restaurantes as $restaurante)                                              
                                                    <option value="{{$restaurante->id}}">{{$restaurante->name}}</option>                  
                                                    @endforeach                                               
                                            </select>  
                                            @else
                                                <select class="form-control" name="idPuntoVenta" required>
                                                    <option value="">Aun no hay puntos de venta</option>                           
                                                </select> 
                                            @endif
                                            
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="comment">Descripcion:</label>
                                        <textarea class="form-control" rows="1" name="descripcion"></textarea>
                                    </div>
                                </div>
                                <!-- <small>En la api se registra el <cite title="idPuntoVenta">idPuntoVenta y status </cite></small> -->
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
                            <h3>Usted no cuenta con permiso para registrar una zona</h3>
                            <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                    </div>
                </div>                    
            </div>
        @endif        
    </div>
</div>
@endsection