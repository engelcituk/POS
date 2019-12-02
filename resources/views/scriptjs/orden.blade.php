<script>

$(document ).ready(function() {
    demo.initMaterialWizard();
    // para deshabilitar boton de atras del navegador
    window.location.hash="inicio";
    window.location.hash="Inicio";//esta linea es necesaria para chrome
    window.onhashchange=function(){window.location.hash="inicio";}
        
});
// obtengo el valor permiso del usuario para abrir mesa 1 o 0
var permisoUserOnlyOpenTable=parseInt($("#userOpenMesaSpanPermission").text());

initZonas();
ocurreCambiosMesa();

function initZonas(){
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;
    if ((/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream)) {                    
        localStorage.removeItem('zon aMesaSeleccionada');
    }
    // para cargar las mesas de una zona en especifica
    btn = $(".buttonZonas");     
    if(localStorage.getItem('zonaMesaSeleccionada')){
        idZonaDefault = localStorage.getItem('zonaMesaSeleccionada').replace( /^\D+/g, ''); //obtengo el id
        nombreZona= btn.eq(idZonaDefault-1).text();
        $("#nombreZona").text(nombreZona);
        $("#zonaBtn"+idZonaDefault).addClass("btn-success");

    }else {
        valor = btn.eq(0).attr("idZonaBtn");
        nombreZona= btn.eq(0).text();
        $("#nombreZona").text(nombreZona);
        idZonaDefault = valor; // $("#zonaElige").children('option:first').val().replace( /^\D+/g, '');//obtengo el id; 
        localStorage.setItem('zonaMesaSeleccionada', "zona"+idZonaDefault);    

    }
    getMesasZona(idZonaDefault,false);// funcion que obtiene las mesas de la zona

}
function ocurreCambiosMesa(){
    // para el realtime
    var chat = $.connection.notificationHub; 
    $.connection.hub.url = 'http://172.16.1.45/TPVApi/signalr/hubs';
    $.connection.hub.start({ withCredentials: false }).done(function () {         
    });  
    chat.client.postToClient =  (data) => {                  
        initZonas();
    };
}

function getMesasZona(idZonaDefault, soloMesasActivas){    
    listaZonas="<div id='zona"+idZonaDefault+"' class='zonas'><ul class='nav nav-pills nav-pills-icons' role='tablist' id='zonaListaMesas"+idZonaDefault+"'></ul></div>";
    $("#zonasPV").html(listaZonas);
    getMesasPorZona(idZonaDefault);    
}

function cambiarZona(idZona) {    
    valorSelect = "zona"+idZona;
    $(".zonas").hide();    
    localStorage.setItem('zonaMesaSeleccionada', valorSelect);    
    $("#" + valorSelect).show(); 
    idZonaDefault = localStorage.getItem('zonaMesaSeleccionada').replace( /^\D+/g, ''); // obtengo el idZona
    soloMesasActivas =false;
    nombreZona= btn.eq(idZonaDefault-1).text();
    $("#nombreZona").text(nombreZona);
    getMesasZona(idZonaDefault, soloMesasActivas);
}

function getMesasPorZona(idZona) {
   var csrf_token = $('meta[name="csrf-token"]').attr('content'); 
    $.ajax({
            url: "{{ url('ordenar/obtenermesaszona')}}"+'/'+idZona,
            type: "GET",
            data: {
                '_method': 'GET',               
                '_token': csrf_token
            },        
            success: function(respuesta) {
                var respuesta = JSON.parse(respuesta);               
                var ok = respuesta["ok"];
                if(ok){
                    var objeto=respuesta["objeto"];                     
                    listaMesas="";
                    for(i =0;  i<objeto.length; i++){
                        var idMesa=objeto[i]["id"];
                        // var idZona=objeto[i]["idZona"];
                        // var nombre=objeto[i]["name"]; 
                        var nombreMesa=objeto[i]["name"];                       
                        var estado=objeto[i]["status"];
                        var cuenta=objeto[i]["cuenta"];
                                                
                        mesaStatus = (estado == 1) ? "disponible" : "ocupado";
                        mesaCss = (estado == 1) ? "mesaOrdenLibre" : "mesaOrdenOcupada";

                        var logintudCuenta=cuenta.length;
                        if(logintudCuenta>0){
                            room = (cuenta[0]["room"] == null) ? "Sin Hab" : cuenta[0]["room"];
                            idCuenta=cuenta[0]["cuenta"];
                            nombre= cuenta[0]["nombre"];
                            // room= cuenta[0]["room"];
                            total= cuenta[0]["total"];
                        }else{
                            idCuenta= "NO";
                            nombre= "SN";
                            room= "Sin Hab";
                            total= "0";
                        }
                        /*
                        <span class='label label-success'>1</span><span class='label label-warning'>2</span><span class='label label-default'>3</span><br>
                        */          
                        listaMesas+="<li class='abrirMesa' id='mesa"+idMesa+"' idCuenta='"+idCuenta+"' style='cursor:pointer;' idMesa='"+idMesa+"' onclick='aperturaMesa("+idMesa+")'><a id='mesaAbrir"+idMesa+"' role='tab' data-toggle='tab' aria-expanded='true' estadoMesa='"+mesaStatus+"' nombreMesa='"+nombreMesa+"' cuentaMesa='"+idCuenta+"' clienteMesa='"+nombre+"' habMesa='"+room+"'><div id='wellMesa"+idMesa+"' class='well well-sm mesaOrden "+mesaCss+"'><span class='label label-info'>"+nombreMesa+"</span><br><span id='idCuentaMesaSpan"+idMesa+"'>"+idCuenta+"</span><br><span id='nomClienteMesaSpan"+idMesa+"'>"+nombre+"</span><br> <span id='roomMesaSpan"+idMesa+"'>"+room+"</span><br><span id='totCuentaMesaSpan"+idMesa+"'>"+total+"</span></div></a></li>";
                    }
                    listaMesas+="";                     
                    $("#zonaListaMesas"+idZona).html(listaMesas);                    
                    crearVariableZonaDefault(); // mantengo la zona elegida por el usuario con localstorage
                    const element =  document.querySelector('#moduloOrdenar')
                    element.classList.add('animated', 'bounce');
                }else{
                    $("#zonaListaMesas"+idZona).html('<p>Sin mesas para esta zona</p>');
                }                
            },
            error: function(respuesta) {
            console.log(JSON.parse(respuesta));
        }
    });
}
//Para trabajar con las zonas que ocupan para cambiar mesas
function getZonas(){
    var csrf_token = $('meta[name="csrf-token"]').attr('content'); 

    $.ajax({
            url: "{{ url('ordenar/obtenerzonas')}}",
            type: "GET",
            data: {
                '_method': 'GET',               
                '_token': csrf_token
            },        
            success: function(respuesta) {
                var respuesta = JSON.parse(respuesta);               
                var ok = respuesta["ok"];
                if(ok){
                    var objeto=respuesta["objeto"];                     
                    objLenght= objeto.length;                    
                    if(objLenght>0){
                        var option = "<option>Elija una mesa</option>"
                         for (i = 0; i < objLenght; i++) {
                            var idZona = objeto[i]["id"];
                            var nombre = objeto[i]["name"];
                            getMesasActivasPorZona(nombre,idZona);
                        }
                    } 
                     $('.selectMesasZonas').append(option);                   

                }               
            },
            error: function(respuesta) {
                console.log(JSON.parse(respuesta));
        }
    });
}
function getMesasActivasPorZona(nombre,idZona) {
   var csrf_token = $('meta[name="csrf-token"]').attr('content'); 

    $.ajax({
            url: "{{ url('ordenar/getmesasactivas')}}"+'/'+idZona,
            type: "GET",
            data: {
                '_method': 'GET',               
                '_token': csrf_token
            },        
            success: function(respuesta) {
                var respuesta = JSON.parse(respuesta);               
                var ok = respuesta["ok"];
                if(ok){
                    var objeto=respuesta["objeto"];                    
                    var objLenght= objeto.length;
                    if(objLenght>0){                        
                        var optgroup = "<optgroup label='"+nombre+"'>"
                         for (i = 0; i < objLenght; i++) {
                            var idZona = objeto[i]["id"];
                            var nombreMesa=objeto[i]["name"];                             
                            optgroup +="<option value='"+idZona+"'>"+nombreMesa+"</option>"
                        }
                        optgroup += "</optgroup>"
                        $('.selectMesasZonas').append(optgroup);
                    }

                }else{
                    console.log("no hay mesas");                    
                }                
            },
            error: function(respuesta) {
                console.log(JSON.parse(respuesta));
        }
    });
}

