<script>
    function getCuenta(idCuenta){
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    
    $.ajax({
            url: "{{url('historico')}}"+'/'+idCuenta,
            type: "GET",
            data: {
                '_method': 'GET',
                '_token': csrf_token
            },            
            success: function(respuesta) {
                var respuesta=JSON.parse(respuesta);
                var ok = respuesta["ok"];
                if(ok){                    
                    var objeto=respuesta["objeto"];

                    var folio=objeto["folio"];
                    var habitacion=objeto["habitacion"];
                    var pax=objeto["pax"];
                    var reserva=objeto["reserva"];
                    var nombreCliente=objeto["nombreCliente"];

                    $("#folioCuenta").val(folio);
                    $("#habitacion").val(habitacion)
                    $("#pax").val(pax)
                    $("#reserva").val(reserva)
                    $("#nombreCliente").val(nombreCliente)
                  
                      
                }                 
            },
            error: function(respuesta) {
            respuesta=JSON.parse(respuesta); 
            console.log(respuesta);
            }
    });
}

function verCuentaDetalles(id) {
        $("#detalleCuenta tbody").empty();//limpio la tabla para cargale lo que traigo por ajax
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $('#modalVerDetalle').modal('show');    
               
        getCuenta(id);       
        $.ajax({
            url: "{{ url('historico/detalle') }}"+'/'+id,
            type: "GET",
            data: {
                '_method': 'GET',                
                '_token': csrf_token
            }, 
            // beforeSend: function () {
            //     $("#showLoader").html('<div class="loader"></div>');                
            // },       
            success: function(respuesta) {
                var respuesta = JSON.parse(respuesta);                
                var ok = respuesta["ok"];
                if(ok){
                    var objeto=respuesta["objeto"];
                    var longitud=objeto.length;                    
                    if(longitud>0){
                        console.log("cuenta",objeto);                                                                        
                        for (i = 0; i < longitud; i++) {                           
                            var idCuenta = objeto[i]["idCuenta"];
                            var cantidad = objeto[i]["cantidad"];
                            var comensal = objeto[i]["comensal"];
                            var precio = objeto[i]["precioUnitario"];
                            //para obtener los estado de acuerdo a las fechas
                            var fechaCancela = objeto[i]["fechaCancela"];                            
                            var fechaImpresion = objeto[i]["fechaImpresion"]; 
                            var fechaAlta = objeto[i]["fechaAlta"]; 


                            var menuCarta = objeto[i]["TPV_MenuCarta"]["TPV_Producto"];
                            var nombreProducto=menuCarta["nombreProducto"];
                            var idProducto=menuCarta["idProducto"];
                            var subTotal=cantidad * precio;

                            var pedido="<span class='label label-info'>Pedido</span>";
                            var preparado="<span class='label label-success'>Preparado</span>";
                            var cancelado="<span class='label label-danger'>Cancelado</span>";
                            if(fechaCancela==null && fechaAlta!=null && fechaImpresion!=null){
                                estado=preparado;
                            }else if(fechaCancela!= null && fechaAlta!=null && fechaImpresion!=null){
                                estado=cancelado;
                            }else if(fechaAlta!=null && fechaImpresion==null && fechaCancela==null){
                                estado=pedido;
                            }

                            itemCuenta="<tr><td>"+cantidad+"</td><td>"+nombreProducto+"</td><td>"+precio+"</td><td>"+subTotal+"</td><td>"+estado+"</td></tr>";
                            $("#detalleCuenta tbody").append(itemCuenta); 
                            // console.log("fechaCancela",fechaCancela);                             
                            // console.log("fechaImpresion",fechaAlta); 
                            // console.log("fechaAlta",fechaAlta); 
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