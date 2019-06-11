<script>
$( document ).ready(function() {
    var valDefault = $("#zonaElige").children('option:first').val();    
    if (valDefault != "") {                        
        $(".zonas").hide();
        $("#" + valDefault).show();
        //     if (valDefault == "todos") {
        //         $(".zonas").show();
        // }
    } 
});
//para mostrar zonas y sus mesas respectivamente
$("#zonaElige").change(function() {
    var valorSelect = $("option:selected", this).val(); //obtener el value de un select
    if (valorSelect != "") {            
        $(".zonas").hide();
        $("#" + valorSelect).show();
            // if (valorSelect == "todos") {
            //     $(".zonas").show();
            // }
    } else {
        swal({
            title: 'Oopss...',
            text: '¡Por favor elija una zona!',
            type: 'error',
            timer: '1500'
        })
    }
});
 function aperturaMesa(idMesa) {
    //muestro el modal pero no lo dejo salir al hacer click fuera de este
    $('#myModal').modal({backdrop: 'static', keyboard: false }) 
 }
 function buscarHuesped(e){
    //  e.preventDefault();
     var csrf_token = $('meta[name="csrf-token"]').attr('content');
     var codigoHotel= $("#codigoHotel").val().length > 0;
     var numHabitacion= $("#numHabitacion").val().length > 0;      
     var codhotel= $("#codigoHotel").val();
     var room= $("#numHabitacion").val();

     if(codigoHotel && numHabitacion){        
        $.ajax({
            url: "{{ url('ordenar') }}"+'/'+codhotel+'/'+room,
            type: "GET",
            data: {
                '_method': 'GET',
                '_token': csrf_token
            },
            success: function(respuesta) {
                var resultado=JSON.parse(respuesta);                
                var objeto = resultado["objeto"];
                var errorCode=objeto["errCode"]; //0 si se encontró el huesped, 404 si no se encontró               
                var reserva=objeto["reserva"];
                var nombre=objeto["nombre"];
                var room=objeto["room"];
                var ocupante=objeto["Ocupante"];
                var fechaSalida=objeto["FechaSalida"];                
                var brazalete = (objeto["brazalete"] == null) ? "Sin brazalete" : objeto["brazalete"];// ternario
                
                if(errorCode==0){
                    $("#mensajeRespuesta").html('<div class="alert alert-success"><strong>Datos encontrados</strong></div>');
                    $("#reserva").val(reserva);
                    $("#nombre").val(nombre);
                    $("#room").val(room);
                    $("#ocupante").val(ocupante);
                    $("#fechaSalida").val(fechaSalida);
                    $("#brazalete").val(brazalete);
                }else if(errorCode==401){
                    $("#mensajeRespuesta").html('<div class="alert alert-warning"><strong>No se encontró el hotel</strong></div>');
                }else if(errorCode==404){
                    $("#mensajeRespuesta").html('<div class="alert alert-warning"><strong>No se encontro Información de Huesped</strong></div>');
                }
            },
            error: function() {
            console.log(respuesta);
            }
    });                    
    }else{
        swal({
            title: 'Oops...',
            text: '¡Por favor no deje campos vacios para la busqueda!',
            type: 'error',
            timer: '2000'
        }) 
    }    
 }
 
</script>