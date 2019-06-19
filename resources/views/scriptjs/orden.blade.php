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
    var estadoMesa = $("#mesaAbrir"+idMesa).attr("estadoMesa");//obtengo el id de la mesa
    $('#idMesaModal').val(idMesa);
    var idPV= $("#idPVModalOrdenar").val();//obtengo el id de pv con el que se inició sesion

    if(estadoMesa=="disponible"){//si la mesa está disponible abro modal para obtener datos de huesped
        $('#myModal').modal({backdrop: 'static', keyboard: false });
        localStorage.setItem("idMesaLS", idMesa); 
    }else if(estadoMesa=="ocupado"){
        $("#zonaTomarOrden").removeClass("hidden");
        $("#zonaMesas").addClass("hidden");
        $("#myModal").modal("hide"); 
        localStorage.setItem("idMesaLS", idMesa);
        leerCuentaTemporal(idPV, idMesa); //obtengo los datos de productos de la cuenta temporal
        // var cuentaTemporal="cuentaTemporal"+idPV+idMesa;
        // var datosCuentaTemporal = localStorage.getItem(cuentaTemporal);
        // console.log("datosCuentaTemporal ",datosCuentaTemporal);
    }

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
                     // creo el objeto lST para la cuenta
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

       guardarCuenta(idMesa); //ejecuto esta funcion para guardar cuenta

     }else{
        swal({
            title: 'Oops...',
            text: '¡Tiene un campo vacio!'+idMesa,
            type: 'error',
            timer: '2000'
        });
     }

 }
 function guardarCuenta(idMesa){
     var csrf_token = $('meta[name="csrf-token"]').attr('content');
     var reserva  = $("#reserva").val();
     var nombreCliente  = $("#nombre").val();
     var pax  = $("#ocupante").val();
     var habitacion  = $("#room").val();

     var idPV= $("#idPVModalOrdenar").val();//obtengo el id de pv con el que se inició sesion
     //var idMesa= $("#idMesaModal").val();//obtengo el id de la mesa

      alergenos = [];//
      var contador=0;
    $("input[name='idAlergeno[]']").each( function () {
        if($(this).prop("checked")){
            alergenos[contador]= $(this).val();
            contador++;
        }	
    });               
     $.ajax({
            url: "{{ url('ordenar/addcuenta') }}",
            type: "POST",
            data: {
                '_method': 'POST',
                'alergenos':alergenos,
                'idMesa':idMesa,'reserva':reserva,'nombreCliente':nombreCliente,'habitacion':habitacion,
                '_token': csrf_token
            },        
            success: function(respuesta) {
                var resultado = JSON.parse(respuesta);
                var objeto = resultado["objeto"];
                var folio=objeto["folio"];
                // console.log("objeto", objeto);
                // console.log("respuesta folio "+folio);
                localStorage.setItem(idPV+idMesa, JSON.stringify(objeto)); //genero la variable LST con el objeto
            },
            error: function() {
            console.log(JSON.parse(respuesta));
        }
    }); 
 }

 function GetProductosBySubCat(idSubCat){
     var csrf_token = $('meta[name="csrf-token"]').attr('content'); 
    // console.log("hiciste clic");
    $.ajax({
            url: "{{url('obtener/productos')}}"+'/'+idSubCat,
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
                    // console.log(objeto);
                    listaProductos=""
                        for(i =0;  i<objeto.length; i++){
                            var idProducto=objeto[i]["id"];
                            var nombreProducto=objeto[i]["nombreProducto"];
                            var precio=objeto[i]["precio"];
                           listaProductos+="<li><div class='well well-sm'><div id='producto"+idProducto+"' idProducto="+idProducto+"' nProducto='"+nombreProducto+"' precio="+precio+"' onclick='addProducto("+idProducto+")' style='cursor: pointer;' ><strong>"+nombreProducto+"</strong></div><br><div style='cursor: pointer;' onclick='verAlergenos("+idProducto+")'>Alergenos</div></div></li>";
                        }
                    listaProductos+="";                     
                    $("#UlList"+idSubCat).html(listaProductos);
                }else{
                    $("#UlList"+idSubCat).html('<p>Sin productos para la subcategoria</p>');
                }
            },
            error: function(respuesta) {
            respuesta=JSON.parse(respuesta); 
            console.log(respuesta);
            }
    });
 }

