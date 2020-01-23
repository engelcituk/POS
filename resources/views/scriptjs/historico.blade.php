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
        $("#sumSubTotales").val("");
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
        // console.log("click");
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
                url: "{{ url('historico/imprimirCuentaHist') }}" + '/'+idCuenta,
                type: "POST",
                data: {
                    '_method': 'POST',
                    '_token': csrf_token
                },
                success: function(respuesta) {
                    console.log("respuesta controlador",respuesta);
                    var respuesta = JSON.parse(respuesta);

                    var ok = respuesta["ok"];               

                    if(ok){
                        var contenidoTicket = respuesta["ticket"];                
                        var maquinaImpresora = respuesta["printer"]
                        if(contenidoTicket != "" ){
                            imprimirTicketCuenta(contenidoTicket, maquinaImpresora);
                        }
                    }                   
                },
                error: function(respuesta) { 
                    console.log("respuesta controlador",respuesta);                    

                }
            });
        }).catch(swal.noop);
    }
// para impirmir desglose de cierre de fecha seleccionada
function imprimirDesglose(idPuntoVenta) {
     var csrf_token = $('meta[name="csrf-token"]').attr('content');
     // otengo la fecha y lo transformo a formato D-M-Y
     var fechaInicio = $("#fechaInicioHist").val().replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3-$2-$1');
     // var fechaInicio = $("#fechaInicioHist").val(); descomentar si el servidor admite Y-M-D
     
     $.ajax({
        url: "{{ url('historico/imprimircerrardia') }}",
        type: "POST",
        data: {
            '_method': 'POST',           
            'fecha': fechaInicio,
            '_token': csrf_token
        },
        success: function(respuesta) {             
             var respuesta = JSON.parse(respuesta);
             console.log("Respuesta controlador",respuesta); 
             var ok = respuesta["ok"];                
            
            if(ok){
                var contenidoTicket = respuesta["ticket"];                
                var maquinaImpresora = respuesta["printer"]
                if(contenidoTicket != "" ){
                    imprimirTicketCuenta(contenidoTicket, maquinaImpresora);
                }
            }              
                                                
        },
        error: function(respuesta) { 
            console.log("respuesta",respuesta); 
        }
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

                    var respuesta = JSON.parse(respuesta);
                    var ok = respuesta["ok"];                                                   
                    if(ok){
                        var mensaje = respuesta["mensaje"];                                                   
                        
                        var contenidoTicket = respuesta["ticket"];                
                        var maquinaImpresora = respuesta["printer"]
                        if(contenidoTicket != "" ){
                            imprimirTicketCuenta(contenidoTicket, maquinaImpresora);
                        }

                        swal({
                            title: 'OK',
                            text: mensaje,
                            type: 'success',                            
                        });
                    }else {
                        var mensaje = respuesta["mensaje"];
                        swal({
                            title: 'OK',
                            text: mensaje,
                            type: 'error',                            
                        });
                    }                 
                },
                error: function(respuesta) {
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
            });
        }                 
    }
    $('#modalCancelarCuenta').on('hidden.bs.modal', function (e) {
        $(this).find('form')[0].reset();
    });

    function detallesFiltro(){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        fechaInicio = $("#fechaInicioHist").val();
        
        $.ajax({
            url: "{{url('historico/cierredia')}}",
            type: "POST",
            data: {
                '_method': 'POST',
                'fecha':fechaInicio,
                '_token': csrf_token
            },
            beforeSend: function () {
                // $("#mensajeRespuesta").html('<div class="loader"></div>');
                swal({
                    title: 'Espere',
                    text: 'Obteniendo información',
                    type : 'info',
                    allowOutsideClick: false
                });
                swal.showLoading();
            },           
            success: function(respuesta) {
                swal.close(); 
                var respuesta=JSON.parse(respuesta);
                var ok = respuesta["ok"];
                if(ok){
                    objeto = respuesta["objeto"];
                    mostrarDetalleFiltro(objeto);
                }                                             
                                    
            },
            error: function(respuesta) {
            respuesta=JSON.parse(respuesta); 
            console.log(respuesta);
            }
        });            
    }
    function mostrarDetalleFiltro(objeto) {
        fechaInicio = $("#fechaInicioHist").val();
                
        console.log("objeto", objeto);

        var totalCuentas= objeto["totalCuentas"];
        if(totalCuentas>0){
            $("#fechaDesglose").text(fechaInicio);
            $("#fechaFiltroBtn").attr("fechaFiltroButton",fechaInicio);

            $("#detalleCuentasFiltro tbody").empty();//limpio la tabla para cargar nuevos datos
            $("#productosFavoritosFiltro tbody").empty();//limpio la tabla para cargar nuevos datos
            var totalCuentas= objeto["totalCuentas"];
            var totalAdultos= objeto["totalAdultos"];
            var totalNinos= objeto["totalNinos"];
            var totalPax= objeto["totalPax"];
            // obtengo la cuenta
            var cuentasObj=  objeto["cuentas"];
            var productosFavoritosObj=  objeto["productos"];

            var longitudCuentas=cuentasObj.length;                    
            var longitudProductos=productosFavoritosObj.length;                    
            //Seccion de cuentas
            $("#totalCuentas").text(totalCuentas);
            $("#totalAdultos").text(totalAdultos);
            $("#totalNinos").text(totalNinos);
            $("#totalPax").text(totalPax);
            // seccion de productos
            $("#productosFavoritos").text(longitudProductos);
            //para mostrar el listado de cuentas
            for (i = 0; i < longitudCuentas; i++) {                           
                var idCuenta = cuentasObj[i]["id"];
                var folio = cuentasObj[i]["folio"];
                var fechaApertura = cuentasObj[i]["fechaAlta"].substring(0,10);
                var horaAlta = cuentasObj[i]["horaAlta"];
                var horaCierre = cuentasObj[i]["horaCierre"];
                var habitacion = cuentasObj[i]["habitacion"];
                var nombreCliente = cuentasObj[i]["nombreCliente"];
                var pax = cuentasObj[i]["pax"];
                var totalCuenta = cuentasObj[i]["totalCuenta"];
                                
                itemCuentas="<tr><td>"+idCuenta+"</td><td>"+folio+"</td><td>"+fechaApertura+"</td><td>"+horaAlta+"</td><td>"+horaCierre+"</td><td>"+habitacion+"</td><td>"+nombreCliente+"</td><td>"+pax+"</td><td>"+totalCuenta+"</td></tr>";
                $("#detalleCuentasFiltro tbody").append(itemCuentas);
            }
            // para mostrar el listado de productos favoritos
            for (i = 0; i < longitudProductos; i++) {                           
                var nombreProducto = productosFavoritosObj[i]["producto"];
                var cantidad = productosFavoritosObj[i]["count"];
                                                
                itemProductos="<tr><td>"+nombreProducto+"</td><td>"+cantidad+"</td>tr>";
                $("#productosFavoritosFiltro tbody").append(itemProductos);
            }
            // muestro el modal
            $('#modalDetalleFiltro').modal({backdrop: 'static', keyboard: false });

        }else{
            swal("Oops", "Aun no hay cuentas para esta fecha" ,  "error");                
        }
    }
    function generarPdfFiltro(){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        fecha = $("#fechaFiltroBtn").attr("fechafiltrobutton");        
        $.ajax({
            url: "{{url('historico/pdf')}}",
            type: "POST",
            data: {
                '_method': 'POST',
                'fechaPDF':fecha,
                '_token': csrf_token
            },           
            success: function(respuesta) {                 
                // var respuesta=JSON.parse(respuesta);
                // console.log(respuesta);
            },
            error: function(respuesta) {
            // respuesta=JSON.parse(respuesta); 
            // console.log(respuesta);
            }
        });            
    }
    function generarExcelFiltro(){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        fecha = $("#fechaFiltroBtn").attr("fechafiltrobutton");        
        $.ajax({
            url: "{{url('historico/datosexcel')}}"+'/'+fecha,
            type: "GET",
            data: {
                '_method': 'GET',
                'fechaExcel':fecha,
                '_token': csrf_token
            },
             beforeSend: function () {
                // $("#mensajeRespuesta").html('<div class="loader"></div>');
                swal({
                    title: 'Espere',
                    text: 'Obteniendo información para generar excel',
                    type : 'info',
                    allowOutsideClick: false
                });
                swal.showLoading();
            },           
            success: function(respuesta) { 
                swal.close(); 
                // var respuesta=JSON.parse(respuesta);
                // console.log(respuesta);
                var url = "{{URL::to('historico/datosexcel')}}"+'/'+fecha;
                window.location = url;
            },
            error: function(respuesta) {
            // respuesta=JSON.parse(respuesta); 
            // console.log(respuesta);
            }
        });            
    }
    // para hacer una impresion te ticket desde mi propio backend
    function imprimirTicketCuenta(contenidoTicket,maquinaImpresora) {              
        var csrf_token = $('meta[name="csrf-token"]').attr('content');    
        // console.log("idPuntoVenta: "+idPV+" idCuenta: "+idCuenta+" idMesaNueva: "+idMesaNueva);              
        $.ajax({
            url: "{{ url('printrecibo/imprimir') }}",
            type: "POST",
            data: {
                '_method': 'POST',                           
                '_token': csrf_token,
                'contenidoTicket': contenidoTicket,
                'maquinaImpresora': maquinaImpresora
            },
            success: function(respuesta) {             
                               
                console.log(respuesta); 
                                                    
            },
            error: function(respuesta) { 
                console.log(respuesta); 
            }
        });
    }
</script> 