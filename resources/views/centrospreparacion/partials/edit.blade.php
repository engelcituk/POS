@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        @php             
            $cpPermisoActualizar= Session::get('CentrosPreparacion.actualizar');                                      
        @endphp
        <a href="{{ route('centrospreparacion.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        @if ($cpPermisoActualizar==1)
            <form method="POST" action="{{ route('centrospreparacion.actualizar')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        {{-- {{ method_field('PUT') }} --}}
                        <input id="name" type="hidden" class="form-control" name="id" value="{{$centroPreparacion->id}}" required>
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fab fa-elementor"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre Centro de preparacion</label>
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$centroPreparacion->name}}" required autofocus>
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-utensils"></i>
                                        </span>
                                        <div class="form-group">
                                            <select class="form-control" name="idImpresora" required>
                                            <option value="{{$datosImpresoraCP->id}}">{{$datosImpresoraCP->name}}</option>
                                                @foreach($impresoras as $impresora)
                                                    <option value="{{$impresora->id}}">{{$impresora->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-utensils"></i>
                                        </span>
                                        <div class="form-group">
                                            <select class="form-control" name="idImpresoraB" required>
                                            <option value="{{$datosImpresoraCPB->id}}">{{$datosImpresoraCPB->name}}</option>
                                                @foreach($impresoras as $impresora)
                                                    <option value="{{$impresora->id}}">{{$impresora->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="radio">
                                            <strong>Estado</strong>
                                            @php
                                            $estado= $centroPreparacion->status;//para obtener el estado de la mesa
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="radio">
                                            <strong>Imprime</strong>
                                            @php
                                            $estado= $centroPreparacion->imprime;//para obtener el estado CP
                                            $radios = ($estado == 1) ?
                                            "<label><input type='radio' name='imprime' value='True' checked>Sí</label>
                                            <label><input type='radio' name='imprime' value='False'>No</label>" :
                                            "<label><input type='radio' name='imprime' value='True'>Si</label>
                                            <label><input type='radio' name='imprime' value='False' checked>No</label>";
                                            echo $radios;
                                            @endphp
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="radio">
                                            <strong>Comanda Completa</strong>
                                            @php
                                            $estado= $centroPreparacion->imprimeComanda;//para obtener el estado CP
                                            $radios = ($estado == 1) ?
                                            "<label><input type='radio' name='imprimeComanda' value='True' checked>Sí</label>
                                            <label><input type='radio' name='imprimeComanda' value='False'>No</label>" :
                                            "<label><input type='radio' name='imprimeComanda' value='True'>Si</label>
                                            <label><input type='radio' name='imprimeComanda' value='False' checked>No</label>";
                                            echo $radios;
                                            @endphp
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="comment">Descripcion:</label>
                                        <textarea class="form-control" rows="2" name="descripcion" required>{{$centroPreparacion->descripcion}}</textarea>
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
        @else
            <div class="card">                    
                <div class="card-content">
                    <div class="col-md-2 text-center">
                        <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                    </div>
                    <div class="col-md-10">
                            <h3>Usted no cuenta con permiso para editar un centro de preparación</h3>
                            <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                    </div>
                </div>                    
            </div>            
        @endif
        
    </div>
</div>
@endsection