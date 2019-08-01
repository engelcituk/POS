<script>

seleccionarRadio();

function seleccionarRadio(){    
    $("input[name='principalRadio[]']").each( function () {
        if($(this).prop("checked")){            
            var id=$("input[type=radio][name='principalRadio[]']:checked").attr('id');
            var idNumero = id.replace( /^\D+/g, ''); 
                $("input[name='principal[]']").each(function(){
                    $(this).val("false");
                });
            $("#valorP"+idNumero).val("true");
            $("#inputPrincipalModo"+idNumero).val("true");
            // document.getElementById("#chekModo"+idNumero).disabled = true;                       
                      
        }	
    });
}
    var regex = /^(.*)(\d)+$/i;
    var cindex = 1;
    $(document).on("click", ".tr_clone_add", function(){
    // $("input.tr_clone_add").on('click', function() {
        var $tr    = $(this).closest('.tr_clone');
        var $clone = $tr.clone();
        cindex++;
        $clone.find(':text').val('');
        $clone.attr('id', 'id'+(cindex) ); //update row id if required
        $('radioP'+(cindex)).attr('radio', cindex);
        //update ids of elements in row
        $clone.find("*").each(function() {
                var id = this.id || "";
                var match = id.match(regex) || [];
                if (match.length == 3) {
                    this.id = match[1] + (cindex);
                }
        });
        $tr.after($clone);
        seleccionarRadio();
    });
    $(document).on("click", ".tr_clone_remove", function(){
        var id= $(this).closest("tr").attr('id');
        var idNumero = id.replace( /^\D+/g, '');
        if(idNumero != 1){
            $(this).closest("tr").remove();            
        }
        seleccionarRadio();    
    });


function productoModos(idProducto){
// console.log("click");
$("#idProductoModo").val(idProducto);
    var csrf_token = $('meta[name="csrf-token"]').attr('content'); 
    $.ajax({
        url: "{{ url('productos/getmodos') }}",
        type: "GET",
        data: {
            '_method': 'GET',                
            'idProducto':idProducto,
            '_token': csrf_token
        },        
        success: function(respuesta) {
            var respuesta=JSON.parse(respuesta);                 
            var ok = respuesta["ok"];                            
            if(ok){
                var objeto=respuesta["objeto"];                                    
                modosId=[];
                for(i =0;  i<objeto.length; i++){
                    modosId[i]= objeto[i].idModo;
                } 
                 
                console.log("modosP",modosPrincipal);                          
                $("input[name='idModo[]']").each( function () {                   
                    if((modosId.indexOf(parseInt($(this).val()))!=-1) ) {               
                        $(this).prop('checked', true);                                                
                    }	
                });                
            }else{
                var mensaje=respuesta["mensaje"];
                console.log("respuesta: ",mensaje);
            }                
        },
        error: function(respuesta) {
        // console.log(JSON.parse(respuesta));
        console.log(respuesta);
        }
    });
    
}
function seleccionarRadioModo(idModo){
    if($("#checkModo"+idModo).is(':checked')) {              
        $("#radioModo"+idModo).prop("checked", true);         
        seleccionarRadio(); 
    } else {  
        $("#radioModo"+idModo).prop("checked", false);
         swal("Oops", "Primero tiene que agregar este modo a este producto" ,  "error"); 
         seleccionarRadio();            
    }
}

function AddDeleteModoProducto(idModo){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var idProducto = $("#idProductoModo").val();
        var principal = $("#inputPrincipalModo"+idModo).val();
        
        var nombreModo = $("#checkModo"+idModo).attr("nombreModo");    

        // console.log("idProducto "+idProducto+" IdModo: "+idModo+" principal "+principal+ "nombreModo "+nombreModo);
        valorCheck=$("#checkModo"+idModo).prop("checked");//obtengo true o false

        if(valorCheck) {    
            $.ajax({
                url: "{{ url('productos/addmodo') }}",
                type: "POST",
                data: {
                    '_method': 'POST',
                    'idProducto':idProducto, 'idModo':idModo, 'principal':principal,
                    '_token': csrf_token
                },
                success: function(respuesta) {
                    $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Se ha registrado modo: <strong>'+nombreModo+'</strong> para el producto.'
                        },{								
                            type: 'info',
                            delay: 5000
                        });                    
                },
                error: function() {
                   $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Ocurrió un error al hacerse la petición'
                        },{								
                            type: 'danger',
                            delay: 5000
                        });
                }
            });
        }else{
            $.ajax({
                url: "{{ url('productos/deletemodo') }}",
                type: "POST",
                data: {
                    '_method': 'POST',
                    'idProducto':idProducto, 'idModo':idModo,
                    '_token': csrf_token
                },
                success: function(respuesta) {                    
                    $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Se ha borrado modo: <strong>'+nombreModo+'</strong> para el producto.'
                        },{								
                            type: 'warning',
                            delay: 5000
                        });
                },
                error: function() {
                   $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Ocurrió un error al hacerse la petición'
                        },{								
                            type: 'danger',
                            delay: 5000
                        });
                }
            });
        }
     }
     //limpio datos del modal que hay en el formulario
     $('#myModalModos').on('hidden.bs.modal', function (e) {
        $(this).find('form')[0].reset();
    });
 </script>