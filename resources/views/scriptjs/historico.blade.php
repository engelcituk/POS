<script>
    function verCuentaDetalles(id) {
        $("#detalleCuenta tbody").empty();//limpio la tabla para cargale lo que traigo por ajax
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $('#modalVerDetalle').modal('show');       
        $.ajax({
            url: "{{ url('historico/detalle') }}"+'/'+id,
            type: "GET",
            data: {
                '_method': 'GET',                
                '_token': csrf_token
            },        
            success: function(respuesta) {
                var respuesta = JSON.parse(respuesta);                
                var ok = respuesta["ok"];
                //  console.log("cuenta",objeto);
                if(ok){
                    var objeto=respuesta["objeto"];
                    var longitud=objeto.length;                    
                    if(longitud>0){
                        for (i = 0; i < longitud; i++) {                           
                            var idCuenta = objeto[i]["idCuenta"];
                            var cantidad = objeto[i]["cantidad"];
                            var comensal = objeto[i]["comensal"];
                            var precio = objeto[i]["precioUnitario"];
                            itemCuenta="<tr><td>"+idCuenta+"</td><td>"+cantidad+"</td><td>"+comensal+"</td><td>"+precio+"</td></tr>";
                            $("#detalleCuenta tbody").append(itemCuenta);                              
                    }    
                }else{
                    itemCuenta="<tr><td colspan='4'>Esta cuenta no tiene detalles a mostrar</td></tr>";                   
                    $("#detalleCuenta tbody").append(itemCuenta); 
                    }
                }                
            },
            error: function() {
            console.log(JSON.parse(respuesta));
        }
    }); 
    }
</script> 