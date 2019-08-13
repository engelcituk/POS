@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('users.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                 @php
                    $usuarioPermisoLeer= Session::get('Usuarios.leer');                                                         
                @endphp
                @if ($usuarioPermisoLeer==1)
                    <div class="card card-profile">
                    <div class="card-avatar">
                        <img class="img" src="{{asset('img/faces/rol.png')}}">
                    </div>
                    <div class="card-content">                                                                                       
                    <h4 ><strong>Nombre Completo: </strong>{{$usuario->name}} </h4>
                          
                        <h4 ><strong>Nombre de usuario: </strong>{{$usuario->usuario}} </h4>                      
                        <h4><strong>Rol y permisos del rol del usuario: </strong>{{$rolUsuario->name}}</h4>                                      
                         @foreach($permisos as $permisoItem)
                            @php                                	
                                $resultado = $idPermisosRolColeccion->contains($permisoItem->id);
                                $checked = ($resultado == 1) ? "checked" : "";
                            @endphp                              
                            <div class="col-md-4">
                                <div class="checkbox checkbox-group required">                              
                                    <label class="labelCheckbox ">
                                    <input type="checkbox" name="idPermiso[]" value="{{$permisoItem->id}}" {{$checked}} onclick="return false;"><strong>{{$permisoItem->name}}</strong>
                                    </label>                                            
                                </div>
                            </div>                                         
                        @endforeach
                        <a href="{{ route('users.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                    </div>
                </div>                    
                @else
                   <div class="card">                    
                        <div class="card-content">
                            <div class="col-md-2 text-center">
                                <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                            </div>
                            <div class="col-md-10">
                                    <h3>Usted no cuenta con permiso para ver a un usuario</h3>
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