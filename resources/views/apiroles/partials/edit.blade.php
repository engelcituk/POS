@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('rolesapi.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        {{-- <div class="row"> --}}            
            @php
                $rolPermisoLeer= Session::get('Roles.leer'); 
                $rolPermisoActualizar= Session::get('Roles.actualizar');                                          
            @endphp
            @if($rolPermisoLeer==1 && $rolPermisoActualizar==1)
                <form method="POST" action="{{ route('rolesapi.actualizar')}}">
                {{-- <div class="col-md-12"> --}}
                    <div class="card card-profile">
                        @csrf                                                                   
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
                                                                            
                                            <div class="col-md-4 col-sm-6 col-xs-6">
                                                <div class="checkbox">
                                                    @php 
                                                        if (!$idPermisosRolColeccion->isEmpty()) {
                                                            $resultado = $idPermisosRolColeccion->contains($permiso->id);     $checked = ($resultado == 1) ? "checked" : "";
                                                            $idPermiso=$permiso->id;
                                                        } else{
                                                            $idPermiso=$permiso->id;
                                                            $checked = "";
                                                        }                                                      
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
            @else
                <div class="card">                    
                    <div class="card-content">
                      <div class="col-md-2 text-center">
                            <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                      </div>
                        <div class="col-md-10">
                                <h3>Usted no cuenta con permisos para editar la información</h3>
                                <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                        </div>
                    </div>                    
                </div>
            @endif             
        {{-- </div> --}}
    </div>
</div>
<script>
    function AddDeletePermisoRol(idPermiso){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var idRol = $("#chekPermiso"+idPermiso).attr("idRol");
        var idPermiso = $("#chekPermiso"+idPermiso).attr("idPermiso");
        var nombreRol = $("#chekPermiso"+idPermiso).attr("nombreRol");
        var nombrePermiso = $("#chekPermiso"+idPermiso).attr("nombrePermiso");
        

        valorCheck=$("#chekPermiso"+idPermiso).prop("checked");//obtengo true o false

        if(valorCheck) {    
            $.ajax({
                url: "{{ url('rolesapi') }}"+'/'+idRol+'/'+idPermiso,
                type: "POST",
                data: {
                    '_method': 'POST',
                    '_token': csrf_token
                },
                success: function(respuesta) {
                    $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Se ha registrado permiso: <strong>'+nombrePermiso+'</strong> Para el rol: <strong>'+nombreRol+'</strong>'
                        },{								
                            type: 'info',
                            delay: 5000
                        });                    
                },
                error: function() {
                   $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Ocurrió un error al hacerse la petición'
                        },{								
                            type: 'danger',
                            delay: 5000
                        });
                }
            });
        }else{
            $.ajax({
                url: "{{ url('rolapiborrar') }}"+'/'+idRol+'/'+idPermiso,
                type: "POST",
                data: {
                    '_method': 'POST',
                    '_token': csrf_token
                },
                success: function(respuesta) {                    
                    $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Se ha borrado permiso: <strong>'+nombrePermiso+'</strong> del rol <strong>'+nombreRol+'</strong>'
                        },{								
                            type: 'warning',
                            delay: 5000
                        });
                },
                error: function(respuesta) {
                    var res = JSON.parse(respuesta); 
                   $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Ocurrió un error al hacerse la petición'+ res 
                        },{								
                            type: 'danger',
                            delay: 5000
                        });
                }
            });
        }
    }
</script>
@endsection