@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('users.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <form method="POST" action="{{ route('users.actualizar')}}">            
            <div class="row">
                    <div class="col-md-12">
                        <div class="card card-profile">
                            @csrf                                                                       
                            {{ method_field('PUT') }}
                            <input id="name" type="hidden" class="form-control" name="id" value="{{$usuario->id}}" required>
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
                                            $resultado = $idPermisosRolColeccion->contains($permisoItem->id);
                                            $checked = ($resultado == 1) ? "checked" : "";
                                        @endphp                              
                                        <div class="row"> 
                                                                                       
                                            <div class="col-md-2 col-md-offset-1">
                                                <div class="checkbox checkbox-group required">                              
                                                    <label class="labelCheckbox">
                                                    <input type="checkbox" name="idPermiso[]" value="{{$permisoItem->id}}" {{$checked}} onclick="return false;"><strong>{{$permisoItem->name}}</strong>
                                                    </label>                                            
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="checkbox checkbox-group required">
                                                    <label>
                                                    <input type="checkbox" name="idPermiso[]" value=""><strong>Crear</strong>
                                                    </label>                                            
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="checkbox checkbox-group required">
                                                    <label>
                                                    <input type="checkbox" name="idPermiso[]" value=""><strong>Leer</strong>
                                                    </label>                                            
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="checkbox checkbox-group required">
                                                    <label>
                                                    <input type="checkbox" name="idPermiso[]" value=""><strong>Actualizar</strong>
                                                    </label>                                            
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="checkbox checkbox-group required">                                           
                                                    <label>
                                                    <input type="checkbox" name="idPermiso[]" value=""><strong>Borrar</strong>
                                                    </label>                                            
                                                </div>
                                            </div>                                            
                                        </div><br>                                        
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