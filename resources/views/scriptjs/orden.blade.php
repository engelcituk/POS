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
    }// else {
    //     swal({
    //         title: 'Oopss...',
    //         text: '¡Por favor elija una zona!',
    //         type: 'error',
    //         timer: '1500'
    //     })
    // }
});
 function aperturaMesa(idMesa) {
    //muestro el modal pero no lo dejo salir al hacer click fuera de este
    $('#myModal').modal({backdrop: 'static', keyboard: false })     
    $('#idMesaModal').val(idMesa);
 }
 function buscarHuesped(){
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
            beforeSend: function () {
                $("#mensajeRespuesta").html('<div class="loader"></div>');
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
  function abrirCuenta() {
     var idMesa = $("#idMesaModal").val();

     var reserva = $("#reserva").val().length > 0;
     var nombre = $("#nombre").val().length > 0;
     var room = $("#room").val().length > 0;
     var pax = $("#ocupante").val().length > 0;
     var fechaSalida = $("#fechaSalida").val().length > 0;
     var brazalete = $("#brazalete").val().length > 0;

     $("#idMesaAddProducts").attr("idMesaValue",idMesa); //le envio el id de la mesa a este atributo que me creo
     if(reserva && nombre && room && pax && fechaSalida && brazalete){
        $("#zonaTomarOrden").removeClass("hidden");
        $("#zonaMesas").addClass("hidden");
        $("#myModal").modal("hide");        
     }else{
        swal({
            title: 'Oops...',
            text: '¡Tiene un campo vacio!'+idMesa,
            type: 'error',
            timer: '2000'
        });
     }

 }
//  function guardarCuenta(){
//      var csrf_token = $('meta[name="csrf-token"]').attr('content');
//       alergenos = [];//
//       var contador=0;
//         $("input[name='idAlergeno[]']").each( function () {
//             if($(this).prop("checked")){
//             alergenos[contador]= $(this).val();
//             contador++;
//             }	
//         });        
//      $.ajax({
//             url: "{{ url('ordenar/addcuenta') }}",
//             type: "POST",
//             data: {
//                 '_method': 'POST',
//                  'alergenos':alergenos,
//                 '_token': csrf_token
//             },
//             beforeSend: function () {
//                 $("#mensajeRespuesta").html('<div class="loader"></div>');
//             },
//             success: function(respuesta) {
//                 console.log(respuesta);
//             },
//             error: function() {
//             console.log(respuesta);
//             }
//     }); 
//  }
 
//  function addProducto(idProducto) {
//     var numeroDeMesa = $("#idMesaAddProducts").attr("idMesaValue");//obtengo el id de la mesa

//     var idProducto = $("#producto"+idProducto).attr("idProducto");
//     var nombreProducto = $("#producto"+idProducto).attr("nProducto");
//     //estructura html para agregar algo a la tabla
//     var filaTabla = "<tr><td><button class='btn btn-danger btn-xs' name='itemProducto' onclick='deleteProductoItem("+idProducto+")'><i class='fas fa-times'></i></button></td><td>Minion Hi</td><td style='text-align:center;'>1.00</td><td class='text-right'>15.00</td><td class='text-right'>15.00</td></tr>";
//     $("table tbody").append(filaTabla);    
//     //console.log("hiciste click mesa "+numeroDeMesa+" Idproducto: "+idProducto+" nombreProducto: "+nombreProducto);
//  }
//  function deleteProductoItem(idProducto) {
//     $("table tbody").find('button[name="itemProducto"]').each(function(){
//         $(this).parents("tr").remove();
//     });
//  }
// $(document).on("click", ".addProducto", function() {
   
//   });
</script>