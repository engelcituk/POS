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

/*=====  END OF PARA QUE AL MENOS UN PERMISO ESTE SELECCIONADO  ======*/
function productoModos(idProducto){
// console.log("click");
$("#idProductoModo").val(idProducto);
}
function seleccionarRadioModo(idModo){
    console.log("click ",idModo);
}
function seleccionarCheckModo(idModo){
    console.log("click ",idModo);
}
 </script>