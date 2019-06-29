<script>
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
        }
    }
</script> 