@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('rolesapi.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        {{-- <div class="row"> --}}
            <form method="POST" action="{{ route('rolesapi.actualizar')}}">
                {{-- <div class="col-md-12"> --}}
                    <div class="card card-profile">
                        @csrf                                            
                        {{ method_field('PUT') }}
                        <input id="name" type="hidden" class="form-control" name="id" value="{{$rol->id}}" required>
                        {{-- <div class="row"> --}}
                            <div class="card-content">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">create</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre Rol</label>
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$rol->name}}" required autofocus>
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
                                            <input id="descripcion" type="text" class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }}" name="descripcion" value="{{$rol->descripcion}}" required>                                            
                                            @if ($errors->has('descripcion'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('descripcion') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <h4><strong>Editar permisos asignados al rol:</strong></h4>                            
                                @foreach($permisos as $permiso)
                                    @php                                	
                                        $resultado = $idPermisosRolColeccion->contains($permiso->id);                                        
                                        $checked = ($resultado == 1) ? "checked" : "";
                                    @endphp                                        
                                            <div class="col-md-4 col-sm-6 col-xs-6">
                                                <div class="checkbox">
                                                    @php
                                                        $idPermiso=$permiso->id;
                                                    @endphp                             
                                                    <label class="labelCheckbox checkbox-inline">
                                                        <input type="checkbox" nombreRol="{{$rol->name}}" nombrePermiso="{{$permiso->name}}" id="chekPermiso{{$permiso->id}}" idRol="{{$rol->id}}" idPermiso="{{$permiso->id}}" name="idPermiso[]" value="{{$permiso->id}}" {{$checked}} onclick="AddDeletePermisoRol({{$idPermiso}})"><strong>{{$permiso->name}}</strong>
                                                    </label>                                            
                                                </div>
                                            </div>                                 
                                @endforeach 
                                                                                               
                                <button type="submit" class="btn btn-primary pull-right">{{ __('Guardar') }}</button>

                            </div>

                        {{-- </div> --}}
                    </div>
                {{-- </div> --}}
            </form>
        {{-- </div> --}}
    </div>
</div>
@endsection