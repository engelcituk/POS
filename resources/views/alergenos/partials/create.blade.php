@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $alergenoPermisocrear= Session::get('Alergenos.crear');                                                         
        @endphp
        <a href="{{ route('alergenos.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        @if ($alergenoPermisocrear==1)
            <form method="POST" action="{{ route('alergenos.store')}}" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-code"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre del alergeno</label>
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
                                            {{-- <i class="fas fa-file-image"></i> --}}
                                        </span>
                                        <div class="form-group">
                                             {{-- <label for="sel1">Subir icono:</label> --}}
                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                    <span class="btn btn-rose btn-round btn-file">
                                                        <span class="fileinput-new"> <i class="fas fa-file-image"></i> Subir icono</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" id="icono" name="icono" onchange="return fileValidation()"/>
                                                    </span>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <small>En la api se registra el <cite title="idPuntoVenta">fechaAlta/horaAlta/idReceta/status </cite></small> --}}
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
                            <h3>Usted no tiene permiso para registrar un alergeno</h3>
                            <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                    </div>
                </div>                    
            </div>
        @endif        
    </div>
</div>
@endsection