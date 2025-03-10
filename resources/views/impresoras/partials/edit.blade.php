@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('impresoras.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
         @php
            $impresoraPermisoActualizar= Session::get('Impresoras.actualizar');                         
        @endphp
        @if ($impresoraPermisoActualizar==1)
            <form method="POST" action="{{ route('impresoras.actualizar')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        {{-- {{ method_field('PUT') }} --}}
                        <input id="name" type="hidden" class="form-control" name="id" value="{{$impresora->id}}" required>
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-file-signature"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre Impresora</label>
                                            <input id="name" type="text" class="form-control" value="{{$impresora->name}}" name="name" required autofocus>
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
                                            <label class="control-label">Ip o nombre local impresora</label>                             
                                            <input id="ipImpresorax" type="text" class="form-control" name="ipImpresora" value="{{$impresora->ipImpresora}}" required autofocus>
                                            <div id="mensajeIpValido"></div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Estado</strong>
                                        <div class="radio">
                                            @php
                                            $estado= $impresora->status;//para obtener el estado de la impresora
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
                                        <strong>Local</strong>
                                        <div class="radio">
                                            @php
                                            $ImpresoraLocal= $impresora->local;//para obtener el local de la impresora
                                            $radios = ($ImpresoraLocal == 1) ?
                                            "<label><input type='radio' name='local' value='True' checked>Activado</label>
                                            <label><input type='radio' name='local' value='False'>Desactivado</label>" :
                                            "<label><input type='radio' name='local' value='True'>Activado</label>
                                            <label><input type='radio' name='local' value='False' checked>Desactivado</label>";
                                            echo $radios;
                                            @endphp
                                        </div>
                                    </div>
                                </div>
                                <!-- <small>En la api se registra el <cite title="idPuntoVenta">idPuntoVenta y status </cite></small> -->
                                <button type="submit" class="btn btn-primary pull-right"> <i class="fas fa-save"></i> {{ __('Guardar') }}</button>
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
                            <h3>Usted no cuenta con permiso para editar una impresora</h3>
                            <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                    </div>
                </div>                    
            </div>
        @endif        
    </div>
</div>
@endsection