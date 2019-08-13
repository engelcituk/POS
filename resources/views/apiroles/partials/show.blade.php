@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('rolesapi.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                @php
                    $rolPermisoLeer= Session::get('Roles.leer');                
                @endphp
                @if ($rolPermisoLeer==1)
                <div class="card card-profile">
                    <div class="card-avatar">
                        <img class="img" src="{{asset('img/faces/settings.png')}}">
                    </div>
                    <div class="card-content">                                                                                       
                    <h4 class="card-title"><strong>Nombre Rol: </strong> {{$rol->name}}</h4><br>
                          
                        <h4 class="card-title"><strong>Descripción: </strong> {{$rol->descripcion}}</h4><br>                       
                        <h4><strong>Permisos asignados al rol:</strong></h4>                                                                 
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
                        <a href="{{ route('rolesapi.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                    </div>
                </div>
                @else
                    <div class="card">                    
                        <div class="card-content">
                        <div class="col-md-2 text-center">
                                <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                        </div>
                            <div class="col-md-10">
                                    <h3>Usted no cuenta con permisos para ver un rol</h3>
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