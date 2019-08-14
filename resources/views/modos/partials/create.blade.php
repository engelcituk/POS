@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $modoPermisocrear= Session::get('Modos.crear');                         
        @endphp
        <a href="{{ route('modos.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        @if ($modoPermisocrear==1)
            <form method="POST" action="{{ route('modos.store')}}">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-profile">
                            @csrf
                            <div class="row">
                                <div class="card-content">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="descripcion">Descripcion:</label>
                                                <textarea class="form-control" rows="1" name="descripcion"></textarea>
                                            <span class="material-input"></span>
                                        </div>                                                                      
                                    </div>
                                    {{-- <small>En la api se registra el <cite title="idPuntoVenta">fechaAlta/horaAlta</cite></small> --}}
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
                            <h3>Usted no tiene permiso para registrar modos de preparación</h3>
                            <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                    </div>
                </div>                    
            </div>
        @endif        
    </div>
</div>
@endsection