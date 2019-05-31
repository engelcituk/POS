@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('rolesapi.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
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
            </div>
        </div>
    </div>
</div>
@endsection