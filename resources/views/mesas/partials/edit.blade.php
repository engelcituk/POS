@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        @php           
            $mesaPermisoActualizar= Session::get('Mesas.actualizar');                                      
        @endphp
        <a href="{{ route('mesas.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        @if ($mesaPermisoActualizar==1)
            <form method="POST" action="{{ route('mesas.actualizar')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        {{-- {{ method_field('PUT') }} --}}
                        <input id="name" type="hidden" class="form-control" name="id" value="{{$mesa->id}}" required>
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-grip-horizontal"></i>
                                        </span>
                                        <div class="form-group">
                                            <!-- <label for="sel1">Select list:</label> -->
                                            <select class="form-control" name="idZona" required>
                                                <option value="{{$datosZonaMesa->id}}">{{$datosZonaMesa->name}}</option>
                                                {{-- @foreach($restaurantes as $restaurante)
                                                <optgroup label="{{$restaurante->name}}"> --}}
                                                    @foreach($zonas as $zona)
                                                    {{-- @php
                                                    $collection = collect(['idPV' => $zona->idPuntoVenta, 'idPV' => $restaurante->id]);
                                                    $respuesta = $collection->contains($zona->idPuntoVenta);
                                                    @endphp
                                                    @if($respuesta==1) --}}
                                                    <option value="{{$zona->id}}">{{$zona->name}}</option>
                                                    {{-- @endif --}}
                                                    @endforeach
                                                {{-- </optgroup>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-file-signature"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre Mesa</label>
                                            <input id="name" type="text" class="form-control" name="name" value="{{$mesa->name}}" required autofocus>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Estado</strong>
                                        <div class="radio">
                                            @php
                                            $estado= $mesa->status;//para obtener el estado de la mesa
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
                            <h3>Usted no tiene permiso para editar una mesa</h3>
                            <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                    </div>
                </div>                    
            </div>
        @endif
        
    </div>
</div>
@endsection