@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('users.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        @php
            $usuarioPermisoLeer= Session::get('Usuarios.leer'); 
            $usuarioPermisoActualizar= Session::get('Usuarios.actualizar');                                          
        @endphp
        @if ($usuarioPermisoLeer==1 && $usuarioPermisoActualizar==1)
            <form method="POST" action="{{ route('users.actualizar')}}">            
            <div class="row" id="accionesPermisos">
                    <div class="col-md-12">
                        <div class="card card-profile">
                            @csrf                                                                       
                            {{-- {{ method_field('PUT') }} --}}
                            <input id="idUsuario" type="hidden" class="form-control" name="id" value="{{$usuario->id}}" required>
                            <div class="row">
                                {{-- <h4><strong>Rol del usuario: </strong>{{$rolUsuario->name}}</h4>  --}}
                                <div class="card-content">
                                    <div class="col-md-4">
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
                                    <div class="col-md-4">
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
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-key"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Contraseña</label>
                                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" >
                                                @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-4">
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
                                    <div class="col-md-4">
                                    <div class="form-group">
                                        <strong>Estado</strong>
                                        <div class="radio">
                                            @php
                                            $estado= $usuario->status;//para obtener el estado de la impresora
                                            $radios = ($estado == 1) ?
                                            "<label><input type='radio' name='status' value='True' checked>Activado</label>
                                            <label><input type='radio' name='status' value='False'>Desactivado</label>" :
                                            "<label><input type='radio' name='status' value='True'>Activado</label>
                                            <label><input type='radio' name='status' value='False' checked>Desactivado</label>";
                                            echo $radios;
                                            @endphp
                                        </div>
                                    </div>
                                </div>     
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <strong>Autoriza cargo habitación</strong>
                                        <div class="radio">
                                            @php
                                            $estado= $usuario->autorizaCargoHab;//para obtener el estado de la impresora
                                            $radios = ($estado == 1) ?
                                            "<label><input type='radio' name='autorizaCargoHab' value='True' checked>Sí</label>
                                            <label><input type='radio' name='autorizaCargoHab' value='False'>No</label>" :
                                            "<label><input type='radio' name='autorizaCargoHab' value='True'>Sí</label>
                                            <label><input type='radio' name='autorizaCargoHab' value='False' checked>No</label>";
                                            echo $radios;
                                            @endphp
                                        </div>
                                    </div>
                                </div>                                                                     
                                                                      
                                    <button type="submit" class="btn btn-primary pull-right">{{ __('Guardar') }}</button>
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
                            <h3>Usted no cuenta con permisos para editar a un usuario</h3>
                            <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                    </div>
                </div>                    
            </div>
        @endif
        
    </div>
</div>
<script>
    function addQuitarPermisoUsuario(idUsuario,idPermiso){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var valorCheck=$("#chekPermiso"+idPermiso).prop("checked");
        
        if(valorCheck) {    
            console.log("hiciste click "+valorCheck);
            $.ajax({
                    url: "{{url('users')}}"+'/'+idUsuario+'/'+idPermiso,
                    type: "POST",
                    data: {
                        '_method': 'POST',                        
                        '_token': csrf_token
                    },
                    success: function(respuesta) {                                                                       
                        $.notify({							
                            message: '<i class="fas fa-sun"></i><strong>Nota:</strong> '+respuesta
                            },{								
                                type: 'info',
                                delay: 4000
                            });                    
                    },
                    error: function() {                         
                    $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Error '+respuesta
                        },{								
                            type: 'danger',
                            delay: 4000
                        });                         
                    }
                });           
        }else{
            console.log("hiciste click "+valorCheck);
            $.ajax({
                    url: "{{url('users')}}"+'/'+idUsuario+'/'+idPermiso,
                    type: "POST",
                    data: {
                        '_method': 'POST',                        
                        '_token': csrf_token
                    },
                    success: function(respuesta) {                                                                       
                        $.notify({							
                            message: '<i class="fas fa-sun"></i><strong>Nota:</strong> '+respuesta
                            },{								
                                type: 'warning',
                                delay: 4000
                            });                    
                    },
                    error: function() {                         
                    $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Error '+respuesta
                        },{								
                            type: 'danger',
                            delay: 4000
                        });                         
                    }
                }); 
        }

    }
    function addAccionesPermiso(idUsuario,idPermiso, accion){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');        
        var estado = $("#"+accion+idPermiso).attr("estado");
        var campo = $("#"+accion+idPermiso).attr("name");
        var valorCheck=$("#"+accion+idPermiso).prop("checked");//obtengo true o false
        var divPermisos =$("#accionesPermisos");
        var crear = $("#crear"+idPermiso).prop("checked");
        var leer = $("#leer"+idPermiso).prop("checked");
        var actualizar = $("#actualizar"+idPermiso).prop("checked");
        var borrar = $("#borrar"+idPermiso).prop("checked");

        opciones = [];
        opciones[0] = [crear,leer,actualizar,borrar];
        
        if(estado=="activo"){
            if(valorCheck) {                   
                $.ajax({
                    url: "{{url('users')}}"+'/'+idUsuario+'/'+idPermiso,
                    type: "POST",
                    data: {
                        '_method': 'PUT',
                        'opciones':opciones,
                        '_token': csrf_token
                    },
                    success: function(respuesta) {                                                                       
                        $.notify({							
                            message: '<i class="fas fa-sun"></i><strong>Nota:</strong> '+respuesta
                            },{								
                                type: 'info',
                                delay: 4000
                            }); 
                            // setTimeout(function(){
                            //     window.location.reload(1); 
                            // }, 6000);                   
                    },
                    error: function() {                         
                    $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Error '+respuesta
                        },{								
                            type: 'danger',
                            delay: 4000
                        });
                        // setTimeout(function(){
                        //     window.location.reload(1); 
                        // }, 6000); 
                    }
                });
            }else{
                // console.log("su valor "+valorCheck);
                $.ajax({
                    url: "{{url('users')}}"+'/'+idUsuario+'/'+idPermiso,
                    type: "POST",
                    data: {
                        '_method': 'PUT',
                        'opciones':opciones,
                        '_token': csrf_token
                    },
                    success: function(respuesta) {                                          
                        $.notify({							
                            message: '<i class="fas fa-sun"></i><strong>Nota:</strong> '+respuesta
                            },{								
                                type: 'warning',
                                delay: 4000
                            });
                        // setTimeout(function(){
                        //     window.location.reload(1); 
                        // }, 6000); 
                    },
                    error: function() {                    
                    $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Error '+respuesta
                        },{								
                            type: 'danger',
                            delay: 4000
                        });
                        // setTimeout(function(){
                        //     window.location.reload(1); 
                        // }, 6000); 
                    }
                });
            }
        }else{
            if(valorCheck) {
                swal({
                    title: 'Oops...',
                    text: '¡Marca el permiso para poder asignar acciones a este!',
                    type: 'error',
                    timer: '3000'
                })
                $("#"+accion+idPermiso).prop("checked",false); //no permito marcar el chckebox
            }             
        }
        
    }
</script>
@endsection