var lstProductos=[];
function addProducto(idProducto) {

    var idPV= $("#idPVModalOrdenar").val();
    var idMesa = localStorage.getItem("idMesaLS");    
    var cuentaObjeto = JSON.parse(localStorage.getItem(idPV+idMesa));
    var idCuenta = cuentaObjeto["id"];
    var nombreProducto = $("#producto"+idProducto).attr("nProducto");
    var precio = $("#producto"+idProducto).attr("precio");
    

    var cuentaTemporal="cuentaTemporal"+idPV+idMesa;
    var datosCuentaTemporal = JSON.parse(localStorage.getItem(cuentaTemporal));

        if (typeof datosCuentaTemporal === 'undefined' || datosCuentaTemporal === null) {
	        lstProductos=[];
	    }else{
	       lstProductos=datosCuentaTemporal;	              
	    }
        while(true){
            var cantidad = prompt('Indique Cantidad', 1);           
            if(!isNaN(cantidad) && cantidad != null && cantidad != ""){            
                break;
            }else if(cantidad == 'fin'){
                break;
            }else{
                alert('no es numero');
                continue;
            }
        }      
    var subTotal = precio*cantidad;    
    lstProductos.push({"idCuenta":idCuenta,
                       "idPV":parseInt(idPV),
                       "idMesa":parseInt(idMesa),                       
                       "idProducto":parseInt(idProducto),
                       "nombreProducto":nombreProducto,
                       "cantidad":parseInt(cantidad),
                       "nota":"",
                       "precio":parseFloat(precio),
                       "subTotal":parseFloat(subTotal)});
    // console.log("su cuenta",cuentaObjeto);
    // console.log("su lista de productos", lstProductos);
    var cuentaTemporal="cuentaTemporal"+idPV+idMesa;
    localStorage.setItem(cuentaTemporal,JSON.stringify(lstProductos));    
    //estructura html para agregar algo a la tabla
    var filaTabla = "<tr><td><button class='btn btn-danger btn-xs' id='producto"+idProducto+"' name='itemProducto' onclick='deleteProductoItem("+idProducto+")'><i class='fas fa-times'></i></button></td><td>"+nombreProducto+"</td><td style='text-align:center;'>"+cantidad+"</td><td class='text-right'>"+precio+"</td><td class='text-right'>"+subTotal+"</td></tr>";
    $("table tbody").append(filaTabla);        
    //console.log("hiciste click mesa "+numeroDeMesa+" Idproducto: "+idProducto+" nombreProducto: "+nombreProducto);
 }
 
 function leerCuentaTemporal(idPV, idMesa) {
     var cuentaTemporal="cuentaTemporal"+idPV+idMesa;
     var datosCuentaTemporal = JSON.parse(localStorage.getItem(cuentaTemporal));
    if (typeof datosCuentaTemporal === 'undefined' || datosCuentaTemporal === null) {
        console.log("no tienes definido la variable");
    }else{
        console.log(datosCuentaTemporal);
        // console.log(datosCuentaTemporal[0]["idCuenta"]);
        var sumaSubTotales=0;   
        for (i = 0; i < datosCuentaTemporal.length; i++) {
            var idCuenta = datosCuentaTemporal[i]["idCuenta"];
            var idPV = datosCuentaTemporal[i]["idPV"];
            var idMesa = datosCuentaTemporal[i]["idMesa"];
            var idProducto = datosCuentaTemporal[i]["idProducto"];
            var nombreProducto = datosCuentaTemporal[i]["nombreProducto"];
            var cantidad = datosCuentaTemporal[i]["cantidad"];
            var precio = datosCuentaTemporal[i]["precio"];
            var subTotal = datosCuentaTemporal[i]["subTotal"]; 
            sumaSubTotales = sumaSubTotales + subTotal;
           lstProductosTr="<tr><td><button class='btn btn-danger btn-xs' id='producto"+idProducto+"' name='itemProducto' onclick='deleteProductoItem("+idProducto+")'><i class='fas fa-times'></i></button></td><td>"+nombreProducto+"</td><td style='text-align:center;'>"+cantidad+"</td><td class='text-right'>"+precio+"</td><td class='text-right'>"+subTotal+"</td></tr>";
           $("table tbody").append(lstProductosTr);
        } 
        var total="<tr><th colspan='2'>Total</th><th colspan='3' class='text-right'>"+sumaSubTotales+"</th></tr>";
        $("table tfoot").append(total);      
    } //sumaSubTotales
}

 function deleteProductoItem(idProducto) {
    $("table tbody").find('#producto'+idProducto).each(function(){
        $(this).parents("tr").remove();
    });
}
function verAlergenos(idProducto) {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');    
    $('#myModalAlergenos').modal('show');

    $.ajax({
            url: "{{ url('buscar/alergenos') }}"+'/'+idProducto,
            type: "GET",
            data: {
                '_method': 'GET',
                '_token': csrf_token
            },            
            success: function(respuesta) {
                var resultado=JSON.parse(respuesta); 
                var ok =resultado["ok"];                
                if(ok){//si ok es true obtengo los datos del objeto
                    var objeto=resultado["objeto"];                                             
                    // console.log(resultado.objeto[0].idAlergeno);
                    alergenosID = [];
                    for (i = 0; i < resultado.objeto.length; i++) {
                        alergenosID[i]= resultado.objeto[i].idAlergeno;
                    }
                    var contador=0;    
                    $("input[name='idAlergenoProducto[]']").each( function () {        
                        if($(this).val().includes(alergenosID[contador])){               
                            $(this).prop('checked', true);
                            valorIdAlergeno= $(this).val();
                            $("#labelCheck"+valorIdAlergeno).addClass("label label-success");
                            contador++;
                        }	
                    });
                    marcarAlergenosMatch(idProducto);
                }
            },
            error: function(respuesta) {
            resultado=JSON.parse(respuesta); 
            console.log(resultado);
            }
    });    
}
function marcarAlergenosMatch(idProducto){
    var idPV= $("#idPVModalOrdenar").val();
    var idMesaLS = localStorage.getItem("idMesaLS");
    var variableLS =idPV+idMesaLS;

    var datosCuentaObjeto = JSON.parse(localStorage.getItem(variableLS));// reconvierto el string a un objeto json
    // console.log(variableLS);
    var idAlergenos = datosCuentaObjeto["TPV_AlergenosCuenta"];
   /* console.log(datosCuentaObjeto); console.log(idAlergenos[0].idAlergeno); alergenosIdHuesped = [8,9]; //aqui voy generando el array que recibo de los que tiene el huesped*/
    alergenosIdHuesped = [];
    for (i = 0; i < idAlergenos.length; i++) {
        alergenosIdHuesped[i]= idAlergenos[i].idAlergeno;
    }
//    console.log(idAlergenos);
    var contador=0;
    $("input[name='idAlergenoProducto[]']").each( function () {
        //    console.log(n)                        ;
        if((alergenosIdHuesped.indexOf(parseInt($(this).val()))!=-1) && $(this).prop("checked")){
            valorIdAlergeno= $(this).val();            
            $("#labelCheck"+valorIdAlergeno).addClass("label label-warning");             
            contador++;	
        }
    });
    //$(this).val().includes(alergenosIdHuesped[contador]) 
}
function cargaAlergeno(idProducto){
    var idPV= $("#idPVModalOrdenar").val();
    var idMesaLS = localStorage.getItem("idMesaLS");
    var variableLS =idPV+idMesaLS;

    var datosCuentaObjeto = JSON.parse(localStorage.getItem(variableLS));
    var idAlergenos = datosCuentaObjeto["TPV_AlergenosCuenta"];  
    alergenosIdHuesped = [];
    for (i = 0; i < idAlergenos.length; i++) {
        alergenosIdHuesped[i]= idAlergenos[i].idAlergeno;
    }
    var contador=0;
    $("input[name='idAlergenoProducto[]']").each( function () {                       
        if((alergenosIdHuesped.indexOf(parseInt($(this).val()))!=-1) && $(this).prop("checked")){
            valorIdAlergeno= $(this).val();            
            $("#labelCheck"+valorIdAlergeno).addClass("label label-warning");             
            contador++;	
        }
    });
    
}
/*al cerrrar el modal myModalAlergenos quito los check previamente marcados en el modal
E igual quito los colores de los label*/
$('#myModalAlergenos').on('hidden.bs.modal', function (e) {
    $("input[name='idAlergenoProducto[]']").each( function () {        
        if($(this).prop("checked")){ 
            valorIdAlergeno= $(this).val();              
            $(this).prop('checked', false);
            $("#labelCheck"+valorIdAlergeno).removeClass("label label-success");
            $("#labelCheck"+valorIdAlergeno).removeClass("label label-warning");                      
        }	
    });        
});

</script>

                        