function crearVariableZonaDefault(){  
    //button.btn-success
    btn = $(".buttonZonas");     
    if (localStorage.getItem('zonaMesaSeleccionada')) {            
        valDefault = localStorage.getItem('zonaMesaSeleccionada'); 
        idZonaDefault = localStorage.getItem('zonaMesaSeleccionada').replace( /^\D+/g, ''); // obtengo el idZona

        $('#zonaElige option[value='+valDefault+']').attr('selected','selected');  
        //pinto el boton de acuerdo a lo que recibo de localstorage
        $(".buttonZonas.btn-success").removeClass("btn-success");
        $("#zonaBtn"+idZonaDefault).addClass("btn-success");  
    }else {            
        //obtengo el botton con el primer valor y lo pinto en verde
        valor = btn.eq(0).attr("idZonaBtn"); 
        $(".buttonZonas.btn-success").removeClass("btn-success");
        $("#zonaBtn"+valor).addClass("btn-success");
        //guardo la zona seleccionada en localstorage
        localStorage.setItem('zonaMesaSeleccionada', "zona"+valor);
    }
                                                                               
    $(".zonas").hide();
    $("#" + valDefault).show();                                             
}
async function aperturaMesa(idMesa) {
    //muestro el modal pero no lo dejo salir al hacer click fuera de este
    var estadoMesa = $("#mesaAbrir"+idMesa).attr("estadoMesa");//obtengo el estado de la mesa
    
    var cuentaMesa = $("#mesaAbrir"+idMesa).attr("cuentaMesa");//obtengo la cuenta que ocupa la mesa
    var nombreMesa = $("#mesaAbrir"+idMesa).attr("nombreMesa");//obtengo el nombre de la mesa
    var clienteMesa = $("#mesaAbrir"+idMesa).attr("clienteMesa");//obtengo cliente
    var habitacionMesa = $("#mesaAbrir"+idMesa).attr("habMesa");//obtengo la hab.

    $('#idMesaModal').val(idMesa);
    var idPV= $("#idPVModalOrdenar").val();//obtengo el id de pv con el que se inició sesion
    var idMenuCarta = $("#idCartaPVModal").val();
	$(".alert").remove();// si hay mensajes de alerta, estas se remueven en el modal
    $("#nombreMesaSpan").text(nombreMesa);$("#clienteMesaSpan").text(clienteMesa);$("#habMesaSpan").text(habitacionMesa);
    
    if(estadoMesa=="disponible"){//si la mesa está disponible abro modal para obtener datos de huesped
        
        $('#myModal').modal({backdrop: 'static', keyboard: false });
        localStorage.setItem("idMesaLS", idMesa);
        $("#btnEnviarCP").attr("idPVCPBtn",idPV);
        $("#btnEnviarCP").attr("idMesaCPBtn",idMesa);
        $("#btnEnviarCP").attr("idMenuCartaCPBtn",idMenuCarta);
            
        var cuentaTemporal="cuentaTemporal"+idPV+idMesa;
        lstProductos=[];
        localStorage.setItem(cuentaTemporal,JSON.stringify(lstProductos));
                       
    }else if(estadoMesa=="ocupado"){
        $("#zonaTomarOrden").removeClass("hidden");
        $("#zonaMesas").addClass("hidden");
        $("#myModal").modal("hide"); 
        localStorage.setItem("idMesaLS", idMesa);
        $("#btnEnviarCP").attr("idPVCPBtn",idPV);
        $("#btnEnviarCP").attr("idMesaCPBtn",idMesa);
        $("#btnEnviarCP").attr("idMenuCartaCPBtn",idMenuCarta);
        var idCuenta =await getIdCuenta(idPV,idMesa); 
        
        $("#btnAddDescuento").attr("btnIdCuenta",idCuenta); 
        $("#idCuentaSpan").attr("idCuentaAttr",idCuenta);
        
        $("#cuentaMesaSpan").text(cuentaMesa);
        // obtengo el listado de zonas y las mesas activas
        getZonas();
        // genero los botones 
        crearCuentaTemporal(idPV,idMesa);                   
        generarBotonesClientes(idPV,idMesa);
        await getProductosMasVendidos();        
        await obtenerDatosCuentaApi(idPV,idMesa,idCuenta);  
        await contadoresProductos(idPV,idMesa);   
        await countProductosCuentaCategoria(idPV,idMesa);
    }

 }
 var lstProductos=[];
 function crearCuentaTemporal(idPV,idMesa){
     var cadena=String(idPV)+String(idMesa);
     var cuentaTemporal="cuentaTemporal"+cadena;
     if (!localStorage.getItem(cuentaTemporal)) {               
        localStorage.setItem(cuentaTemporal,JSON.stringify(lstProductos));      
    }
 }
 async function getIdCuenta(idPV,idMesa){    
    var variable=idPV+idMesa;
    // console.log("variable",variable);
    var cuenta = JSON.parse(localStorage.getItem(variable));    
    // console.log("cuenta",cuenta["id"]);

    idCuenta=$("#mesa"+idMesa).attr("idCuenta");
    if(idCuenta=="NO"){
        idCuenta=$("#cuentaMesaSpan").text();
    }else if(typeof idCuenta === 'undefined'){
        idCuenta=cuenta["id"];
    }     
    
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
        
    if(cuenta==null){  
        //obtengo la cuenta y creo la variable localstorage de acuerdo a la mesa                 
        await $.ajax({
                url: "{{url('getcuenta')}}"+'/'+idCuenta,
                type: "GET",
                data: {
                    '_method': 'GET',
                    '_token': csrf_token
                },            
                success: function(respuesta) {
                    var respuesta=JSON.parse(respuesta);
                    var ok = respuesta["ok"];
                    if(ok){
                        var objeto =  respuesta["objeto"];                          
                        localStorage.setItem(idPV+idMesa, JSON.stringify(objeto)); //genero la variable LST con el objeto                        
                        var cuentaGet = JSON.parse(localStorage.getItem(variable));
                        var idCuenta =cuentaGet["id"];
                    }                 
                }
        });
    }else{
        await $.ajax({
                url: "{{url('getcuenta')}}"+'/'+idCuenta,
                type: "GET",
                data: {
                    '_method': 'GET',
                    '_token': csrf_token
                },            
                success: function(respuesta) {
                    var respuesta=JSON.parse(respuesta);
                    var ok = respuesta["ok"];
                    if(ok){
                        var objeto =  respuesta["objeto"];                          
                        localStorage.setItem(idPV+idMesa, JSON.stringify(objeto)); //genero la variable LST con el objeto                        
                        var cuentaGet = JSON.parse(localStorage.getItem(variable));
                        var idCuenta =cuentaGet["id"];
                    }                 
                }
        });        
    }   
    return idCuenta;
 }  
 async function actualizarCuenta(idPV, idMesa) {
    idCuenta=$("#mesa"+idMesa).attr("idCuenta");     
    var csrf_token = $('meta[name="csrf-token"]').attr('content');        
    $.ajax({
        url: "{{url('getcuenta')}}"+'/'+idCuenta,
        type: "GET",
        data: {
           '_method': 'GET',
           '_token': csrf_token
        },            
        success: function(respuesta) {
            var respuesta=JSON.parse(respuesta);
            console.log("respuesta ajax", respuesta);
            var ok = respuesta["ok"];
            // if(ok){
            //     var objeto =  respuesta["objeto"];                          
            //     localStorage.setItem(idPV+idMesa, JSON.stringify(objeto));                 
            // }                 
        }
    });
 }
 
 function buscarHuesped(){
    //  e.preventDefault();
     var csrf_token = $('meta[name="csrf-token"]').attr('content');
     var codigoHotel= $("#codigoHotel").val().length > 0;
     var numHabitacion= $("#numHabitacion").val().length > 0;      
     var codhotel= $("#codigoHotel").val();
     var room= $("#numHabitacion").val();
     
    //  console.log("codhotel",codhotel," habitación ", room);

     if(codigoHotel && numHabitacion){        
        $.ajax({
            url: "{{ url('ordenar') }}"+'/'+codhotel+'/'+room,
            type: "GET",
            data: {
                '_method': 'GET',
                '_token': csrf_token
            },
            beforeSend: function () {
                // $("#mensajeRespuesta").html('<div class="loader"></div>');
                swal({
                    title: 'Espere',
                    text: 'Buscando información del húesped',
                    type : 'info',
                    allowOutsideClick: false
                });
                swal.showLoading();
            },
            success: function(respuesta) {
                swal.close(); 
                var resultado=JSON.parse(respuesta);  
                console.log(resultado);              
                var objeto = resultado["objeto"];
                var errorCode=objeto["errCode"]; //0 si se encontró el huesped, 404 si no se encontró               
                var reserva=objeto["reserva"];                
                var nombre=objeto["nombre"];
                var room=objeto["room"];
                var ocupante=objeto["Ocupante"];
                var fechaSalida=objeto["FechaSalida"];                
                var brazalete = (objeto["brazalete"] == null) ? "Sin brazalete" : objeto["brazalete"];// ternario
                
                if(errorCode==0){
                    // console.log("datos",objeto);
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
            error: function(respuesta) {
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
  function buscarDatosHuesped(){      
    //  e.preventDefault();
     var csrf_token = $('meta[name="csrf-token"]').attr('content');
     var codigoHotel= $("#codigoHotelModal").val().length > 0;
     var numHabitacion= $("#habitacionModal").val().length > 0;      
     var codhotel= $("#codigoHotelModal").val();
     var room= $("#habitacionModal").val();
     
    //  console.log("codhotel",codhotel," habitación ", room);    
     if(codigoHotel && numHabitacion){
               
        $.ajax({
            url: "{{ url('ordenar') }}"+'/'+codhotel+'/'+room,
            type: "GET",
            data: {
                '_method': 'GET',
                '_token': csrf_token
            },
            beforeSend: function () {
                // $("#mensajeRespuestaModal").html('<div class="loader"></div>');
                swal({
                    title: 'Espere',
                    text: 'Buscando información del húesped',
                    type : 'info',
                    allowOutsideClick: false
                });
                swal.showLoading();
            },
            success: function(respuesta) {                
                swal.close(); 
                var resultado=JSON.parse(respuesta);  
                console.log("datos huesped", resultado);              
                var objeto = resultado["objeto"];
                var errorCode=objeto["errCode"]; //0 si se encontró el huesped, 404 si no se encontró               
                var reserva=objeto["reserva"];                
                var nombre=objeto["nombre"];
                var room=objeto["room"];
                var ocupante=objeto["Ocupante"];
                var fechaSalida=objeto["FechaSalida"];
                var brazalete = (objeto["brazalete"] == null) ? "Sin brazalete" : objeto["brazalete"];// ternario
                
                // var fechaSalida=objeto["FechaSalida"];                
                // var brazalete = (objeto["brazalete"] == null) ? "Sin brazalete" : objeto["brazalete"];// ternario                
                if(errorCode==0){
                    
                    $("#mensajeRespuestaModal").html('<div class="alert alert-success"><strong>Datos encontrados</strong></div>');
                    $("#reservaModal").val(reserva);
                    $("#nombreModal").val(nombre);
                    $("#roomModal").val(room);
                    $("#ocupanteModal").val(ocupante);
                    $("#fechaSalidaModal").val(fechaSalida);
                    $("#brazaleteModal").val(brazalete);
                     // creo el objeto lST para la cuenta
                }else if(errorCode==401){
                    $("#mensajeRespuestaModal").html('<div class="alert alert-warning"><strong>No se encontró el hotel</strong></div>');
                }else if(errorCode==404){
                    $("#mensajeRespuestaModal").html('<div class="alert alert-warning"><strong>No se encontro Información de Huesped</strong></div>');
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
$('#myModal').on('hidden.bs.modal', function (e) {
         $(this).find('form')[0].reset();
});
async function abrirCuenta() {
     var idMesa = $("#idMesaModal").val();     

     var reserva = $("#reserva").val().length > 0;
     var nombre = $("#nombre").val().length > 0;
     var room = $("#room").val().length > 0;
     var pax = $("#ocupante").val().length > 0;
     var fechaSalida = $("#fechaSalida").val().length > 0;
     var brazalete = $("#brazalete").val().length > 0;
     var idPV= $("#idPVModalOrdenar").val();

     $("#idMesaAddProducts").attr("idMesaValue",idMesa); //le envio el id de la mesa a este atributo que me creo
     if(nombre && pax ){
        //oculto el modal
        $("#myModal").modal("hide"); 

       await guardarCuenta(idMesa); //ejecuto esta funcion para guardar cuenta        
        //    var idCuenta = $("#cuentaMesaSpan").text();
        if(permisoUserOnlyOpenTable === 0){
            // si usuario toma ordenes, muestro la zona de tomar ordenes de productos
            $("#zonaTomarOrden").removeClass("hidden");
            $("#zonaMesas").addClass("hidden"); // oculto las mesas            
            await getProductosMasVendidos(); 
                  generarBotonesClientes(idPV,idMesa);
            localStorage.setItem("idMesaLS", idMesa);
            var idPV= $("#idPVModalOrdenar").val();//obtengo el id de pv con el que se inició sesion
                
            var idCuenta = await getIdCuenta(idPV,idMesa); 
            if(idCuenta=="NO"){
                    idCuenta=$("#cuentaMesaSpan").text();
                }
            
            obtenerDatosCuentaApi(idPV,idMesa,idCuenta);
        }
        // obtengo el listado de zonas y las mesas, aqui se actualizan las zonas en tiempo real
        getZonas();
             
     }else{
        swal({
            title: 'Oops...',
            text: '¡Tiene campo(s) vacio(s)!',
            type: 'error',
            timer: '2000'
        });
     }
 }
//  para evitar poner valores diferentes a cero y que no sean numericos--campo pax
 $("#ocupante").change(function(){ 	
 	var pax = $("#ocupante").val(); 	
 	var soloNumeros = this.value.replace(/[^0-9]/g,''); 	
	    if(soloNumeros > 0 && pax !=''){	        
	        $("#addProductoBtn").removeAttr("disabled");	        
	    }else{
	        swal("Oops", "Ingrese un valor numerico mayor a cero" ,  "error");
	        $("#ocupante").val(1);	        	        
	    }	 
 });
 $(document).on("input", "#ocupante", function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    //para pax al agregar habitacion posterior
$("#ocupanteModal").change(function(){ 	
 	var pax = $("#ocupanteModal").val(); 	
 	var soloNumeros = this.value.replace(/[^0-9]/g,''); 	
	    if(soloNumeros > 0 && pax !=''){	        
	        // $("#addProductoBtn").removeAttr("disabled");	        
	    }else{
	        swal("Oops", "Ingrese un valor numerico mayor a cero" ,  "error");
	        $("#ocupanteModal").val(1);	        	        
	    }	 
 });
 $(document).on("input", "#ocupanteModal", function() {
        this.value = this.value.replace(/[^0-9]/g, '');
     });


 async function guardarCuenta(idMesa){
     var csrf_token = $('meta[name="csrf-token"]').attr('content');
     var reserva  = $("#reserva").val();
     var nombreCliente  = $("#nombre").val();
     var pax  = $("#ocupante").val();
     var habitacion  = $("#room").val();
     var brazalete  = $("#brazalete").val();

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
    await $.ajax({
            url: "{{ url('ordenar/addcuenta') }}",
            type: "POST",
            data: {
                '_method': 'POST',
                'alergenos':alergenos,
                'idMesa':idMesa,'reserva':reserva,'nombreCliente':nombreCliente,'habitacion':habitacion, 'pax':pax, 'brazalete': brazalete,
                '_token': csrf_token
            },
            beforeSend: function () {
                swal({
                    title: 'Espere',
                    text: 'Guardando cuenta',
                    type : 'info',
                    allowOutsideClick: false
                });
                swal.showLoading();
            },        
            success: function(respuesta) {
                swal.close(); 
                var resultado = JSON.parse(respuesta);
                console.log("resultado", resultado);
                var ok = resultado["ok"];
                if(ok){                    
                    var objeto = resultado["objeto"];
                    var idCuenta=objeto["id"];
                    var nombreCliente=objeto["nombreCliente"];
                    var habitacion=objeto["habitacion"];

                    $("#cuentaMesaSpan").text(idCuenta);
                    $("#clienteMesaSpan").text(nombreCliente);
                    $("#habMesaSpan").text(habitacion);

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
            error: function(respuesta) {
            console.log(JSON.parse(respuesta));
        }
    }); 
 }
 

function updateRoom() {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var idCuenta=$("#idCuentaModal").val();

    var reserva=$("#reservaModal").val();
    var nombre=$("#nombreModal").val();
    var habitacion=$("#roomModal").val();
    var pax=$("#ocupanteModal").val();
    var brazalete  = $("#brazaleteModal").val();


    var nombreD = $("#nombreModal").val().length > 0
    var paxD = $("#ocupanteModal").val().length > 0;

    var idPV= $("#idPVModalOrdenar").val();
    var idMesa= localStorage.getItem("idMesaLS");
    // var idCuenta =getIdCuenta(idPV,idMesa);     
    var variableCuenta=idPV+idMesa;
    var cuenta = JSON.parse(localStorage.getItem(variableCuenta)); 

    if(nombreD && paxD ){
        $.ajax({
            url: "{{ url('ordenar/updatecuenta') }}"+'/'+idCuenta,
            type: "POST",
            data: {
                '_method': 'POST',           
                'reserva': reserva,'nombre':nombre,'habitacion':habitacion,'pax':pax, 'brazalete':brazalete,
                '_token': csrf_token
            },
            beforeSend: function () {
                swal({
                    title: 'Espere',
                    text: 'Actualizando datos',
                    type : 'info',
                    allowOutsideClick: false
                });
                swal.showLoading();
            }, 
            success: function(respuesta) {
                swal.close();             
                var respuesta = JSON.parse(respuesta);
                var ok = respuesta["ok"];
                
                if(ok){//si ok es true
                    var objeto =respuesta["objeto"];
                    // console.log("Respuesta controlador",objeto); 
                     localStorage.setItem(variableCuenta, JSON.stringify(objeto));
                     swal({
                            title: 'Oops...',
                            text: '¡Operacion realizada con exito!',
                            type: 'success',
                            timer: '2000'
                        });
                        $("#myModalAddRoom").modal("hide");                    
                    
                }             
                                                    
            }
        });           
     }else{
        swal({
            title: 'Oops...',
            text: 'Tiene campo(s) sin datos',
            type: 'error',
            timer: '2000'
        });
     }    
}
 async function GetProductosByCat(idCategoria){
    var csrf_token = $('meta[name="csrf-token"]').attr('content'); 
    var idPV= $("#idPVModalOrdenar").val();
    var idMesaLS = localStorage.getItem("idMesaLS");
    var variableLS =idPV+idMesaLS;
    var idCuenta = await getIdCuenta(idPV,idMesaLS); 
    $("#idCuentaSpan").attr("idCuentaAttr",idCuenta); 

    var datosCuentaObjeto = JSON.parse(localStorage.getItem(variableLS));// reconvierto el string a un objeto json    
    var alergenosCuenta = datosCuentaObjeto["TPV_AlergenosCuenta"];

    alergenosIdHuesped = [];
    nombreAlergenosHuesped= [];
    alergenosHuesped= [];
    for (i = 0; i < alergenosCuenta.length; i++) {
        alergenosIdHuesped[i]= alergenosCuenta[i].idAlergeno;
        nombreAlergenosHuesped[i] = alergenosCuenta[i]["TPV_Alergenos"].name;
        alergenosHuesped[i]= {"idAlergeno": alergenosCuenta[i].idAlergeno,"nombreAlergeno":alergenosCuenta[i]["TPV_Alergenos"].name};
    }   
    // console.log("idAlergenosHuesped", alergenosIdHuesped);
    console.log("alegenosHuesped", alergenosHuesped);
    $.ajax({
            url: "{{url('obtener/productos')}}",
            type: "GET",
            data: {
                '_method': 'GET',
                'idCategoria':idCategoria,
                '_token': csrf_token
            },  
            beforeSend: function () {                               
                $("#spinLoader").removeClass("hidden");
            },          
            success: function(respuesta) {
                // swal.close();
                $("#spinLoader").addClass("hidden");
                var respuesta=JSON.parse(respuesta); 
                // console.log(respuesta["objeto"]);                
                var ok = respuesta["ok"];                
                if(ok){
                    var objeto=respuesta["objeto"];                    
                    // console.log(objeto);
                    // listaProductos="";
                    tumbnails="";
                        for(i =0;  i<objeto.length; i++){
                            var colorAlergeno = "label-info";
                            var alergenoHaceMatch = false;
                            var idProducto=objeto[i]["TPV_Producto"]["id"];
                            var idMenuCarta=objeto[i]["id"];
                            var nombreProducto=objeto[i]["TPV_Producto"]["nombreProducto"];
                            var temporada=objeto[i]["TPV_Producto"]["temporada"];
                            var precio=objeto[i]["precio"];
                            var imagen=objeto[i]["TPV_Producto"]["imagen"];
                            var alergenosP = objeto[i]["TPV_Producto"]["TPV_ProductoAlergeno"];
                            var modosProducto = JSON.stringify(objeto[i]["TPV_Producto"]["TPV_ProductoModos"]);
                            var nombreAlergenosMatch ="";
                            // console.log("sus Alergenos",alergenosP);
                           if(alergenosP.length >0 ){
                                //operador ternario
                                nombreAlergiasCoinciden= [];
                                for (j = 0; j < alergenosP.length; j++) {
                                    
                                    if(alergenosIdHuesped.indexOf(alergenosP[j].idAlergeno)!=-1){
                                            colorAlergeno="label-warning";
                                            alergenoHaceMatch=true;
                                            // filtro las alergias que coiciden
                                            const resultado = alergenosHuesped.find( alergia => alergia.idAlergeno === alergenosP[j].idAlergeno);
                                            nombreAlergiasCoinciden.push(resultado.nombreAlergeno);
                                            nombreAlergenosMatch=nombreAlergiasCoinciden.toString();
                                    }
                                }
                            }
                            // console.log("alergenos: ",nombreAlergenosMatch);                                  
                            // var dataImg = 'data:image/png;base64,';                       
                            var imgProducto =imagen;                            
                            var imgFinal= '{{ URL::asset('/storage/productos') }}'+'/'+imgProducto;

                            var imgDefault ='img/faces/defaultProducto.png'; //Esto es para la imagen por default
                            resultadoImg = ((imgProducto == "SIN IMAGEN") || (imgProducto == null)) ? imgDefault : imgFinal;
                            
                            abrirModal=true;                                                                                             
                            tumbnails+="<div class='col-xs-6 col-sm-3 col-md-3' id='tumbImg"+idProducto+"'><div class='thumbnail'><img src='"+resultadoImg+"' sytle='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='"+nombreProducto+"' id='producto"+idProducto+"' idMenuCarta='"+idMenuCarta+"' idProducto='"+idProducto+"' alergenoMatch='"+alergenoHaceMatch+"' nombreAlergenosHuesped='"+nombreAlergenosMatch+"' nProducto='"+nombreProducto+"' precio='"+precio+"' temporada='"+temporada+"' style='cursor: pointer;' onclick='getModosProductoModal("+idProducto+","+idMenuCarta+","+modosProducto+", "+idCuenta+")'><div class='caption'><div class='spanNombrePlatilloScroll'><strong>"+nombreProducto+"</strong></div><span style='cursor: pointer;' class='label small "+colorAlergeno+"' onclick='verAlergenos("+idProducto+","+abrirModal+")'>Alergenos</span>  <span class='label "+colorAlergeno+"' id='cantCuentaClienteSpan"+idProducto+"'>0</span></div></div></div>";

                        }
                    // listaProductos+="";                     
                    tumbnails+="";                     
                    
                    $("#UlList2").html(tumbnails);
                    countProductosCuentaCategoria(idPV,idMesaLS);

                                        
                }else{
                    
                    $("#UlList2").html('<p>Sin productos para la categoria</p>');
                }
            },
            error: function(respuesta) {
            respuesta=JSON.parse(respuesta); 
            console.log(respuesta);
            }
    });
    // $('body').tooltip({
    //     selector: '[data-toggle="tooltip"]'
    // })
 }
async function getProductosMasVendidos(){
    var csrf_token = $('meta[name="csrf-token"]').attr('content'); 
    var idPV= $("#idPVModalOrdenar").val();//obtengo el id de pv con el que se inició sesion
    var idCarta = $("#idCartaPVModal").val(); 
    
    var idMesaLS = localStorage.getItem("idMesaLS");
    // console.log("idMesaLS",idMesaLS);
    // console.log("idPV",idPV);
    var idCuenta = await getIdCuenta(idPV,idMesaLS); 
    
    var variableLS =idPV+idMesaLS;
    $("#idCuentaSpan").attr("idCuentaAttr",idCuenta); 
    
    
    var datosCuentaObjeto = JSON.parse(localStorage.getItem(variableLS));// reconvierto el string a un objeto json
    var alergenosCuenta = datosCuentaObjeto["TPV_AlergenosCuenta"];        
    // console.log("datosCuentaObjeto",datosCuentaObjeto);
    if(idCuenta=="NO"){
        idCuenta = datosCuentaObjeto["id"];
    }
        
    alergenosIdHuesped = [];
    nombreAlergenosHuesped= [];
    alergenosHuesped= [];
    for (i = 0; i < alergenosCuenta.length; i++) {
        alergenosIdHuesped[i]= alergenosCuenta[i].idAlergeno;
        nombreAlergenosHuesped[i] = alergenosCuenta[i]["TPV_Alergenos"].name;
        alergenosHuesped[i]= {"idAlergeno": alergenosCuenta[i].idAlergeno,"nombreAlergeno":alergenosCuenta[i]["TPV_Alergenos"].name};
    }   
    // console.log("idAlergenosHuesped", alergenosIdHuesped);
    // console.log("alegenosHuesped", alergenosHuesped);
    $.ajax({
            url: "{{ url('ordenar/getfavoritos') }}",
            type: "GET",
            data: {
                '_method': 'GET',                
                'idPuntoVenta':idPV,'idCarta':idCarta,
                '_token': csrf_token
            },  
            beforeSend: function () {                               
                $("#spinLoader").removeClass("hidden");
            },          
            success: function(respuesta) {
                // swal.close();
                $("#spinLoader").addClass("hidden");
                var respuesta=JSON.parse(respuesta); 
                // console.log(respuesta["objeto"]);                
                var ok = respuesta["ok"];                
                if(ok){
                    var objeto=respuesta["objeto"];                    
                    // console.log(objeto);
                    // listaProductos="";
                    tumbnails="";
                        for(i =0;  i<objeto.length; i++){
                            var colorAlergeno = "label-info";
                            var alergenoHaceMatch = false;
                            var idProducto=objeto[i]["TPV_Producto"]["id"];
                            var idMenuCarta=objeto[i]["id"];
                            var nombreProducto=objeto[i]["TPV_Producto"]["nombreProducto"];
                            var temporada=objeto[i]["TPV_Producto"]["temporada"];
                            var precio=objeto[i]["precio"];
                            var imagen=objeto[i]["TPV_Producto"]["imagen"];
                            var alergenosP = objeto[i]["TPV_Producto"]["TPV_ProductoAlergeno"];
                            var modosProducto = JSON.stringify(objeto[i]["TPV_Producto"]["TPV_ProductoModos"]);
                            var nombreAlergenosMatch ="";
                            // console.log("sus Alergenos",alergenosP);
                           if(alergenosP.length >0 ){
                                //operador ternario
                                nombreAlergiasCoinciden= [];
                                for (j = 0; j < alergenosP.length; j++) {
                                    
                                    if(alergenosIdHuesped.indexOf(alergenosP[j].idAlergeno)!=-1){
                                            colorAlergeno="label-warning";
                                            alergenoHaceMatch=true;
                                            // filtro las alergias que coiciden
                                            const resultado = alergenosHuesped.find( alergia => alergia.idAlergeno === alergenosP[j].idAlergeno);
                                            nombreAlergiasCoinciden.push(resultado.nombreAlergeno);
                                            nombreAlergenosMatch=nombreAlergiasCoinciden.toString();
                                    }
                                }  
                            }
                            // console.log("alergenos: ",nombreAlergenosMatch);                              
                            // var dataImg = 'data:image/png;base64,';                       
                            var imgProducto =imagen;                            
                            var imgFinal= '{{ URL::asset('/storage/productos') }}'+'/'+imgProducto;

                            var imgDefault ='img/faces/defaultProducto.png'; //Esto es para la imagen por default
                            resultadoImg = ((imgProducto == "SIN IMAGEN") || (imgProducto == null)) ? imgDefault : imgFinal;
                            
                            abrirModal=true;                                                                                             
                            tumbnails+="<div class='col-xs-6 col-sm-3 col-md-3' id='tumbImg"+idProducto+"'><div class='thumbnail'><img src='"+resultadoImg+"' sytle='cursor: pointer;' data-toggle='tooltip' data-placement='top' title='"+nombreProducto+"' id='producto"+idProducto+"' idMenuCarta='"+idMenuCarta+"' idProducto='"+idProducto+"' alergenoMatch='"+alergenoHaceMatch+"' nombreAlergenosHuesped='"+nombreAlergenosMatch+"' nProducto='"+nombreProducto+"' precio='"+precio+"' temporada='"+temporada+"' style='cursor: pointer;' onclick='getModosProductoModal("+idProducto+","+idMenuCarta+","+modosProducto+", "+idCuenta+")'><div class='caption'><div class='spanNombrePlatilloScroll'><strong>"+nombreProducto+"</strong></div><span style='cursor: pointer;' class='label "+colorAlergeno+"' onclick='verAlergenos("+idProducto+","+abrirModal+")'>Alergenos</span>  <span class='label "+colorAlergeno+"' id='cantCuentaClienteSpan"+idProducto+"'>0</span></div></div></div>";

                        }
                    // listaProductos+="";                     
                    tumbnails+="";                     
                    
                    $("#UlList2").html(tumbnails);
                    countProductosCuentaCategoria(idPV,idMesaLS);// ejecuto esta funcion por si no se ejecutó antes
                                        
                }else{
                    
                    $("#UlList2").html('<p>Sin productos para la categoria</p>');
                }
            },
            error: function(respuesta) {
            respuesta=JSON.parse(respuesta); 
            console.log(respuesta);
            }
    });
    // $('body').tooltip({
    //     selector: '[data-toggle="tooltip"]'
    // })
}
async function contadoresProductos(idPV,idMesa) {
    var cuentaMesa=String(idPV)+String(idMesa);
    var cuentaMesaTemporal="cuentaTemporal"+String(idPV)+String(idMesa);
    var cuentaMesaBDApi="cuentaBD"+String(idPV)+String(idMesa);

    cuenta =[]; cuentaTemp=[]; cuentaBDAPi=[]; idCuenta=""; pax = 1; lstProductosApi=[]; lstProductosTemp=[];
    //obtengo la cuenta por si es necesario
    if (localStorage.getItem(cuentaMesa) ){
        cuenta = JSON.parse(localStorage.getItem(cuentaMesa));        
        pax = cuenta["pax"];
        idCuenta = cuenta["id"];        
    }
    //obtengo la cuenta temporal con productos y genero un nuevo array 
    if (localStorage.getItem(cuentaMesaTemporal) ){
        cuentaTemp = JSON.parse(localStorage.getItem(cuentaMesaTemporal));                        
        lengthCuentaTemp = cuentaTemp.length; //otengo la longitud del array
        if(lengthCuentaTemp>0){

            for(i =0;  i < lengthCuentaTemp; i++){                           
                var idCuenta = cuentaTemp[i]["idCuenta"];
                var idPV = cuentaTemp[i]["idPV"];
                var idMesa = cuentaTemp[i]["idMesa"];
                var comensal = cuentaTemp[i]["comensal"];
                var cantidad = cuentaTemp[i]["cantidad"];
            
                lstProductosTemp.push({
                    "idCuenta":parseInt(idCuenta),                    
                    "tipo": "temporal",                    
                    "comensal":parseInt(comensal),
                    "cantidad":parseInt(cantidad), 
                });            
            }
        }
    }    
    //obtengo la cuenta con productos de la api y genero un nuevo array 
    if (localStorage.getItem(cuentaMesaBDApi) ){
        cuentaBDAPi = JSON.parse(localStorage.getItem(cuentaMesaBDApi)); 
        lengthCuentaApi= cuentaBDAPi.length; //otengo la longitud del array
        if(lengthCuentaApi>0){

            for(i =0;  i < lengthCuentaApi; i++){                           
                var idCuenta = cuentaBDAPi[i]["idCuenta"];
                var idPV = cuentaBDAPi[i]["idPV"];
                var idMesa = cuentaBDAPi[i]["idMesa"];
                var comensal = cuentaBDAPi[i]["comensal"];
                var cantidad = cuentaBDAPi[i]["cantidad"];
            
                lstProductosApi.push({
                    "idCuenta":parseInt(idCuenta),                    
                    "tipo": "api",                    
                    "comensal":parseInt(comensal),
                    "cantidad":parseInt(cantidad), 
                });            
            }
        }              
    }
    var nuevoArrayProductos = lstProductosApi.concat(lstProductosTemp);
    var longNewArrayProductos = nuevoArrayProductos.length;
    if(longNewArrayProductos>0){        
        n=1;
        for (var i = 0; i < numPax; i++) {
            valorBadge = parseInt($("#btnBadge"+n).text());
            
            //filtro el comensal
            var pax =  nuevoArrayProductos.filter( (comensal) => {
                return comensal.comensal == n;
            });
            // sumo la cantidad de productos que tiene el pax filtraado
            var total = pax.reduce( (acumulador, comensal) => {             
                return acumulador + comensal.cantidad;  
            }, 0);
            // pinto en el badge correpondiente del pax
            $("#btnBadge"+n).text(total);
            n++;                
        }                
    }else {
        n=0;
        for (var i = 0; i < numPax; i++) { 
            n++;                
           $("#btnBadge"+n).text(0);
        }
    }        
}
/*Esta funcion es para pintar en badges la cantidad que ha sido pedidos en una cuenta cada platillo*/
async function countProductosCuentaCategoria(idPV,idMesa) {
    
    var cuentaMesa=String(idPV)+String(idMesa);
    var cuentaMesaTemporal="cuentaTemporal"+String(idPV)+String(idMesa);
    var cuentaMesaBDApi="cuentaBD"+String(idPV)+String(idMesa);

    cuenta =[]; cuentaTemp=[]; cuentaBDAPi=[]; idCuenta=""; pax = 1; lstProductosApi=[]; lstProductosTemp=[];
    //obtengo la cuenta por si es necesario
    if (localStorage.getItem(cuentaMesa) ){
        cuenta = JSON.parse(localStorage.getItem(cuentaMesa));        
        pax = cuenta["pax"];
        idCuenta = cuenta["id"];        
    }
    
    //obtengo la cuenta temporal con productos y genero un nuevo array 
    if (localStorage.getItem(cuentaMesaTemporal) ){
        cuentaTemp = JSON.parse(localStorage.getItem(cuentaMesaTemporal));                        
        lengthCuentaTemp = cuentaTemp.length; //otengo la longitud del array
        if(lengthCuentaTemp>0){

            for(i =0;  i < lengthCuentaTemp; i++){                           
                var idCuenta = cuentaTemp[i]["idCuenta"];
                var idPV = cuentaTemp[i]["idPV"];
                var idMesa = cuentaTemp[i]["idMesa"];
                var idProducto = cuentaTemp[i]["idProducto"];
                var cantidad = cuentaTemp[i]["cantidad"];
            
                lstProductosTemp.push({
                    "idCuenta":parseInt(idCuenta),                    
                    "tipo": "temporal",                    
                    "idProducto":parseInt(idProducto),
                    "cantidad":parseInt(cantidad), 
                });            
            }
        }
    }    
    //obtengo la cuenta con productos de la api y genero un nuevo array 
    if (localStorage.getItem(cuentaMesaBDApi) ){
        cuentaBDAPi = JSON.parse(localStorage.getItem(cuentaMesaBDApi)); 
        lengthCuentaApi= cuentaBDAPi.length; //otengo la longitud del array
        if(lengthCuentaApi>0){

            for(i =0;  i < lengthCuentaApi; i++){                           
                var idCuenta = cuentaBDAPi[i]["idCuenta"];
                var idPV = cuentaBDAPi[i]["idPV"];
                var idMesa = cuentaBDAPi[i]["idMesa"];
                var idProducto = cuentaBDAPi[i]["idProducto"];
                var cantidad = cuentaBDAPi[i]["cantidad"];
            
                lstProductosApi.push({
                    "idCuenta":parseInt(idCuenta),                    
                    "tipo": "api",                    
                    "idProducto":parseInt(idProducto),
                    "cantidad":parseInt(cantidad), 
                });            
            }
        }              
    }
    var nuevoArrayProductos = lstProductosApi.concat(lstProductosTemp);
    var longNewArrayProductos = nuevoArrayProductos.length;
    
    if(longNewArrayProductos>0){                
        for (var i = 0; i < longNewArrayProductos; i++) {
            var idProducto = nuevoArrayProductos[i]["idProducto"];
            //filtro el producto
            var producto =  nuevoArrayProductos.filter( (producto) => {
                return producto.idProducto == idProducto;
            });            
            // sumo la cantidad de productos que tiene el pax filtraado
            var total = producto.reduce( (acumulador, producto) => {             
                return acumulador + producto.cantidad;  
            }, 0);            
            // pinto en el badge correpondiente el total
            $("#cantCuentaClienteSpan"+idProducto).text(total);                 

        }                
    }
}
function getModosProductoModal(idProducto,idMenuCarta,modosProducto,idCuenta){        
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var longitudModos = modosProducto.length;
    var idPV= $("#idPVModalOrdenar").val(); 
    var idMesa = localStorage.getItem("idMesaLS");
    // var idCuenta = $("#cuentaMesaSpan" ).text();                     
    if(longitudModos>0){        
        $('#modalModosProducto').modal({backdrop: 'static', keyboard: false });        
            
            listaModos="<div class='col-md-3 col-md-offset-1 col-sm-3 col-sm-offset-1'><div class='input-group'><div class='form-group'><select class='form-control' name='idModo' id='modoSelect'>";
            for(i =0;  i<modosProducto.length; i++){
                
                var checkedRadio = (modosProducto[i]["principal"] == true) ? "checked" : "";// ternario                   
                var idModo=modosProducto[i]["idModo"];
                //entro a un subarray para obtener los datos del modo
                var datosModosProducto = modosProducto[i]["TPV_Modo"];
                var descripcion = datosModosProducto["descripcion"];                
                listaModos+="<option value='"+idModo+"'>" +descripcion+ "</option>"; 
                                                                             
            }
            listaModos += "</select></div></div></div>";          
            $("#modosProducto").html(listaModos); 
            $("#modoSelect option:first").attr('selected','selected');;//selecciono el primer elemento de la lista
            $('#modoSelect').select2();
            $("#idProductoModalModo").val(idProducto);
            $("#idMenuCartaModalModo").val(idMenuCarta);
            $("#idCuentaModalModal").val(idCuenta);
            
    }else{
       addAlergiaCuentaPax(idProducto,idCuenta);
       var tieneModos=false;        
       var idModo="";
       var descripcionModo="";
       addProducto(idProducto, idMenuCarta,idModo,tieneModos,descripcionModo)       
    }
    $('#modalModosProducto').on('hidden.bs.modal', function (e) {
        $(this).find('form')[0].reset();
    });    
 }

function addProducto(idProducto, idMenuCarta,idModo,tieneModos,descripcionModo) { 

    notaDetalle = addNotaDetallePax(idProducto, descripcionModo)

    var idPV= $("#idPVModalOrdenar").val(); 
    var idUsuario = $("#idUserModalOrdenar").val();        
    var tiempo=tiempoOrden();
    var cantidad=1;
    var idMesa = localStorage.getItem("idMesaLS");
    var cuentaObjeto = JSON.parse(localStorage.getItem(idPV+idMesa));
    var idCuenta = cuentaObjeto["id"];
    var comensal = cuentaObjeto["pax"];    
    var nota = notaDetalle;
    var nombreProducto = $("#producto"+idProducto).attr("nProducto");
    var temporada = $("#producto"+idProducto).attr("temporada");
    // var nota = $("#producto"+idProducto).attr("nota");
    var precio = $("#producto"+idProducto).attr("precio");
    var subTotal = precio*cantidad;

    $(".btnC").each( function () {                
        if($(this).hasClass("btn-success")){
            numeroComensal= $(this).attr("numComensal"); // btn numComensal                            
        }
    });

    var datosProducto=JSON.stringify({
        "idPV":idPV,
        "idMesa":idMesa,
        "idCuenta":idCuenta,
        "idMenuCarta":idMenuCarta,
        "idProducto":idProducto,
        "nombreProducto":nombreProducto,
        "cantidad":cantidad,
        "comensal":parseInt(numeroComensal),
        "tiempo": parseInt(tiempo),
        "idUsuarioAlta":idUsuario,
        "nota":nota,
        "modo":idModo,
        "temporada":temporada,
        "precioUnitario":precio,
        "subTotal":subTotal});

    var cuentaTemporal="cuentaTemporal"+idPV+idMesa;
    var datosCuentaTemporal = JSON.parse(localStorage.getItem(cuentaTemporal));    
    if (localStorage.getItem(cuentaTemporal)) {        
        lstProductos=datosCuentaTemporal;        
        if(lstProductos!=""){                                    
            cuentaTemporalConValor(idPV,idMesa,datosCuentaTemporal,datosProducto,tieneModos);
        }else{
            cuentaTemporalVacia(idPV,idMesa,datosCuentaTemporal,datosProducto,tieneModos);
        }          
    }
    element="#tumbImg"+idProducto;
    animarAgregadoProductos(element, 'shake');
    leerCuentaTemporal(idPV,idMesa);
            
 }

function animarAgregadoProductos(element, animationName, callback) {
    const node = document.querySelector(element)
    node.classList.add('animated', animationName)
    function handleAnimationEnd() {
        node.classList.remove('animated', animationName)
        node.removeEventListener('animationend', handleAnimationEnd)

        if (typeof callback === 'function') callback()
    }

    node.addEventListener('animationend', handleAnimationEnd)
}

 function addNotaDetallePax(idProducto, descripcionModo) {

     var idAttr = "#producto"+idProducto;
     var boolAlergenoMatch  = JSON.parse($(idAttr).attr('alergenoMatch'));      
     var checkAlergia=$('#checkAlergia').prop('checked');
     var numeroComensal;
     var alergias = "";     
     var nota="";
     $(".btnC").each( function () {                
        if($(this).hasClass("btn-success")){
            numeroComensal= $(this).attr("numComensal"); // btn numComensal                            
        }
    });

    nota = "("+numeroComensal+" , "+alergias+" , "+descripcionModo+")";

    $(".btnC").each( function () {                
        if($(this).hasClass("btn-success") && boolAlergenoMatch && checkAlergia){
            alergiasHuesped  = $(idAttr).attr('nombreAlergenosHuesped');      
            nota = "("+numeroComensal+" , Alergias: "+alergiasHuesped+" , "+descripcionModo+")";            
        }
    });
    return nota;
 }

 function addAlergiaCuentaPax(idProducto,idCuenta){
    //  console.log("entré aquí")
     var idAttr = "#producto"+idProducto;
     var boolAlergenoMatch  = JSON.parse($(idAttr).attr('alergenoMatch'));      
     var checkAlergia=$('#checkAlergia').prop('checked');        
    //  var alergenoMatech = document.getElementById(idAttr).hasAttribute("alergenoMatch");
    //  console.log('id producto',idProducto);          
     $(".btnC").each( function () {
        //  console.log("entro en el each");                
        if($(this).hasClass("btn-success") && boolAlergenoMatch && checkAlergia){
            var comensalSeleccionado= $(this).attr("numComensal"); // btn numComensal            
            // console.log('Valor alergenoMatch',boolAlergenoMatch, 'con alergiaCheckbox',checkAlergia, 'comensal', comensalSeleccionado, 'idCuenta', idCuenta);
            guardarCuentaAlergiaPax(idProducto, idCuenta,comensalSeleccionado);
        }
    });     
 }
async function guardarCuentaAlergiaPax(idProducto,idCuenta,numPaxAlergico) {
    
     var csrf_token = $('meta[name="csrf-token"]').attr('content');
     var idPV= $("#idPVModalOrdenar").val(); 
     var idMesa = localStorage.getItem("idMesaLS");
     var cuenta =String(idPV)+String(idMesa); 

    await $.ajax({
        url: "{{ url('ordenar/addcuentaalergia') }}",
        type: "POST",
        data: {
            '_method': 'POST',
            'idCuenta': idCuenta,          
            'paxConAlergia':numPaxAlergico,                                
            '_token': csrf_token
        },        
        success: function(respuesta) {            
            //  $("#modalCargando").modal("hide");                          
            var respuesta = JSON.parse(respuesta);
            var ok = respuesta["ok"];
            // console.log("respuesta",respuesta); 
            if(ok) {                
                 actualizarCuenta(idPV, idMesa);
                // verAlergenos(idProducto, false);                        
            }                                       
        },
        error: function(respuesta) {                    
            console.log("respuesta",respuesta); 
        }
    });
     
 }
 function cuentaTemporalVacia(idPV,idMesa,datosCuentaTemporal,datosProducto,tieneModos) {
    // console.log("cuenta temporal vacia");      
    var datosProducto=JSON.parse(datosProducto);
    var idProducto=datosProducto["idProducto"];    
    var cuentaTemporal="cuentaTemporal"+idPV+idMesa;    
    
    $(".btnC").each( function () {                
        if($(this).hasClass("btn-success")){
            numeroComensal= parseInt($(this).attr("numComensal")); // btn numComensal                            
        }
    });

    if(tieneModos){        
        lstProductos.push(datosProducto);
        localStorage.setItem(cuentaTemporal,JSON.stringify(lstProductos)); 
        suma=true;
        sumarRestarConteoComensal(numeroComensal,suma,idProducto);                
        leerCuentaTemporal(idPV,idMesa);                 
    }else{                          
        lstProductos.push(datosProducto);
        localStorage.setItem(cuentaTemporal,JSON.stringify(lstProductos));
        suma=true;
        sumarRestarConteoComensal(numeroComensal,suma,idProducto);                 
        leerCuentaTemporal(idPV,idMesa);
    }
 }
 function cuentaTemporalConValor(idPV,idMesa,datosCuentaTemporal,datosProducto,tieneModos) {    
    var seRepiteProducto=seRepiteProductoCuentaTemporal(datosCuentaTemporal,datosProducto); 
    var datosProducto=JSON.parse(datosProducto);
    var idProducto=datosProducto["idProducto"];    
    var cuentaTemporal="cuentaTemporal"+idPV+idMesa;  
    
    $(".btnC").each( function () {                
        if($(this).hasClass("btn-success")){
            numeroComensal= parseInt($(this).attr("numComensal")); // btn numComensal                            
        }
    });

    if(tieneModos){
        if(seRepiteProducto){            
            lstProductos.push(datosProducto);
            localStorage.setItem(cuentaTemporal,JSON.stringify(lstProductos));
            suma=true;
            sumarRestarConteoComensal(numeroComensal,suma,idProducto);                
            leerCuentaTemporal(idPV,idMesa);
        }else{            
            lstProductos.push(datosProducto);
            localStorage.setItem(cuentaTemporal,JSON.stringify(lstProductos));
            suma=true;
            sumarRestarConteoComensal(numeroComensal,suma,idProducto);                
            leerCuentaTemporal(idPV,idMesa);
        }                 
    }else{
        if(seRepiteProducto){
            var descripcionModo = "";
            for (i = 0; i < datosCuentaTemporal.length; i++) {
                if(datosCuentaTemporal[i]["idProducto"]==idProducto ){
                                        
                    var nuevaNota= addNotaDetallePax(idProducto, descripcionModo);
                    var notaPrevia= datosCuentaTemporal[i]["nota"];

                    var comensalAnterior = JSON.parse(localStorage.getItem("comensalAnterior")); 

                    if (numeroComensal != comensalAnterior){
                        nota = notaPrevia+"-"+nuevaNota;
                        console.log("entro aqi 1");
                        
                    }else{
                        nota = notaPrevia;
                        // console.log("entro aqi 2");
                    }
                    localStorage.setItem("comensalAnterior",numeroComensal);                            
                    var cantPrevia= datosCuentaTemporal[i]["cantidad"];
                    datosCuentaTemporal[i]["cantidad"] = cantPrevia+1;
                    suma=true;
                    sumarRestarConteoComensal(numeroComensal,suma,idProducto);
                    datosCuentaTemporal[i]["nota"] = nota;
                    localStorage.setItem("comensalAnterior",numeroComensal); 
                    localStorage.setItem(cuentaTemporal,JSON.stringify(lstProductos));                
                    leerCuentaTemporal(idPV,idMesa);
                }
            }
        }else{
            suma=true;
            sumarRestarConteoComensal(numeroComensal,suma,idProducto);         
            lstProductos.push(datosProducto);
            localStorage.setItem(cuentaTemporal,JSON.stringify(lstProductos));                
            leerCuentaTemporal(idPV,idMesa);
        }        
    }
    
 }
 function seRepiteProductoCuentaTemporal(datosCuentaTemporal,datosProducto){
    var seRepiteProducto=false;
    if(datosCuentaTemporal){
        var logintudCuentaTemp= datosCuentaTemporal.length;    
        var datosProducto=JSON.parse(datosProducto);      
        if(logintudCuentaTemp>0){
            var idProductoB=datosProducto["idProducto"];
            var resultado = datosCuentaTemporal.filter(producto => producto.idProducto == idProductoB);
            var longResultado=resultado.length;
            if(longResultado>0){
                seRepiteProducto=true;
            }else{
                seRepiteProducto=false;                      
            }           
        }
    }            
    return seRepiteProducto;
 }
 function sumarRestarConteoComensal(numComensal,suma, idProducto) {
     valorSpan = parseInt($("#btnBadge"+numComensal).text());
     valorSpanEnProducto = parseInt($("#cantCuentaClienteSpan"+idProducto).text());
          
     if(suma){
         valor = valorSpan + 1;
         valorSpanPlatillo= valorSpanEnProducto + 1;// suma para mostrar en los span de cantidades de los platillos
     }else {
         valor = valorSpan - 1;
         valorSpanPlatillo= valorSpanEnProducto - 1;

     }
     
     $("#btnBadge"+numComensal).text(valor);
     $("#cantCuentaClienteSpan"+idProducto).text(valorSpanPlatillo);// en span de productos mas vendidos

 }
 function seleccionarModo(){
    var idProducto = $("#idProductoModalModo").val();
    var idMenuCarta = $("#idMenuCartaModalModo").val();
    var idCuenta = $("#cuentaMesaSpan").text();
    var idModo = $("#modoSelect option:selected" ).val();
    var descripcionModo =$("#modoSelect option:selected").text();//se convierte en la nota
    // var idCuenta = $("#idCuentaSpan").attr("idCuentaAttr"); 
    var tieneModos=true;
    $("#modalModosProducto").modal("hide");
    //reseteo los valores de los campos del modal
     $('#modalModosProducto').on('hidden.bs.modal', function (e) {
        $(this).find('form')[0].reset();
    });  
    // console.log("idProducto", idProducto);    
    addAlergiaCuentaPax(idProducto,idCuenta);
    addProducto(idProducto, idMenuCarta,idModo,tieneModos,descripcionModo);
 }

 //SOLO NUMEROS

function modificarPrecioProducto(posicion, idPV, idMesa) {
    var cuentaTemporal="cuentaTemporal"+idPV+idMesa;
    var datosCuentaTemporal = JSON.parse(localStorage.getItem(cuentaTemporal));

    var precioActual= datosCuentaTemporal[posicion]["precioUnitario"];
        
    var precioNuevo= $("#precioProdTemp"+posicion).html();
 	var soloNumeros = precioNuevo.replace(/[^0-9]/g,'');
    var noEsNumero = isNaN(precioNuevo);

    var cantidad = datosCuentaTemporal[posicion]["cantidad"];                                       

    //console.log("is not a number", isNaN(precioNuevo)); //devuelve false);
    if(!noEsNumero){
        if(soloNumeros >= 0  && precioNuevo !=''){
            datosCuentaTemporal[posicion]["precioUnitario"]=precioNuevo;
            datosCuentaTemporal[posicion]["subTotal"]=cantidad * precioNuevo;
        
            localStorage.setItem(cuentaTemporal, JSON.stringify(datosCuentaTemporal));
            leerCuentaTemporal(idPV, idMesa) 	        
        }else{
            swal("Oops", "Ingrese un valor numerico" ,  "error");            
            $("#precioProdTemp"+posicion).html(precioActual);
            
            datosCuentaTemporal[posicion]["precioUnitario"]=precioActual; 
            datosCuentaTemporal[posicion]["subTotal"]=cantidad * precioActual;

            localStorage.setItem(cuentaTemporal, JSON.stringify(datosCuentaTemporal));
            leerCuentaTemporal(idPV, idMesa);       	        	        
        }
    }else {
        $("#precioProdTemp"+posicion).html(precioActual);
            
            datosCuentaTemporal[posicion]["precioUnitario"]=precioActual; 
            datosCuentaTemporal[posicion]["subTotal"]=cantidad * precioActual;

            localStorage.setItem(cuentaTemporal, JSON.stringify(datosCuentaTemporal));
            leerCuentaTemporal(idPV, idMesa); 
    }   
}


 function leerCuentaApi(idPV, idMesa, idCuenta) {
     var counter=0;
     var cuentaAPi="cuentaBD"+idPV+idMesa;
     var sumaSubTotales=0;
     
     if(localStorage.getItem(cuentaAPi)){
         var objCuentaAPi =JSON.parse(localStorage.getItem(cuentaAPi));
         objCuentaAPi.sort( function (a, b) {// ordeno los productos en orden ascendente por tiempos
            return(a.tiempo - b.tiempo)
        });
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
            tiempo="";
            //filtro los datos para obtener el ultimo valor
            let res1 = objCuentaAPi.reverse().find(x =>  x.tiempo === 1);            
            objCuentaAPi.reverse();
            let res2 = objCuentaAPi.reverse().find(x =>  x.tiempo === 2);            
            objCuentaAPi.reverse();
            let res3 = objCuentaAPi.reverse().find(x =>  x.tiempo === 3);            
            objCuentaAPi.reverse();
            let res4 = objCuentaAPi.reverse().find(x =>  x.tiempo === 4);
            objCuentaAPi.reverse();

            if(objCuentaAPi[i]["tiempo"]==1){
               tiempo="<span class='labelTiempos label-warning'>T1</span>";
               borde="border_bottom";
               var trWhite ="<tr><td colspan='5'><img src='img/imgBlancoTr.png'></td></tr>";
               var espacioTr = (objCuentaAPi[i]==res1) ? trWhite : "";// ternario

            }else if(objCuentaAPi[i]["tiempo"]==2){
               tiempo ="<span class='labelTiempos label-warning'>T2</span>";
               borde="border_bottom";
               var trWhite ="<tr><td colspan='5'><img src='img/imgBlancoTr.png'></td></tr>";
               var espacioTr = (objCuentaAPi[i]==res2) ? trWhite : "";

            }else if(objCuentaAPi[i]["tiempo"]==3){
               tiempo="<span class='labelTiempos label-warning'>T3</span>"; 
               borde="border_bottom";
               var trWhite ="<tr><td colspan='5'><img src='img/imgBlancoTr.png'></td></tr>";
               var espacioTr = (objCuentaAPi[i]==res3) ? trWhite : "";

            }else if(objCuentaAPi[i]["tiempo"]==4){
                tiempo="<span class='labelTiempos label-warning'>T4</span>"; 
                borde="border_bottom";
                var trWhite ="<tr><td colspan='5'><img src='img/imgBlancoTr.png'></td></tr>";
                var espacioTr = (objCuentaAPi[i]==res4) ? trWhite : "";
            }

            lstProductosTr="<tr class='danger celdaTexto'><td><button class='btn btn-danger btn-xs' id='posi"+counter+"' name='itemProducto' onclick='cancelarProductoModal("+idDetalleCuenta+","+counter+")'>C </button></td><td>"+tiempo+" - "+nombreProducto+"</td><td>"+cantidad+"</td><td>"+precio+"</td><td class='text-primary'>"+total+"</td></tr><tr class='danger celdaTexto "+borde+"'><td></td><td colspan='4' id='notaApi"+counter+"'>"+nota+"</td></tr>"+espacioTr;

            counter++;   
            $("table tbody").append(lstProductosTr);                                 
           
        }
     }else{
        obtenerDatosCuentaApi(idPV,idMesa,idCuenta);
     }     
     //sumaSubTotales
    // console.log("sumaApitotal",sumaSubTotales);
    return sumaSubTotales;               
}
function leerCuentaTemporal(idPV, idMesa) {
    $("#tablaItemProductos tbody").empty();
    $("#tablaItemProductos tfoot").empty();
    var cadena=String(idPV)+String(idMesa);  
    var cuenta = JSON.parse(localStorage.getItem(cadena)); 
    var sumaApiTotales=leerCuentaApi(idPV, idMesa, idCuenta); //lo que se tiene de la api //  console.log("sumaApiTotales",sumaApiTotales);
    // ordeno los productos de mi cuenta temporal para facilitar su eliminación
     ordenarProductosPorTiempos(idPV, idMesa);
     var cuentaTemporal="cuentaTemporal"+idPV+idMesa;
     if(localStorage.getItem(cuentaTemporal)){
        var datosCuentaTemporal = JSON.parse(localStorage.getItem(cuentaTemporal));

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
            var temporada = datosCuentaTemporal[i]["temporada"];
            var modificarPrecio = (temporada === "false") ? false : true;// ternario

            var precio = datosCuentaTemporal[i]["precioUnitario"];
            var subTotal = datosCuentaTemporal[i]["subTotal"]; 
            sumaSubTotales = sumaSubTotales + subTotal; //este son los totales de la cuenta temporal
            counter++;
            counterTem++;
           
            tiempo="";
            //filtro los datos para obtener el ultimo valor
            let res1 = datosCuentaTemporal.reverse().find(x =>  x.tiempo === 1);            
            datosCuentaTemporal.reverse();
            let res2 = datosCuentaTemporal.reverse().find(x =>  x.tiempo === 2);            
            datosCuentaTemporal.reverse();
            let res3 = datosCuentaTemporal.reverse().find(x =>  x.tiempo === 3);            
            datosCuentaTemporal.reverse();
            let res4 = datosCuentaTemporal.reverse().find(x =>  x.tiempo === 4);
            datosCuentaTemporal.reverse();
            
            if(datosCuentaTemporal[i]["tiempo"]==1){                
               tiempo="<span class='labelTiempos label-warning'>T1</span>";
               borde="border_bottom";
               var trWhite ="<tr><td colspan='5'><img src='img/imgBlancoTr.png'></td></tr>";
               var ultimo = (datosCuentaTemporal[i]==res1) ? trWhite : "";// ternario  

            }else if(datosCuentaTemporal[i]["tiempo"]==2){
               tiempo ="<span class='labelTiempos label-warning'>T2</span>";
               borde="border_bottom";
               var trWhite ="<tr><td colspan='5'><img src='img/imgBlancoTr.png'></td></tr>";
               var ultimo = (datosCuentaTemporal[i]==res2) ? trWhite : "";

            }else if(datosCuentaTemporal[i]["tiempo"]==3){
               tiempo="<span class='labelTiempos label-warning'>T3</span>"; 
               borde="border_bottom";
               var trWhite ="<tr><td colspan='5'><img src='img/imgBlancoTr.png'></td></tr>";
               var ultimo = (datosCuentaTemporal[i]==res3) ? trWhite : "";

            }else if(datosCuentaTemporal[i]["tiempo"]==4){
                tiempo="<span class='labelTiempos label-warning'>T4</span>"; 
                borde="border_bottom";
                var trWhite ="<tr><td colspan='5'><img src='img/imgBlancoTr.png'></td></tr>";
                var ultimo = (datosCuentaTemporal[i]==res4) ? trWhite : "";
            }

           lstProductosTr="<tr class='success celdaTexto'><td><button id='pos"+counterTem+"' class='btn btn-danger btn-xs' name='itemProducto' onclick='deleteProductoItem("+counterTem+","+idPV+","+idMesa+")'>X</button></td><td>"+tiempo+" - "+nombreProducto+"</td><td>"+cantidad+"</td><td contenteditable='"+modificarPrecio+"' id='precioProdTemp"+counterTem+"' onBlur='modificarPrecioProducto("+counterTem+","+idPV+","+idMesa+")'>"+precio+"</td><td class='text-primary'>"+subTotal+"</td></tr><tr class='success celdaTexto "+borde+"'><td></td><td colspan='4' contenteditable='true' id='nota"+counterTem+"' onBlur='addNota("+counterTem+","+idPV+","+idMesa+")'>"+nota+"</td></tr>"+ultimo;

           $("table tbody").append(lstProductosTr);
           
        }
        
        cuenta["subtotalCuenta"] = sumaApiTotales +sumaSubTotales;
        
        localStorage.setItem(cadena, JSON.stringify(cuenta));
        mostrarTotales(cadena);//el total que trae la api y la suma de los totales en localstorage
        
    }    
    
    return sumaSubTotales;
}

function ordenarProductosPorTiempos(idPV, idMesa) {
    var cuentaTemporal="cuentaTemporal"+idPV+idMesa;
    if(localStorage.getItem(cuentaTemporal)){
        datosCuentaTemporal = JSON.parse(localStorage.getItem(cuentaTemporal));
        // ordeno los productos en orden ascendente por tiempos
        datosCuentaTemporal.sort( function (a, b) {
            return(a.tiempo - b.tiempo)            
        });
       localStorage.setItem(cuentaTemporal, JSON.stringify(datosCuentaTemporal));
    }         
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
    var totalesDesglose="<tr><td colspan='2'>Subtotal</td><td class='text-right' colspan='3'>"+subtotal+"</td></tr><tr class='danger'><td colspan='2'>Descuento</td><td colspan='3' class='text-right' id='descuentoCuenta'>"+descuentCalculado+"</td></tr><tr class='success'><td colspan='2'>Total</td><td colspan='3' class='text-right' id='totalCuenta'>"+TotalConDescuento+"</td></tr>";

    $("table tfoot").append(totalesDesglose);//sumaSubTotales         
    
}

async function obtenerDatosCuentaApi(idPV,idMesa,idCuenta){
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    
    await $.ajax({
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
                    // console.log(objeto);
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
                //  console.log(respuesta);
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
     
     var cantidadProducto= datosCuentaTemporal[pos]["cantidad"];
      
      if(cantidadProducto>1){
          datosCuentaTemporal[pos]["cantidad"] = cantidadProducto-1;
          localStorage.setItem(cuentaTemporal,JSON.stringify(datosCuentaTemporal));
          comensal = datosCuentaTemporal[pos]["comensal"];
          idProducto = datosCuentaTemporal[pos]["idProducto"];
                    
          suma=false;
          sumarRestarConteoComensal(comensal,suma,idProducto);                
          leerCuentaTemporal(idPV,idMesa);
          return;
      }else{
          $.notify({							
                message: '<i class="fas fa-sun"></i><strong>Producto eliminado de la lista</strong>'
            },{								
                type: 'warning',
                delay: 2000
            });

            $("table tbody").find('#pos'+pos).each(function(){
                $(this).parents("tr").remove();
            });
            $("table tbody").find('#nota'+pos).each(function(){
                $(this).parents("tr").remove();
            });
            // delete splice[productoNum];
            comensal = datosCuentaTemporal[pos]["comensal"];
            idProducto = datosCuentaTemporal[pos]["idProducto"];
            
            suma=false;
            sumarRestarConteoComensal(comensal,suma,idProducto);
            datosCuentaTemporal.splice(pos,1);
            
            localStorage.setItem(cuentaTemporal,JSON.stringify(datosCuentaTemporal));
             
      }      	        
    leerCuentaTemporal(idPV, idMesa);
}

function addNota(indiceProducto,idPV,idMesa){
    var cuentaTemporal="cuentaTemporal"+idPV+idMesa;//creo la variable
    var datosCuentaTemporal = JSON.parse(localStorage.getItem(cuentaTemporal));
    var nota= $("#nota"+indiceProducto).html();

    // var nota=$("#nota"+indiceProducto).val();
    //obtengo la nota y lo agrego al producto    
    datosCuentaTemporal[indiceProducto]["nota"]=nota;
    localStorage.setItem(cuentaTemporal,JSON.stringify(datosCuentaTemporal));   
}
function verAlergenos(idProducto, abrirModal) {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    if(abrirModal){
        $('#myModalAlergenos').modal('show');
    }    
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
    var cuenta = idPV+idMesaLS;

    var datosCuentaObjeto = JSON.parse(localStorage.getItem(cuenta)) ;// reconvierto el string a un objeto json
    // console.log(datosCuentaObjeto);
    var idAlergenos = datosCuentaObjeto["TPV_AlergenosCuenta"];
   /* console.log(datosCuentaObjeto); console.log(idAlergenos[0].idAlergeno); alergenosIdHuesped = [8,9]; //aqui voy generando el array que recibo de los que tiene el huesped*/
    alergenosIdHuesped = [];
    for (i = 0; i < idAlergenos.length; i++) {
        alergenosIdHuesped[i]= idAlergenos[i].idAlergeno;
    }
//    console.log(idAlergenos);
    var contador=0;
    var nombreAlergenos=[];
    $("input[name='idAlergenoProducto[]']").each( function () {
        //    console.log(n)                        ;
        if((alergenosIdHuesped.indexOf(parseInt($(this).val()))!=-1) && $(this).prop("checked")){
            valorIdAlergeno= $(this).val();            
            $("#labelCheck"+valorIdAlergeno).addClass("label label-warning");
            var alergeno =$(this).attr("nombreAlergeno")
            nombreAlergenos.push(alergeno);             
            contador++;	
        }
    });
    // console.log("alergenos coinciden", nombreAlergenos);
    //$(this).val().includes(alergenosIdHuesped[contador]) 
    // addNotaHuespedAlergeno(cuenta,nombreAlergenos);
}
function addNotaHuespedAlergeno(cuenta,notaAlergeno){
    var nota = notaAlergeno.toString();
    var cuentaTemporal = "cuentaTemporal"+ cuenta;
    // console.log(notaAlergeno.replace(/['"]+/g, ''));
    var datosCuentaTemporal = JSON.parse(localStorage.getItem(cuentaTemporal)) ;// reconvierto el string a un objeto json
    // datosCuentaTemporal[i]["cantidad"] = cantPrevia+1;    
    var indiceProducto =  datosCuentaTemporal.length-1;

    var nota=$("#nota"+indiceProducto).val();
    //obtengo la nota y lo agrego al producto    
    datosCuentaTemporal[indiceProducto]["nota"]=nota;
    localStorage.setItem(cuentaTemporal,JSON.stringify(datosCuentaTemporal));   

}
function getAlergenosMatchHuesped(idProducto){
     var csrf_token = $('meta[name="csrf-token"]').attr('content');        
    $.ajax({
            url: "{{ url('buscar/alergenos') }}"+'/'+idProducto,
            type: "GET",
            data: {
                '_method': 'GET',
                '_token': csrf_token
            },            
            success: function(respuesta) {
                var resultado=JSON.parse(respuesta);
                var ok = resultado["ok"];                
                if(ok){//si ok es true obtengo los datos del objeto
                    var objeto=resultado["objeto"];                                             
                    console.log(objeto);
                    // console.log(resultado.objeto[0].idAlergeno);                        
                }
            },
            error: function(respuesta) {
            resultado=JSON.parse(respuesta); 
            console.log(resultado);
        }
    });    
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

function asignarHabitacionModal(){
    var idPV= $("#idPVModalOrdenar").val();
    var idMesa = localStorage.getItem("idMesaLS");
    
	$(".alert").remove();// si hay mensajes de alerta, estas se remueven en el modal
    // var idCuenta =getIdCuenta(idPV,idMesa);     
    var variable=idPV+idMesa;
    var cuenta = JSON.parse(localStorage.getItem(variable)); 
    idCuenta =cuenta["id"];
    habitacion =cuenta["habitacion"];
    if(habitacion==null){
        $("#idCuentaModal").val(idCuenta);        
        $('#myModalAddRoom').modal({backdrop: 'static', keyboard: false });
    }else{
        $("#idCuentaModal").val(idCuenta);

        $("#reservaModal").val(cuenta["reserva"]);
        $("#nombreModal").val(cuenta["nombreCliente"]);
        $("#roomModal").val(cuenta["habitacion"]);
        $("#ocupanteModal").val(cuenta["pax"]);
        $("#fechaSalidaModal").val(cuenta["FechaSalida"]);
        $("#brazaleteModal").val(cuenta["brazalete"]);

       
        $('#myModalAddRoom').modal({backdrop: 'static', keyboard: false });
    }   
   
}

 $('#myModalAddRoom').on('hidden.bs.modal', function (e) {
     $(this).find('form')[0].reset();
});
 function enviarCentroPrep() {
     var csrf_token = $('meta[name="csrf-token"]').attr('content');
     var idPV = $("#idPVModalOrdenar").val();//obtengo el id de pv con el que se inició sesion  
     var idMesa = localStorage.getItem("idMesaLS");
     var idMenuCarta = $("#idCartaPVModal").val();//obtengo el id de pv con el que se inició sesion       

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
            beforeSend: function () {
                // $('#modalCargando').modal({backdrop: 'static', keyboard: false });
                // $("#animacionCargando").html('<div class="loader"></div>');
                swal({
                    title: 'Espere',
                    text: 'Enviando producto(s) a centros de preparación',
                    type : 'info',
                    allowOutsideClick: false
                });
                swal.showLoading();
            },        
            success: function(respuesta) {
                // $("#modalCargando").modal("hide");
                //  console.log("su respuesta desde CONtroller", respuesta);
                swal.close(); 
                var respuesta = JSON.parse(respuesta);
                var ok = respuesta["ok"];
                // console.log("respuesta",respuesta);
                if(ok){//si ok es true
                    var lstProductos=[];
                     localStorage.setItem(cuentaTemporal, lstProductos);                     
                    //  crearCuentaTemporal(idPV,idMesa);
                     swal({
                            title: 'Exito',
                            text: '¡Operacion realizada con exito!',
                            type: 'success',
                            // timer: '1500'
                        }).then(function(){ 
                            location.reload();
                        }
                    );
                }
            },
            error: function(respuesta) {
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
    var idCuenta= datosCuentaAPi[posicionProducto]["idCuenta"];
    console.log("idCuenta", idCuenta);
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
                beforeSend: function () {
                    $("#modalCancelarProducto").modal("hide");
                    // $('#modalCargando').modal({backdrop: 'static', keyboard: false });
                    // $("#animacionCargando").html('<div class="loader"></div>');
                    swal({
                        title: 'Espere',
                        text: 'Cancelando producto en la cuenta',
                        type : 'info',
                        allowOutsideClick: false
                    });
                    swal.showLoading();

                },
                success: function(respuesta) {
                    // $("#modalCargando").modal("hide");//oculto el modal que muestra el cargando
                    swal.close(); 
                    var respuesta=JSON.parse(respuesta);                 
                    var ok = respuesta["ok"]; 
                    // console.log(respuesta);
                    if(ok){
                        console.log("la cuenta bdAPi",datosCuentaAPi);
                        
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
     var idPV= $("#idPVModalOrdenar").val();
     var idMesa = localStorage.getItem("idMesaLS");

     var cuenta = JSON.parse(localStorage.getItem(idPV+idMesa));  

   
     var porcentaje = $("#cantidadDescuento").val(); 
     var totalSinDescuento = cuenta["subtotalCuenta"];
     var descuentCalculado=((porcentaje*totalSinDescuento)/100);
     var TotalConDescuento=totalSinDescuento-descuentCalculado;
    //  $("#descuentoCuenta").val(descuentCalculado);
     $("#descuentoCuenta").html(descuentCalculado);

    //  $("#descuentoCuenta").attr("porcentajeDescuento",porcentaje)
        //  
    //  $("#totalCuenta").val(TotalConDescuento);
     $("#totalCuenta").html(TotalConDescuento);
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
    // mostrarTotales(cadena);
 }

 function cerrarCuentaModal() {     
     var idPV= $("#idPVModalOrdenar").val();
     var idMesa = localStorage.getItem("idMesaLS");
     var idCuenta = $("#cuentaMesaSpan").text(); 
      
     var totalCuenta = $("#totalCuenta").val();

     var cuentaTemporal="cuentaTemporal"+idPV+idMesa;//creo la variable
     var cuentaAPi="cuentaBD"+idPV+idMesa;

     var datosCuentaTemporal = JSON.parse(localStorage.getItem(cuentaTemporal));
     var datosCuentaApi = JSON.parse(localStorage.getItem(cuentaAPi));

     if(datosCuentaTemporal==null){
         hayCuenta=false;
         longitud = 0;
     }else{
         longitud =datosCuentaTemporal.length;
         hayCuenta = true;
     }
     if(datosCuentaApi && datosCuentaApi.length==0){         
        cuentaApi = false;         
    }else{            
        cuentaApi = true;
    }              
    if(longitud==0){
        $("#idCuentaCerrar").val(idCuenta); //guardo el id de la cuenta en un campo dentro de un modal
        if(totalCuenta !=0 ){
            $('#modalMetodoPago').modal({backdrop: 'static', keyboard: false });
        }else {
            cerrarCuenta();
        }
    }else{
        swal("Oops", "¡Aún tienes productos sin enviar a centros de preparación o la cuenta no tiene informacion!" ,  "error");        
    }
 }
 function cerrarCuenta() {
     var csrf_token = $('meta[name="csrf-token"]').attr('content');
    
     var idPV= $("#idPVModalOrdenar").val();
     var idMesa = localStorage.getItem("idMesaLS");          

     var cuenta = JSON.parse(localStorage.getItem(idPV+idMesa));        
     var idCuenta = $("#cuentaMesaSpan").text();  
     var porcentajeDesc = cuenta["descuentoPorc"]; 
     var idFormaPago = $("#formaPagoSelect option:selected").val();
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
        beforeSend: function () {
            // $('#modalCargando').modal({backdrop: 'static', keyboard: false });
            // $("#animacionCargando").html('<div class="loader"></div>');
            swal({
                title: 'Espere',
                text: 'Cerrando la cuenta',
                type : 'info',
                allowOutsideClick: false
            });
            swal.showLoading();
        },
        success: function(respuesta) {            
            //  $("#modalCargando").modal("hide");
             swal.close(); 
             
             var respuesta = JSON.parse(respuesta);
             console.log("respuesta",respuesta);
             var ok = respuesta["ok"];                
                if(ok){//si ok es true                
                var cuenta=idPV+idMesa;
                var cuentaTemporal="cuentaTemporal"+cuenta;
                var cuentaAPi="cuentaBD"+cuenta;

                     localStorage.removeItem(cuenta);
                     localStorage.removeItem(cuentaTemporal);
                     localStorage.removeItem(cuentaAPi);
                     localStorage.removeItem("zonaMesaSeleccionada");

                     swal({
                            title: 'Exito',
                            text: '¡Operacion realizada con exito!',
                            type: 'success',
                            // timer: '1500'
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
 //funcion con sweetalert para reimprimir cuenta
function imprimirCuenta() {
    var idCuenta = $("#cuentaMesaSpan").text(); 
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
            beforeSend: function () {
                // $('#modalCargando').modal({backdrop: 'static', keyboard: false });
                // $("#animacionCargando").html('<div class="loader"></div>');
                swal({
                    title: 'Espere',
                    text: 'Imprimiendo la cuenta',
                    type : 'info',
                    allowOutsideClick: false
                });
                swal.showLoading();
            },
            success: function(respuesta) {
                // $("#modalCargando").modal("hide");
                swal.close();
                var respuesta = JSON.parse(respuesta);
                console.log("respuesta controlador",respuesta);                    
            },
            error: function(respuesta) {
                swal.close();
                respuesta = JSON.parse(respuesta);                
                console.log("respuesta controlador",respuesta);                    

            }
        });
    }).catch(swal.noop);
}

 function cerrarDia(idPuntoVenta) {
     var csrf_token = $('meta[name="csrf-token"]').attr('content');
     
     $.ajax({
        url: "{{ url('ordenar/cerrardia') }}"+'/'+idPuntoVenta,
        type: "POST",
        data: {
            '_method': 'POST',           
            
            '_token': csrf_token
        },
        success: function(respuesta) {             
             var respuesta = JSON.parse(respuesta);
             console.log("Respuesta controlador",respuesta);               
                                                
        },
        error: function(respuesta) { 
            console.log("respuesta",respuesta); 
        }
    });
 } 

//para cambiar color del botón de tiempo seleccionado 
 $(document).on("click", "#opcionesTiempo span", function(){
    $("span.btn-success").removeClass("btn-success");
    $(this).addClass("btn-success");
 });

function tiempoOrden() {    
    // var tiempoElegido = $("#opcionesTiempo").children('span:first').attr("tiempo");
    if($("#tiempo1").hasClass("btn-success")){
        var tiempoElegido=$("#tiempo1").attr("tiempo");
    }else if($("#tiempo2").hasClass("btn-success")){
        var tiempoElegido=$("#tiempo2").attr("tiempo");
    }else if($("#tiempo3").hasClass("btn-success")){
        var tiempoElegido=$("#tiempo3").attr("tiempo");
    }else if($("#tiempo4").hasClass("btn-success")){
        var tiempoElegido=$("#tiempo4").attr("tiempo");
    }
    // console.log('tiempo ',tiempoElegido);
    return tiempoElegido;
    
}
//para marcar los span a las categorias seleccionadas
$(document).on("click", ".slideProductos", function(){    
    $(".slideProductos").children('p').removeClass("btn-success");
    $(this).children('p').addClass("btn-success");
    // $(".slideProductos").children('p').addClass("btn-info");
         
});
//para marcar el boton seleccionado a la zona seleccionada
$(document).on("click", "#sliderZonas button", function(){    
    $("button.buttonZonas").removeClass("btn-success");
    $(this).addClass("btn-success");
    idZona=$(this).attr("idZonaBtn");    
    localStorage.setItem('zonaMesaSeleccionada', "zona"+idZona);    
});
function generarBotonesClientes(idPV,idMesa) {
    
    var cuentaMesa=String(idPV)+String(idMesa);
    // console.log('la cuenta es ',cuentaMesa); 
    if (localStorage.getItem(cuentaMesa) ){
        cuenta = JSON.parse(localStorage.getItem(cuentaMesa));        
        numPax =cuenta["pax"];
        idCuenta =cuenta["id"];
        n=0;
        botones="";
            for (var i = 0; i < numPax; i++) {
                n++;  
                botones+="<button class='btn btn-sm btnC' id='btn"+n+"' idCuenta='"+idCuenta+"' numComensal='"+n+"' onclick='selectCustomer(this,"+cuentaMesa+")'>"+n+" <span id='btnBadge"+n+"' class='badgeCliente'>0</span></button>  &nbsp;&nbsp;";                
            }
        botones+="";
        $("#lstBtnClientes").html(botones); 
        // contadoresProductos(idPV,idMesa);
    }else{
        console.log("entro aquí, si botones de client");
    }      
    marcarCheckboxDefault(cuentaMesa) ;
}
function selectCustomer(elemento, cuentaMesa){
   
    var botones = document.getElementsByClassName('btnC');
    var numComensal= elemento.getAttribute("numComensal");
    // localStorage.setItem("comensalAnterior",numComensal);    
    for (i = 0; i < botones.length; i++) {       
        botones[i].classList.remove('btn-success')
    }    
    elemento.classList.add('btn-success'); 
    //elemento.id; elemento.getAttribute("idCuenta");
    if (localStorage.getItem(cuentaMesa) ){
        cuenta = JSON.parse(localStorage.getItem(cuentaMesa));                

        alergenosCuenta = cuenta["TPV_AlergenosCuenta"];

        if(alergenosCuenta.length>0){
            // console.log("con alergenos en la Cuenta", alergenosCuenta);        
            var comensalList = alergenosCuenta.filter(function (comensalAlergia) {
                return comensalAlergia.paxAlergia == numComensal;
            });
            // console.log("resultado filtro comnensal:", comensalList);
                if(comensalList.length>0){
                    $('#checkAlergia').prop('checked', true);
                }else {
                $('#checkAlergia').prop('checked', false);
            }
        }
    }    
}
function marcarCheckboxDefault(cuentaMesa) {
    $("#lstBtnClientes").children('button:first').addClass("btn-success");
    var comensal = $("#btn1").attr("numComensal");
        
	localStorage.setItem("comensalAnterior",comensal);                            
                                   
    if(cuentaMesa){
        cuenta = JSON.parse(localStorage.getItem(cuentaMesa));
        if(cuenta!=null){
            alergenosCuenta = cuenta["TPV_AlergenosCuenta"];
        // console.log(alergenosCuenta);
            if(alergenosCuenta.length>0){            
                var comensalList = alergenosCuenta.filter(function (comensalAlergia) {
                    return comensalAlergia.paxAlergia == 1;
                });               
                if(comensalList.length>0){
                    $('#checkAlergia').prop('checked', true);
                }else {
                    $('#checkAlergia').prop('checked', false);            
                }                   
            }
        }        
    }    
}

/*============================
 PARAE CAMBIAR DE MESA
==============================*/
function cambiarMesa() {

    idPV = $("#idPVModalOrdenar").val();//obtengo el id de pv con el que se inició sesion

    mesaActual = $("#nombreMesaSpan" ).text();// la original
    idMesaActual = localStorage.getItem("idMesaLS");

    idMesaNueva = $(".selectMesasZonas option:selected" ).val();// la nueva
    nuevaMesaNombre = $(".selectMesasZonas option:selected" ).text();

    idCuenta = $("#cuentaMesaSpan" ).text();
    //cuenta actual
    cuentaAnterior=idPV+idMesaActual;
    cuentaMesaDatosAnterior = JSON.parse(localStorage.getItem(cuentaAnterior));
    //cuenta temporal actaal
    cuentaTemporalAnteriorTemp="cuentaTemporal"+idPV+idMesaActual;
    cuentaMesaDatosAnteriorTemp = JSON.parse(localStorage.getItem(cuentaTemporalAnteriorTemp));
    longitudCT = cuentaMesaDatosAnteriorTemp.length;
    //cuenta temporal actual BD de API
    cuentaAnteriorBD="cuentaBD"+idPV+idMesaActual;
    cuentaMesaDatosAnteriorBD = JSON.parse(localStorage.getItem(cuentaAnteriorBD));
    longitudCBD = cuentaMesaDatosAnteriorBD.length;

    if (idMesaNueva !="") {
        swal({
            title: 'Cambio de mesa: '+mesaActual+' a '+nuevaMesaNombre,
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            cancelButtonText: '¡Desistir!',
            confirmButtonText: '¡Cambiar!'
        }).then(function() {

            //genero nueva variable localstorage cuenta-> idPV+idMesaNueva
            cuentaNueva=idPV+idMesaNueva;
            cuentaMesaDatosAnterior["idMesa"]=parseInt(idMesaNueva);
            localStorage.setItem(cuentaNueva,JSON.stringify(cuentaMesaDatosAnterior)); 
            //genero nueva variable localstorage cuentaTemporal -> idPV+idMesaNueva
            cuentaTemporalNueva="cuentaTemporal"+idPV+idMesaNueva;            
            if (longitudCT > 0) {
                for (i = 0; i < cuentaMesaDatosAnteriorTemp.length; i++) {
                    cuentaMesaDatosAnteriorTemp[i]["idMesa"]=idMesaNueva;
                    localStorage.setItem(cuentaTemporalNueva,JSON.stringify(cuentaMesaDatosAnteriorTemp)); 
                }                
            } else {
                localStorage.setItem(cuentaTemporalNueva,JSON.stringify(cuentaMesaDatosAnteriorTemp));                
            }                                  
            //genero nueva variable localstorage cuentaBD -> idPV+idMesaNueva
            cuentaBDNueva="cuentaBD"+idPV+idMesaNueva;            
            if (longitudCBD > 0) {
                for (i = 0; i < cuentaMesaDatosAnteriorBD.length; i++) {
                    cuentaMesaDatosAnteriorBD[i]["idMesa"]=idMesaNueva;
                    localStorage.setItem(cuentaBDNueva,JSON.stringify(cuentaMesaDatosAnteriorBD)); 
                }                
            } else {
                localStorage.setItem(cuentaBDNueva,JSON.stringify(cuentaMesaDatosAnteriorBD));                 
            }
            // cambio el idMesa en localstorage idMesaLS-> idMesaNueva                                   
            localStorage.setItem("idMesaLS",idMesaNueva);
            $("#nombreMesaSpan" ).text(nuevaMesaNombre);// Cambio nombre de mesa en div well
            // remuevo las variables localstorage anteriores
            localStorage.removeItem(cuentaAnterior);
            localStorage.removeItem(cuentaTemporalAnteriorTemp);
            localStorage.removeItem(cuentaAnteriorBD);
            
            guardarCambioDeMesa(idPV, idCuenta, idMesaNueva);            

        }).catch(swal.noop);        
    }else{
        swal("Oops", "Seleccione una mesa por favor" ,  "error");                
    }
}
function guardarCambioDeMesa(idPV, idCuenta, idMesaNueva){
     var csrf_token = $('meta[name="csrf-token"]').attr('content');    
    // console.log("idPuntoVenta: "+idPV+" idCuenta: "+idCuenta+" idMesaNueva: "+idMesaNueva);    
    $.ajax({
        url: "{{ url('ordenar/updatemesa') }}",
        type: "POST",
        data: {
            '_method': 'POST',           
            'idPV': idPV,'idCuenta':idCuenta,'idMesaNueva':idMesaNueva,
            '_token': csrf_token
        },
        beforeSend: function () {
            swal({
                title: 'Espere',
                text: 'Actualizando datos',
                type : 'info',
                allowOutsideClick: false
            });
            swal.showLoading();
        }, 
        success: function(respuesta) {
            swal.close();             
            var respuesta = JSON.parse(respuesta);
            console.log("respuesta",respuesta); 
            var ok = respuesta["ok"];                                                                                     
        },
        error: function(respuesta) { 
            console.log("respuesta",respuesta); 
        }
    });           
     
}
// Para trabajar con media queries
    var mediaquery = window.matchMedia("(max-width: 600px)");     
    function handleOrientationChange(mediaquery) {
        var userAgent = navigator.userAgent || navigator.vendor || window.opera;

      if (mediaquery.matches) {        
        $("#btnAddDescuento").html('<i class="fas fa-percentage"></i> Desc');
        $("#btnAddRoomCuenta").html('<i class="fas fa-bed"></i>  Hab.');
        $("#btnEnviarCP").html('<i class="fas fa-paper-plane"></i> Enviar');
        $("#sliderZonas > button").addClass("buttonZonasSmallDev");        

      } else {
        $("#btnAddDescuento").html('<i class="fas fa-percentage"></i> Descuento');
        $("#btnAddRoomCuenta").html('<i class="fas fa-bed"></i>  Habitación');
        $("#btnEnviarCP").html('<i class="fas fa-paper-plane"></i> Enviar');
        // $("#sliderZonas > button").addClass("buttonZonasSmallDev");        

      }
      
      if ((/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream)) {
          $("#sliderZonas > button").addClass("buttonZonasSmallDev");                    
      }
 
    }
    handleOrientationChange(mediaquery);
    mediaquery.addListener(handleOrientationChange);
</script>

                        




