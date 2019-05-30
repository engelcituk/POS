<script>
    function AddDeletePermisoRol(idPermiso){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var idRol = $("#chekPermiso"+idPermiso).attr("idRol");
        var idPermiso = $("#chekPermiso"+idPermiso).attr("idPermiso");
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
                        message: '<i class="fas fa-sun"></i> <strong>Nota:</strong> Se ha registrado permiso para '+nombrePermiso  
                        },{								
                            type: 'info',
                            delay: 5000
                        });                    
                },
                error: function() {
                   console.log("Error");
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
                    console.log(respuesta);
                },
                error: function() {
                   console.log("Error");
                }
            });
        }
    }
</script>