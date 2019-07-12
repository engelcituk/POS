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
                        // console.log("cuenta",objeto);
                        var sumaSubTotales=0;
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
                            sumaSubTotales = sumaSubTotales + subTotal; 
                            itemCuenta="<tr><td>"+cantidad+"</td><td>"+nombreProducto+"</td><td>"+precio+"</td><td>"+subTotal+"</td><td>"+estado+"</td></tr>";
                            $("#detalleCuenta tbody").append(itemCuenta); 
                            // console.log("fechaCancela",fechaCancela);                             
                            // console.log("fechaImpresion",fechaAlta); 
                            // console.log("fechaAlta",fechaAlta); 
                    }
                    $("#sumSubTotales").val(sumaSubTotales);
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
    //funcion con sweetalert para reimprimir cuenta
    function imprimirCuenta(idCuenta) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        swal({
            title: '¿Seguro de realizar la impresión de la cuenta?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: '¡Sí, imprimir!',
            cancelButtonText: '¡No, desistir!'
        }).then(function() {
            $.ajax({
                url: "{{ url('historico/imprimir') }}" + '/'+idCuenta,
                type: "POST",
                data: {
                    '_method': 'POST',
                    '_token': csrf_token
                },
                success: function(respuesta) {
                    console.log("respuesta controlador",respuesta);                    
                },
                error: function(respuesta) { 
                    console.log("respuesta controlador",respuesta);                    

                }
            });
        });
    }
    function cancelarCuentaModal(idCuenta) {
        $("#idCuentaCancelar").val(idCuenta);
        $('#modalCancelarCuenta').modal({backdrop: 'static', keyboard: false });
        $("#cancelarCuentaBtn").attr("idCuenta",idCuenta)
    }
    /*
    $("#modalDescuentoCuenta").modal("hide");
    //reseteo los valores de los campos del modal por si acaso 
     $('#modalDescuentoCuenta').on('hidden.bs.modal', function (e) {
        $(this).find('form')[0].reset();
    });
    */
    //funcion con sweetalert para cancelar cuenta
    function cancelarCuenta() {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var idCuenta =$("#cancelarCuentaBtn").attr("idCuenta");
        var motivoCancelacion =$("#motivoCancelacion").val();               
                 
        if(motivoCancelacion.length >= 20) {                     
            $.ajax({
                url: "{{ url('historico/cancelar') }}" + '/'+idCuenta,
                type: "POST",
                data: {
                    '_method': 'POST',
                    'motivo':motivoCancelacion,
                    '_token': csrf_token
                },
                success: function(respuesta) {
                    console.log("respuesta controlador cancelar",respuesta);                    
                },
                error: function() { 
                    console.log("respuesta controlador",respuesta);                    

                }
            }); 
            $("#modalCancelarCuenta").modal("hide");
            // reseteo los valores de los campos del modal por si acaso            
        } else{
            swal({
                title: 'Oops...',
                text: '¡EL motivo tiene que ser mayor a 20 caracteres!',
                type: 'error',
                timer: '2500'
            })
        }                 
    }
    $('#modalCancelarCuenta').on('hidden.bs.modal', function (e) {
        $(this).find('form')[0].reset();
    });
</script> 