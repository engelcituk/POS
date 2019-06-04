@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('users.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <form method="POST" action="{{ route('users.actualizar')}}">            
            <div class="row" id="accionesPermisos">
                    <div class="col-md-12">
                        <div class="card card-profile">
                            @csrf                                                                       
                            {{ method_field('PUT') }}
                            <input id="idUsuario" type="hidden" class="form-control" name="id" value="{{$usuario->id}}" required>
                            <div class="row">
                                {{-- <h4><strong>Rol del usuario: </strong>{{$rolUsuario->name}}</h4>  --}}
                                <div class="card-content">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-file-signature"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Nombre Completo</label>
                                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$usuario->name}}" required autofocus>
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
                                                <i class="fas fa-user-edit"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Nombre de usuario</label>
                                                <input id="usuario" type="text" class="form-control{{ $errors->has('usuario') ? ' is-invalid' : '' }}" name="usuario" value="{{$usuario->usuario}}" required>
                                                @if ($errors->has('usuario'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('usuario') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-key"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Contraseña</label>
                                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{$usuario->password}}" required autofocus>
                                                @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                    <i class="fas fa-user-cog"></i>
                                                </span>
                                            <div class="form-group">
                                                <select class="form-control" name="idRol" required>
                                                    <option value="{{$rolUsuario->id}}">{{$rolUsuario->name}}</option>
                                                    @foreach($roles as $rol)
                                                        <option value="{{$rol->id}}">{{$rol->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>                                        
                                    </div>                                    
                                    <h4><strong>Permisos del rol del usuario: </strong>{{$rolUsuario->name}}</h4> 
                                    @foreach($permisos as $permisoItem)
                                        @php       
                                            $idUsuario=$usuario->id;
                                            $idPermiso=$permisoItem->id;
                                            $resultado = $idPermisosRolColeccion->contains($permisoItem->id);

                                            // dd($crearColeccion[1]);
                                            $resultadoCrear = $crearColeccion->contains(true,false);
                                            //  dd($resultadoCrear);
                                            $checked = ($resultado == 1) ? "checked" : "";
                                            $clickReturn= ($resultado == 1) ? "return false;" : "addQuitarPermisoUsuario($idUsuario,$idPermiso)";
                                            $estadoPermisoPadre = ($resultado == 1) ? "estado=activo" : "estado=desactivado";

                                            $checkCrear=($resultadoCrear == 1) ? "checked" : "";
                                            // dd($checkCrear);
                                        @endphp                              
                                        <div class="row">                                                                                   
                                            <div class="col-md-offset-1 col-md-3">
                                                <div class="checkbox checkbox-group required">                              
                                                    <label class="labelCheckbox">
                                                    <input type="checkbox" id="chekPermiso{{$idPermiso}}" idUsuario="{{$idUsuario}}"  idPermiso="{{$idPermiso}}" name="idPermiso[]" value="{{$permisoItem->id}}" {{$checked}}  onclick="{{$clickReturn}}"><strong>{{$permisoItem->name}}</strong>
                                                    </label>                                            
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="checkbox checkbox-group required">
                                                    <label>
                                                    <input type="checkbox" id="crear{{$idPermiso}}" idUsuario="{{$idUsuario}}" idPermiso="{{$idPermiso}}" name="crear" value="" {{$estadoPermisoPadre}} onclick="addAccionesPermiso({{$idUsuario}},{{$idPermiso}},'crear')"><strong>Crear</strong>
                                                    </label>                                            
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="checkbox checkbox-group required">
                                                    <label>
                                                    <input type="checkbox" id="leer{{$idPermiso}}" idUsuario="{{$idUsuario}}" idPermiso="{{$idPermiso}}" name="leer" value="" {{$estadoPermisoPadre}} onclick="addAccionesPermiso({{$idUsuario}},{{$idPermiso}},'leer')"><strong><br>Leer</strong>
                                                    </label>                                            
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="checkbox checkbox-group required">
                                                    <label>
                                                    <input type="checkbox" id="actualizar{{$idPermiso}}" idUsuario="{{$idUsuario}}" idPermiso="{{$idPermiso}}" name="actualizar" value="" {{$estadoPermisoPadre}} onclick="addAccionesPermiso({{$idUsuario}},{{$idPermiso}},'actualizar')"><strong>Actualizar</strong>
                                                    </label>                                            
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="checkbox checkbox-group required">                                           
                                                    <label>
                                                    <input type="checkbox" id="borrar{{$idPermiso}}" idUsuario="{{$idUsuario}}" idPermiso="{{$idPermiso}}" name="borrar" value="" {{$estadoPermisoPadre}} onclick="addAccionesPermiso({{$idUsuario}},{{$idPermiso}},'borrar')"><strong>Borrar</strong>
                                                    </label>                                            
                                                </div>
                                            </div>                                            
                                        </div>                                       
                                    @endforeach                                  
                                       
                                                                      
                                    <button type="submit" class="btn btn-primary pull-right">{{ __('Guardar') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </form>
    </div>
</div>
@endsection