@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('rolesapi.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <img class="img" src="{{asset('img/faces/rol.png')}}">
                    </div>
                    <div class="card-content">                                                                                       
                    <h4 class="card-title"><strong>Nombre Rol: </strong> {{$rol->name}}</h4><br>
                          
                        <h4 class="card-title"><strong>Descripción: </strong> {{$rol->descripcion}}</h4><br>                       
                        <h4><strong>Permisos asignados al rol:</strong></h4>
                                @foreach($listaPermisos as $permisoItem)                                 
                                    <div class="col-md-4">
                                        <div class="checkbox checkbox-group required"> 
                                            <label>
                                            <input type="checkbox" name="idPermiso[]" value="{{$permisoItem->id}}" onclick="return false;"><strong>{{$permisoItem->name}}</strong>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach 

                                <h4><strong>Permisos que ya el rol: </strong></h4>
                                
                                @foreach($permisosRol as $permiso)
                                
                                    <div class="col-md-4">
                                        <div class="checkbox checkbox-group required"> 
                                            <label>
                                            <input type="checkbox" name="idPermisoRol[]" value="{{$permiso->idRol}}" onclick="return false;"><strong>{{$permiso->idPermiso}} {{$checked }}</strong>
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