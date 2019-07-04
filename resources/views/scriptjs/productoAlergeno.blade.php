<script>
    function AddDeleteProductoAlergeno(idAlergeno){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var idProducto = $("#checkAlergeno"+idAlergeno).attr("idProducto");
        var nombreAlergeno = $("#checkAlergeno"+idAlergeno).attr("nombreAlergeno");
        var nombreProducto = $("#checkAlergeno"+idAlergeno).attr("nombreProducto");
        
        valorCheck=$("#checkAlergeno"+idAlergeno).prop("checked");//obtengo true o false
        // console.log("idProducto "+idProducto+" idAlergeno "+idAlergeno+" Valorcheck "+valorCheck);        

        if(valorCheck) {    
            $.ajax({
                url: "{{ url('productos') }}"+'/'+idProducto+'/'+idAlergeno,
                type: "POST",
                data: {
                    '_method': 'POST',
                    '_token': csrf_token
                },
                success: function(respuesta) {
                    $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Se ha registrado alergeno: <strong>'+nombreAlergeno+' para el producto '+nombreProducto+' con id: '+idProducto 
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
                url: "{{ url('borrar') }}"+'/'+idProducto+'/'+idAlergeno,
                type: "POST",
                data: {
                    '_method': 'DELETE',
                    '_token': csrf_token
                },
                success: function(respuesta) {                    
                    $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Se ha borrado el alergeno: <strong>'+nombreAlergeno+' para el producto '+nombreProducto+' con id: '+idProducto 
                        },{								
                            type: 'warning',
                            delay: 5000
                        });
                },
                error: function(respuesta) {
                   $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Ocurrió un error al hacerse la petición'+respuesta
                        },{								
                            type: 'danger',
                            delay: 5000
                        });
                }
            });
        }
    }
</script>