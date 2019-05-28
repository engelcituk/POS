@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('rolesapi.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <form method="POST" action="{{ route('rolesapi.store')}}">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">create</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre Rol</label>
                                            <input id="nameRol" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required autofocus>
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
                                            <i class="material-icons">create</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Descripción</label>
                                            <input id="descripcionRol" type="text" class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }}" name="descripcion" required>                                            
                                            @if ($errors->has('descripcion'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('descripcion') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div> 
                                <h4>Asignar permisos de acceso para el rol:</h4>
                                @foreach($listaPermisos as $permiso)
                                    <div class="col-md-4">
                                        <div class="checkbox checkbox-group required"> 
                                            <label>
                                                <input type="checkbox" name="idPermiso[]" value="{{$permiso->id}}"><strong>{{$permiso->name}}</strong>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach                                
                                {{-- <small>En la api se requiere registar el <cite title="idUsuarioAlta y la fechaalta">idUsuarioAlta y la fechaalta</cite></small> --}}
                                <button type="submit" class="btn btn-primary pull-right saveRolPermisos">{{ __('Guardar') }}</button>

                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection