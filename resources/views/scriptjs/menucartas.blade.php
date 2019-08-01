<script> 
  
// $(document).ready(function() {
//     $('.listaProductos').select2();
// });

var regex = /^(.*)(\d)+$/i;
    var cindex = 1;
    $(document).on("click", ".addCloneTr", function(){
    // $("input.clonarTr_add").on('click', function() {
        var $tr    = $(this).closest('.clonarTr');
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
    });
    $(document).on("click", ".clonTr_remove", function(){
        var id= $(this).closest("tr").attr('id');
        var idNumero = id.replace( /^\D+/g, '');
        if(idNumero != 1){
            $(this).closest("tr").remove();            
        }            
    });
   
   //al seleccionar un producto envio su precio al input precio que le corresponde
    $(document).on('change', '.listaProductos', function() {
        var valorSelectId = $(this).attr("id");
        var id = valorSelectId.replace(/[^0-9]/g,'');//obtengo el numero
        var precio= $('option:selected',this).attr('precio');
        $("#precio"+id).val(precio); //le pongo el precio en el campo correspondiente        
    });
    
</script>
