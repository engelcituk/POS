<script>

    borrarLocalStorageZones();
    limpiarNombrePuntoVenta();


    function eligeHotel(){        
        var idHotel = $("#idHotel option:selected").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        if(idHotel !=''){
            $.ajax({
                url: "{{ url('login/getpuntosventa') }}"+'/'+idHotel,
                type: "GET",
                data: {
                    '_method': 'GET',                    
                    '_token': csrf_token
                },
                success: function(respuesta) {             
                    var respuesta = JSON.parse(respuesta);
                    
                    var ok = respuesta["ok"];                
                    if(ok){//si ok es true
                        var objeto= respuesta["objeto"];  
                        // console.log("respuestaContoller",objeto[]);
                        listaPuntosVenta="<select class='form-control' name='listaPuntosVenta' id='listaPuntosVenta' required><option value=''>Elige punto de venta</option>"
                            for (i =0;  i<objeto.length; i++) {
                                listaPuntosVenta+= "<option value="+objeto[i]["id"]+">"+objeto[i]["name"]+"</option>";
                            }               
                        listaPuntosVenta+="</select>";
			            $("#listaPuntosVenta").html(listaPuntosVenta);
                    }else{
                        listaPuntosVenta="<select class='form-control' name='listaPuntosVenta' id='listaPuntosVenta' required><option value=''>Sin puntos de venta</option></select>";
                        $("#listaPuntosVenta").html(listaPuntosVenta);
                    }                               
                },
                error: function(respuesta) {                    
                    console.log("respuesta",respuesta); 
                }
            });
        }else{
            swal({
                title: 'Oopss...',
                text: '¡Tiene que elegir un hotel!',
                type: 'error',
                timer: '2500'
            });
            listaPuntosVenta="<select class='form-control' name='listaPuntosVenta' id='listaPuntosVenta' required><option value=''>Sin puntos de venta</option></select>";
            $("#listaPuntosVenta").html(listaPuntosVenta);

            listaCartas="<select class='form-control' name='listaCartas' id='listaCartas' required><option value=''>Sin puntos de venta</option></select>";
            $("#listaCartas").html(listaCartas);
        }
    }
    function obtenerCartasPV() {
        var idPuntoVenta = $("#listaPuntosVenta option:selected").val();
        var nombrePuntoVenta = $("#listaPuntosVenta option:selected").text();        
        var csrf_token = $('meta[name="csrf-token"]').attr('content');

        if(idPuntoVenta !=''){
        setearNombrePuntoVenta(nombrePuntoVenta);          
         $.ajax({
                url: "{{ url('login/getcartas') }}"+'/'+idPuntoVenta,
                type: "GET",
                data: {
                    '_method': 'GET',                    
                    '_token': csrf_token
                },
                success: function(respuesta) {             
                    var respuesta = JSON.parse(respuesta);                    
                    var ok = respuesta["ok"];  
                    if(ok){//si ok es true
                        var cartaTurno = respuesta["idCarta"];              
                        var objeto=respuesta["objeto"];
                        listaCartas="<select class='form-control' name='listaCartas' id='listaCartas' required> <option value=''>Elige carta</option>"
                            for (i =0;  i<objeto.length; i++) {
                                var select= objeto[i]["id"] == cartaTurno ? "selected" : "";
                                
                                listaCartas+= "<option "+select+" turno='"+objeto[i]["turno"]+"' value="+objeto[i]["id"]+">"+objeto[i]["name"]+"</option>";
                            }               
                        listaCartas+="</select>";
			            $("#listaCartas").html(listaCartas);

                    }else{                        
                        listaCartas="<select class='form-control' name='listaCartas' id='listaCartas' required><option value=''>Sin cartas</option></select>";
                        $("#listaCartas").html(listaCartas);
                    }                               
                },
                error: function(respuesta) {                    
                    console.log("respuesta",respuesta); 
                }
            });           
        }else{
            swal({
                title: 'Oopss...',
                text: '¡Tiene que elegir un punto de venta!',
                type: 'error',
                timer: '2500'
            }); 
            limpiarNombrePuntoVenta();            
            listaCartas="<select class='form-control' name='listaCartas' id='listaCartas' required><option value=''>Sin cartas</option></select>";
            $("#listaCartas").html(listaCartas);          
        }
}


function verificaSiEsAdmin(){
    var usuario = $("#usuarioAdmin").val();    
    if(usuario=="admin"){
        $("#btnIngresoAdmin").removeAttr("disabled")
    }else if( usuario=="" || usuario !="admin"){
         $("#btnIngresoAdmin").attr("disabled", true); 
    }
}

function borrarLocalStorageZones(){
    localStorage.removeItem("zonaMesaSeleccionada");
}

function setearNombrePuntoVenta(nombre){
    localStorage.setItem("nombrePuntoVentaTPV",nombre);    
}
function limpiarNombrePuntoVenta(){
    localStorage.removeItem("nombrePuntoVentaTPV");    
}
</script> 
