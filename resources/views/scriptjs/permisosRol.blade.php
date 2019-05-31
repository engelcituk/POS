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
                url: "{{ url('rolesapi') }}"+'/'+idRol+'/'+idPermiso,
                type: "POST",
                data: {
                    '_method': 'DELETE',
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
                error: function() {
                   $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Ocurrió un error al hacerse la petición'
                        },{								
                            type: 'danger',
                            delay: 5000
                        });
                }
            });
        }
    }
</script>