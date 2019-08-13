@extends('layouts.dashboard')
@section('content')
<div class="content"> 
    <div class="container-fluid">
        <a href="{{ route('impresoras.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        @php
            $impresoraPermisocrear= Session::get('Impresoras.crear');                         
        @endphp
        @if ($impresoraPermisocrear==1)
            <form method="POST" action="{{ route('impresoras.store')}}">
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
                                            <label class="control-label">Nombre Impresora</label>
                                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required autofocus>
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>|
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <!-- <i class="fas fa-map-pin"></i> -->
                                            <i class="fas fa-sort-numeric-up"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Ip Impresora</label>
                                            <input id="ipImpresora" type="text" class="form-control{{ $errors->has('ipImpresora') ? ' is-invalid' : '' }}" name="ipImpresora" required autofocus>
                                            <div id="mensajeIpValido"></div>
                                            @if ($errors->has('ipImpresora'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('ipImpresora') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Estado</strong>
                                        <div class="radio">
                                            <label><input type="radio" name="status" value="True" checked>Activado</label>
                                            <label><input type="radio" name="status" value="False">Desactivado</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- <small>En la api se registra el <cite title="idPuntoVenta">idPuntoVenta y status </cite></small> -->
                                <button class="btn btn-primary pull-right" id="btnGuardarImpresora"  class="fas fa-save"></i> {{ __('Guardar') }}</button>
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
                            <h3>Usted no cuenta con permiso para registrar una impresora</h3>
                            <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                    </div>
                </div>                    
            </div>  
        @endif        
    </div>
</div>
@endsection