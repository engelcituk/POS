<script>

    function showPermisosModal(idUsuario) {
        $('#modalShowUserPermisos').modal({backdrop: 'static', keyboard: false });
        $('#idUsuarioPermisoRolModal').val(idUsuario);
        // console.log("su id",idUsuario);
        marcarPermisosUsuario(idUsuario);
        
    }
    function marcarPermisosUsuario(idUsuario){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{url('users/getpermisos')}}"+'/'+idUsuario,
            type: "GET",
            data: {
                '_method': 'GET',                        
                '_token': csrf_token
            },
            success: function(respuesta) { 
                var respuesta = JSON.parse(respuesta); 
                var ok = respuesta["ok"];                
                if(ok){
                    var objeto =respuesta["objeto"];
                    idPermisoLst = [];
                    for (i = 0; i < objeto.length; i++) {
                        var idPermiso=objeto[i]["idPermiso"];
                        var crear=objeto[i]["crear"];
                        var leer=objeto[i]["leer"];
                        var actualizar=objeto[i]["actualizar"];
                        var borrar=objeto[i]["borrar"];
                        // console.log("crear",crear);
                        idPermisoLst.push(idPermiso);//creo un array con los idPermisos del usuario

                        $("#crear"+idPermiso).prop('checked', crear);//marca los valores booleanos que se me trae del usuario
                        $("#leer"+idPermiso).prop('checked', leer);
                        $("#actualizar"+idPermiso).prop('checked', actualizar);
                        $("#borrar"+idPermiso).prop('checked', borrar);
                    }
                    // console.log("objeto",objeto);
                    $("input[name='permiso[]']").each( function () {                       
                        if((idPermisoLst.indexOf(parseInt($(this).val()))!=-1)){
                           $(this).prop('checked', true);                            
                        }
                    });
                }                
            }
        }); 
    }
    $('#modalShowUserPermisos').on('hidden.bs.modal', function (e) {
         $(this).find('form')[0].reset();
    });
    
    function addQuitarPermisoUsuario(idPermiso){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var valorCheck=$("#chekPermiso"+idPermiso).prop("checked");
        var idUsuario =  $('#idUsuarioPermisoRolModal').val();
        
        if(valorCheck){            
            $.ajax({
                    url: "{{url('users')}}"+'/'+idUsuario+'/'+idPermiso,
                    type: "POST",
                    data: {
                        '_method': 'POST',                        
                        '_token': csrf_token
                    },
                    success: function(respuesta) {
                        var respuesta = JSON.parse(respuesta); 
                        var ok = respuesta["ok"];
                        var mensaje= respuesta["mensaje"];                                              
                        if(ok){
                            $.notify({							
                                message: '<i class="fas fa-sun"></i><strong>Nota:</strong> '+mensaje
                                },{								
                                    type: 'info',
                                    delay: 3000,
                                    z_index: 2000,
                            });
                        }                                           
                    }
                });           
        }else{            
            $.ajax({
                    url: "{{url('users/destroy')}}"+'/'+idUsuario+'/'+idPermiso,
                    type: "POST",
                    data: {
                        '_method': 'POST',                        
                        '_token': csrf_token
                    },
                    success: function(respuesta) { 
                        var respuesta = JSON.parse(respuesta);
                        var ok = respuesta["ok"];       
                        var mensaje= respuesta["mensaje"];                                              

                        if(ok){
                            $.notify({							
                                message: '<i class="fas fa-sun"></i><strong>Nota:</strong> '+mensaje
                            },{								
                                type: 'warning',
                                delay: 3000,
                                z_index: 2000,
                            });
                        }                    
                    }
            }); 
    }
}
function addAccionesPermiso(idPermiso){
    var csrf_token = $('meta[name="csrf-token"]').attr('content');        
    
    var valorCheck=$("#chekPermiso"+idPermiso).prop("checked");//el checkbox del permiso
    var idUsuario =  $('#idUsuarioPermisoRolModal').val();

    var crear = $("#crear"+idPermiso).prop("checked");
    var leer = $("#leer"+idPermiso).prop("checked");
    var actualizar = $("#actualizar"+idPermiso).prop("checked");
    var borrar = $("#borrar"+idPermiso).prop("checked");

    opciones = [];
    opciones[0] = [crear,leer,actualizar,borrar];
    
    if(valorCheck){       
         $.ajax({
            url: "{{url('users/update')}}"+'/'+idUsuario+'/'+idPermiso,
            type: "POST",
            data: {
                '_method': 'POST',
                'opciones':opciones,
                '_token': csrf_token
            },
            success: function(respuesta) {
                var respuesta = JSON.parse(respuesta);
                // var ok = respuesta["ok"];       
                // var mensaje= respuesta["mensaje"];                                                                                       

                $.notify({							
                    message: '<i class="fas fa-sun"></i><strong>Nota:</strong> '+respuesta
                    },{								
                        type: 'info',
                        delay: 4000,
                        z_index: 2000,
                    });                                       
            }
        });
    }else{        
        $.notify({							
            message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Primero tiene que seleccionar el permiso para asignarle acciones a este'
        },{								
            type: 'warning',
            delay: 3000,
            z_index: 2000,
        });
    }                
}
</script>