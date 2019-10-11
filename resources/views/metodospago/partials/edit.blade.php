@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $mpPermisoActualizar= Session::get('MetodosPago.actualizar'); 
        @endphp
        <a href="{{ route('metodospago.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">               
            @if ($mpPermisoActualizar==1)
                <div class="card card-profile">
                    <form method="POST" action="{{ route('metodospago.actualizar')}}">
                                @csrf
                                {{-- {{ method_field('PUT') }} --}}
                                <input id="name" type="hidden" class="form-control" name="id" value="{{$metodoPago->id}}" required>
                                <div class="card-content">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-money-bill"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Nombre metodo de pago</label>
                                                <input id="name" type="text" class="form-control" name="name" value="{{$metodoPago->name}}" required autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-file-signature"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Descripción</label>
                                                <input id="descripcion" type="text" class="form-control" name="descripcion" value="{{$metodoPago->descripcion}}" required>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <strong>Cargo habitacion</strong>
                                        <div class="radio">
                                            @php
                                            $conCargoHab= $metodoPago->cargoHab;//para obtener el estado de la impresora
                                            $radios = ($conCargoHab == 1) ?
                                            "<label><input type='radio' name='cargoHab' value='True' checked>Si</label>
                                            <label><input type='radio' name='cargoHab' value='False'>No</label>" :
                                            "<label><input type='radio' name='cargoHab' value='True'>Si</label>
                                            <label><input type='radio' name='cargoHab' value='False' checked>No</label>";
                                            echo $radios;
                                            @endphp
                                        </div>
                                    </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary pull-right"> <i class="fas fa-save"></i> {{ __('Guardar') }}</button>
                                </div>
                            </form>
                        </div>
                        @else
                            <div class="card">                    
                                <div class="card-content">
                                    <div class="col-md-2 text-center">
                                        <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                                    </div>
                                    <div class="col-md-10">
                                            <h3>Usted no tiene permiso para editar la información</h3>
                                            <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                                    </div>
                                </div>                    
                            </div>
                        @endif                    
                </div>
        </div>                
    </div>
</div>
@endsection