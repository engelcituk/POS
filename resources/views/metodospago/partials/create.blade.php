@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $mpPermisocrear= Session::get('MetodosPago.crear');                         
        @endphp
        <a href="{{ route('metodospago.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        @if ($mpPermisocrear==1)
            <form method="POST" action="{{ route('metodospago.store')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-money-bill"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre metodo de pago</label>
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
                                            <i class="fas fa-file-signature"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Descripción</label>
                                            <input id="descripcion" type="text" class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }}" name="descripcion" required autofocus>
                                            @if ($errors->has('descripcion'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('descripcion') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
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
                            <h3>Usted no tiene permiso para registrar un metodo de pago</h3>
                            <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                    </div>
                </div>                    
            </div>
        @endif        
    </div>
</div>
@endsection