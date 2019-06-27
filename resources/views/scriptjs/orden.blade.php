<script>
$(document ).ready(function() {
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
    //     });
    // }
});
 function aperturaMesa(idMesa) {
    //muestro el modal pero no lo dejo salir al hacer click fuera de este
    var estadoMesa = $("#mesaAbrir"+idMesa).attr("estadoMesa");//obtengo el id de la mesa
    $('#idMesaModal').val(idMesa);
    var idPV= $("#idPVModalOrdenar").val();//obtengo el id de pv con el que se inició sesion
    var idMenuCarta = $("#idMemuCartaPVModal").val();

    if(estadoMesa=="disponible"){//si la mesa está disponible abro modal para obtener datos de huesped
        $('#myModal').modal({backdrop: 'static', keyboard: false });
        localStorage.setItem("idMesaLS", idMesa);

        $("#btnEnviarCP").attr("idPVCPBtn",idPV);
        $("#btnEnviarCP").attr("idMesaCPBtn",idMesa);
        $("#btnEnviarCP").attr("idMenuCartaCPBtn",idMenuCarta);
                

    }else if(estadoMesa=="ocupado"){
        $("#zonaTomarOrden").removeClass("hidden");
        $("#zonaMesas").addClass("hidden");
        $("#myModal").modal("hide"); 
        localStorage.setItem("idMesaLS", idMesa);
        $("#btnEnviarCP").attr("idPVCPBtn",idPV);
        $("#btnEnviarCP").attr("idMesaCPBtn",idMesa);
        $("#btnEnviarCP").attr("idMenuCartaCPBtn",idMenuCarta);
        var idCuenta =getIdCuenta(idPV,idMesa);            
        $("#btnAddDescuento").attr("btnIdCuenta",idCuenta); 
        $("#idCuentaSpan").attr("idCuentaAttr",idCuenta);         
        obtenerDatosCuentaApi(idPV,idMesa,idCuenta);
        //obtengo los datos de productos de la cuenta temporal
        // var cuentaTemporal="cuentaTemporal"+idPV+idMesa;
        // var datosCuentaTemporal = localStorage.getItem(cuentaTemporal);
        // console.log("datosCuentaTemporal ",datosCuentaTemporal);
    }

 }
 function getIdCuenta(idPV,idMesa){    
    var variable=idPV+idMesa;
    var cuenta = JSON.parse(localStorage.getItem(variable));
    var idCuenta =cuenta["id"];
    return idCuenta;
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
                console.log("resultado", resultado);
                var ok = resultado["ok"];
                if(ok){
                    var objeto = resultado["objeto"];
                    var idCuenta=objeto["id"];
                    var folio=objeto["folio"];
                    // console.log("respuesta folio "+folio);
                    $("#btnAddDescuento").attr("btnIdCuenta",idCuenta);//creo los atributos
                    localStorage.setItem(idPV+idMesa, JSON.stringify(objeto)); //genero la variable LST con el objeto
                }else{
                    var mensaje=resultado["mensaje"];
                    swal({
                        title: 'Error',
                        text: mensaje,
                        type: 'error',
                        // timer: '1500'
                            }).then(function(){ 
                                location.reload();
                        }
                    );
                }                
            },
            error: function() {
            console.log(JSON.parse(respuesta));
        }
    }); 
 }

 function GetProductosBySubCat(idSubCat){
    var csrf_token = $('meta[name="csrf-token"]').attr('content'); 
    var idPV= $("#idPVModalOrdenar").val();
    var idMesaLS = localStorage.getItem("idMesaLS");
    var variableLS =idPV+idMesaLS;

    var datosCuentaObjeto = JSON.parse(localStorage.getItem(variableLS));// reconvierto el string a un objeto json
    // console.log(variableLS);
    var alergenosCuenta = datosCuentaObjeto["TPV_AlergenosCuenta"];
    alergenosIdHuesped = [];
    for (i = 0; i < alergenosCuenta.length; i++) {
        alergenosIdHuesped[i]= alergenosCuenta[i].idAlergeno;
    }
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
                    console.log(objeto);
                    listaProductos=""
                        for(i =0;  i<objeto.length; i++){
                            var colorAlergeno = "label-info";
                            var idProducto=objeto[i]["id"];
                            var nombreProducto=objeto[i]["nombreProducto"];
                            var precio=objeto[i]["precio"];
                            var alergenosP = objeto[i]["TPV_ProductoAlergeno"];
                            console.log("sus Alergenos",alergenosP);
                           if(alergenosP.length >0 ){
                                //operador ternario
                            alergenosIdP = [];                            
                                for (j = 0; j < alergenosP.length; j++) {
                                    if(alergenosIdHuesped.indexOf(alergenosP[j].idAlergeno)!=-1){
                                            colorAlergeno="label-warning";
                                    }
                                } 
                            }                                                                                
                            // console.log("sus Alergenos",alergenosPOk);
                           listaProductos+="<li><div class='well well-sm'><div id='producto"+idProducto
                           +"' idProducto="+idProducto+"' nProducto='"+nombreProducto+"' precio='"+precio+"' onclick='addCantidadProductoModal("+idProducto+")' style='cursor: pointer;' ><strong>"+
                           nombreProducto+"</strong></div><br><span style='cursor: pointer;' class='label "+colorAlergeno+"' onclick='verAlergenos("+idProducto+")'>Alergenos</span></div></li>";
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
 function addCantidadProductoModal(idProducto) {
     $('#modalCantidadProducto').modal({backdrop: 'static', keyboard: false });
     $("#idProductoModal").val(idProducto);
     $(document).on("input", "#cantidadProducto", function() {
        this.value = this.value.replace(/[^0-9]/g, '');
     });
     //valido que se ingrese un valor mayor  a cero
    $("#cantidadProducto").on('input', function(){
        var cant = parseInt(this.value, 10);
       $("#addProductoBtn").attr("disabled", cant <= 0);                
    });
 }
$("#cantidadProducto").change(function(){ 	
 	var cantidad = $("#cantidadProducto").val(); 	
 	var soloNumeros = this.value.replace(/[^0-9]/g,''); 	
	    if(soloNumeros > 0 && cantidad !=''){	        
	        $("#addProductoBtn").removeAttr("disabled");	        
	    }else{
	        swal("Oops", "Ingrese un valor numerico mayor a cero" ,  "error");
	        $("#cantidadProducto").val(1);	        	        
	    }	 
 });

var lstProductos=[];
function addProducto() { 
      

    var idPV= $("#idPVModalOrdenar").val();
    var idMenuCarta = $("#idMemuCartaPVModal").val();
    var idUsuario = $("#idUserModalOrdenar").val();
    var idProducto=$("#idProductoModal").val();
    var cantidad=$("#cantidadProducto").val();
    var idMesa = localStorage.getItem("idMesaLS");
    var cuentaObjeto = JSON.parse(localStorage.getItem(idPV+idMesa));
    var idCuenta = cuentaObjeto["id"];
    var nombreProducto = $("#producto"+idProducto).attr("nProducto");
    // var nota = $("#producto"+idProducto).attr("nota");
    var precio = $("#producto"+idProducto).attr("precio");
    $("#modalCantidadProducto").modal("hide");
    //reseteo los valores de los campos del modal por si acaso 
     $('#modalCantidadProducto').on('hidden.bs.modal', function (e) {
        $(this).find('form')[0].reset();
    });
    
    var cuentaTemporal="cuentaTemporal"+idPV+idMesa;
    var datosCuentaTemporal = JSON.parse(localStorage.getItem(cuentaTemporal));

    if (typeof datosCuentaTemporal === 'undefined' || datosCuentaTemporal === null) {
        lstProductos=[];
    }else{
        lstProductos=datosCuentaTemporal;	              
    }       

    var subTotal = precio*cantidad;    
    lstProductos.push({"idCuenta":idCuenta,
                       "idPV":parseInt(idPV),
                       "idMesa":parseInt(idMesa),
                       "idMenuCarta":parseInt(idMenuCarta),
                       "idProducto":parseInt(idProducto),
                       "nombreProducto":nombreProducto,
                       "cantidad":parseInt(cantidad),
                       "comensal":3,
                       "tiempo":2,
                       "idUsuarioAlta":parseInt(idUsuario),
                       "nota":"",
                       "precioUnitario":parseFloat(precio),
                       "subTotal":parseFloat(subTotal)});
    // console.log("su cuenta",cuentaObjeto);
    // console.log("su lista de productos", lstProductos);
    //var cuentaTemporal="cuentaTemporal"+idPV+idMesa;
    localStorage.setItem(cuentaTemporal,JSON.stringify(lstProductos));   
    // var count = lstProductos.length-1; 
    // //estructura html para agregar algo a la tabla
    // var filaTabla = "<tr ><td><button class='btn btn-danger btn-xs' id='pos"+count+"' name='itemProducto'  onclick='deleteProductoItem("+count+","+idPV+","+idMesa+")'><i class='fas fa-times'></i></button></td><td>"+nombreProducto+"</td><td style='text-align:center;'>"+cantidad+"</td><td class='text-right'>"+precio+"</td><td class='text-right'>"+subTotal+"</td></tr><tr><td colspan='5'><input type='text' id='nota"+count+"' class='form-control' value='' placeholder='Agregar nota' onchange='addNota("+count+","+idPV+","+idMesa+")'></td></tr>";
    // $("table tbody").append(filaTabla);      
    leerCuentaTemporal(idPV,idMesa);  
    //console.log("hiciste click mesa "+numeroDeMesa+" Idproducto: "+idProducto+" nombreProducto: "+nombreProducto);    
 }

 function leerCuentaTemporal(idPV, idMesa) {
    $("#tablaItemProductos tbody").empty();
    $("#tablaItemProductos tfoot").empty();
    var cadena=String(idPV)+String(idMesa);  
    var cuenta = JSON.parse(localStorage.getItem(cadena)); 
     var sumaApiTotales=leerCuentaApi(idPV, idMesa); //lo que se tiene de la api
    //  console.log("sumaApiTotales",sumaApiTotales);
     var cuentaTemporal="cuentaTemporal"+idPV+idMesa;
     var datosCuentaTemporal = JSON.parse(localStorage.getItem(cuentaTemporal));
    if (typeof datosCuentaTemporal === 'undefined' || datosCuentaTemporal === null) {
        console.log("no tienes definido la variable");
    }else{
        console.log(datosCuentaTemporal);
        // console.log(datosCuentaTemporal[0]["idCuenta"]);
        var sumaSubTotales=0;
        var counter=-1;
        var counterTem=-1;        
        for (i = 0; i < datosCuentaTemporal.length; i++) {
            var idCuenta = datosCuentaTemporal[i]["idCuenta"];
            var idPV = datosCuentaTemporal[i]["idPV"];
            var idMesa = datosCuentaTemporal[i]["idMesa"];
            var idProducto = datosCuentaTemporal[i]["idProducto"];
            var nombreProducto = datosCuentaTemporal[i]["nombreProducto"];
            var nota = datosCuentaTemporal[i]["nota"];
            var cantidad = datosCuentaTemporal[i]["cantidad"];
            var precio = datosCuentaTemporal[i]["precioUnitario"];
            var subTotal = datosCuentaTemporal[i]["subTotal"]; 
            sumaSubTotales = sumaSubTotales + subTotal; //este son los totales de la cuenta temporal
            counter++;
            counterTem++;
           lstProductosTr="<tr class='success'><td><button id='pos"+counterTem+"'  class='btn btn-danger btn-xs' name='itemProducto' onclick='deleteProductoItem("+counterTem+","+idPV+","+idMesa+")'><i class='fas fa-times'></i></button></td><td>"+nombreProducto+"</td><td style='text-align:center;'>"+cantidad+"</td><td class='text-right'>"+precio+"</td><td class='text-right'>"+subTotal+"</td></tr><tr class='success'><td colspan='5'><input type='text' id='nota"+counterTem+"' class='form-control' value='"+nota+"' onchange='addNota("+counterTem+","+idPV+","+idMesa+")'></td></tr>";
           $("table tbody").append(lstProductosTr);
           
        }    
        cuenta["subtotalCuenta"] = sumaApiTotales +sumaSubTotales;
        
         localStorage.setItem(cadena, JSON.stringify(cuenta));
        mostrarTotales(cadena);//el total que trae la api y la suma de los totales en localstorage
    }
    return sumaSubTotales;
}
function mostrarTotales(cadena) {
       var cuenta = JSON.parse(localStorage.getItem(cadena));  
       var subtotal=  cuenta["subtotalCuenta"];
       var descuento= cuenta["descuento"];

     var porcentaje = cuenta["descuentoPorc"]; 
     var totalSinDescuento = cuenta["subtotalCuenta"];
     var descuentCalculado=((porcentaje*totalSinDescuento)/100);
     var TotalConDescuento=totalSinDescuento-descuentCalculado;
 
     cuenta["descuento"]=descuentCalculado;
     cuenta["totalCuenta"]=TotalConDescuento;

    localStorage.setItem(cadena, JSON.stringify(cuenta));
    var total="<tr><th colspan='2'>Subtotal</th><th colspan='3' class='text-right'><input type='text' class='form-control' id='totalCuentaSinDesc' value='"+subtotal+"' disabled></th></tr>";
    var sdescuento="<tr class='danger'><th colspan='2'>Descuento</th><th colspan='3' class='text-right'><input type='text' class='form-control' id='descuentoCuenta' value='"+descuentCalculado+"' disabled></th></tr>";
    var totalFinal="<tr class='success'><th colspan='2'>Total</th><th colspan='3' class='text-right'><input type='text' class='form-control' id='totalCuenta' value='"+TotalConDescuento+"' disabled></th></tr>";

    $("table tfoot").append(total);//sumaSubTotales         
    $("table tfoot").append(sdescuento);//sumaSubTotales         
    $("table tfoot").append(totalFinal);//sumaSubTotales
}
 function leerCuentaApi(idPV, idMesa) {
     var counter=-1;
     var cuentaAPi="cuentaBD"+idPV+idMesa;
     var objCuentaAPi =JSON.parse(localStorage.getItem(cuentaAPi));
    if (typeof objCuentaAPi === 'undefined' || objCuentaAPi === null) {
        console.log("no tienes definido la variable");
    }else{
        console.log(objCuentaAPi);
        // console.log(objCuentaAPi[0]["idCuenta"]);
        var sumaSubTotales=0;
        
        for (i = 0; i < objCuentaAPi.length; i++) {
            var idCuenta = objCuentaAPi[i]["idCuenta"];
            var idPV = objCuentaAPi[i]["idPV"];
            var idMesa = objCuentaAPi[i]["idMesa"];
            var idDetalleCuenta= objCuentaAPi[i]["idDetalleCuenta"];
            var idProducto = objCuentaAPi[i]["idProducto"];
            var nombreProducto = objCuentaAPi[i]["nombreProducto"];            
            var nota = (objCuentaAPi[i]["nota"] == null) ? "" : objCuentaAPi[i]["nota"];// ternario
            var cantidad = objCuentaAPi[i]["cantidad"];
            var precio = objCuentaAPi[i]["precioUnitario"];
            var total = cantidad * precio;
            sumaSubTotales = sumaSubTotales + total;
            counter++;
           lstProductosTr="<tr class='danger'><td><button id='posi"+counter+"'  class='btn btn-danger btn-xs' name='itemProducto' onclick='cancelarProductoModal("+idDetalleCuenta+","+counter+")'>Cancel</button></td><td>"+nombreProducto+"</td><td style='text-align:center;'>"+cantidad+"</td><td class='text-right'>"+precio+"</td><td class='text-right'>"+total+"</td></tr><tr class='danger'><td colspan='5'><input type='text' id='notaApi"+counter+"' class='form-control' value='"+nota+"' disabled></td></tr>";
           $("table tbody").append(lstProductosTr);
           
        }
    } //sumaSubTotales
    // console.log("sumaApitotal",sumaSubTotales);
    return sumaSubTotales;               
}
function obtenerDatosCuentaApi(idPV,idMesa,idCuenta){
     var csrf_token = $('meta[name="csrf-token"]').attr('content');
    
    $.ajax({
            url: "{{url('obtenercuenta')}}"+'/'+idCuenta,
            type: "GET",
            data: {
                '_method': 'GET',
                '_token': csrf_token
            },            
            success: function(respuesta) {
                var respuesta=JSON.parse(respuesta);
                var ok = respuesta["ok"];
                if(ok){
                    var cuentaApi="cuentaBD"+idPV+idMesa;//creo la variable
                    var objeto=respuesta["objeto"];                    
                    console.log(objeto);
                     lstProductos=[];
                        for(i =0;  i<objeto.length; i++){                           
                            var menuCarta = objeto[i]["TPV_MenuCarta"];
                            var idMenuCarta=menuCarta["id"];
                            var idProducto=menuCarta["idProducto"];                            
                            var idDetalleCuenta=objeto[i]["id"];
                            var producto = objeto[i]["TPV_MenuCarta"]["TPV_Producto"];
                            var nombreProducto=producto["nombreProducto"];
                            var cantidad=objeto[i]["cantidad"];
                            var comensal=objeto[i]["comensal"];
                            var tiempo=objeto[i]["tiempo"];
                            var idUsuarioAlta=objeto[i]["idUsuarioAlta"];
                            var nota=objeto[i]["nota"];
                            var precio=objeto[i]["precioUnitario"];

                            lstProductos.push({"idCuenta":idCuenta,
                                "idPV":parseInt(idPV),
                                "idMesa":parseInt(idMesa),
                                "idDetalleCuenta":parseInt(idDetalleCuenta),
                                "idMenuCarta":parseInt(idMenuCarta),
                                "idProducto":parseInt(idProducto),
                                "nombreProducto":nombreProducto,
                                "cantidad":parseInt(cantidad),
                                "comensal":parseInt(comensal),
                                "tiempo":parseInt(tiempo),
                                "idUsuarioAlta":parseInt(idUsuarioAlta),
                                "nota":nota,
                                "precioUnitario":parseFloat(precio)
                            });
                           
                        }
                localStorage.setItem(cuentaApi,JSON.stringify(lstProductos));   
                } 
                leerCuentaTemporal(idPV, idMesa);
                 console.log(respuesta);
            },
            error: function(respuesta) {
            respuesta=JSON.parse(respuesta); 
            console.log(respuesta);
            }
    });
}
 function deleteProductoItem(pos,idPV,idMesa) {
     var cuentaTemporal="cuentaTemporal"+idPV+idMesa;//creo la variable
     var datosCuentaTemporal = JSON.parse(localStorage.getItem(cuentaTemporal));
     
      console.log(datosCuentaTemporal);
      
    $("table tbody").find('#pos'+pos).each(function(){
        $(this).parents("tr").remove();
    });
    $("table tbody").find('#nota'+pos).each(function(){
        $(this).parents("tr").remove();
    });
    // delete splice[productoNum];
    datosCuentaTemporal.splice(pos,1);
	    
    localStorage.setItem(cuentaTemporal,JSON.stringify(datosCuentaTemporal));
    leerCuentaTemporal(idPV, idMesa);
}

function addNota(indiceProducto,idPV,idMesa){
    var cuentaTemporal="cuentaTemporal"+idPV+idMesa;//creo la variable
    var datosCuentaTemporal = JSON.parse(localStorage.getItem(cuentaTemporal));
    var nota=$("#nota"+indiceProducto).val();
    //obtengo la nota y lo agrego al producto    
    datosCuentaTemporal[indiceProducto]["nota"]=nota;
    localStorage.setItem(cuentaTemporal,JSON.stringify(datosCuentaTemporal));
    console.log("cambiaste de foco");
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
 function enviarCentroPrep() {
     var csrf_token = $('meta[name="csrf-token"]').attr('content');
     var idPV = $("#btnEnviarCP").attr("idPVCPBtn");
     var idMesa = $("#btnEnviarCP").attr("idMesaCPBtn");
     var idMenuCarta = $("#btnEnviarCP").attr("idMenuCartaCPBtn");

     //console.log("idPV es: "+idPV+" idMesa: "+idMesa+" idMenuCarta: "+idMenuCarta);
     var cuentaTemporal="cuentaTemporal"+idPV+idMesa;//creo la variable
     var datosCuentaTemporal = JSON.parse(localStorage.getItem(cuentaTemporal));
     var longitud = datosCuentaTemporal.length;
     
     if(datosCuentaTemporal != null && longitud>0){
         $.ajax({
            url: "{{ url('ordenar/enviarcuenta') }}",
            type: "POST",
            data: {
                '_method': 'POST',
                'cuentaTemporal':datosCuentaTemporal,                
                '_token': csrf_token
            },        
            success: function(respuesta) {
                // console.log("su respuesta desde CONtroller", respuesta);
                var respuesta = JSON.parse(respuesta);
                var ok = respuesta["ok"];
                console.log("respuesta",respuesta);
                if(ok){//si ok es true
                     localStorage.setItem(cuentaTemporal, null);
                     swal({
                            title: 'Exito',
                            text: '¡Operacion realizada con exito!',
                            type: 'success',
                            timer: '1500'
                        }).then(function(){ 
                            location.reload();
                        }
                    );
                }
            },
            error: function() {
                console.log(respuesta);
        }
    });          
     }else{                  
         swal({
            title: 'Oopss...',
            text: '¡Por favor agregue productos a la cuenta!',
            type: 'error',
            timer: '1500'
        });
     }
 }
 function cancelarProductoModal(idDetalleCuenta,posicion){
    $('#modalCancelarProducto').modal({backdrop: 'static', keyboard: false });
    $("#idDetalleCuenta").val(idDetalleCuenta);
    $("#posicionProductoCancelar").val(posicion);
    // cancelarProductoCuenta();       
 }
 $('#modalCancelarProducto').on('hidden.bs.modal', function (e) {
     $(this).find('form')[0].reset();
});
 function cancelarProductoCuenta(){
    idDetalleCuenta =$("#idDetalleCuenta").val();
    posicionProducto =$("#posicionProductoCancelar").val();

    motivoCancelacion =$("#motivoCancelacion").val();

    var idPV=$("#idPVModalOrdenar").val();
    var idMesa=localStorage.getItem("idMesaLS");//
    
    var cuentaAPi="cuentaBD"+idPV+idMesa;
    var datosCuentaAPi =JSON.parse(localStorage.getItem(cuentaAPi));

    if(motivoCancelacion.length >= 20) {                     
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
                url: "{{ url('cancelarproducto') }}"+'/'+idDetalleCuenta,
                type: "DELETE",
                data: {
                    '_method': 'DELETE',
                    'motivo':motivoCancelacion,
                    '_token': csrf_token
                },
                success: function(respuesta) {
                    var respuesta=JSON.parse(respuesta);                 
                    var ok = respuesta["ok"]; 

                    console.log(respuesta);
                    if(ok){
                        console.log("la cuenta bdAPi",datosCuentaAPi);
                        $("#modalCancelarProducto").modal("hide");

                        $("table tbody").find('#posi'+posicionProducto).each(function(){
                            $(this).parents("tr").remove();
                        });
                        $("table tbody").find('#notaApi'+posicionProducto).each(function(){
                            $(this).parents("tr").remove();
                        }); 
                        datosCuentaAPi.splice(posicionProducto,1);
                        localStorage.setItem(cuentaAPi,JSON.stringify(datosCuentaAPi));
                    }                    
                },
                error: function(respuesta) {                    
                    swal({
                        title: 'Oops...',
                        text: '¡Algo salió mal!',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
    } else{
        swal({
            title: 'Oops...',
            text: '¡EL motivo tiene que ser mayor a 20 caracteres!',
            type: 'error',
            timer: '2500'
        })
    }
 }
 function addDescuentoCuentaModal() {
     idCuenta=$("#btnAddDescuento").attr("btnIdCuenta");
     $("#idCuentaModalDescuento").val(idCuenta);
     $('#modalDescuentoCuenta').modal({backdrop: 'static', keyboard: false });

     $(document).on("input", "#cantidadDescuento", function() {
        this.value = this.value.replace(/[^0-9]/g, '');
     });
     //valido que se ingrese un valor mayor  a cero
    $("#cantidadDescuento").on('input', function(){
        var cant = parseInt(this.value, 10);
       $("#addDescuentoBtn").attr("disabled", cant <= 0);                
    });

    //  console.log("idCuenta",idCuenta);
 }
 $("#cantidadDescuento").change(function(){ 	
 	var porcentaje = $("#cantidadDescuento").val(); 	
 	var soloNumeros = this.value.replace(/[^0-9]/g,''); 	
	    if(soloNumeros > 0  && soloNumeros <= 100 && porcentaje !=''){	                               
	        $("#addDescuentoBtn").removeAttr("disabled");	        
	    }else{
	        swal("Oops", "Ingrese un valor numerico de 0 a 100" ,  "error");
	        $("#cantidadDescuento").val(1);	        	        
	    }	 
 });
 function addDescuento(){
     var idPV = $("#btnEnviarCP").attr("idPVCPBtn");
     var idMesa = $("#btnEnviarCP").attr("idMesaCPBtn");
     var cuenta = JSON.parse(localStorage.getItem(idPV+idMesa));  

   
     var porcentaje = $("#cantidadDescuento").val(); 
     var totalSinDescuento = cuenta["subtotalCuenta"];
     var descuentCalculado=((porcentaje*totalSinDescuento)/100);
     var TotalConDescuento=totalSinDescuento-descuentCalculado;
     $("#descuentoCuenta").val(descuentCalculado); 
    //  $("#descuentoCuenta").attr("porcentajeDescuento",porcentaje)
        //  
     $("#totalCuenta").val(TotalConDescuento);
     cuenta["descuentoPorc"]=porcentaje;
     cuenta["descuento"]=descuentCalculado;
     cuenta["totalCuenta"]=TotalConDescuento;
    //  console.log("idCuenta",idCuenta);
    //  console.log("descuentoPorcentaje",porcentaje);      
    $("#modalDescuentoCuenta").modal("hide");
    //reseteo los valores de los campos del modal por si acaso 
     $('#modalDescuentoCuenta').on('hidden.bs.modal', function (e) {
        $(this).find('form')[0].reset();
    });
   
    localStorage.setItem(idPV+idMesa, JSON.stringify(cuenta));
 }

 function cerrarCuentaModal() {     
     var idPV = $("#btnEnviarCP").attr("idPVCPBtn");//obtengo el idPV que tengo en el btn enviar
     var idMesa = $("#btnEnviarCP").attr("idMesaCPBtn");//obtengo el idMesa que tengo en el btn enviar

     var idCuenta = $("#idCuentaSpan").attr("idCuentaAttr");//obtengo el idMesa que tengo en el btn enviar

     var cuentaTemporal="cuentaTemporal"+idPV+idMesa;//creo la variable
     var datosCuentaTemporal = JSON.parse(localStorage.getItem(cuentaTemporal));
     if(datosCuentaTemporal==null){
        var longitud = 0;
     }else{
         longitud =datosCuentaTemporal.length
     }
    //  console.log("cuentaTemporal",datosCuentaTemporal);
     
    if(longitud==0 ){
        $('#modalMetodoPago').modal({backdrop: 'static', keyboard: false });
        $("#idCuentaCerrar").val(idCuenta);
    }else{
        swal({
            title: 'Oopss...',
            text: '¡Aún tienes productos sin enviar a centros de preparación!',
            type: 'error',
            timer: '2500'
        });
    }
 }
 function cerrarCuenta() {
     var csrf_token = $('meta[name="csrf-token"]').attr('content');
     var idPV = $("#btnEnviarCP").attr("idPVCPBtn");
     var idMesa = $("#btnEnviarCP").attr("idMesaCPBtn");

     var cuenta = JSON.parse(localStorage.getItem(idPV+idMesa));        
     var idCuenta = $("#idCuentaSpan").attr("idCuentaAttr");  
     var porcentajeDesc = cuenta["descuentoPorc"]; 
     var idFormaPago = $("#formaPagoSelect option:selected" ).val();
     $("#modalMetodoPago").modal("hide");     
     $.ajax({
        url: "{{ url('ordenar/cerrarcuenta') }}"+'/'+idCuenta,
        type: "POST",
        data: {
            '_method': 'POST',           
            'porcentajeDescuento':porcentajeDesc,                    
            'idFormaPago':idFormaPago,
            '_token': csrf_token
        },
        success: function(respuesta) {             
             var respuesta = JSON.parse(respuesta);
             var ok = respuesta["ok"];                
                if(ok){//si ok es true                
                var cuenta=idPV+idMesa;
                var cuentaTemporal="cuentaTemporal"+cuenta;
                var cuentaAPi="cuentaBD"+cuenta;

                     localStorage.removeItem(cuenta);
                     localStorage.removeItem(cuentaTemporal);
                     localStorage.removeItem(cuentaAPi);

                     swal({
                            title: 'Exito',
                            text: '¡Operacion realizada con exito!',
                            type: 'success',
                            timer: '1500'
                        }).then(function(){ 
                            location.reload();
                        }
                    );
                }                                
        },
        error: function(respuesta) {                    
            console.log("respuesta",respuesta); 
        }
    });
 }
</script>

                        


