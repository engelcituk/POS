@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $mesaPermisocrear= Session::get('Mesas.crear');                         
        @endphp
        <a href="{{ route('mesas.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        @if ($mesaPermisocrear==1)
        <form method="POST" action="{{ route('mesas.store')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        <div class="row">
                            <div class="card-content">
                                @if ($zonas!="")
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-grip-horizontal"></i>
                                            </span>
                                            <div class="form-group">
                                                <!-- <label for="sel1">Select list:</label> -->
                                                <select class="form-control" name="idZona" required>
                                                    <option value="">Seleccione zona para la mesa</option>
                                                    {{-- @foreach($restaurantes as $restaurante)
                                                    <optgroup label="{{$restaurante->name}}"> --}}
                                                        @foreach($zonas as $zona)
                                                        {{-- @php
                                                        $collection = collect(['idPV' => $zona->idPuntoVenta, 'idPV' => $restaurante->id]);
                                                        $respuesta = $collection->contains($zona->idPuntoVenta);
                                                        @endphp --}}
                                                        {{-- @if($respuesta==1) --}}
                                                        <option value="{{$zona->id}}">{{$zona->name}}</option>
                                                        {{-- @endif --}}
                                                        @endforeach
                                                    {{-- </optgroup>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </div>
                                    </div>    
                                @else 
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-grip-horizontal"></i>
                                            </span>
                                            <div class="form-group">
                                                <!-- <label for="sel1">Select list:</label> -->
                                                <select class="form-control" name="idZona" required>
                                                    <option value="">Aun no se tiene una lista de zonas</option>                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-file-signature"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre Mesa</label>
                                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required autofocus>
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">                                       
                                        <strong>Estado</strong>
                                        <div class="radio">
                                            <label><input type="radio" name="status" value="True" checked>Activado</label>
                                            <label><input type="radio" name="status" value="False">Desactivado</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- <small>En la api se registra el <cite title="idPuntoVenta">idZona y status </cite></small> -->
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
                            <h3>Usted no cuenta con permiso para registrar una mesa</h3>
                            <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                    </div>
                </div>                    
            </div>
        @endif        
    </div>
</div>
@endsection