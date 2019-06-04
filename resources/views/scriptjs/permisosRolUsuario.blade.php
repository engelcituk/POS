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
                        '_method': 'DELETE',                        
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